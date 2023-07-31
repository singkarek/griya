<?php

namespace App\Http\Controllers\Sales;

use App\Models\Sales;
use App\Models\Pakets;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProspectController extends Controller
{
    public function index()
    {
        return view('sales.prospect.index',[
            "customers" => Sales::all()
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
            'nama' => 'required|max:255',
            'no_tlp' => 'required|max:20',
            'alamat' => 'required',
            'rt' => 'required|max:11',
            'rw' => 'required|max:11',
            'paket_layanan_id' => 'required|max:11'
        ]);

        $validateData['status_akhir'] = 'closing';

        Sales::create($validateData);

        return redirect('/sales/prospect')->with('success', 'Data berhasil ditambahkan !');
    }

    public function detail(Sales $customer)
    {
        // dd($customer);
        return view('sales/prospect/detail',[
            'customer' => $customer
        ]);
    }
}
