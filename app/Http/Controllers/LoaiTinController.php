<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoaiTin;
use App\TheLoai;
class LoaiTinController extends Controller
{
    //
    public function getDanhsach()
    {
    	$theloai = TheLoai::all();
    	$loaitin = LoaiTin::all();
    	return view('admin.loaitin.danhsach',['loaitin'=>$loaitin]);
    }

    public function getThem()
    {
    	$theloai = TheLoai::all();
    	return view('admin.loaitin.them',['theloai'=>$theloai]);
    }
    public function postThem(Request $request)
    {
    	$this->validate($request,
    		[
    			'TenLoaiTin'=>'required|unique:LoaiTin,Ten|min:3|max:100',
    			'TheLoai'=>'required'
    		],
    		[
    			'TenLoaiTin.required'=>'Bạn chưa nhập tên loại tin',
    			'TenLoaiTin.unique'=>'Tên loại tin đã tồn tại, mời bạn nhập tên khác',
    			'TenLoaiTin.min'=>'Tên loại tin phải có độ dài từ 3 đến 100 ký tự',
    			'TenLoaiTin.max'=>'Tên loại tin phải có độ dài từ 3 đến 100 ký tự',
    			'TheLoai.required'=>'Bạn chưa chọn thể loại'
    		]);
    	$loaitin = new LoaiTin;
    	$loaitin->idTheLoai = $request->TheLoai;
    	$loaitin->Ten = $request->TenLoaiTin;
    	$loaitin->TenKhongDau = str_slug($request->TenLoaiTin);
    	$loaitin->save();

    	return redirect('admin/loaitin/them')->with('thongbao','Đã thêm thành công ');
    }
    public function getSua($id)
    {
    	$theloai = TheLoai::all();
    	$loaitin = LoaiTin::find($id);
    	return view('admin.loaitin.sua',['loaitin'=>$loaitin,'theloai'=>$theloai]);
    }
    public function postSua(Request $request,$id)
    {
    	$loaitin = LoaiTin::find($id);
    	$this->validate($request,
    		[
    			'TenLoaiTin'=>'required|unique:LoaiTin,Ten|min:3|max:100',
    			'TheLoai'=>'required'
    		],
    		[
    			'TenLoaiTin.required'=>'Bạn chưa nhập tên loại tin',
    			'TenLoaiTin.unique'=>'Tên loại tin đã tồn tại, mời bạn nhập tên khác',
    			'TenLoaiTin.min'=>'Tên loại tin phải có độ dài từ 3 đến 100 ký tự',
    			'TenLoaiTin.max'=>'Tên loại tin phải có độ dài từ 3 đến 100 ký tự',
    			'TheLoai.required'=>'Bạn chưa chọn thể loại'
    		]);
    	$loaitin->Ten = $request->TenLoaiTin;
    	$loaitin->TenKhongDau=str_slug($request->TenLoaiTin);
    	$loaitin->idTheLoai = $request->TheLoai;
    	$loaitin->save();

    	return redirect('admin/loaitin/sua/'.$id)->with('thongbao','Đã sửa thành công');
    }
    public function getXoa($id)
    {
    	$loaitin = LoaiTin::find($id);
    	$loaitin->delete();

    	return redirect('admin/loaitin/danhsach')->with('thongbao','Đã xóa thành công');
    }
}
