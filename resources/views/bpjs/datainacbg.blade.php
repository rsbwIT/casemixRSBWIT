@extends('..layout.layoutDashboard')
@section('title', 'Casemix Bpjs')

@section('konten')
<form action="{{ url('/data-inacbg') }}" action="POST">
    @csrf
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <div class="input-group input-group-xs">
                    <input type="search" name="cariNomor" class="form-control form-control-xs"
                        placeholder="Cari No.Rawat / No.SEP">
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
    <div class="card card-Light">
        <div class="card-header">
            <h5 class="card-title"></h5>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="col-md-12">
                @if ($dataInacbg)
                    @foreach ($dataInacbg as $item)
                        <div class="card-body">
                            <div class="card py-4  d-flex justify-content-center align-items-center">
                                <table border="0px" width="1000px">
                                    <tr>
                                        <td rowspan="3"> <img src="../img/rs.png" alt="Girl in a jacket" width="90"
                                                height="75"></td>
                                        <td class="text-center">
                                            <h4>RS. BUMI WARAS </h4>
                                        </td>
                                    </tr>
                                    <tr class="text-center">
                                        <td>Jln. Wolter Monginsidi No. 235 , Bandar Lampung, Lampung
                                            (0721)
                                            254589</td>
                                    </tr>
                                    <tr class="text-center">
                                        <td> E-mail : www.rsbumiwaras.co.id</td>
                                    </tr>
                                    <tr class="text-center">
                                        <td colspan="2">
                                            <h5 class=""><b>RINGKAS RESUME & BILL</b></h5>
                                        </td>
                                    </tr>
                                </table>
                                <table border="0px" width="1000px">
                                    <tr style="vertical-align: top;">
                                        <td width="100px">Nama Pasien</td>
                                        <td width="400px">: {{ $item->nm_pasien }}</td>
                                        <td width="100px">No. Rekam Medis</td>
                                        <td width="200px">: {{ $item->no_rkm_medis }}</td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td width="100px">No. Rawat</td>
                                        <td width="400px">: {{ $item->no_rawat }}</td>
                                        <td width="100px">No. SEP</td>
                                        <td width="200px">: {{ $item->no_sep }}</td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td width="100px">Status Lanjut</td>
                                        <td width="400px">: {{ $item->status_lanjut }}</td>
                                        <td width="100px"></td>
                                        <td width="200px"> </td>
                                    </tr>
                                </table>
                                <table border="0px" width="1000px" class="mt-3">
                                    <tr>
                                        <td width="250px" style="vertical-align: top;">Keluhan Utama Riwayat
                                            Penyakit
                                        </td>
                                        <td style="vertical-align: top;"> : {{ $item->keluhan_utama }}
                                        </td>
                                        <td width="250px"></td>
                                    </tr>
                                </table>
                                <table border="0px" width="1000px" class="mt-3">
                                    <tr>
                                        <td width="250px" style="vertical-align: top;">Jalannya Penyakit Selama Perawatan
                                        </td>
                                        <td style="vertical-align: top;"> : {{ $item->jalannya_penyakit }}
                                        </td>
                                        <td width="250px"></td>
                                    </tr>
                                </table>
                                <table border="0px" width="1000px" class="mt-3">
                                    <tr>
                                        <td width="250px" style="vertical-align: top;">Pemeriksaan penunjang yang positif
                                        </td>
                                        <td style="vertical-align: top;"> : {{ $item->pemeriksaan_penunjang }}
                                        </td>
                                        <td width="200px"></td>
                                    </tr>
                                </table>
                                <table border="0px" width="1000px" class="mt-3">
                                    <tr>
                                        <td width="250px" style="vertical-align: top;">Hasil laboratorium yang positif
                                        </td>
                                        <td style="vertical-align: top;"> : {{ $item->hasil_laborat }}
                                        </td>
                                        <td width="200px"></td>
                                    </tr>
                                </table>
                                <table border="0px" width="1000px" class="mt-3">
                                    <tr>
                                        <td width="250px">Diagnosa Akhir</td>
                                        <td colspan="2"></td>
                                        <td width="80px" class="text-center">Kode ICD</td>
                                        <td width="20px"></td>
                                    </tr>
                                    <tr>
                                        <td width="250px">&nbsp; - Diagnosa Utama </td>
                                        <td>: {{ $item->diagnosa_utama }}</td>
                                        <td width="20px" class="text-right">(</td>
                                        <td width="80px" class="text-center">
                                            {{ $item->kd_diagnosa_utama }}
                                        </td>
                                        <td>)</td>
                                    </tr>
                                    <tr>
                                        <td width="250px">&nbsp; - Diagnosa Sekunder </td>
                                        <td>: 1. {{ $item->diagnosa_sekunder }}</td>
                                        <td width="20px" class="text-right">(</td>
                                        <td width="80px" class="text-center">
                                            {{ $item->kd_diagnosa_sekunder }}
                                        </td>
                                        <td>)</td>
                                    </tr>
                                    <tr>
                                        <td width="250px"></td>
                                        <td>&nbsp; 2. {{ $item->diagnosa_sekunder2 }}</td>
                                        <td width="20px" class="text-right">(</td>
                                        <td width="80px" class="text-center">
                                            {{ $item->kd_diagnosa_sekunder2 }}
                                        </td>
                                        <td>)</td>
                                    </tr>
                                    <tr>
                                        <td width="250px"></td>
                                        <td>&nbsp; 3. {{ $item->diagnosa_sekunder3 }}</td>
                                        <td width="20px" class="text-right">(</td>
                                        <td width="80px" class="text-center">
                                            {{ $item->kd_diagnosa_sekunder3 }}
                                        </td>
                                        <td>)</td>
                                    </tr>
                                    <tr>
                                        <td width="250px"></td>
                                        <td>&nbsp; 4. {{ $item->diagnosa_sekunder4 }}</td>
                                        <td width="20px" class="text-right">(</td>
                                        <td width="80px" class="text-center">
                                            {{ $item->kd_diagnosa_sekunder4 }}
                                        </td>
                                        <td>)</td>
                                    </tr>
                                    <tr>
                                        <td width="250px">&nbsp; - Prosedur/Tindakan Utama </td>
                                        <td>: {{ $item->prosedur_utama }}</td>
                                        <td width="20px" class="text-right">(</td>
                                        <td width="80px" class="text-center">
                                            {{ $item->kd_prosedur_utama }}
                                        </td>
                                        <td>)</td>
                                    </tr>
                                    <tr>
                                        <td width="250px">&nbsp; - Prosedur/Tindakan Sekunder </td>
                                        <td>: 1. {{ $item->prosedur_sekunder }}</td>
                                        <td width="20px" class="text-right">(</td>
                                        <td width="80px" class="text-center">
                                            {{ $item->kd_prosedur_sekunder }}
                                        </td>
                                        <td>)</td>
                                    </tr>
                                    <tr>
                                        <td width="250px"></td>
                                        <td>&nbsp; 2. {{ $item->prosedur_sekunder2 }}</td>
                                        <td width="20px" class="text-right">(</td>
                                        <td width="80px" class="text-center">
                                            {{ $item->kd_prosedur_sekunder2 }}
                                        </td>
                                        <td>)</td>
                                    </tr>
                                    <tr>
                                        <td width="250px"></td>
                                        <td>&nbsp; 3. {{ $item->prosedur_sekunder3 }}</td>
                                        <td width="20px" class="text-right">(</td>
                                        <td width="80px" class="text-center">
                                            {{ $item->kd_prosedur_sekunder3 }}
                                        </td>
                                        <td>)</td>
                                    </tr>
                                </table>
                                <table border="0px" width="1000px" class="mt-3">
                                    <tr style="vertical-align: top;">
                                        <td width="100px"></td>
                                        <td width="400px"></td>
                                        <td width="150px"><b>TAGIHAN / PIUTANG</b></td>
                                        <td width="150px" class="text-center">:
                                            <b>Rp {{ number_format($item->totalpiutang, 0, ',', '.') }}
                                            </b>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
