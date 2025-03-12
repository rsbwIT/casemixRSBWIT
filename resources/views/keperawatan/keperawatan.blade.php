@extends('..layout.layoutDashboard')
@section('title', 'Input Tindakan Dasar Keperawatan')
@push('styles')
    @livewireStyles
@endpush
@section('konten')
    <div class="row">
        <div class="col-md-12">
            @livewire('keperawatan.pengawas-keperawatan')
        </div>
    </div>
@endsection
@push('scripts')
    @livewireScripts
@endpush

