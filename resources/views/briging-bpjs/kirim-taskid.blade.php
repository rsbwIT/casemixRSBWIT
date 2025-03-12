@extends('..layout.layoutDashboard')
@section('title', 'Cekin / Kirim TaskID')
@push('styles')
    @livewireStyles
@endpush
@section('konten')
    <div class="row">
        <div class="col-md-12">
            @livewire('briging-bpjs.kirim-task-id')
        </div>
    </div>
@endsection
@push('scripts')
    @livewireScripts
@endpush
