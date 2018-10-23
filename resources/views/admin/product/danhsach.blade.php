@extends('admin.layout.index')
@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Sản phẩm
                    <small>Danh sách</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr align="center">
                        <th>ID</th>
                        <th>Name</th>
                        <th>ID_Type</th>
                        <th>Description</th>
                        <th>Unit Price</th>
                        <th>Promotion Price</th>
                        <th>Image</th>
                        <th>Unit</th>
                        <th>New</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($product as $prod)
                    <tr class="odd gradeX" align="center">
                        <td>{{$prod-> id}}</td>
                        <td>{{$prod-> name}}</td>
                        <td>{{$prod-> id_type}}</td>
                        <td>{{$prod-> description}}</td>
                        <td>{{$prod-> unit_price}}</td>
                        <td>{{$prod-> promotion_price}}</td>
                        <td>
                            <img width="100px" src="source/image/product/{{$prod-> image}}"><br>
                            {{$prod-> image}}
                        </td>
                        <td>{{$prod-> unit}}</td>
                        <td>{{$prod-> new}}</td>
                        <td class="center"><i class="fa fa-trash-o fa-fw"></i><a href="#"> Delete</a></td>
                        <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="#">Edit</a></td>
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