<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slide;
use App\Product;
use App\ProductType;
use App\Cart;
use Session;
use App\Customer;
use App\Bill;
use App\BillDetail;
use App\User;
use Hash;
use Auth; 
use Mail;
use Socialite;

class PageController extends Controller
{
    public function getIndex(){
    	$slide = Slide::all();
    	$new_product = Product::where('new',1)->paginate(4);
    	$sanpham_khuyenmai =Product::where('promotion_price','<>',0)->paginate(4);
    	return view('page.trangchu',compact('slide','new_product','sanpham_khuyenmai'));
    }

    public function getLoaiSp($type){
    	$sp_theoloai = Product::where('id_type',$type)->get();
    	$sp_khac = Product::where('id_type','<>',$type)->paginate(3);
    	$loai = ProductType::all();
    	$loai_sp = ProductType::where('id',$type)-> first();
    	return view('page.loai_sanpham',compact('sp_theoloai','sp_khac','loai','loai_sp'));
    }

    public function getChitiet(Request $req){
    	$sanpham = Product::where('id',$req-> id)-> first();
    	$sp_tuongtu = Product::where('id_type', $sanpham-> id_type)-> paginate(6);
    	return view('page.chitiet_sanpham',compact('sanpham','sp_tuongtu'));
    }

    public function getLienhe(){
    	return view('page.lienhe');
    }

    public function getGioithieu(){
    	return view('page.gioithieu');
    }

    public function getAddtoCart(Request $req,$id){
    	$product = Product::find($id);
    	$oldCart = Session('cart')?Session::get('cart'):null;
    	$cart = new Cart($oldCart);
    	$cart->add($product, $id);
    	$req->session()->put('cart',$cart);
    	return redirect()->back();
    }

    public function getDelItemCart($id){
    	$oldCart = Session::has('cart')?Session::get('cart'):null;
    	$cart = new Cart($oldCart);
    	$cart-> removeItem($id);
    	Session::put('cart', $cart);
    	return redirect()-> back();
    }

    public function getDathang(){
        if(Session('cart')){
            $oldCart = Session::get('cart');
            $cart = new Cart($oldCart);
            return view('page.dathang',['product_cart'=> $cart-> items,
                'totalPrice'  => $cart-> totalPrice,
                'totalQty'    => $cart-> totalQty]);
        }
        else{
            return view('page.dathang');
        }
    }

    public function postDathang(Request $req){

        $cart = Session::get('cart');

        $customer = new Customer;

        $customer -> name = $req-> full_name;
        $customer -> gender= $req-> gender;
        $customer -> email= $req-> email;
        $customer -> address= $req-> address;
        $customer -> phone_number= $req-> phone_number;
        $customer -> note= $req-> note;
        $customer -> save();

        $bill = new Bill;

        $bill -> id_customer = $customer-> id;
        $bill -> date_order = date('Y-m-d');
        $bill -> total = $cart-> totalPrice;
        $bill -> payment = $req-> payment_method;
        $bill -> note = $req-> note;
        $bill -> save();

        foreach($cart-> items as $kye=> $value){
            $bill_detail = new BillDetail;
            $bill_detail-> id_bill = $bill-> id;
            $bill_detail-> id_product = $kye;
            $bill_detail-> quantity = $value['qty'];
            $bill_detail -> unit_price = $value['price']/$value['qty'];
            $bill_detail -> save();

        }
        Session::forget('cart');
        return redirect()-> back()-> with('thongbao','Đặt hàng thành công');
    }

    public function getLogin(){
        if(Auth::check()){
            return redirect()-> route('trang-chu');
        }
        else{
            return view('page.dangnhap');    
        }
    }

    // public function postLogin(Request $req){
    //     $this-> validate($req,
    //         [
    //             'email'=> 'required|email',
    //             'password'=> 'required|min:6|max:20'
    //         ],
    //         [
    //             'email.required'=> 'Vui lòng nhập email',
    //             'email.email'=> 'Không đúng định dạng email',

    //             'password.required'=> 'Vui lòng nhập mật khẩu',
    //             'password.min'=> 'Mật khẩu ít nhất 06 ký tự',
    //             'password.max'=> 'Mật khẩu tối đa 20 ký tự'
    //         ]
    //     );
    //     $credentials = array('email'=> $req-> email,
    //                          'password'=> $req-> password);
    //     $user = User::where([
    //         ['email','=',$req->email],
    //         ['status','=','1']
    //     ])->first();
    //     if($user){
    //         if(Auth::attempt($credentials)){
    //             return redirect()-> back()-> with(['flag'=> 'success','message'=>'Đăng nhập thành công']);
    //         }
    //         else{
    //             return redirect()-> back()-> with(['flag'=> 'danger','message'=>'Đăng nhập thất bại']);
    //         }
    //     }
    //     else{
    //         return redirect()->back()->with(['flag'=>'danger','message'=>'Tài khoản chưa kích hoạt']);
    //     }
    // }
    public function postLogin(Request $req){
        if(Auth::attempt(['email'=>$req-> email,
                          'password'=>$req-> password,
                          'active'=> 1])){
            return redirect()-> route('trang-chu');
        }
        else{
            return redirect()-> back()-> with(['flag'=> 'danger','message'=>'Sai thông tin đăng nhập']);
        }    
    }

