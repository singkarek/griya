@extends('sales.layouts.main')

@section('container')


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Customers Prospects</h1>
  </div>

@if(session()->has('success'))
    <div class="alert alert-success col-lg-9" role="alert">
        {{ session('success') }}
    </div>
@endif


<div class="table-responsive col-lg-9">
    <a href="{{ route('sales.create') }}" class="btn btn-primary mb-3">Customer Baru</a>
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nama</th>
          <th scope="col">Alamat</th>
          <th scope="col">No Tlp</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($customers as $customer )
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $customer->nama }}</td>
              <td>{{ $customer->alamat }}</td>
              <td>{{ $customer->no_tlp }}</td>
              <td>
                @if($customer->foto_ktp == null)
                <a href="/sales/customer/{{ $customer->id }}/melengkapi" class="badge btn-success"><span data-feather="edit"></span> Foto KTP</a>
                @endif
                @if($customer->foto_ktp != null && $customer->foto_rumah == null)
                <a href="/sales/customer/{{ $customer->id }}/melengkapi" class="badge btn-success"><span data-feather="edit"></span> Foto Rumah</a>
                @endif
                @if($customer->foto_rumah != null && $customer->lat == null)
                <a href="/sales/customer/{{ $customer->id }}/melengkapi" class="badge btn-success"><span data-feather="edit"></span> Koordinat Rumah</a>
                @endif
                @if($customer->lat != null && $customer->id_dp == null)
                <a href="/sales/customer/{{ $customer->id }}/melengkapi" class="badge btn-success"><span data-feather="edit"></span> Pilih ODP</a>
                @endif
 
                
                
                <a href="/sales/customer/{{ $customer->id }}/melengkapi" class="badge btn-warning"><span data-feather="edit"></span> Detail</a>
                {{-- <form action="/dashboard/posts/" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button class="badge btn-danger border-0" onclick="return confirm('Yakin hapus Post ?')"><span data-feather="x-circle"></span></button>
                </form> --}}
              </td>
            </tr>
        @endforeach
      </tbody>
    </table>
  </div>



@endsection

