@extends('..layout.layoutDashboard')
@section('title', 'Kegiatan Kepala Ruangan')
@push('styles')
    @livewireStyles
@endpush
@section('konten')
    <div class="row">
        <div class="col-md-12">
            @livewire('keperawatan.kegiatan-karu')
        </div>
    </div>
@endsection
@push('scripts')
    @livewireScripts
@endpush

