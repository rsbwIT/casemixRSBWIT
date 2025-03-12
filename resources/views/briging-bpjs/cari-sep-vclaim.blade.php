@extends('..layout.layoutDashboard')
@section('title', 'Cari Sep V-claim')
@push('styles')
    @livewireStyles
@endpush
@section('konten')
    <div class="row">
        <div class="col-md-12">
            @livewire('briging-bpjs.sep-vclaim')
        </div>
    </div>
@endsection
@push('scripts')
    @livewireScripts
@endpush
