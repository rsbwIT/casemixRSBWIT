@extends('..layout.layoutDashboard')
@section('title', 'Retur Obat')

@section('konten')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Pemakaian obat Pasien</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <section class="content">
                        <form action="{{url('cariNorm')}}" action="POST">
                        @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group input-group-lg">
                                            <input type="search" name="cariNorm" class="form-control form-control-lg"
                                                placeholder="Type your keywords here">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-lg btn-default">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </section>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>TGL BERI</th>
                                        <th>NO RM</th>
                                        <th>NAMA PASIEN</th>
                                        <th>NAMA OBAT / ALKES</th>
                                        <th>EMBALASE</th>
                                        <th>TUSLAH</th>
                                        <th>JML</th>
                                        <th>BIAYA OBAT</th>
                                        <th>TOTAL BIAYA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1;  @endphp
                                    @if ($getAllObat->count() > 0)
                                        @foreach ($getAllObat as $item)
                                            <tr class="text-sm">
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $item->tanggal_beri }}</td>
                                                <td>{{ $item->no_rkm_medis }}</td>
                                                <td>{{ $item->nm_pasien }}</td>
                                                <td>{{ $item->nama_brng }}</td>
                                                <td>{{ $item->embalase }}</td>
                                                <td>{{ $item->tuslah }}</td>
                                                <td>{{ $item->jml }}</td>
                                                <td>Rp. {{ number_format($item->biaya_obat, 2, ',', '.') }}</td>
                                                <td>Rp. {{ number_format($item->total, 2, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10" class="text-center">Silahkan Cari data</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th colspan="8">TOTAL ALKES :</th>
                                        <th colspan="2">Rp. {{ number_format($sumAllObat, 2, ',', '.') }}</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- RETUR --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>TGL RETUR</th>
                                            <th>NO RM</th>
                                            <th>NAMA PASIEN</th>
                                            <th>NAMA OBAT / ALKES</th>
                                            <th>JUMLAH RETUR</th>
                                            <th>BIAYA OBAT</th>
                                            <th>TOTAL BIAYA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1;  @endphp
                                        @foreach ($getAllRetur as $item)

                                            <tr class="text-sm">
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $item->tgl_retur }}</td>
                                                <td>{{ $item->no_rkm_medis }}</td>
                                                <td>{{ $item->nm_pasien }}</td>
                                                <td>{{ $item->nama_brng }}</td>
                                                <td>{{ $item->jml_retur }}</td>
                                                <td>{{ $item->h_retur }}</td>
                                                <td>Rp. {{ number_format($item->subtotal, 2, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th colspan="6">Total Retur:</th>
                                            <th colspan="2">Rp. {{ number_format($sumAllRetur, 2, ',', '.') }}</th>
                                        </tr>
                                        <tr>
                                            <th colspan="6">Total Obat Bersih:</th>
                                            <th colspan="2">Rp. {{ number_format($TotalObtBersih, 2, ',', '.') }}</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row no-print">
                        <div class="col-12">
                            @php
                                $printNorm = isset($_GET['cariNorm']) ? $_GET['cariNorm'] : '';
                            @endphp
                            <a href="{{ url('print', urlencode($printNorm))}}" rel="noopener" target="_blank" class="btn btn-default"><i
                                    class="fas fa-print"></i> Print</a>
                            <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i>
                                Submit
                                Payment
                            </button>
                            <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                                <i class="fas fa-download"></i> Generate PDF
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
