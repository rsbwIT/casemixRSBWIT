@extends('..layout.layoutDashboard')
@section('title', 'Berkas Pasien BPJS')
@push('styles')
    @livewireStyles
@endpush
@section('konten')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @livewire('r-m.berkas-r-m')
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @livewireScripts
@endpush
