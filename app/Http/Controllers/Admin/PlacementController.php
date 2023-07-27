<?php

namespace App\Http\Controllers\Admin;

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
}
