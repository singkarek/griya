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
        return view('admin.placement.index',[
            "areas" => "CoverageArea::all()"
        ]);
    }

    public function create()
    {
        return view('admin.placement.create',[
            "areas" => CoverageArea::all()
        ]);
    }

    public function ambiltiang()
    {
        $place = Placement::select('tiang_id')->get();
        $result_pole = Pole::whereNotIn('id', $place)->get();
        return response()->json(['tiangbos' => $result_pole]);
    }


}
