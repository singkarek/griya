<?php

namespace App\Http\Controllers\Admin;

use App\Models\Spliters;
use App\Models\SpliterOuts;
use App\Models\CoverageArea;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BackboneController extends Controller
{
//     public function index()
//     {
//         // $data = CoverageArea::Joinlef('placements', 'coverage_areas.id', '=' , 'placements.area_id')->where('placements.id',$id->id)->get();
//         // dd($data);
        
//         $spliters = Spliters::select('coverage_areas_id')->get();
//         $areas = CoverageArea::whereNotIn('id', $spliters)->get();

//         // dd($areas);
//         return view('sales.splitter.backbone.index',[
//             'areas' => $areas
//         ]);

    
//     }
// }

// public function index()
// {
//     $coverage_areas_id = 3;
    
//     $hasilCreate = Spliters::create([
//         'coverage_areas_id' => $coverage_areas_id,
//         'type_spliter'      => 'backbone',
//         'spliter_ke'        => '1',
//         'jumlah_output'     => '2'
//     ]);

//     $id_SpliterBackbone = $hasilCreate->id;

//     $id_distribusi = [];
//     for($a = 0 ; $a<2 ; $a++){
        
//         $hasilCreate_distribusi = Spliters::create( [
//             'coverage_areas_id' => $coverage_areas_id,
//             'type_spliter'      => 'distribusi',
//             'mother_id'         => $id_SpliterBackbone,
//             'spliter_ke'        => $a+1,
//             'jumlah_output'     => '8'
//         ]);

//         $id_distribusi[] = $hasilCreate_distribusi->id;
//     };

//     $access = [];
//     for($a = 0 ; $a<2 ; $a++){
//         $mother_id = $id_distribusi[$a];
//         for($b=0;$b<8;$b++){
//             $value_spliter = [
//             'coverage_areas_id' => $coverage_areas_id,
//             'type_spliter'      => 'accsess',
//             'mother_id'         => $mother_id,
//             'spliter_ke'        => $b+1,
//             'jumlah_output'     => '8'
//             ];
//             $access[] = $value_spliter;
//         };
//     };
    // Spliters::insert($access);
    // dd($access);

// }

    // public function index()
    // {
    //     $coverage_areas_id = 3;


    //     $hasilCreate = Spliters::create([
    //         'coverage_areas_id' => $coverage_areas_id,
    //         'type_spliter'      => 'backbone',
    //         'spliter_ke'        => '1',
    //         'jumlah_output'     => '2'
    //     ]);

    //     $idSpliterBackbone = $hasilCreate->id;

    //     $idCoreOutBackbone = [];
    //     for($i = 0 ; $i < 2 ; $i++){
    //         $idCoreOutBackbone[] = [
    //             'coverage_areas_id' => $coverage_areas_id,'spliter_id' => $idSpliterBackbone, 
    //             'type_spliter'=> 'backbone','port_out_ke' => $i+1 
    //         ];
    //     };
    //     SpliterOuts::insert($idCoreOutBackbone);

    //     $cariIdcoreoutBackbone = SpliterOuts::where('spliter_id', $idSpliterBackbone)->get();
        
    //     $id_distribusi = [];
    //     for($a = 0 ; $a<2 ; $a++){
    //         $spliter_in_backbone = $cariIdcoreoutBackbone[$a]['id'];
    //         $hasilCreate_distribusi = Spliters::create( [
    //             'type_spliter'=> 'distribusi' ,'spliter_ke' => $a+1,
    //             'core_in_id' =>$spliter_in_backbone, 'jumlah_output' => '8',
    //             'coverage_areas_id' => $coverage_areas_id
    //         ]);
    //         $id_distribusi[] = $hasilCreate_distribusi->id;
    //     };
      
    //     for($a = 0 ; $a<2 ; $a++){
    //         for($b=0;$b<8;$b++){
    //             $hasilCreate_out_distribusi = SpliterOuts::create([
    //                 'coverage_areas_id' => $coverage_areas_id,'spliter_id' => $id_distribusi[$a],
    //                 'type_spliter'=> 'distribusi', 'port_out_ke' => $b+1
    //             ]);
    //             $id_output_distribusi = $hasilCreate_out_distribusi->id;
    //             $hasilCreate_out_accsess = Spliters::create( [
    //                         'type_spliter'=> 'accsess' ,'spliter_ke' => $b+1,
    //                         'core_in_id' =>$id_output_distribusi, 'jumlah_output' => '8',
    //                         'coverage_areas_id' => $coverage_areas_id
    //                         ]);


    //         };
    //     };

      

    // }

}