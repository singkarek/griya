<?php

namespace App\Http\Controllers\Admin\Area;

use App\Models\Spliters;
use App\Models\Placement;
use App\Models\CoverageArea;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SplitterController extends Controller
{
    public function index($area_id)
    {
        $data = CoverageArea::Join('placements', 'coverage_areas.id', '=' , 'placements.area_id')
            ->WHERE('placements.area_id',$area_id)->get();

        // $data = CoverageArea::
        //       Join('placements', 'coverage_areas.id', '=' , 'placements.area_id')
        //     ->rightJoin('placements','spliters.placement_id','=','placements.id')
        //     ->WHERE('placements.area_id',$area_id)->get();
        $place = Spliters::WHERE('coverage_areas_id',$area_id)->whereNotNull('placement_id'
        )->get();
        
        // dd($place);
        $data_dua = [];
        for($a=0;$a<count($data) ; $a++){
            $data_dua[] = $data[$a];
            $data_dua[$a]["ok"] = "-";
            for($b=0;$b<count($place);$b++){
                if($data[$a]['id'] == $place[$b]["placement_id"]){
                    $oke = [];
                    for($c=0; $c<count($place);$c++ ){
                        if($data[$a]['id'] == $place[$c]["placement_id"]){
                            if($place[$c]['type_spliter'] == "backbone"){
                                $oke[] = 'Backbone'.".".$place[$c]['spliter_ke'];
                            }elseif($place[$c]['type_spliter'] == "distribusi"){
                                $oke[] = 'Distribusi'.".".$place[$c]['spliter_ke'];
                            }else{
                                $oke[] = 'Accsess'.".".$place[$c]['parent_ke'].".".$place[$c]['spliter_ke'];
                            }
                        }
                    }
                  $data_dua[$a]["ok"] = implode(' / ', $oke);
                }
            }
        }

        // dd($data_dua);
        return view('admin.area.splitter.index',[
            "places" => $data_dua
        ]);
    }

    public function editSplitter($place_id)
    {
        $data = CoverageArea::Join('placements', 'coverage_areas.id', '=' , 'placements.area_id')->WHERE('placements.id',$place_id)->get();
        $splitter = CoverageArea::Join('spliters','coverage_areas.id','=','spliters.coverage_areas_id')
                    ->Where([['coverage_areas_id', $data[0]['area_id']],['placement_id' , null]])->get(); 

        // dd($splitter);
        return view('admin.area.splitter.splitter-add-update',[
            'place' => $data,
            'splitters' => $splitter
        ]);
    }

    public function editRemoveSplitter($place_id)
    {
        $data = CoverageArea::Join('placements', 'coverage_areas.id', '=' , 'placements.area_id')->WHERE('placements.id',$place_id)->get();
        $splitter = CoverageArea::Join('spliters','coverage_areas.id','=','spliters.coverage_areas_id')
                    ->Where([['coverage_areas_id', $data[0]['area_id']],['placement_id' , $place_id]])->get(); 

        // dd($splitter);
        return view('admin.area.splitter.splitter-remove-update',[
            'place' => $data,
            'splitters' => $splitter
        ]);
    }

    public function updateAddSplitter(Request $request)
    {
        $validateData = $request->validate([
            'item' => 'required'
        ]);

        for($a=0;$a<count($validateData['item']);$a++){
            Spliters::where('id', $validateData['item'][$a])->update(['placement_id' => $request['placement_id']]);
        }

        return redirect('/admin/area/splitter/'.$request->area_id)->with('success', 'Data berhasil ditambahkan !');
    }

    public function updateRemoveSplitter(Request $request)
    {
        Spliters::where('placement_id', $request['placement_id'])->update(['placement_id' => null]);

        if($request['item']){
            for($a=0;$a<count($request['item']);$a++){
                Spliters::where('id', $request['item'][$a])->update(['placement_id' => $request['placement_id']]);
            }
        }
 
        return redirect('/admin/area/splitter/'.$request->area_id)->with('success', 'Data berhasil Dihapus !');
    }
}
