<?php

namespace App\Http\Controllers\Sales;

use App\Models\User;
use App\Models\Pakets;
use App\Models\Metodes;
use App\Models\Spliters;
use App\Models\Customers;
use App\Models\Prospects;
use App\Models\VaCustomer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PsbWorkOrders;
use App\Models\ProspectPlaces;
use App\Models\ProspectPoints;
use Illuminate\Support\Carbon;
use App\Models\ProspectSegments;
use Illuminate\Support\Facades\DB;
use App\Models\CustomersAlamatMaps;
use App\Http\Controllers\Controller;
use App\Models\CustomersAlamatTerpasang;

class CustomersController extends Controller
{
    public function index()
    {
        $nip = auth()->user()->karyawan_nip;
        $admin = auth()->user()->is_admin;

        $customer = Prospects::where([
            ['status_akhir','=','closing'],
            ['status_proggres','!=','proses_pengajuan'],
            ['sales_nip','=',$nip],
            ['is_admin','=',$admin]
            ])->get();
        return view('sales.customers.index',[
            "customers" => $customer
        ]);   
    }

    public function create()
    {
        $nip = auth()->user()->karyawan_nip;
        $admin = auth()->user()->is_admin;

        return view('sales.customers.create',[
            'metodes'       => Metodes::all(),
            'layananpakets' => Pakets::all(),
            'sales_survey' => User::where('division_id','1')->get(),
            'sales_nip' => $nip,
            'is_admin' => $admin
        ]);
    }

    public function store(Request $request)
    {   
        // dd($request);
        $validateData = $request->validate([
            'sales_nip' => 'required',
            'is_admin' => 'required',
            'type_customer' => 'required',
            'metodes_id' => 'required',
            'nama'   => 'required|max:255',
            'no_tlp' =>  ['required', 'regex:/^[a-zA-Z0-9]+$/'] ,
            'alamat' => 'required',
            'rt' => 'required|max:11',
            'rw' => 'required|max:11',
            'service_packages_id' => 'required|max:11'
        ]);

        if (substr($validateData['no_tlp'], 0, 1) === '0') {
           $validateData['no_tlp'] = '62' . substr($validateData['no_tlp'], 1); // Replace leading 0 with 62
        }

        $validateData['status_awal'] = 'closing';
        $validateData['status_akhir'] = 'closing';
        $validateData['status_proggres'] = 'koordinat';
    
        Prospects::create($validateData);

        return redirect('/sales/customers')->with('success', 'Data berhasil ditambahkan !');
    }

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
        $accsess = Spliters::
        select('coverage_areas.kode_area',
        'spliters.id', 'spliters.type_spliter', 'spliters.parent_ke', 'spliters.spliter_ke','spliters.coverage_areas_id',
        'placements.nama_tempat', 'placements.alamat', 'placements.lat', 'placements.lng'
        )->join('placements', 'spliters.placement_id', '=', 'placements.id')
        ->join('coverage_areas', 'spliters.coverage_areas_id', '=', 'coverage_areas.id')
        ->whereNotNull('placement_id')
        ->where('spliters.type_spliter', 'accsess')
        ->withCount(['customers' => function ($query) {
            $query->where('subscribe_status', '!=' ,'terminate');
        }])->get();

