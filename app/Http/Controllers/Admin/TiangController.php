<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tiang;
use App\Models\Placement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TiangController extends Controller
{
    public function index()
    {
        $place = Placement::select('tiang_id')->get();

        return view('admin.tiang.index',[
            "tiangs" => Tiang::whereNotIn('id', $place)->get(),

        ]);
    }

    public function create()
    {
        return view('admin.tiang.create');
    }

    public function store(Request $request)
    {
        $nilai_terahir = Tiang::count()+1;

        $data_tiang = [];
        $harga = $request->harga / $request->jumlah_tiang ;
        
        for($a = 0 ; $a<$request->jumlah_tiang ; $a++){
            $nama_tiang = "T".$a+$nilai_terahir;
            $data_tiang[] = ["nama_tiang" => $nama_tiang, "harga" => $harga];
        };

        Tiang::insert($data_tiang);


        // return view('admin.tiang.create');
    }
}
