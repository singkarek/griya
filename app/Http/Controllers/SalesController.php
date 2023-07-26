<?php
// Sales::select('id')->where('id',7)->get()
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sales;
use App\Models\Pakets;

class SalesController extends Controller
{
    public function index()
    {
       
        return view('sales.index');
    }

    public function complate()
    {
        // dd(Sales::all());
        return view('sales.customers.index',[
            "customers" => Sales::all()
        ]);
    }

    public function createview()
    {
        return view('sales.customers.create',[
            'layananpakets' => Pakets::all()
        ]);
    }
    public function create(Request $request)
    {   
        // dd($request);
        $validateData = $request->validate([
            'nama' => 'required|max:255',
            'no_tlp' => 'required|max:20',
            'alamat' => 'required',
            'rt' => 'required|max:11',
            'rw' => 'required|max:11',
            'paket_layanan' => 'required|max:11'
        ]);

        $validateData['status_akhir'] = 'new input';

        // dd($validateData);

        Sales::create($validateData);

        return redirect('/sales/customer/complate')->with('success', 'Data berhasil ditambahkan!!!');
    }

    public function antrian()
    {
        return view('sales.customers.antrian');
    }

    public function edit(Sales $customer)
    {
        dd($customer);
    }
    public function melengkapi(Sales $customer)
    {
        // dd($customer);
        return view('/sales/customers/melengkapi',[
            'customer' => $customer
        ]);
    }
}
