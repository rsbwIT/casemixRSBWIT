@extends('..layout.layoutDashboard')
@section('title', 'Input Kegiatan Perawat')
@push('styles')
    @livewireStyles
@endpush
@section('konten')
    <div class="row">
        <div class="col-md-12">
            @livewire('keperawatan.kegiatan-lain-keperawatan')
        </div>
    </div>
@endsection
@push('scripts')
    @livewireScripts
@endpush

