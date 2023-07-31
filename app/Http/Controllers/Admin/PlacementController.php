<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pole;
use App\Models\Placement;
use App\Models\CoverageArea;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlacementController extends Controller
{
    public function index()
    {
        // $data = Placement::Join('coverage_areas', 'placements.area_id', '=' , 'coverage_areas.id')->get();
        $data = CoverageArea::Join('placements', 'coverage_areas.id', '=' , 'placements.area_id')->get();

        // dd($data);
        return view('admin.placement.index',[
            "places" => $data
        ]);
    }

    public function create()
    {
    
        return view('admin.placement.create',[
            "areas" => CoverageArea::all()
        ]);
    }


    public function store(Request $request)
    {
        $validateData = $request->validate([
            'area_id' => 'required',
            'jenis_tempat' => 'required',
            'tiang_id'=> 'required'
        ]);

        if($validateData['jenis_tempat'] == "Tiang Sendiri" && $validateData['tiang_id'] == 0){
            return redirect('/admin/placement/create')->with('error', 'Data tiang kosong !');
        };

        $id_area = $validateData['area_id'];

        $hasil_cover = Placement::where('area_id',$id_area)->count()+1;
        $namatempat = 'P-'.$hasil_cover;

        $validateData['nama_tempat'] = $namatempat;

        Placement::create($validateData);

        return redirect('/admin/placement')->with('success', 'Data berhasil ditambahkan !');
    }

    public function edit(Placement $id)
    {
        $data = CoverageArea::Join('placements', 'coverage_areas.id', '=' , 'placements.area_id')->where('placements.id',$id->id)->get();
        // dd($data);
        return view('admin.placement.map',[
            'data' => $data[0]
        ]);
    }

    public function update_koordinat(Request $request)
    {  
        if($request->lat == 'latitude'){
            return redirect('/admin/placement')->with('error', 'Data Koordinat kosong !');
        } 
        $validateData = $request->validate([
            'lat' => 'required',
            'lng' => 'required'
        ]);
        Placement::where('id', $request->id)
            ->update($validateData);

        return redirect('/admin/placement')->with('success', 'Data berhasil ditambahkan !');
    }

    public function map()
    {
        return view('admin.placement.map');
    }

    public function ambiltiang()
    {
        $place = Placement::select('tiang_id')->get();
        $result_pole = Pole::whereNotIn('id', $place)->get();
        return response()->json(['tiang' => $result_pole]);
    }


}
