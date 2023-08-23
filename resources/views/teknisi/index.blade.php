@extends('teknisi.layouts.main')

@section('container')


  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    {{-- <h1 class="h2">selamat datang, {{ auth()->user()->name }}</h1> --}}
    <h1 class="h2">Selamat Datangddddddd</h1>
  </div>

{{ auth()->user()->is_admin }}

{{ $customers }}


@endsection