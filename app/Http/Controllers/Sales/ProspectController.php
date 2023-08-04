<?php

namespace App\Http\Controllers\Sales;

use App\Models\Prospects;
use App\Models\Pakets;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProspectController extends Controller
{
    public function index()
    {
        return view('sales.prospect.index',[
            "customers" => Prospects::all()
        ]);   
    }

    public function create()
    {
        return view('sales.prospect.create',[
            'layananpakets' => Pakets::all()
        ]);
    }

    public function store(Request $request)
    {   
        $validateData = $request->validate([
            'metode' => 'required',
            'nama' => 'required|max:255',
            'no_tlp' => 'required|max:20',
            'alamat' => 'required',
            'rt' => 'required|max:11',
            'rw' => 'required|max:11',
            'paket_layanan_id' => 'required|max:11'
        ]);

        $validateData['closing'] = true;

        Prospects::create($validateData);

        return redirect('/sales/prospect')->with('success', 'Data berhasil ditambahkan !');
    }

    public function detail(Prospects $customer)
    {
        // dd($customer);
        return view('sales/prospect/detail',[
            'customer' => $customer
        ]);
    }

    public function editKoordinat(Prospects $id)
    {
        return view('sales.prospect.edit-koordinat', [
            'prospect' => $id
        ]);
    }

    public function updateKoordinat(Request $request)
    {
        if($request->lat == 'latitude'){
            return redirect('/sales/prospect')->with('error', 'Data Koordinat kosong !');
        } 
        $validateData = $request->validate([
            'lat' => 'required',
            'lng' => 'required'
        ]);
        Prospects::where('id', $request->id)
            ->update($validateData);

        return redirect('/sales/prospect')->with('success', 'Data berhasil ditambahkan !');

    }
}
