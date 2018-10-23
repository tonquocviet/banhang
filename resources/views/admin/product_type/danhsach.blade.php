@extends('admin.layout.index')
@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Loại sản phẩm
                    <small>Danh sách</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            @if(Session::has('thongbao'))
                    <div class="alert alert-success">{{Session::get('thongbao')}}</div>
            @endif
            
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr align="center">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                	@foreach($prodtype as $prt)
                    <tr class="odd gradeX" align="center">
                        <td>{{$prt-> id}}</td>
                        <td>{{$prt-> name}}</td>
                        <td>{{$prt-> description}}</td>
                        <td>
                            <img width="100px" src="source/image/product/{{$prt-> image}}">
                            {{$prt-> image}}
                        </td>
                        <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/product_type/xoa/{{$prt-> id}}"> Delete</a></td>
                        <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="admin/product_type/sua/{{$prt -> id}}">Edit</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@endsection