@extends('..layout.layoutDashboard')
@section('title', 'Minimal Stok Obat')
@push('styles')
    @livewireStyles
@endpush
@section('konten')
    <div class="row">
        <div class="col-md-12">
            @livewire('farmasi.minimal-stok-obat')
        </div>
    </div>
@endsection
@push('scripts')
    @livewireScripts
@endpush