        return view('sales.customers.update-access', [
            'customer' => $id,
            'accsess' => $accsess
        ]);
    }

    public function editJalur($id)
    {
        
        $data_customer = Prospects::
                select('prospects.*','prospects.id as prospects_id', 'prospects.lat as lat_prospect','prospects.lng as lng_prospect' , 
                    'griya_coverage.spliters.*','griya_coverage.placements.*')
                ->join('griya_coverage.spliters','prospects.spliter_id','=','griya_coverage.spliters.id')
                ->join('griya_coverage.coverage_areas','prospects.coverage_areas_id','=','griya_coverage.coverage_areas.id')
                ->join('griya_coverage.placements','griya_coverage.spliters.placement_id','=','griya_coverage.placements.id')
                ->where('prospects.id', $id)->get();
        // dd($data_customer);
        return view('sales.customers.update-jalur', [
            'customer' => $data_customer[0]
        ]);
    }


    public function updateKoordinat(Request $request)
    {
    
        if($request->lat == 'latitude'){
            return redirect('/sales/customers')->with('error', 'Data Koordinat kosong !');
        } 
        $validateData = $request->validate([
            'lat' => 'required',
            'lng' => 'required',
            'm_no' => 'required',
            'm_jln' => 'required',
            'm_kel' => 'required',
            'm_kec' => 'required',
            'm_kota' => 'required',
            'm_type' => 'required'
        ]);

        $validateData['status_proggres'] = 'access';

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
        $validateData['status_proggres'] = 'jalur';

        Prospects::where('id', $request->customer_id)
        ->update($validateData);
        
        return $validateData;
    }

    public function jalurStore(Request $request)
    {
        $prospect_id = $request->prospect_id;
        $segments_raw = $request->segments;

        $places = $request->places;
        $points = $request->points;

        $id_place = ProspectPlaces::create($places);

        foreach ($points as &$item) {
            $item['place_id'] = $id_place->id;
        }
        unset($item); // Hapus referensi terakhir

        ProspectPoints::insert($points);
        Prospects::where('id', $prospect_id)->update(['status_proggres' => 'siap_pengajuan']);

        return "oke";
    }

    public function pengajuanPasang($id)
    {
        [$prospect] = Prospects::where('id', $id)->get();
        $no_urut_seluruh_customers = Customers::count()+1;

        $lengthVa = Str::length($no_urut_seluruh_customers);
        $limit = 9-$lengthVa;
        $p = Str::repeat('0', $limit);
        $customer_va = "7".$p.$no_urut_seluruh_customers;
        
        $get_harga_paket = Pakets::where('id', $prospect->service_packages_id)->get();
        $harga_paket =$get_harga_paket[0]['harga'];
        // dd($harga_paket[0]['harga']);
        //saat customer ditetapkan terminate oleh system maka system akan membuat record baru ditable khusus agar ada data dan diketahui siapa saja yang harus di hapus user pppoe dan di olt (record ini akan berhasilkan status true jika sudah di lakukan penghapusan).
        //saat status_subscribe menjadi terminate dan kolom port_acces masih ada nilai, yang akan menjadikan pada wo ada kolom lepas port menjadi true, berfungsi untuk menandakan bahwa teknisi perlu melakukan pelepasan pada port acces dilapangan,

        //pada saat teknisi melakukan post lepas port bertujuan untuk mentriger backend menggatur agar wo lepas port akan menjadi value true menandakan teknisi berhasil melakukan pelepasan port di lapangan
        
        $coverage_areas_id = $prospect->coverage_areas_id;
        $spliter_access_id = $prospect->spliter_id;

        $customers = Customers::where('coverage_areas_id',$coverage_areas_id)->get();
        // dd($customer);
        $count_customer = count($customers);

        $hari_ini = Carbon::now()->format('dmy');
        
        $pppoe_secret = 'G'.$hari_ini.$no_urut_seluruh_customers;

        $user_exist = [];
        $terminate = [];
        $active = [];
        $cari_spliter_no = [];
        $cabut_port = null;
        $user_terminate = null;

        $missingNumbers = [];

        //block DP dimulai disini
        $referensi_access = range(1, 8);
        for($b=0;$b<$count_customer;$b++){
            if( $customers[$b]['spliter_id'] == $spliter_access_id & $customers[$b]['port_access'] != null){
                $user_exist[] = $customers[$b]['port_access'];
                if( $customers[$b]['subscribe_status'] == 'terminate' ){
                    $terminate[] = $customers[$b]['port_access'];
                }else{
                    $active[] = $customers[$b]['port_access'];
                } 
            }
        }
        if(count($active) == 8){
            //return DP penuh 
            dd(['status'=>'dp penuh','prospect_id'=>$id]);
            $hapus = ProspectPlaces::where('prospect_id',$id)->first();
            if($hapus){
                $hapus->delete();
            }
            ProspectPoints::where('place_id',$hapus->id)->delete();
            Prospects::where('id', $id)->update([
                'status_akhir' => 'access_penuh',
                'status_proggres' => 'access',
                'coverage_areas_id' => null,
                'spliter_id' => null
            ]);
            dd('halaman_aawal');
        };

        // dd($user_exist);
        if(count($user_exist) == 0){
            $no_spliter = 1;
        }else{
            if(count($terminate)+count($active) == 8 ){
                $no_spliter = min($terminate);
                $cabut_port = true;

                $user_terminate = Customers::where([['spliter_id','=', $spliter_access_id], ['port_access','=', $no_spliter]])->first();
                if($user_terminate){
                    $user_terminate->update(['port_access' => null]);
                }
                $user_terminate = $user_terminate['pppoe_secret'];

            }else{
                foreach ($referensi_access as $number) {
                    if (!in_array($number, $user_exist)) {
                        $cari_spliter_no[] = $number;
                    }
                }
                $no_spliter = min($cari_spliter_no);
            }
        }
        // dd([$no_spliter,$cabut_port,$user_terminate]);

        //blok DP done, sumpah lelah, tapi seru, nulis ini sampe salah terus, wkwkwkwkwk

        //Block Urusan ONU, Iyo Ancen akeh,wkwkwkwkk/// 
        
        $missingNumbers = [];
        // dd($customers);
        if($count_customer == 0){
            $missingNumbers = [1];
        }else{
            $no_onu_customers = [];
            for($a=0;$a<$count_customer;$a++){
                if($customers[$a]["no_onu"] != null){
                    $no_onu_customers[] = $customers[$a]["no_onu"];
                }    
            }
            
            $referensi = range(1, 128);
            foreach ($referensi as $number) {
                if (!in_array($number, $no_onu_customers)) {
                    $missingNumbers[] = $number;
                }
            }
        }
        if(count($missingNumbers) == 0){
            Prospects::where('id', $id)->update(['status_proggres'=>'olt_penuh']);
            return redirect('/sales/customers')->with('error', 'Hubungi admin !');
        }else{
            $no_onu = min($missingNumbers);
        }

        $alamat_maps = [
            'pppoe_secret' => $pppoe_secret, 'lat' => $prospect->lat ,'lng' => $prospect->lng ,
            'm_no'         => $prospect->m_no ,'m_jln' => $prospect->m_jln , 'm_kel' => $prospect->m_kel ,
            'm_kec'        => $prospect->m_kec , 'm_kota' => $prospect->m_kota ,'m_type'       => $prospect->m_type 
        ];

        $alamat_terpasang = [
            'pppoe_secret' => $pppoe_secret, 'alamat' => $prospect->alamat ,
            'rt'           => $prospect->rt, 'rw' => $prospect->rw 
        ];

        $customer = [
            'prospects_id'  => $prospect->id , 'sales_nip' => $prospect->sales_nip ,'is_admin' => $prospect->is_admin, 'type_customer' => $prospect->type_customer,
            'pppoe_secret'  => $pppoe_secret , 'nama' => $prospect->nama ,
            'no_tlp'        => $prospect->no_tlp , 'service_packages_id'=> $prospect->service_packages_id ,
            'coverage_areas_id' => $prospect->coverage_areas_id , 'spliter_id' => $prospect->spliter_id ,
            'port_access'       => $no_spliter ,
            'no_onu'            => $no_onu ,
            "pppoe_vlan_id"     => 1 ,
            "hotspot_vlan_id"   => 2 ,
            'va'                => $customer_va,
            'subscribe_status'  => 'pra_wo'
        ];

        $work_order = ['pppoe_secret' => $pppoe_secret, 'lepas_port' => $cabut_port, 'pppoe_secret_cabut' => $user_terminate, 'status_wo' => 'prosess_validasi'];

        try {
            DB::connection('db_customers')->transaction(function() use ($customer,$work_order,$alamat_maps,$alamat_terpasang,$harga_paket){
                DB::connection('db_oprasional')->transaction(function() use ($customer,$work_order,$alamat_maps,$alamat_terpasang,$harga_paket){
                    DB::connection('db_sales')->transaction(function() use ($customer,$work_order,$alamat_maps,$alamat_terpasang,$harga_paket){
                        DB::connection('db_customers_dasarata')->transaction(function() use ($customer,$work_order,$alamat_maps,$alamat_terpasang,$harga_paket){
                        $va_customers = ['va' =>$customer['va'] ,'aplikasi' => 1, 'customer_name' => $customer['nama'], 'amount' => $harga_paket ]; 
                        VaCustomer::create($va_customers);
                        Prospects::where('id', $customer['prospects_id'])->update(['status_proggres' => 'proses_pengajuan']);
                        Customers::create($customer);
                        CustomersAlamatMaps::create($alamat_maps);
                        CustomersAlamatTerpasang::create($alamat_terpasang);
                        PsbWorkOrders::create($work_order);
                        });
                    });
                });
            });
            
            return redirect()->back()->with('success', 'Berhasil pengajuan !');
        } catch (\Exception $e) {

            dd($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menjalankan operasi !');
        }

    }
}
