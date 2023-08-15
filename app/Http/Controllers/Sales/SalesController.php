<?php
// Sales::select('id')->where('id',7)->get()
namespace App\Http\Controllers\Sales;

use App\Models\Sales;
use App\Models\Pakets;
use App\Models\Spliters;
use App\Models\CoverageArea;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SalesController extends Controller
{
    public function index()
    {
        return view('sales.index');
    }

    public function antrian()
    {
        return view('sales.prospect.antrian');
    }

    public function mapsAccess()
    {
        // $accsess = CoverageArea::Join('placements', 'coverage_areas.id', '=' , 'placements.area_id')->get();
        // 'spliters.type_spliter', 'spliters.id'
        $accsess = Spliters::select(
            'coverage_areas.kode_area',
            'spliters.id', 'spliters.type_spliter', 'spliters.parent_ke', 'spliters.spliter_ke','spliters.coverage_areas_id',
            'placements.nama_tempat', 'placements.alamat', 'placements.lat', 'placements.lng'
            )->join('placements', 'spliters.placement_id', '=', 'placements.id')
            ->join('coverage_areas', 'spliters.coverage_areas_id', '=', 'coverage_areas.id')
            ->whereNotNull('placement_id')
            ->where('spliters.type_spliter', 'accsess')
            ->get();

        // dd($accsess);
                // ->WHERE('placements.area_id',$id)->get();
        return view('sales.map-access',[
            'accsess' => $accsess
        ]);
    }

}
