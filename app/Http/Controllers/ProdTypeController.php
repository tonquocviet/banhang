<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductType;

class ProdTypeController extends Controller
{
    public function getDanhSach(){
    	$prodtype = ProductType::all();
    	return view('admin.product_type.danhsach',['prodtype'=> $prodtype]);
    }

    public function getThem(){

    	return view('admin.product_type.them');
    }

    public function postThem(Request $req)
    {
    	$this-> validate($req,
    		[
    			'name'=> 'required|min:4|max:100|unique:type_products,name',
                'hinh'=> 'required | mimes:jpeg,jpg,png |',

    		],
    		[
    			'name.required'=> 'Bạn chưa nhập tên loại sản phẩm',
                'name.unique'=> 'Tên loại sản phẩm đã tồn tại',
    			'name.min'=> 'Tên loại sản phẩm phải nhiều hơn 4 ký tự',
    			'name.max'=> 'Tên loại sản phẩm phải không được nhiều hơn 100 ký tự',
                'hinh.required'=> 'Bạn chưa chọn hình',
                'hinh.mimes'=> "Chỉ được chọn file dạng png, jpg, jpeg",
    		]);
    	$prodtype = new ProductType;
    	$prodtype-> name = $req-> name ;
    	$prodtype-> description = $req-> description;

    	if($req-> hasFile('hinh'))
	    	{
	    		$file = $req-> file('hinh');
	    		$name = $file-> getClientOriginalName();
                $tenhinh = str_random(4)."_". $name;
                while(file_exists("source/image/product".$tenhinh))
                {
                    $tenhinh = str_random(4)."_". $name;
                }
                $file-> move("source/image/product", $tenhinh);
                $prodtype-> image = $tenhinh;

	    	}else
	    	{
                $prodtype-> image = "";

	    	}
    	$prodtype -> save();

    	return redirect('admin/product_type/them')-> with('thongbao','Thêm thành công');
    }

    public function getSua($id)
    {
        $prodtype_sua = ProductType::find($id);
        return view('admin.product_type.sua',['prodtype_sua'=> $prodtype_sua]); //dung 1 mang co ten prodtype truyen bien $ vao de qua view dùng lại $prodtype_sua-> name
    }

    public function postSua(Request $req,$id)
    {
        $prodtype_sua = ProductType::find($id);
        $this->validate($req,
            [
                'name'=> 'required|min:4|max:100',
                'hinh'=> '| mimes:jpeg,jpg,png |',
            ],
            [
                'name.required'=> 'Bạn chưa nhập tên loại sản phẩm',
                'name.min'=> 'Tên loại sản phẩm phải nhiều hơn 4 ký tự',
                'name.max'=> 'Tên loại sản phẩm phải không được nhiều hơn 100 ký tự',
                'hinh.mimes'=> "Chỉ được chọn file dạng png, jpg, jpeg",
            ]);
        $prodtype_sua-> name = $req-> name ;
        $prodtype_sua-> description = $req-> description;

        if($req-> hasFile('hinh'))
            {
                $file = $req-> file('hinh');
                $name = $file-> getClientOriginalName();
                $tenhinh = str_random(4)."_". $name;
                while(file_exists("source/image/product".$tenhinh))
                {
                    $tenhinh = str_random(4)."_". $name;
                }
                $file-> move("source/image/product", $tenhinh);
                if($prodtype_sua-> image)
                {
                    unlink("source/image/product/".$prodtype_sua-> image); //xoa file anh cu khi update
                }
                
                $prodtype_sua-> image = $tenhinh;
            }
        $prodtype_sua -> save();
        return redirect('admin/product_type/sua/'.$id)-> with('thongbao','Sửa thành công');
    }

    public function getXoa($id)
    {
        $prodtype_xoa = ProductType::find($id);
        $prodtype_xoa -> delete();

        return redirect('admin/product_type/danhsach')-> with('thongbao','Xóa thành công');
    }
}
