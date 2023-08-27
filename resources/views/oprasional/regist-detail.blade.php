@extends('oprasional.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Register User</h1>
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

{{ $customers[0] }}

<div class="table-responsive col-lg-9">

  <form method="post" action="/oprasional/regist/store">
    @csrf
    <input type="text" value="{{ $customers[0]['pppoe_secret'] }}" name="pppoe_secret" required hidden>
    <div class="mt-4 mb-5">
      <button type="submit" class="btn btn-primary">Konfrim Regist Done</button>
    </div>
  </form>

<div class="col-lg-8">
Skirp No. 1 | SCAN MODEM <button class="copyButton">Copy</button> 
<div class="bg-gray-900 text-white p-4 rounded-md mb-5" id="readonlyCode">
<pre>
show gpon onu uncfg
</pre>
</div>
</div>

<div class="col-lg-8">
Skirp No. 2 | REGIS MODEM <button class="copyButton">Copy</button> 
<div class="bg-gray-900 text-white p-4 rounded-md mb-5" id="readonlyCode">
<pre>
interface {{ $customers[0]['olt'] }}
onu {{ $customers[0]['no_onu'] }} type All sn {{ $customers[0]['sn_modem'] }}  
</pre>
</div>
</div>

<div class="col-lg-8">
Skirp No. 3 | CEK HASIL REDAMAN <button class="copyButton">Copy</button> 
  <div class="bg-gray-900 text-white p-4 rounded-md mb-5" id="readonlyCode">
<pre>
show pon power attenuation {{ $customers[0]['olt'] }}:{{ $customers[0]['no_onu'] }}
</pre>
  </div>
  </div>

<div class="col-lg-8">
Skirp No. 4 | ISI PROFILE <button class="copyButton">Copy</button>
<div class="bg-gray-900 text-white p-4 rounded-md mb-5" id="readonlyCode">
<pre>
interface {{ $customers[0]['olt'] }}:{{ $customers[0]['no_onu'] }}
name {{ $customers[0]['nama'] }}
description BNDL 1.2.16.1.5
tcont 1 profile 100M
tcont 1 gap mode2
gemport 1 unicast tcont 1 dir both
gemport 1 traffic-limit downstream DW100M
switchport mode hybrid vport 1
switchport vlan 230-231 tag vport 1  
</pre>
</div>
</div>

<div class="col-lg-8 mb-5">
Skirp No. 5 | PPPOE <button class="copyButton">Copy</button>
<div class="bg-gray-900 text-white p-4 rounded-md mb-5" id="readonlyCode">
<pre>
pon-onu-mng {{ $customers[0]['olt'] }}:{{ $customers[0]['no_onu'] }}
flow mode 1 tag-filter vid-filter untag-filter discard
flow 1 priority 0 vid 231
flow 1 priority 0 vid 230
gemport 1 flow 1
switchport-bind switch_0/1 iphost 1
switchport-bind switch_0/1 veip 1
pppoe 1 nat enable user {{ $customers[0]['pppoe_secret'] }} password GRIYA
vlan-filter-mode iphost 1 tag-filter vid-filter untag-filter discard
vlan-filter iphost 1 priority 0 vid 230
vlan port eth_0/4 mode tag vlan 231
vlan port wifi_0/4 mode tag vlan 231
dhcp-ip ethuni eth_0/1 from-onu
dhcp-ip ethuni eth_0/2 from-onu
dhcp-ip ethuni eth_0/3 from-onu
dhcp-ip ethuni eth_0/4 from-onu
dhcp-ip ethuni eth_0/4 from-internet  
</pre>
</div>
</div>








</div>




{{-- interface gpon-onu_1/2/16:58
name {{ $customers[0]['nama'] }}
description BNDL 1.2.16.1.5
tcont 1 profile 100M --}}

<script>
  const copyButtons = document.querySelectorAll(".copyButton");
  copyButtons.forEach(button => {
      button.addEventListener("click", function() {
          const codeBox = this.nextElementSibling.querySelector("pre");
          const textArea = document.createElement("textarea");
          textArea.value = codeBox.textContent.trim();
          document.body.appendChild(textArea);
          textArea.select();
          document.execCommand("copy");
          document.body.removeChild(textArea);
      });
  });
</script>

@endsection

