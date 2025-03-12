@extends('..layout.layoutDashboard')
@section('title', 'Display Poli')
@push('styles')
    @livewireStyles
@endpush
@section('konten')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                @livewire('antrian-poli.setting-posisi-dokter')
            </div>
            <div class="card">
                @livewire('antrian-poli.setting-poli')
            </div>
            <div class="card">
                @livewire('antrian-poli.setting-display-poli')
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    @livewireScripts
@endpush
