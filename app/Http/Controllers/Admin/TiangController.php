<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pole;
use App\Models\Placement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TiangController extends Controller
{
    public function index()
    {
        $place = Placement::select('tiang_id')->get();
        $result_tiang = Pole::whereNotIn('id', $place)->get();

        return view('admin.tiang.index',[
            "tiangs" => $result_tiang,

        ]);
    }

    public function create()
    {
        return view('admin.tiang.create');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'ref' => 'required|max:15',
            'vendor' => 'required',
            'tinggi' => 'required',
            'ukuran' => 'required',
            'tebal' => 'required',
            'harga' => 'required',
            'jumlah_tiang' => 'required',
        ]);


        $nilai_terahir = Pole::count()+1;
        $harga = $validateData["harga"] / $validateData["jumlah_tiang"] ;
        $ref = strtoupper($validateData["ref"]);
        $vendor = strtoupper($validateData["vendor"]);
        $banyak_tiang = $validateData["jumlah_tiang"];

        $data_tiang = [];
        
        for($a = 0 ; $a<$banyak_tiang ; $a++){
            $nama_tiang = "T-".$a+$nilai_terahir;
            $data_tiang[] = [
                "ref" => $ref, "vendor" => $vendor,
                "tinggi" => $validateData["tinggi"],"ukuran" => $validateData["ukuran"],
                "tebal" => $validateData["tebal"], "harga" => $harga,
                "nama_tiang" => $nama_tiang
            ];
        };


        Pole::insert($data_tiang);
        return redirect('/admin/tiang')->with('success', 'Data berhasil ditambahkan !');
    }
}
