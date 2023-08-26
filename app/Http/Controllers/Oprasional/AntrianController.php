<?php

namespace App\Http\Controllers\Oprasional;

use App\Models\User;
use App\Models\Modems;
use App\Models\Customers;
use App\Models\VaCustomer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PsbWorkOrders;
use App\Models\ProspectPlaces;
use App\Models\ProspectPoints;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class AntrianController extends Controller
{
    public function requestvalidasi()
    {
        $request_validasi = PsbWorkOrders::
          join('griya_customers.customers','psb_work_orders.pppoe_secret','=','griya_customers.customers.pppoe_secret')
        ->join('griya_customers.customers_alamat_maps','psb_work_orders.pppoe_secret','=','griya_customers.customers_alamat_maps.pppoe_secret')
        ->join('griya_customers.customers_alamat_terpasang','psb_work_orders.pppoe_secret','=','griya_customers.customers_alamat_terpasang.pppoe_secret')
        ->join('griya_company.service_packages','griya_customers.customers.service_packages_id','=','griya_company.service_packages.id')
        ->where('status_wo','!=','terpasang')
        ->where('status_wo','=','prosess_validasi')
        ->get();

        // dd($request_validasi);
        return view('oprasional.new-customers.request-validasi',[
           'customers' => $request_validasi
        ]);
    }

    public function riviewValidasi($pppoe_secret)
    {
        $data_customers = PsbWorkOrders::
            join('griya_customers.customers','psb_work_orders.pppoe_secret','=','griya_customers.customers.pppoe_secret')
        ->join('griya_customers.customers_alamat_maps','psb_work_orders.pppoe_secret','=','griya_customers.customers_alamat_maps.pppoe_secret')
        ->join('griya_customers.customers_alamat_terpasang','psb_work_orders.pppoe_secret','=','griya_customers.customers_alamat_terpasang.pppoe_secret')
        ->join('griya_company.service_packages','griya_customers.customers.service_packages_id','=','griya_company.service_packages.id')
        ->join('griya_coverage.spliters','griya_customers.customers.spliter_id','=','griya_coverage.spliters.id')
        ->join('griya_coverage.coverage_areas','griya_customers.customers.coverage_areas_id','=','griya_coverage.coverage_areas.id')
        ->join('griya_coverage.placements','griya_coverage.spliters.placement_id','=','griya_coverage.placements.id')
        ->where('griya_customers.customers.pppoe_secret','=',$pppoe_secret)
        ->get();

        return view('oprasional.new-customers.riview-validasi',[
            'customers' => $data_customers
        ]);
    }

    public function waitList()
    {
        $wait_payment = PsbWorkOrders::
            join('griya_customers.customers','psb_work_orders.pppoe_secret','=','griya_customers.customers.pppoe_secret')
        ->join('griya_customers.customers_alamat_maps','psb_work_orders.pppoe_secret','=','griya_customers.customers_alamat_maps.pppoe_secret')
        ->join('griya_customers.customers_alamat_terpasang','psb_work_orders.pppoe_secret','=','griya_customers.customers_alamat_terpasang.pppoe_secret')
        ->join('griya_company.service_packages','griya_customers.customers.service_packages_id','=','griya_company.service_packages.id')
        ->where(function($query) {
            $query->where('subscribe_status', '=', 'pra_wo')
                  ->orWhere('subscribe_status', '=', 'paid');
        })
        ->where('status_wo','=','tervalidasi')
        ->where('status_proggres','=',null)
        ->get();

        // dd($wait_payment);
        return view('oprasional.new-customers.wait-payment',[
            'customers' => $wait_payment
        ]);
    }

    // public function waitaAtrian()
    // {
    //     $wait_jadwal = PsbWorkOrders::
    //         join('griya_customers.customers','psb_work_orders.pppoe_secret','=','griya_customers.customers.pppoe_secret')
    //     ->join('griya_customers.customers_alamat_maps','psb_work_orders.pppoe_secret','=','griya_customers.customers_alamat_maps.pppoe_secret')
    //     ->join('griya_customers.customers_alamat_terpasang','psb_work_orders.pppoe_secret','=','griya_customers.customers_alamat_terpasang.pppoe_secret')
    //     ->join('griya_company.service_packages','griya_customers.customers.service_packages_id','=','griya_company.service_packages.id')
    //     ->where('subscribe_status','=','paid')
    //     ->where('status_wo','=','tervalidasi')
    //     ->get();

    //     dd($wait_jadwal);

    //     return view('oprasional.new-customers.wait-jadwal',[
    //         'customers' => $wait_jadwal
    //     ]);
    // }

    public function penjadwalan()
    {
        $customers = PsbWorkOrders::
            join('griya_customers.customers','psb_work_orders.pppoe_secret','=','griya_customers.customers.pppoe_secret')
        ->join('griya_customers.customers_alamat_maps','psb_work_orders.pppoe_secret','=','griya_customers.customers_alamat_maps.pppoe_secret')
        ->join('griya_customers.customers_alamat_terpasang','psb_work_orders.pppoe_secret','=','griya_customers.customers_alamat_terpasang.pppoe_secret')
        ->join('griya_company.service_packages','griya_customers.customers.service_packages_id','=','griya_company.service_packages.id')
        ->join('griya_coverage.spliters','griya_customers.customers.spliter_id','=','griya_coverage.spliters.id')
        ->join('griya_coverage.coverage_areas','griya_customers.customers.coverage_areas_id','=','griya_coverage.coverage_areas.id')
        ->join('griya_coverage.placements','griya_coverage.spliters.placement_id','=','griya_coverage.placements.id')
        ->where('griya_customers.customers.subscribe_status','=','paid')
        ->where('status_proggres','=',null)
        ->get();
        
        $modem = Modems::where('status','ready')->get();

        $teknisi = User::where('division_id','2')->get();

        // dd($customers);
    
        return view('oprasional.new-customers.penjadwalan',[
            'customers' => $customers,
            'modems' => $modem,
            'teknisi' => $teknisi
        ]);
    }

    public function jalur($pppoe_secret)
    {
        $customers = PsbWorkOrders::
        select(
            'griya_customers.customers.*',
            'griya_customers.customers_alamat_maps.*',
            'griya_coverage.spliters.*',
            'griya_coverage.placements.*','griya_coverage.placements.lat AS access_lat','griya_coverage.placements.lng AS access_lng',
        )
        ->join('griya_customers.customers','psb_work_orders.pppoe_secret','=','griya_customers.customers.pppoe_secret')
        ->join('griya_customers.customers_alamat_maps','psb_work_orders.pppoe_secret','=','griya_customers.customers_alamat_maps.pppoe_secret')
        ->join('griya_coverage.spliters','griya_customers.customers.spliter_id','=','griya_coverage.spliters.id')
        ->join('griya_coverage.placements','griya_coverage.spliters.placement_id','=','griya_coverage.placements.id')
        ->where('griya_customers.customers.pppoe_secret','=',$pppoe_secret)
        ->get();

    

        $jalur = ProspectPlaces::with('points')->where('prospect_id','=',$customers[0]->prospects_id)->get();
        $points = $jalur[0]['points'];

        return view('oprasional.new-customers.update-jalur',[
            'customer' => $customers,
            'jalur' => $points
        ]);
    }

    public function jalurStore(Request $request)
    {

        // return $hapus->id;
        $prospect_id = $request->prospect_id;
        $places = $request->places;
        $points = $request->points;

        // return $prospect_id;
        $hapus = ProspectPlaces::where('prospect_id',$prospect_id)->first();
        if($hapus){
            $hapus->delete();
        }
        ProspectPoints::where('place_id',$hapus->id)->delete();
        $id_place = ProspectPlaces::create($places);

        foreach ($points as &$item) {
            $item['place_id'] = $id_place->id;
        }
        unset($item); // Hapus referensi terakhir

        ProspectPoints::insert($points);

        return "oke";
    }

    public function validasiReq(Request $request)
    {

        // dd($customer_va);

        $customers = PsbWorkOrders::join('griya_customers.customers','psb_work_orders.pppoe_secret','=','griya_customers.customers.pppoe_secret')
        ->join('griya_customers.customers_alamat_maps','psb_work_orders.pppoe_secret','=','griya_customers.customers_alamat_maps.pppoe_secret')
        ->join('griya_coverage.spliters','griya_customers.customers.spliter_id','=','griya_coverage.spliters.id')
        ->join('griya_coverage.placements','griya_coverage.spliters.placement_id','=','griya_coverage.placements.id')
        ->join('griya_company.service_packages','griya_customers.customers.service_packages_id','=','griya_company.service_packages.id')
        ->where('griya_customers.customers.pppoe_secret','=',$request->pppoe_secret)
        ->get();

        $pppoe_secret = $request->pppoe_secret;
        $type_customer = $customers[0]['type_customer'];
        $customer_name = $customers[0]['nama'];
        $harga_layanan = $customers[0]['harga'];
        $nama_layanan = $customers[0]['nama_layanan'];
        $customer_va =  $customers[0]['va'];

        if($type_customer == 3){
            Customers::where('pppoe_secret',$request->pppoe_secret)->update(['subscribe_status'=>'paid']);
            PsbWorkOrders::where('pppoe_secret',$request->pppoe_secret)->update(['status_wo'=>'tervalidasi']);
            return redirect('/oprasional/antrian/requestvalidasi')->with('success', 'berhasil Tervalidasi!');
        }
        $pesan = Http::asForm()->post(env('WHATSAPP'), [
            'number' => $customers[0]['no_tlp'],
            'message' =>  'Hallo '.$customer_name ."\n"."\n".'Data anda sudah terverifikasi sebagai berikut : '."\n".
            'Nama Pelanggan : '.$customer_name."\n".
            'Nomor Pelanggan : '.$pppoe_secret."\n".
            'Paket Layanan : '.$nama_layanan."\n".
            'Harga Layanan : '.'Rp. '.$harga_layanan."\n".
            "\n".'Mohon melakukan pembayaran dari salah satu nomor virtual account berikut :'."\n".
            'BCA : '.'19005614'.$customer_va."\n".
            'Mandiri : '.'19005614'.$customer_va."\n".
            'BRI : '.'142321'.$customer_va."\n".
            'Alfamart : '.'352220'.$customer_va."\n".
            'Indomart : '.'352221'.$va."\n"
            ."\n".'Silakan segera melakukan pembayaran untuk segera di proses pemasangan anda, Terimakasih',
        ]);

        // dd($customers[0]);
        PsbWorkOrders::where('pppoe_secret',$request->pppoe_secret)->update(['status_wo'=>'tervalidasi']);
        return redirect('/oprasional/antrian/requestvalidasi')->with('success', 'berhasil Tervalidasi!');
    }

    public function penjadwalanUpdate(Request $request)
    {   
        $validatedata = $request->validate([
            'pppoe_secret' => 'required',
            'katim_id' => 'required',
            'tgl_jadwal' => 'required|date',
            'sn_modem' => 'required'
        ]);

        $validatedata['tgl_jadwal'] = Carbon::createFromFormat('d-m-Y', $validatedata['tgl_jadwal'])->format('Y-m-d');


        $modem = [
            'status' => 'terpakai',
            'pppoe_secret' => $validatedata['pppoe_secret']
        ];

        $wo = [
            'status_proggres' => 'jadwal_terbit',
            'katim_id' => $validatedata['katim_id'],
            'tgl_jadwal' => $validatedata['tgl_jadwal']
        ];
        Customers::where('pppoe_secret', $validatedata['pppoe_secret'])->update(['sn_modem' => $validatedata['sn_modem']]);
        PsbWorkOrders::where('pppoe_secret', $validatedata['pppoe_secret'])->update($wo);
        Modems::where('sn',$validatedata['sn_modem'])->update($modem);
        return redirect('/oprasional/antrian/penjadwalan')->with('success','Berhasil Dijadwalkan');
        // dd($modem);
    }

}
