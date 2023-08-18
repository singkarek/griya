<?php

namespace App\Http\Controllers\Admin\Area;

use App\Models\Spliters;
use App\Models\Placement;
use App\Models\CoverageArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AreaController extends Controller
{
    public function index()
    {   
        // $data = CoverageArea::join('placements', 'coverage_areas.id', '=' , 'placements.area_id')->get();
        $data = CoverageArea::withCount('placements')->get();
        // $data = $coverageAreas = CoverageArea::withCount(['placements' => function ($query) {
        //     $query->where('jenis_tempat', 'Tiang Sendiri');
        // }])->get();

        // dd($data);
        return view('admin.area.index',[
            "areas" => $data
        ]);
    }

    public function create()
    {
        return view('admin.area.create');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama_area' => 'required|max:255',
            'kode_area' => 'required|max:4|min:4|unique:db_coverage.coverage_areas'
        ]);

        $validateData["kode_area"] = strtoupper($validateData["kode_area"]);

        $coverage = CoverageArea::create($validateData);
        $coverage_areas_id =$coverage->id;
    
        $hasilCreate = Spliters::create([
            'coverage_areas_id' => $coverage_areas_id,
            'type_spliter'      => 'backbone',
            'spliter_ke'        => '1',
            'jumlah_output'     => '2'
        ]);
    
        $id_SpliterBackbone = $hasilCreate->id;
    
        $id_distribusi = [];
        for($a = 0 ; $a<2 ; $a++){
            $hasilCreate_distribusi = Spliters::create( [
                'coverage_areas_id' => $coverage_areas_id,
                'type_spliter'      => 'distribusi',
                'parent_id'         => $id_SpliterBackbone,
                'parent_ke'         => '1',
                'spliter_ke'        => $a+1,
                'jumlah_output'     => '8'
            ]);
    
            $id_distribusi[] = $hasilCreate_distribusi->id;
        };
    
        $access = [];
        for($a = 0 ; $a<2 ; $a++){
            $mother_id = $id_distribusi[$a];
            for($b=0;$b<8;$b++){
                $value_spliter = [
                'coverage_areas_id' => $coverage_areas_id,
                'type_spliter'      => 'accsess',
                'parent_id'         => $mother_id,
                'parent_ke'         => $a+1,
                'spliter_ke'        => $b+1,
                'jumlah_output'     => '8'
                ];
                $access[] = $value_spliter;
            };
        };
        Spliters::insert($access);

        $placement = [];
        for($d = 0 ; $d<16 ; $d++){
            $placement[] = [
                'area_id' => $coverage_areas_id, 'nama_tempat' => 'P-'.$d+1
            ];
        };
        Placement::insert($placement);

        return redirect('/admin/area')->with('success', 'Data berhasil ditambahkan !');
    }
}
