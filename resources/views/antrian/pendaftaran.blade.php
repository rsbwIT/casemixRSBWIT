@extends('..layout.layoutDashboard')
@section('title', 'Pendaftaran')

@section('konten')
    <div class="row">
        <div class="col-md-12 card">
            <table class="table">
                <thead>
                    <tr>
                        <th>Kd Pendaftaran</th>
                        <th>Nama Pendaftaran</th>
                        <th class="text-center">Display Antrian</th>
                        <th class="text-center">Display Petugas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Pendaftaran as $item)
                        @php
                            $kdPenjab = $item->kd_pendaftaran != 'A' ? 'BPJ' : 'XBPJ';
                        @endphp
                        <tr>
                            <td>{{ $item->kd_pendaftaran }}</td>
                            <td>{{ $item->nama_pendaftaran }}</td>
                            <td class="text-center">
                                <form action="{{ url('cari-loket') }}" method="">
                                    @csrf
                                    <input name="KdPendaftaran" value="{{ $item->kd_pendaftaran }}" hidden>
                                    <input name="KdPenjab" value="{{ $kdPenjab }}" hidden>
                                    <button class="" style="background: none; border: none;">
                                        <i class="nav-icon fas fa-search"></i>
                                    </button>
                                </form>
                            </td>
                            <td class="text-center">
                                <div class="badge-group-sm">
                                    <a data-toggle="dropdown" href="#">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-xs dropdown-menu-right">
                                        @foreach ($item->getLoket as $item)
                                            <form action="{{ url('display-petugas') }}" method="">
                                                <div class="dropdown-item">
                                                    @csrf
                                                    <input name="kdLoket" value="{{ $item->kd_loket }}" hidden>
                                                    <button class="btn btn-block btn-flat btn-primary">
                                                        {{ $item->nama_loket }}
                                                    </button>
                                                </div>
                                            </form>
                                        @endforeach
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
