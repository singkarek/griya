@extends('admin.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h3">Input Modem</h1>
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

@if(session()->has('error'))
  <div class="alert alert-danger col-lg-9" role="alert">
      {{ session('error') }}
  </div>
@endif

@if(session()->has('success'))
  <div class="alert alert-success col-lg-9" role="alert">
      {{ session('success') }}
  </div>
@endif

<div class="col-lg-9">
  <form method="post" action="/admin/modem/store" autocomplete="">
    @csrf
    <div id="form-container"  class="col-lg-9">

        <div class="row mb-2">
          <div class="col-md-3">
            <label for="ref" class="h6 form-label">Kode Ref</label>
            <input type="text" class="form-control" id="ref" name='ref' autocomplete="off" required autofocus>
          </div>
          <div class="col-md-5">
            <label for="supplier" class="h6 form-label">Supllier</label>
            <input type="text" class="form-control" id="supplier" name='supplier' required>
          </div>
          <div class="col-md-4">
            <label for="totalharga" class="h6 form-label">Total Harga</label>
            <input type="text" class="form-control" id="totalharga" name='totalharga' required autocomplete="off" >
          </div>

        </div>

      {{-- <input type="text" class="form-control" name="serial_number[]" placeholder="Serial Number" autofocus> --}}

      <div class="form-group mb-3">
        <div class="row mb-2">
          <div class="col-md-3">
            <label for="brand" class="h6 form-label @error('brand') is-invalid @enderror" >Brand</label>
            <select class="form-select" name="brand">
              <option value="ZTE" >ZTE</option>         
            </select>
          </div>
          <div class="col-md-3">
            <label for="type" class="h6 form-label" >Type</label>
            <select class="form-select" name="type">
              <option value="F607-V7" >F607-V7</option>         
              <option value="ZTE" >ZTE</option>         
            </select>
          </div>
          <div class="col-md-2">
            <label for="connector" class="h6 form-label" >Connector</label>
            <select class="form-select" name="connector">
              <option value="UPC" >UPC</option>         
              <option value="APC" >APC</option>         
            </select>
          </div>
          <div class="col-md-4">
            <label for="totalbelanja" class="h6 form-label">Total Item</label>
            <input type="number" class="form-control" id="totalbelanja" name='totalbelanja' disabled>
          </div>
        </div>
      </div>


        <!-- Form pertama -->
        <div class="form-group">
          <div class="row mb-2 " >
            <div class="col-md-8">
              <input type="text" class="form-control" name="serial_number[]" placeholder="Serial Number" autofocus>
            </div>
            <div class="col">
              {{-- <button type="button" class="btn btn-danger ml-2" onclick="removeFormm(this)">-</button> --}}
            </div>
          </div>
        </div>
       
    </div>

    <div class="mb-2 mt-4">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>

  </form>

</div>

<script>
  // Mengambil elemen form-container
  var formContainer = document.getElementById('form-container');
  const total_belanja  = document.querySelector('#totalbelanja');
  var formCounter = 0;
  total_belanja.value = formCounter

  // Mendengarkan peristiwa keypress pada input teks
  document.addEventListener('keypress', function(event) {
      if (event.key === 'Enter') {
          event.preventDefault(); // Mencegah peristiwa default enter
          var formRow = document.createElement('div');
          formRow.className = 'form-group';
          formCounter++; 
          total_belanja.value = formCounter
          formRow.innerHTML = `          
          <div class="row mb-2 " >
            <div class="col-md-8">
              <input type="text" class="form-control" name="serial_number[]" placeholder="Serial Number">
            </div>
            <div class="col">
              <button type="button" class="btn btn-danger ml-2" onclick="removeFormm(this)">-</button>
            </div>
          </div>`;
          formContainer.appendChild(formRow);
          console.log(formCounter);
          // Set focus ke input pada form yang baru 
          formRow.querySelector('[name="serial_number[]"]').focus();
      }
  });

  // Fungsi untuk menghapus form
  function removeFormm(button) {
    const formGroup = button.closest('.form-group');
    formGroup.remove();
    formCounter--;
    total_belanja.value = formCounter
  }
</script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
      const totalInput = document.getElementById("totalharga");

      totalInput.addEventListener("input", function() {
          const inputValue = parseFloat(this.value.replace(/,/g, ""));
          if (!isNaN(inputValue)) {
              this.value = new Intl.NumberFormat().format(inputValue);
          }
      });
  });
</script>

@endsection