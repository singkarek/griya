<?php

namespace App\Http\Controllers\Admin;

use App\Models\CoverageArea;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AreaController extends Controller
{
    public function index()
    {
        return view('admin.area.index',[
            "areas" => CoverageArea::all()
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
            'kode_area' => 'required|max:5|min:5|unique:db_coverage.coverage_areas'
        ]);

        $validateData["kode_area"] = strtoupper($validateData["kode_area"]);

        CoverageArea::create($validateData);

        return redirect('/admin/area')->with('success', 'Data berhasil ditambahkan !');
    }
}
