<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\LoaiTin;
use App\TinTuc;
use App\Comment;
class TinTucController extends Controller
{
    //
    public function getDanhsach()
    {
    	$tintuc = TinTuc::orderBy('id','DESC')->get();
    	return view('admin.tintuc.danhsach',['tintuc'=>$tintuc]);
    }
    public function getThem()
    {
    	$theloai = TheLoai::all();
    	$loaitin = LoaiTin::all();
    	return view('admin.tintuc.them',['theloai'=>$theloai],['loaitin'=>$loaitin]);
    }
    public function postThem(Request $request)
    {
    	$this->validate($request,
    		[
    			'LoaiTin'=>'required',
    			'TieuDe'=>'required|min:3|unique:TinTuc,TieuDe',
    			'TomTat'=>'required|min:3',
    			'NoiDung'=>'required|min:3',
    			'Hinh' => 'image|mimes:jpeg,jpg,png'
    		],
    		[
    			'LoaiTin.required'=>"Bạn chưa chọn loại tin",
    			'TieuDe.required'=>"Bạn chưa thêm tiêu đề",
    			'TieuDe.min'=>'Tiêu đề phải có ít nhất 3 kí tự',
    			'TieuDe.unique'=>'Tiêu đề đã tồn tại',
    			'TomTat.required'=>'Bạn chưa thêm tóm tắt',
    			'TomTat.min'=>'Tóm tắt phải có ít nhất 3 kí tự',
    			'NoiDung.required'=>'Bạn chưa thêm nội dung',
    			'NoiDung.min'=>'Nội dung phải có ít nhất 10 kí tự',
    			'Hinh.image'=>'File chọn phải là hình ảnh',
    			'Hinh.mimes'=>'Bạn chỉ được chọn file có đuôi jpg, png, jpeg'
    		]);
    	$tintuc = new TinTuc;
    	$tintuc->TieuDe = $request->TieuDe;
    	$tintuc->TieuDeKhongDau = str_slug($request->TieuDe);
    	$tintuc->idLoaiTin = $request->LoaiTin;
    	$tintuc->TomTat = $request->TomTat;
    	$tintuc->NoiDung=$request->NoiDung;
    	$tintuc->SoLuotXem = 0;
    	$tintuc->NoiBat=$request->get('NoiBat',0);
    	if($request->hasFile('Hinh'))
    	{
    		$file = $request->file('Hinh');
    		//kiem tra duoi cua hinh anh
    		// $duoi = $file->getClientOriginalExtension();
    		// if($duoi != "jpg" && $duoi != "png" && $duoi != "jpeg")
    		// {
    		// 	return redirect('admin/tintuc/them')->with('loi','Bạn chỉ được chọn file có đuôi là jpg, png, jpeg');
    		// }
    		//Lay ra ten hinh
    		$name = $file->getClientOriginalName();
    		$Hinh = str_random(4)."_".$name;
    		while(file_exists("upload/tintuc/".$Hinh))
    		{
    			$Hinh = str_random(4)."_".$name;
    		}
    		$file->move("upload/tintuc", $Hinh);
    		$tintuc->Hinh = $Hinh;
    	}
    	else
    	{
    		$tintuc->Hinh ="";
    	}
    	$tintuc->save();
    	return redirect('admin/tintuc/them')->with('thongbao','Đã thêm thành công ');
    }
    public function getSua($id)
    {
    	$theloai = TheLoai::all();
    	$loaitin = LoaiTin::all();
    	$tintuc = TinTuc::find($id);
    	return view('admin.tintuc.sua',['tintuc'=>$tintuc,'theloai'=>$theloai,'loaitin'=>$loaitin]);
    }
    public function postSua(Request $request, $id)
    {
    	$tintuc = TinTuc::find($id);
    	$this->validate($request,
    		[
    			'LoaiTin'=>'required',
    			'TieuDe'=>'required|min:3',
    			'TomTat'=>'required|min:3',
    			'NoiDung'=>'required|min:3',
    			'Hinh' => 'image|mimes:jpeg,jpg,png'
    		],
    		[
    			'LoaiTin.required'=>"Bạn chưa chọn loại tin",
    			'TieuDe.required'=>"Bạn chưa thêm tiêu đề",
    			'TieuDe.min'=>'Tiêu đề phải có ít nhất 3 kí tự',
    			'TomTat.required'=>'Bạn chưa thêm tóm tắt',
    			'TomTat.min'=>'Tóm tắt phải có ít nhất 3 kí tự',
    			'NoiDung.required'=>'Bạn chưa thêm nội dung',
    			'NoiDung.min'=>'Nội dung phải có ít nhất 10 kí tự',
    			'Hinh.image'=>'File chọn phải là hình ảnh',
    			'Hinh.mimes'=>'Bạn chỉ được chọn file có đuôi jpg, png, jpeg'
    		]);
    	$tintuc->TieuDe = $request->TieuDe;
    	$tintuc->TieuDeKhongDau = str_slug($request->TieuDe);
    	$tintuc->idLoaiTin = $request->LoaiTin;
    	$tintuc->TomTat = $request->TomTat;
    	$tintuc->NoiDung=$request->NoiDung;
    	$tintuc->NoiBat=$request->get('NoiBat',0);
    	if($request->hasFile('Hinh'))
    	{
    		$file = $request->file('Hinh');
    		//kiem tra duoi cua hinh anh
    		// $duoi = $file->getClientOriginalExtension();
    		// if($duoi != "jpg" && $duoi != "png" && $duoi != "jpeg")
    		// {
    		// 	return redirect('admin/tintuc/them')->with('loi','Bạn chỉ được chọn file có đuôi là jpg, png, jpeg');
    		// }
    		//Lay ra ten hinh
    		$name = $file->getClientOriginalName();
    		$Hinh = str_random(4)."_".$name;
    		while(file_exists("upload/tintuc/".$Hinh))
    		{
    			$Hinh = str_random(4)."_".$name;
    		}
    		
    		$file->move("upload/tintuc", $Hinh);
    		unlink("upload/tintuc/".$tintuc->Hinh);
    		$tintuc->Hinh = $Hinh;
    	}
    	$tintuc->save();
		return redirect('admin/tintuc/sua/'.$id)->with('thongbao','Đã sửa thành công ');
    }

    public function getXoa($id)
    {
    	$tintuc = TinTuc::find($id);
    	$tintuc->delete();
    	unlink("upload/tintuc/".$tintuc->Hinh);
    	return redirect('admin/tintuc/danhsach')->with('thongbao','Đã xóa thành công ');
	}
}
