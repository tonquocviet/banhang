@extends('admin.layout.index')
@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Loại sản phẩm
                    <small>{{$prodtype_sua-> name}}</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-7" style="padding-bottom:120px">
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

                <form action="admin/product_type/sua/{{$prodtype_sua-> id}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" name="name" placeholder="Nhập tên loại sản phẩm" value="{{$prodtype_sua-> name}}"/>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control ckeditor" name="description" rows="8">    {{$prodtype_sua-> description}}
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label class="custom-file">Image
                          <p>
                            <img width="400px" src="source/image/product/{{$prodtype_sua-> image}}">
                          </p>
                          <input type="file" name="hinh" class="custom-file-input">
                          <span class="custom-file-control"></span>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default">Category Edit</button>
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