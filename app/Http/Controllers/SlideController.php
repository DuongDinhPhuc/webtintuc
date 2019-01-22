<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slide;

class SlideController extends Controller
{
    //
    Public function getDanhsach()
    {
    	$slide = Slide::all();
    	return view('admin.slide.danhsach',['slide'=>$slide]);
    }
    public function getThem()
    {
    	return view('admin.slide.them');
    }
    public function postThem(Request $request)
    {
    	$this->validate($request,
    		[
    			'TenSlide'=>'required',
    			'NoiDung'=>'required',
    			'Hinh'=>'image|mimes:jpg,png,jpeg'
    		],
    		[
    			'TenSlide.required'=>'Bạn chưa nhập tên',
    			'NoiDung.required'=>'Bạn chưa nhập nội dung',
    			'Hinh.image'=>'File chọn phải là hình ảnh',
    			'Hinh.mimes'=>'Bạn chỉ được chọn file có đuôi jpg, png, jpeg'
    		]);
    	$slide = new Slide;
    	$slide->Ten = $request->TenSlide;
    	$slide->Noidung = $request->NoiDung;
    	if($request->has('Link'))
    	{
    		$slide->link = $request->Link;
    	}
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
    		while(file_exists("upload/slide/".$Hinh))
    		{
    			$Hinh = str_random(4)."_".$name;
    		}
    		$file->move("upload/slide", $Hinh);
    		$slide->Hinh = $Hinh;
    	}
    	else
    	{
    		$slide->Hinh ="";
    	}
    	$slide->save();
    	return redirect('admin/slide/them')->with('thongbao','Đã thêm thành công');
    }
    public function getSua($id)
    {
    	$slide = Slide::find($id);
    	return view('admin.slide.sua',['slide'=>$slide]);
    }
    public function postSua(Request $request,$id)
    {
    	$this->validate($request,
    		[
    			'TenSlide'=>'required',
    			'NoiDung'=>'required',
    			'Hinh'=>'image|mimes:jpg,png,jpeg'
    		],
    		[
    			'TenSlide.required'=>'Bạn chưa nhập tên',
    			'NoiDung.required'=>'Bạn chưa nhập nội dung',
    			'Hinh.image'=>'File chọn phải là hình ảnh',
    			'Hinh.mimes'=>'Bạn chỉ được chọn file có đuôi jpg, png, jpeg'
    		]);
    	$slide=Slide::find($id);
    	$slide->Ten = $request->TenSlide;
    	$slide->Noidung = $request->NoiDung;
    	if($request->has('Link'))
    	{
    		$slide->link = $request->Link;
    	}
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
    		while(file_exists("upload/slide/".$Hinh))
    		{
    			$Hinh = str_random(4)."_".$name;
    		}
    		unlink("upload/slide/".$slide->Hinh);
    		$file->move("upload/slide", $Hinh);
    		$slide->Hinh = $Hinh;
    	}
    	$slide->save();
    	return redirect('admin/slide/sua/'.$id)->with('thongbao','Đã sửa thành công');
    }
    public function getXoa($id)
    {
    	$slide = Slide::find($id);
    	$slide->delete();
    	unlink("upload/slide/".$slide->Hinh);
    	return redirect('admin/slide/danhsach')->with('thongbao','Đã xóa thành công');
    }
}
