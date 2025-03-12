@extends('..layout.layoutDashboard')
@section('title', 'Jadwal Dokter')
@push('styles')
    @livewireStyles
@endpush
@section('konten')
    @livewire('antrian-poli.jadwal-dokter')

@endsection
@push('scripts')
    @livewireScripts
@endpush
