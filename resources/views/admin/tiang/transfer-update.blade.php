@extends('admin.layouts.main')

@section('container')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Transfer Tiang</h1>
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
  
  <form action="/admin/tiang/tes" method="post" id="mainForm">
    @csrf
    <div id="formContainer" class="col-lg-9">
        <div class="mb-3 ">
            <label for="area_id" class="h6 form-label @error('area_id') is-invalid @enderror" >Pilih Area</label>
            <select class="form-select" name="area_id">
                <option value=""> -- Pilih Area -- </option> 
                @foreach ($areas as $area)
                <option value="{{ $area->id }}" >{{ $area->nama_area}} | {{ $area->kode_area }}</option>         
                @endforeach
            </select>
        </div>
    </div>

        <div id="formContainer" class="col-lg-9">
        </div>
        
        <div class="row mb-2 mt-4">
            <div class="col-md-2">
                <button type="button" class="btn btn-success" id="addButton">+ Add tiang</button>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
        
  </form>
   
{{-- {{ $motorList }} --}}

    <script>
        const usedOptions = new Set(); // Set to keep track of used options
   
        document.addEventListener("DOMContentLoaded", function() {
            const formContainer = document.getElementById("formContainer");
            const addButton = document.getElementById("addButton");
            
            addButton.addEventListener("click", function() {
                const newDropdown = document.createElement("div");
                newDropdown.classList.add("form-group");
                // <label>Select Motor:</label>\
                newDropdown.innerHTML = `
                <div class="row mb-2 ">
                    <div class="col-md-8">
                    <select name="tiang[]" class="form-select" onchange="handleDropdownChange(this)">
                        <option value="null"> -- Pilih Tiang -- </option> 
                        @foreach ($tiangs as $tiang)
                            <option value="{{ $tiang->id }}" ${[...usedOptions].includes('{{ $tiang->id }}') ? 'hidden' : ''}>{{ $tiang->nama_tiang }} | {{ $tiang->vendor }} | {{ $tiang->tinggi }}</option>
                        @endforeach
                    </select>
                    </div>
                    <div class="col">
                    <button type="button" class="btn btn-danger ml-2" onclick="removeForm(this)">-</button>
                    </div>
                </div>
                `;
    
                formContainer.appendChild(newDropdown);
            });
        });
    
        function handleDropdownChange(selectElement) {
            console.log(usedOptions)

            usedOptions.add(selectElement.value); // Mark the selected option as used
        }

        function removeForm(button) {
        const formGroup = button.closest('.form-group');
        const selectElement = formGroup.querySelector('[name="tiang[]"]');
        usedOptions.delete(selectElement.value);
        formGroup.remove();
    }
    </script>
@endsection