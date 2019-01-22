<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TheLoai extends Model
{
    //
    protected $table = "theloai";

    public function loaitin()
    {
    	return $this->hasMany('App\LoaiTin','idTheLoai','id');
    }

    public function tintuc()
    {
    	//Đối số thứ 1 là model cuối cùng chúng ta muốn truy cập
    	//Đối số thứ 2 là modeltrung gian
    	//Đối số thứ 3 là khó phụ của model trung gian 
    	//Đối số thứ 4 là khóa phụ của model cuối cùng
    	//Đối số thứ 5 là khóa chính 
    	return $this->hasManyThrough('App\TinTuc','App\LoaiTin','idTheLoai','idLoaiTin','id');
    }
}
