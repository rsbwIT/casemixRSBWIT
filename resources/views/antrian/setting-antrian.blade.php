@extends('..layout.layoutDashboard')
@section('title', 'Pendaftaran')
@push('styles')
    @livewireStyles
@endpush
@section('konten')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                @livewire('antrian-pendaftaran.setting-posisi-dokter')
            </div>
            <div class="card">
                @livewire('antrian-pendaftaran.setting-antrian-loket')
            </div>
            <div class="card">
                @livewire('antrian-pendaftaran.setting-antrian')
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    @livewireScripts
@endpush
