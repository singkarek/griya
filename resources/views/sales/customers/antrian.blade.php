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

    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nama</th>
          <th scope="col">Alamat</th>
          <th scope="col">No Tlp</th>
          <th scope="col">Status</th>
        </tr>
      </thead>
      <tbody>

      </tbody>
    </table>
</div>



@endsection
