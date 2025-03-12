@extends('layout.layoutpendaftaran')
@section('title', 'DISPLAY FARMASI')
@push('styles')
    @livewireStyles
@endpush
@section('konten')
    <div class="d-flex justify-content-between align-items-center container-fluid mt-3">
        <img src="data:image/png;base64,{{ base64_encode($getSetting->logo) }}"
                    alt="Girl in a jacket" width="100" height="80">
        <div class="pricing-header ">
            <h1 class="display-4 font-weight-bold" style="width: 130%; height: 80%; text-align: center;">ANTRIAN OBAT</h1>
        </div>
        <img src="/img/bpjs.png" width="250px" height="50px" alt="" srcset="">
    </div>
    <hr>
    @livewire('antrian-obat.displayfarmasi')
    <footer class="bg-blue text-left py-3 mt-5 fixed-bottom" style="overflow: hidden; white-space: nowrap;" > <!-- Tambahkan gaya untuk efek scrolling -->
        <div id="running-text" style="display: inline-block; animation: scroll 10s linear infinite;"> <!-- Tambahkan animasi untuk running text -->
            <p class="mb-0" style="font-size: 15px; display: inline;">© {{ date('Y') }} Rumah Sakit Bumi Waras - rsbumiwaras.co.id</p>
        </div>
    </footer>
    
    <style>
        @keyframes scroll {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
    </style>
    
@endsection
@push('scripts')
    @livewireScripts
@endpush
