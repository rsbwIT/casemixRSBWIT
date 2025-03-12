@extends('..layout.layoutDashboard')
@section('title', 'Setting Obat')
@push('styles')
    @livewireStyles
@endpush
@section('konten')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                @livewire('antrian-obat.setting-obat')
            </div>
            <div class="card">
                @livewire('antrian-obat.setting-display-obat')
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    @livewireScripts
@endpush
