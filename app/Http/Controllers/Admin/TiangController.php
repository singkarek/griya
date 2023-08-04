<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pole;
use App\Models\Placement;
use App\Models\CoverageArea;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TiangController extends Controller
{
    public function index()
    {
        // $place = Placement::select('tiang_id')->get();
        // $result_tiang = Pole::whereNotIn('id', $place)->get();
        $result_tiang = Pole::where('area_id', null)->get();


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

    public function transferTiang()
    {
        
        // $place = Placement::select('tiang_id')->get();
        // $result_tiang = Pole::whereNotIn('id', $place)->get();
        $result_tiang = Pole::where('area_id', null)->get();
        $areas = CoverageArea::all();

        return view('admin.tiang.tranfer-update', [
            'tiangs' => $result_tiang,
            'areas' => $areas
        ]);
    }

    public function tes(Request $request)
    {
        $validateData = $request->validate([
            'area_id' => 'required',
            'tiang' => 'required',
        ]);

        $valueCounts = array_count_values($request->tiang);
        foreach ($valueCounts as $value => $count) {
            if ($count > 1) {
                return redirect('/admin/tiang/transfertiang')->with('error', 'GAGAL, ada tiang yang sama !');
            }
        }
        
        $updates = [];
        foreach ($request->tiang as $t => $value){
            if($value == "null"){
                return redirect('/admin/tiang/transfertiang')->with('error', 'GAGAL, Data tiang kosong !');
            }
            $updates[] = ['id' => $value, 'area_id' => $request->area_id];
        };

        foreach($updates as $update){
            $id = $update['id'];
            $area = ['area_id' => $update['area_id']];
            Pole::where('id', $id)->update($area);
        };

        return redirect('/admin/tiang')->with('success', 'Data berhasil ter-input !');
    }

}
