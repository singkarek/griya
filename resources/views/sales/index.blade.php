@extends('sales.layouts.main')



@push('css')
<style>
  input.link-like {
  color: blue;
  }

</style>
@endpush


@section('container')

  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    {{-- <h1 class="h2">selamat datang, {{ auth()->user()->name }}</h1> --}}
    <h1 class="h2">Selamat Datang</h1>
  </div>


@endsection