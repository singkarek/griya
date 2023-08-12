<?php

namespace App\Http\Controllers\Sales;

use App\Models\Pakets;
use App\Models\Metodes;
use App\Models\Prospects;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProspectController extends Controller
{
    public function index()
    {
        return view('sales.customers.index',[
            "customers" => Prospects::all()
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
        // dd($request);
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

        return redirect('/sales/prospect')->with('success', 'Data berhasil ditambahkan !');
    }

    // public function detail(Prospects $customer)
    // {
    //     // dd($customer);
    //     return view('sales/prospect/detail',[
    //         'customer' => $customer
    //     ]);
    // }

    public function editKoordinat(Prospects $id)
    {
        return view('sales/customers/edit-koordinat', [
            'prospect' => $id
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
}
