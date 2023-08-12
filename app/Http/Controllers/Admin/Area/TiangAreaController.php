<?php

namespace App\Http\Controllers\Admin\Area;

use App\Models\Pole;
use App\Models\Placement;
use App\Models\CoverageArea;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TiangAreaController extends Controller
{
    // $data = Placement::Join('coverage_areas', 'placements.area_id', '=' , 'coverage_areas.id')->get();
    // $data = 
    public function index($id)
    {
        $data = CoverageArea::Join('placements', 'coverage_areas.id', '=' , 'placements.area_id')->WHERE('placements.area_id',$id)->get();
        return view('admin.area.tiang.index',[
            "places" => $data
        ]);
    }

    public function updateTempat(Request $request)
    {
        $validateData = $request->validate([
            'jenis_tempat' => 'required',
            'tiang_id'=> 'required'
        ]);

       
        if($validateData['jenis_tempat'] == "Tiang Sendiri" && $validateData['tiang_id'] == 0){
            return redirect('/admin/area/tiang/'.$request->area_id)->with('error', 'Data tiang kosong !');
        };
               
        if($validateData['jenis_tempat'] == "Tiang Sendiri"){
            $cek_tiang = Placement::where('tiang_id', $validateData['tiang_id'])->count();
            if($cek_tiang > 0 ){
                Placement::where('tiang_id', $validateData['tiang_id'])
                ->update(['tiang_id'=>'0','jenis_tempat' => null]);
            }
        }
        // dd($cek_tiang);

        Placement::where('id', $request->id)
        ->update($validateData);

        return redirect('/admin/area/tiang/'.$request->area_id)->with('success', 'Data berhasil ditambahkan !');
    }

    public function createTempat($id, $type)
    {
        // dd($type);
        // $cover_area = CoverageArea::where('id', $area)->get();
        // $place = Placement::where('id',$id)->get();
        // dd($cover_area);
        $data = CoverageArea::Join('placements', 'coverage_areas.id', '=' , 'placements.area_id')->WHERE('placements.id',$id)->get();

        return view('admin.area.tiang.tiang-update',[
            'place' => $data,
            'type' => $type
        ]);
    }

    public function editKoordinat(Placement $id)
    {
        $data = CoverageArea::Join('placements', 'coverage_areas.id', '=' , 'placements.area_id')->where('placements.id',$id->id)->get();
        return view('admin.area.tiang.map-update',[
            'data' => $data[0]
        ]);
    }

    public function updateKoordinat(Request $request)
    {  

        if($request->lat == 'latitude'){
            return redirect('/admin/area/tiang/'.$request->area_id)->with('error', 'Data Koordinat kosong !');
        } 
        $validateData = $request->validate([
            'lat' => 'required',
            'lng' => 'required',
            'alamat' => 'required'
        ]);

        Placement::where('id', $request->id)
            ->update($validateData);

        return redirect('/admin/area/tiang/'.$request->area_id)->with('success', 'Data berhasil ditambahkan !');
    }

    public function getTiang($area, $type)
    {
        if($type == 'edit'){
            $result_pole = Pole::leftJoin('placements', 'pole.id' , '=' , 'placements.tiang_id' )->where('pole.area_id', $area)->get();

        }else{
            $place = Placement::select('tiang_id')->where('area_id', $area)->get();
            $result_pole = Pole::whereNotIn('id', $place)->where('area_id', $area)->get();
        }
        return response()->json(['tiang' => $result_pole]);
    }

}
