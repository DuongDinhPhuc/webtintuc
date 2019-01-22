<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\User;
use App\Comment;
class UserController extends Controller
{
    public function getDanhsach()
    {
    	$user = User::all();
    	return view('admin.user.danhsach',['user'=>$user]);
    }
    public function getThem()
    {
    	return view('admin.user.them');
    }
    public function postThem(Request $request)
    {
    	$this->validate($request,
    		[
    			'TenUser'=>'required|min:3|unique:users,name',
    			'Email'=>'required|email|unique:users,email',
    			'Password'=>'required|min:3|max:32',
    			'PasswordAgain'=>'required|same:Password'
    		],
    		[
    			'TenUser.required'=>'Bạn chưa nhập tên',
    			'TenUser.min'=>'Tên người dùng phải có ít nhất 3 ký tự',
    			'TenUser.unique'=>'Tên người dùng đã tồn tại',
    			'Email.required'=>'Bạn chưa nhập email',
    			'Email.unique'=>'Email đã tồn tại',
    			'Email.email'=>'Bạn chưa nhập đúng định dạng',
    			'Password.required'=>'Bạn chưa nhập mật khẩu',
    			'Password.min'=>'Mật khẩu phải có ít nhất 3 ký tự và nhiều nhất là 32 ký tự',
    			'Password.max'=>'Mật khẩu phải có ít nhất 3 ký tự và nhiều nhất là 32 ký tự',
    			'PasswordAgain.required'=>'Bạn chưa nhập lại mật khẩu',
    			'PasswordAgain.same'=>'Mật khẩu không trùng nhau'
    		]);
    	$user = new User;
    	$user->name=$request->TenUser;
    	$user->email=$request->Email;
    	$user->password=bcrypt($request->Password);
    	$user->quyen=$request->quyen;
    	$user->save();

    	return redirect('admin/user/them')->with('thongbao','Đã thêm thành công');
    }
    public function getSua($id)
    {
    	$user = User::find($id);
    	return view('admin.user.sua',['user'=>$user]);
    }
    public function postSua(Request $request,$id)
    {
    	$user = User::find($id);
    	$this->validate($request,
    		[
    			'TenUser'=>'required|min:3',
    		],
    		[
    			'TenUser.required'=>'Bạn chưa nhập tên',
    			'TenUser.min'=>'Tên người dùng phải có ít nhất 3 ký tự'
    		]);
    	$user = User::find($id);
    	$user->name = $request->TenUser;
    	$user->quyen=$request->quyen;


    	if($request->changePassword == "on")
    	{
    		$this->validate($request,
    		[
    			 'Password'=>'required|min:3|max:32',
    			 'PasswordAgain'=>'required|same:Password'
    		],
    		[
    			'Password.required'=>'Bạn chưa nhập mật khẩu',
    			'Password.min'=>'Mật khẩu phải có ít nhất 3 ký tự và nhiều nhất là 32 ký tự',
    			'Password.max'=>'Mật khẩu phải có ít nhất 3 ký tự và nhiều nhất là 32 ký tự',
    			'PasswordAgain.required'=>'Bạn chưa nhập lại mật khẩu',
    			'PasswordAgain.same'=>'Mật khẩu không trùng nhau'
    		]);
    		$user->password=bcrypt($request->Password);
    	}
    	
    	
    	$user->save();

    	return redirect('admin/user/sua/'.$id)->with('thongbao','Đã sửa thành công');
    }
    public function getXoa($id)
    {
      $user = User::find($id);
      $comment = Comment::where('idUser',$id); //Tìm các comment của user
      $comment->delete(); //Xóa các comment của user
      $user->delete(); //Xóa user
      return redirect('admin/user/danhsach')->with('thongbao','Đã xóa thành công');
    }
    public function getDangnhapAdmin()
    {
        return view('admin.login');
    }
    public function postDangnhapAdmin(Request $request)
    {
        $this->validate($request,
            [
                'email'=>'required',
                'password'=>'required|min:3|max:32'
            ],
            [
                'email.required'=>'Bạn chưa nhập email',
                'password.required'=>'Bạn chưa nhập mật khẩu',
                'password.min'=>'Mật khẩu phải có ít nhất 3 ký tự và nhiều nhất là 32 ký tự',
                'password.max'=>'Mật khẩu phải có ít nhất 3 ký tự và nhiều nhất là 32 ký tự'
            ]);
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password]))
        {
            return redirect('admin/theloai/danhsach');
        }   
        else
        {
            return redirect('admin/dangnhap')->with('thongbao','Sai tên tài khoản hoặc mật khẩu');
        }
    }
    public function getDangxuatAdmin()
        {
            Auth::logout();
            return redirect('admin/dangnhap');
        }
}
