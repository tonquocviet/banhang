@extends('admin.layout.index')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Sản phẩm
                    <small>Thêm</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-10" style="padding-bottom:120px">
                @if(count($errors) >0)
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $err)
                            {{$err}}<br>
                        @endforeach
                    </div>
                @endif

                @if(Session::has('thongbao'))
                    <div class="alert alert-success">{{Session::get('thongbao')}}</div>
                @endif

                <form action="admin/product/them" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="form-group">
                        <label>Category Parent</label>
                        <select class="form-control" name="id_type">
                            <option value="0">Chọn loại sản phẩm</option>
                            @foreach($product as $prod)
                            <option value="{{$prod-> id}}">{{$prod-> name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Product Name</label>
                        <input class="form-control" name="name" placeholder="Nhập tên sản phẩm" />
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea id="description" class="ckeditor" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Unit Price</label>
                        <input class="controls col-xs-4 input-group" name="unit_price" placeholder="10.000 VND"/>
                    </div>
                    <div class="form-group">
                        <label>Promotion Price</label>
                        <input class="controls col-xs-4 input-group" name="promotion_price" placeholder="10.000 VND"/>
                    </div>
                    <div class="form-group">
                        <label class="custom-file">Image
                          <input type="file" name="hinh" class="custom-file-input">
                          <span class="custom-file-control"></span>
                        </label>
                    </div>
                    {{-- <div class="form-group">
                        <label>Unit</label>
                        <select class="form-control" name="unit">
                            <option value="0">Chọn đơn vị tính của sản phẩm</option>
                            <option name="unit" value="">hộp</option>
                            <option name="unit" value="">cái</option>
                        </select>
                    </div> --}}
                    <div class="form-group">
                        <label>Đơn vị tính</label>
                        <label class="radio-inline">
                            <input name="unit" value="hộp" checked="" type="radio">hộp
                        </label>
                        <label class="radio-inline">
                            <input name="unit" value="cái" type="radio">Cái
                        </label>
                    </div>
                    <div class="form-group">
                        <label>New</label>
                        <label class="radio-inline">
                            <input name="new" value="1" type="radio">Visible
                        </label>
                        <label class="radio-inline">
                            <input name="new" value="0" type="radio">Invisible
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default">Add</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                <form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@endsection