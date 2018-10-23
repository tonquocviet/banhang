<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\ProductType;
class ProductController extends Controller
{
	public function getDanhSach(){
    	$product = Product::all();
    	return view('admin.product.danhsach',['product'=> $product]);
    }

    public function getThem()
    {
    	$product = ProductType::all();
    	return view ('admin.product.them',['product'=> $product]);
    }
    public function postThem(Request $req)
    {
    	$this-> validate($req,
    		[
    			'id_type'=> 'required',
    			'name'=> 'required|min:4|max:100|unique:type_products,name',
                'unit_price'=> 'required|numeric',
                'promotion_price'=> 'required|numeric',
                'hinh'=> 'required | mimes:jpeg,jpg,png,PNG |',
                'unit'=> 'required',

    		],
    		[
    			'id_type.required'=> 'bạn chưa chọn loại sản phẩm',
    			'name.required'=> 'Bạn chưa nhập tên sản phẩm',
                'name.unique'=> 'Tên sản phẩm đã tồn tại',
    			'name.min'=> 'Tên sản phẩm phải nhiều hơn 4 ký tự',
    			'name.max'=> 'Tên sản phẩm không được nhiều hơn 100 ký tự',
                'unit_price.required'=> 'Bạn chưa nhập Unit price',
                'unit_price.numeric'=> 'Bạn phải nhập dạng số cho Unit Price',
                'promotion_price.required'=>' Bạn chưa nhập Promotion Price',
                'promotion_price.numeric'=> 'Bạn phải nhập dạng số cho Promotion Price',
                'hinh.required'=> 'Bạn chưa chọn hình',
                'hinh.mimes'=> 'Chỉ được chọn file dạng PNG, png, jpg, jpeg',
                'unit.required'=> 'Bạn chưa chọn đơn vị tính của sản phẩm',

    		]);
    	$product = new Product;
    	$product-> id_type = $req-> id_type;
    	$product-> name = $req-> name ;
    	$product-> description = $req-> description;
    	$product-> unit_price = $req-> unit_price;
    	$product-> promotion_price = $req-> promotion_price;

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
                $product-> image = $tenhinh;

	    	}else
	    	{
                $product-> image = "";

	    	}
	    $product-> unit = $req-> unit;
	    $product-> new = $req-> new;
	    

	    $product-> save();
	    return redirect('admin/product/them/')-> with('thongbao','Thêm thành công');
    }
}