    public function getRegister(){
        return view('page.dangky');
    }

    public function postRegister(Request $req){  //đăng kí và dùng mail kích hoạt tài khoản
        $this -> validate($req,
            [
                    'email'=> 'required|email|unique:users,email', // email co ton tai trong bang users ko
                    'password'=>'required|min:6|max:20', //06<=password<=20 chars
                    'fullname'=> 'required', //required: bat buoc phai nhap
                    're_password'=> 'required|same:password', //kiem tra xem co giong password ko
                    'phone'=> 'numeric'
                ],
                [
                    'email.required'=> 'Vui lòng nhập email', //ng dùng ko nhập 
                    'email.email'=> 'Không đúng định dạng email', //nhập ko đúng định dạng email
                    'email.unique'=> 'Email đã có người sử dụng', //nhập trùng email

                    'password.required'=> 'Vui lòng nhập mật mã',
                    're_password.same'=> 'Mật khẩu không giống nhau',
                    'password.min'=> 'Mật khẩu ít nhất 06 ký tự',
                    'password.max'=> 'Mật khẩu tối đa 20 ký tự',
                    'phone.numeric'=> 'Số điện thoại phải là 1 dãy số gồm 11 ký tự'               
                ]);
            $user = new User();
            $user -> full_name = $req-> fullname;
            $user-> email = $req-> email;
            $user-> password = Hash::make($req-> password); //make 1 hash để mã hóa mật khẩu
            $user-> phone = $req-> phone;
            $user-> address = $req-> address;
            $user -> save();

            Mail::send('page.mail',['nguoidung'=> $user], function ($message) use ($user)
        {
            $message-> from('tonquocviet123@gmail.com', 'Bakery Shop'); // tên người gửi
            $message-> to ($user-> email,$user-> full_name); // gửi đến mail này
            $message-> subject('Xác nhận mật khẩu'); // chủ đề của mail
        });
            return redirect()->back()->with('thongbao','Đăng ký thành công , vui lòng kiểm tra Gmail để kích hoạt tài khoản');
    }

    public function postLogout(){
        Auth::logout();
        return redirect()-> route('trang-chu');
    }

    public function sendMail(){  //bỏ
        // $products= Product::where('id',1)-> first()-> toArray();
        $data= array();
        Mail::send('page.mail',$data, function ($message)
        {
            $message-> from('tonquocviet123@gmail.com', 'Bakery Shop'); // tên người gửi
            $message-> to ('tonquocviet159753@gmail.com','quoc viet'); // gửi đến mail này
            $message-> subject('Reset Password'); // chủ đề của mail
        });
        echo 'Đã gửi';
    }

    public function activeUser($id){
        $user = User::find($id);
        if($user){
            $user-> active = 1;
            $user-> save();
            return redirect()-> route('login')-> with(['thanhcong'=>'Kích hoạt tài khoản thành công']);
        }
    }

    public function getSearch(Request $req){
        $product =Product::where('name','like','%'.$req-> key.'%') //tìm theo tên
                            ->orWhere('unit_price',$req-> key) //tìm theo giá
                            ->get();
        return view('page.timkiem',compact('product'));
    }

    public function redirectToProvider($providers){
        return Socialite::driver($providers)-> redirect();
    }

    public function handleProviderCallback($providers){
        try{
            $socialUser = Socialite::driver($providers)-> user();
        }
        catch(\Exception $e){
            return redirect()-> route('trang-chu')->with(['flash_level'=>'danger','flash_message'=>"Đăng nhập không thành công"]);
        }
        $socialProvider = SocialProvider::where('provider_id',$socialUser->getId())-> first();
        if(!$socialProvider){
            //tạo mới
            $user = User::where('email',$socialUser-> getEmail())-> first();
            if($user){
                return redirect()->route('trang-chu')->with(['flash_level'=>'danger','flash_message'=>"Email đã có người sử dụng"]);
            }
            else{
                $user = new User();
                $user-> email = $socialUser-> getEmail();
                $user-> full_name = $socialUser-> getName();
                //if($provider == 'google')
                    $image = explode('?',$socialUser-> getAvatar());
                    $user-> avatar = $image[0];
                //?
                //user->avatar = $socialUser->getAvatar();
                $user-> save();
            }
            $provider = new SocialProvider();
            $provider-> provider_id = $socialUser -> getId();
            $provider-> provider = $providers;
            $provider-> email = $socialUser -> getEmail();
            $provider-> save();
        }
        else{
            $user = User::where('email',$socialUser-> getEmail())-> first();
        }
        Auth()->login($user);
        return redirect()-> route('trang-chu')-> with(['flash_level'=> 'success','flash_message'=> "Đăng nhập thành công"]);
    }
}
