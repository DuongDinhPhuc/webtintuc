<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;

class TheLoaiController extends Controller
{
    //
    public function getDanhsach()
    {
    	$theloai = TheLoai::all();
    	return view('admin.theloai.danhsach',['theloai'=> $theloai]);
    }
    public function getThem()
    {
    	return view('admin.theloai.them');
    }
    public function postThem(Request $request)
    //Truyen request de nhan du lieu
    {
    	//check dieu kien,sd ham validate
    	//mảng đầu tiên là lỗi
    	//mảng thứ 2 là hiện ra thông báo lỗi
    	$this->validate($request,
    		[
    			'TenTheLoai'=>'required|unique:TheLoai,Ten|min:3|max:100'
    		],
    		[
    			'TenTheLoai.required'=>'Bạn chưa nhập tên thể loại',
    			'TenTheLoai.unique'=>'Tên thể loại đã tồn tại, mời bạn nhập tên khác',
    			'TenTheLoai.min'=>'Tên thể loại phải có độ dài từ 3 đến 100 ký tự',
    			'TenTheLoai.max'=>'Tên thể loại phải có độ dài từ 3 đến 100 ký tự'
    		]);
    	$theloai = new TheLoai;
    	$theloai->Ten=$request->TenTheLoai;
    	//ham str_slug dùng để tạo tiêu đề không dấu, link thân thiện
    	$theloai->TenKhongDau=str_slug($request->TenTheLoai);
    	$theloai->save();

    	return redirect('admin/theloai/them')->with('thongbao','Thêm thành công');
    }
    public function getSua($id)
    {
    	$theloai = TheLoai::find($id);
    	return view('admin.theloai.sua',['theloai'=>$theloai]);
    }
    public function postSua(Request $request,$id)
    {
    	$theloai = TheLoai::find($id);
    	$this->validate($request,
    		[
    			//unique:TheLoai,Ten->trùng trong bảng thể loại và cột tên 
    			'TenTheLoai'=>'required|unique:TheLoai,Ten|min:3|max:100'
    		],
    		[
    			'TenTheLoai.required'=>'Bạn chưa nhập tên thể loại',
    			'TenTheLoai.unique'=>'Tên thể loại đã tồn tại, mời bạn nhập tên khác',
    			'TenTheLoai.min'=>'Tên thể loại phải có độ dài từ 3 đến 100 ký tự',
    			'TenTheLoai.max'=>'Tên thể loại phải có độ dài từ 3 đến 100 ký tự'
    		]);
    	$theloai->Ten = $request->TenTheLoai;
    	$theloai->TenKhongDau=str_slug($request->TenTheLoai);
    	$theloai->save();

    	return redirect('admin/theloai/sua/'.$id)->with('thongbao','Đã sửa thành công');
    }

    public function getXoa($id)
    {
    	$theloai=TheLoai::find($id);
    	$theloai->delete();

    	return redirect('admin/theloai/danhsach')->with('thongbao','Đã xóa thành công');
    }
}
