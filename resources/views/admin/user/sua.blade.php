@extends('admin.layout.index')

@section('content')
<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Người dùng
                            <small>Sửa</small>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <div class="col-lg-7" style="padding-bottom:120px">
                        <!---Hiển thị ra lỗi-->
                        @if(count($errors)>0)
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $err)
                                {{ $err }}<br>
                                @endforeach
                            </div>
                            
                        @endif
                        <!--Hiển thị ra thông báo-->
                        @if(session('thongbao'))
                            <div class="alert alert-success">
                                {{ session('thongbao') }}
                            </div>
                        @endif
                        {{-- @if(session('loi'))
                            <div class="alert alert-success">
                                {{ session('loi') }}
                            </div>
                        @endif --}}
                        <form action="admin/user/sua/{{ $user->id }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label>Tên</label>
                                <input class="form-control" name="TenUser" value="{{ $user->name }}" placeholder="Nhập tên user" />
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" type="email" value="{{ $user->email }}" name="Email" placeholder="Nhập địa chỉ email" readonly="" />
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="changePassword" id="changePassword">
                                <label>Mật khẩu</label>
                                <input class="form-control password" type="password" name="Password" placeholder="Nhập mật khẩu" disabled="" />
                            </div>
                            <div class="form-group">
                                <label>Nhập lại mật khẩu</label>
                                <input class="form-control password" type="password" name="PasswordAgain" placeholder="Nhập lại mật khẩu" disabled="" />
                            </div>
                            <div class="form-group">
                                <label>Quyền</label>
                                <label class="radio-inline">
                                    <input name="quyen" value="1" 
                                    @if($user->quyen == 1)
                                        {{ "checked" }}
                                    @endif
                                     type="radio">Admin
                                </label>
                                <label class="radio-inline">
                                    <input name="quyen" value="0" 
                                    @if($user->quyen == 0)
                                        {{ "checked" }}
                                    @endif
                                      type="radio">Thường
                                </label>
                            </div>
                            <button type="submit" class="btn btn-default">Sửa</button>
                            <button type="reset" class="btn btn-default">Làm mới</button>
                        <form>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>


@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $("#changePassword").change(function(){
                if($(this).is(":checked"))
                {
                    $(".password").removeAttr('disabled');
                }
                else
                {
                    $(".password").attr('disabled','');
                }
            });
        });
    </script>
@endsection