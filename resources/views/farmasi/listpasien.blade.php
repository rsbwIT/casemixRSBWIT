@extends('..layout.layoutDashboard')
@section('title', 'List Pasein')

@section('konten')
    <div class="row">
        <div class="col-md-12 card">
            <label for="" class="label mt-3">Cari</label>
            <form action="{{ url('cari-list-pasien-farmasi') }}" action="POST">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="input-group input-group-xs">
                                <input type="text" name="cariNomor" class="form-control form-control-xs"
                                    placeholder="Cari Nama/RM/No Rawat">
                                <div class="input-group-append">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group input-group-xs">
                                <input type="date" name="tgl1" class="form-control form-control-xs"
                                    value="{{ request('tgl1', now()->format('Y-m-d')) }}">
                                <div class="input-group-append">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group input-group-xs">
                                <input type="date" name="tgl2" class="form-control form-control-xs"
                                    value="{{ request('tgl2', now()->format('Y-m-d')) }}">
                                <div class="input-group-append">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group input-group-xs">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-md btn-primary">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="card">
                <div class="card-header">

                </div>
                <table class="card-body table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">RM</th>
                            <th class="text-center">No.Rawat</th>
                            <th class="text-center">No.Sep</th>
                            <th class="text-center">Pasein | Status Bayar</th>
                            <th class="text-center">Asal</th>
                            <th class="text-center">Jenis Jual</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($daftarPasien as $item)
                                @php
                                    $matchingBerksDownload = $downloadBerkas->where('no_rawat', $item->no_rawat);
                                    $color = $matchingBerksDownload->isNotEmpty() ? 'text-success' : '';
                                @endphp
                            <tr class="{{$color}}">
                                <td class="text-center" width="55px">
                                    <form action="{{ url('view-sep-resep') }}" method="">
                                        @csrf
                                        <input name="cariNoRawat" value="{{ $item->no_rawat }}" hidden>
                                        <input name="cariNoSep" value="{{ $item->no_sep }}" hidden>
                                        <button class="{{$color}}" style="background: none; border: none;">
                                            <i class="nav-icon fas fa-search"></i>
                                        </button>
                                    </form>
                                </td>
                                <td class="text-center">{{ $item->no_rkm_medis }}</td>
                                <td class="text-center">{{ $item->no_rawat }}</td>
                                <td class="text-center">
                                    @if ($item->no_sep)
                                        {{ $item->no_sep }}
                                    @else
                                        <ul class="navbar-nav ml-auto">
                                            <li class="nav-item dropdown">
                                                <a class="" href="#" style="color: inherit;"
                                                    data-toggle="tooltip" data-placement="top"
                                                    title="Berkas SEP Dibuat di V-Claim dan Tidak Tersedia di
                                                Khanza, Silahkan Gabung File Dengan Cara Manual">
                                                    <i class="nav-icon fas fa-question"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    @endif
                                </td>
                                <td>{{ $item->nm_pasien }} |
                                    @if ($item->status_bayar === 'Sudah Bayar')
                                        <a href="#" class="" data-toggle="tooltip" data-placement="top"
                                            title="Sudah Bayar">
                                            <i class="text-success nav-icon fas fa-check"></i>
                                        </a>
                                    @else
                                        <a class="" href="#" data-toggle="tooltip" data-placement="top"
                                            title="Belum Bayar">
                                            <i class="text-dark nav-icon fas fa-dollar-sign"></i>
                                        </a>
                                    @endif
                                </td>
                                <td>{{ $item->nm_poli }}</td>
                                <td>{{ $item->jns_jual }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
