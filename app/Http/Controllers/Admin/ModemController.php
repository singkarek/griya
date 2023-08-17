<?php

namespace App\Http\Controllers\Admin;

use App\Models\Modems;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class ModemController extends Controller
{
    public function index()
    {
        return view('admin.modem.index');
    }

    public function create()
    {
        return view('admin.modem.create');
    }
    
    public function store(Request $request)
    {
        $request["totalharga"] = str_replace(',', '', $request->totalharga);
        $validateData = $request->validate([
            'supplier' => 'required',
            'totalharga' => 'required|numeric'
        ]);

        if($request->serial_number[0] == null){
            return redirect('/admin/modem/create')->with('error', 'SN kosong !');
        }

        $total_harga = $validateData['totalharga'];

        $sn_modem = $filteredArray = array_values(array_filter($request->serial_number, function ($value) {
            return $value !== null;
        }));

        $supplier = Str::upper($request->supplier);
        $hari_ini = Carbon::now()->format('Y-m-d');

        $panjang = count($sn_modem);
        $harga_pcs = $total_harga/$panjang;

        $data_modem = [];
        for($a=0;$a<$panjang;$a++){
            $data_modem[] = [
                'supplier' => $supplier,
                'brand' => $request->brand,
                'type' => $request->type,
                'connector' => $request->connector,
                'sn' => $sn_modem[$a],
                'harga' => $harga_pcs,
                'tanggal_belanja' => $hari_ini
            ];
        };

        // dd($data_modem);

        Modems::insert($data_modem);
        return redirect('/admin/modem')->with('success', 'Data berhasil ditambahkan !');
    }
}
