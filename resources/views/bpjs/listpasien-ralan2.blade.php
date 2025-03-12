@extends('..layout.layoutDashboard')
@section('title', 'List Pasien Ralan 2')
@push('styles')
    @livewireStyles
@endpush
@section('konten')
    <div class="row">
        <div class="col-md-12">
            @livewire('bpjs.lispasien-ralan2')
        </div>
    </div>
@endsection
@push('scripts')
    @livewireScripts
@endpush

