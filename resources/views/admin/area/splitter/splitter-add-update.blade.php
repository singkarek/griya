@extends('admin.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3 class="h3">Add Splitters - {{ $place[0]['nama_area'] }} - {{ $place[0]['nama_tempat'] }}</h3>
</div>

@if ($errors->any())
  <div class="alert alert-danger col-lg-9">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
@endif

@if(session()->has('success'))
    <div class="alert alert-success col-lg-9" role="alert">
        {{ session('success') }}
    </div>
@endif

@if(session()->has('error'))
    <div class="alert alert-danger col-lg-9" role="alert">
        {{ session('error') }}
    </div>
@endif

<div class="col-lg-7">



    <form action="/admin/area/splitter/edit/splitter" method="post">
        @csrf
        <input type="text" value={{ $place[0]->id }} name='placement_id' required hidden>
        <input type="text" value={{ $place[0]->area_id }} name='area_id' required hidden>
        <table class="table table-striped table-sm"> 
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Type Splitter</th>
                    <th scope="col">Kode Splitter</th>
                    <th scope="col">Chose</th>
                </tr>
            </thead>
            <tbody>
                @foreach ( $splitters as $splitter)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $splitter->type_spliter }}</td>
                        <td>
                        @if($splitter->type_spliter == 'backbone')
                            {{ $splitter->kode_area }}.{{ $splitter->spliter_ke }}
                        @else
                            {{ $splitter->kode_area }}.{{ $splitter->parent_ke }}.{{ $splitter->spliter_ke }}
                        @endif
                        </td>
                        <td><input type="checkbox" name="item[]" value='{{ $splitter->id }}'></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary ">Simpan</button>
    </form>


</div>

{{ $place }}
{{ $splitters }}

@endsection