<?php

namespace App\Http\Controllers\Sales;

use App\Models\Pakets;
use App\Models\Metodes;
use App\Models\Spliters;
use App\Models\Prospects;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomersController extends Controller
{
    public function index()
    {
        return view('sales.customers.index',[
            "customers" => Prospects::where('status_akhir','closing')->get()
        ]);   
    }

    public function create()
    {
        return view('sales.customers.create',[
            'metodes' => Metodes::all(),
            'layananpakets' => Pakets::all()
        ]);
    }

    public function store(Request $request)
    {   
        $validateData = $request->validate([
            'metodes_id' => 'required',
            'nama' => 'required|max:255',
            'no_tlp' => 'required|max:20',
            'alamat' => 'required',
            'rt' => 'required|max:11',
            'rw' => 'required|max:11',
            'service_packages_id' => 'required|max:11'
        ]);

        $validateData['status_awal'] = 'closing';
        $validateData['status_akhir'] = 'closing';

        Prospects::create($validateData);

        return redirect('/sales/customers')->with('success', 'Data berhasil ditambahkan !');
    }

    // public function detail(Prospects $customer)
    // {
    //     // dd($customer);
    //     return view('sales/prospect/detail',[
    //         'customer' => $customer
    //     ]);
    // }

    public function editFotoRumah(Prospects $id)
    {
        return view('sales.customers.update-fotorumah',[
            'customer' => $id
        ]);

    }

    public function editKoordinat(Prospects $id)
    {
        return view('sales.customers.update-koordinat', [
            'customer' => $id
        ]);
    }

    public function editAccess(Prospects $id)
    {
        $accsess = Spliters::select(
            'coverage_areas.kode_area',
            'spliters.id', 'spliters.type_spliter', 'spliters.parent_ke', 'spliters.spliter_ke','spliters.coverage_areas_id',
            'placements.nama_tempat', 'placements.alamat', 'placements.lat', 'placements.lng'
            )->join('placements', 'spliters.placement_id', '=', 'placements.id')
            ->join('coverage_areas', 'spliters.coverage_areas_id', '=', 'coverage_areas.id')
            ->whereNotNull('placement_id')
            ->where('spliters.type_spliter', 'accsess')
            ->get();

        return view('sales.customers.update-access', [
            'customer' => $id,
            'accsess' => $accsess
        ]);
    }

    public function editJalur(Prospects $id)
    {
        $accsess = Spliters::select(
            'coverage_areas.kode_area',
            'spliters.id', 'spliters.type_spliter', 'spliters.parent_ke', 'spliters.spliter_ke','spliters.coverage_areas_id',
            'placements.nama_tempat', 'placements.alamat', 'placements.lat', 'placements.lng'
            )->join('placements', 'spliters.placement_id', '=', 'placements.id')
            ->join('coverage_areas', 'spliters.coverage_areas_id', '=', 'coverage_areas.id')
            ->whereNotNull('placement_id')
            ->where('spliters.type_spliter', 'accsess')
            ->get();

        return view('sales.customers.update-access', [
            'customer' => $id,
            'accsess' => $accsess
        ]);
    }


    public function updateKoordinat(Request $request)
    {
        if($request->lat == 'latitude'){
            return redirect('/sales/customers')->with('error', 'Data Koordinat kosong !');
        } 
        $validateData = $request->validate([
            'lat' => 'required',
            'lng' => 'required'
        ]);
        
        Prospects::where('id', $request->id)
            ->update($validateData);

        return redirect('/sales/customers')->with('success', 'Data berhasil ditambahkan !');

    }
    public function updateAccess(Request $request)
    {
        session()->flash('success', 'Data berhasil ditambahkan!');
     
        $validateData = $request->validate([
            'spliter_id' => 'required',
            'coverage_areas_id' => 'required'
        ]);
        
        Prospects::where('id', $request->customer_id)
        ->update($validateData);
        
        return $validateData;
    }
}
