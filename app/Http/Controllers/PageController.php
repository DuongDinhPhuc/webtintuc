<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\Slide;
use App\Loaitin;
use App\TinTuc;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class PageController extends Controller
{
    //
    function __construct()
    {	
    	$slide = Slide::all();
    	$theloai = TheLoai::all();
    	view()->share('theloai',$theloai);
    	view()->share('slide',$slide);


    }
    public function trangchu()
    {
        return view('pages.trangchu');
    }
    public function lienhe()
    {
    	return view('pages.lienhe');
    }
    public function loaitin($id)
    {
    	$loaitin = LoaiTin::find($id);
    	$tintuc = TinTuc::where('idLoaiTin',$id)->paginate(5);
    	return view('pages.loaitin',['loaitin'=>$loaitin,'tintuc'=>$tintuc]);
    }
    public function tintuc($id)
    {
    	$tintuc = TinTuc::find($id);
    	$tinnoibat = TinTuc::where('NoiBat',1)->take(4)->get();
    	$tinlienquan = TinTuc::where('idLoaiTin',$tintuc->idLoaiTin)->take(4)->get();
    	//khi xem 1 bai viet thi bai viet do +1 luot xem
    	DB::table('tintuc')->where('id', $id)->update(['SoLuotXem' => $tintuc->SoLuotXem+1]);
    	return view('pages.tintuc',['tintuc'=>$tintuc,'tinnoibat'=>$tinnoibat,'tinlienquan'=>$tinlienquan]);
    }
    public function getDangNhap()
    {
    	return view('pages.dangnhap');
    }
    public function postDangNhap(Request $request)
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
            return redirect('trangchu');
        }   
        else
        {
            return redirect('dangnhap')->with('thongbao','Sai tên tài khoản hoặc mật khẩu');
        }
    }
    public function DangXuat()
    {
    	Auth::logout();
    	return redirect('trangchu');
    }
    public function getNguoiDung()
    {
        return view('pages.nguoidung');
    }
    public function postNguoiDung(Request $request)
    {
        $this->validate($request,
            [
                'name'=>'required|min:3',
            ],
            [
                'name.required'=>'Bạn chưa nhập tên',
                'name.min'=>'Tên người dùng phải có ít nhất 3 ký tự'
            ]);
        $user = Auth::user();
        $user->name = $request->name;


        if($request->checkpassword == "on")
        {
            $this->validate($request,
            [
                 'password'=>'required|min:3|max:32',
                 'passwordAgain'=>'required|same:password'
            ],
            [
                'password.required'=>'Bạn chưa nhập mật khẩu',
                'password.min'=>'Mật khẩu phải có ít nhất 3 ký tự và nhiều nhất là 32 ký tự',
                'password.max'=>'Mật khẩu phải có ít nhất 3 ký tự và nhiều nhất là 32 ký tự',
                'passwordAgain.required'=>'Bạn chưa nhập lại mật khẩu',
                'passwordAgain.same'=>'Mật khẩu không trùng nhau'
            ]);
                $user->password=bcrypt($request->password);  
        }
        
              

        $user->save();

        return redirect('nguoidung')->with('thongbao','Đã sửa thành công');
    
    }
    public function getDangKy()
    {
        return view('pages.dangky');
    }
    public function postDangKy(Request $request)
    {
        $this->validate($request,
            [
                'name'=>'required|min:3|unique:users,name',
                'email'=>'required|email|unique:users,email',
                'password'=>'required|min:3|max:32',
                'passwordAgain'=>'required|same:password'
            ],
            [
                'name.required'=>'Bạn chưa nhập tên',
                'name.min'=>'Tên người dùng phải có ít nhất 3 ký tự',
                'name.unique'=>'Tên người dùng đã tồn tại',
                'email.required'=>'Bạn chưa nhập email',
                'email.unique'=>'Email đã tồn tại',
                'email.email'=>'Bạn chưa nhập đúng định dạng',
                'password.required'=>'Bạn chưa nhập mật khẩu',
                'password.min'=>'Mật khẩu phải có ít nhất 3 ký tự và nhiều nhất là 32 ký tự',
                'password.max'=>'Mật khẩu phải có ít nhất 3 ký tự và nhiều nhất là 32 ký tự',
                'passwordAgain.required'=>'Bạn chưa nhập lại mật khẩu',
                'passwordAgain.same'=>'Mật khẩu không trùng nhau'
            ]);
        $user = new User;
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=bcrypt($request->password);
        $user->quyen=0;
        $user->save();

        return redirect('dangky')->with('thongbao','Bạn đã đăng ký thành công');
    }
    public function postTimKiem(Request $request)
    {
        $tukhoa = $request->tukhoa;
        $tintuc = TinTuc::where('TieuDe','like',"%$tukhoa%")->orWhere('TomTat','like',"%$tukhoa%")->orWhere('NoiDung','like',"%$tukhoa%")->take(50)->paginate(5);
        return view('pages.timkiem',['tintuc'=>$tintuc,'tukhoa'=>$tukhoa]);
    }

    public function gioithieu()
    {
        return view('pages.gioithieu');
    }
}
