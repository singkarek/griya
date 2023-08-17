<?php

namespace App\Http\Controllers\Sales;

use App\Models\Pakets;
use App\Models\Metodes;
use App\Models\Spliters;
use App\Models\Customers;
use App\Models\Prospects;
use Illuminate\Http\Request;
use App\Models\ProspectPlaces;
use App\Models\ProspectPoints;
use Illuminate\Support\Carbon;
use App\Models\ProspectSegments;
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
            'metodes'       => Metodes::all(),
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
        $validateData['status_proggres'] = 'foto_rumah';



        // dd($tes);

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

        foreach ($points as &$item) {
            $item['prospect_id'] = $prospect_id;
        }
        unset($item); // Hapus referensi terakhir

        $segments = [];
        foreach ($segments_raw as $item) {
            $newItem = [
                'prospect_id' => $prospect_id,
                'end_lat' => $item['end_location']['lat'],
                'end_lng' => $item['end_location']['lng'],
                'start_lat' => $item['start_location']['lat'],
                'start_lng' => $item['start_location']['lng'],
                'length_text' => $item['length']['text'],
                'length_val' => $item['length']['value']
            ];
            array_push($segments, $newItem);
        }


        ProspectPlaces::insert($places);
        ProspectSegments::insert($segments);
        ProspectPoints::insert($points);
        Prospects::where('id', $prospect_id)->update(['status_proggres' => 'siap_pengajuan']);

        return "oke";
    }

    public function pengajuanPasang($id)
    {
        [$prospect] = Prospects::where('id', $id)->get();

        [$spliter_cari] = Spliters::withCount('customers')->where([['type_spliter','=','accsess'],['id','=',$prospect->spliter_id]])->get();
        $spliter_no = $spliter_cari->customers_count+1;

        // $customer = Customers::where('area_id','5')->get();

        $hari_ini = Carbon::now()->format('dmy');
        $no_urut = Customers::count()+1;

        $pppoe_secret = 'G'.$hari_ini.$no_urut;

        $alamat_maps = [
            'pppoe_secret' => $pppoe_secret,
            'lat'          => $prospect->lat ,
            'lng'          => $prospect->lng ,
            'm_no'         => $prospect->m_no ,
            'm_jln'        => $prospect->m_jln ,
            'm_kel'        => $prospect->m_kel ,
            'm_kec'        => $prospect->m_kec ,
            'm_kota'       => $prospect->m_kota ,
            'm_type'       => $prospect->m_type 
        ];

        $alamat_terpasang = [
            'pppoe_secret' => $pppoe_secret,
            'alamat'       => $prospect->alamat ,
            'rt'           => $prospect->rt ,
            'rw'           => $prospect->rw 
        ];

        $customer = [
            'prospects_id'  => $prospect->id ,
            'sales_id'      => $prospect->sales_id ,
            'pppoe_secret'  => $pppoe_secret ,
            'nama'          => $prospect->nama ,
            'no_tlp'        => $prospect->no_tlp ,
            'paket_id'      => $prospect->service_packages_id ,
            'coverage_areas_id' => $prospect->coverage_areas_id ,
            'spliter_id'        => $prospect->spliter_id ,
            'port_access'       => $spliter_no ,
            'no_onu'            => 1 ,
            "pppoe_vlan_id"     => 1 ,
            "hotspot_vlan_id"   => 2 ,
            'subscribe_status'  => 'pra_wo'
        ]; 

        
        dd($customer);
        dd($alamat_maps);

    }
}
