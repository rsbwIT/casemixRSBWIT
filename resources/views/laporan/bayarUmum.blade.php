@extends('..layout.layoutDashboard')
@section('title', 'Bayar Umum')

@section('konten')
    <div class="card">
        <div class="card-body">
            @include('laporan.component.search-bayarUmum')
            Jumlah Data : {{ count($bayarUmum) }}
            <div class="row no-print">
                <div class="col-12">
                    <button type="button" class="btn btn-default float-right" id="copyButton">
                        <i class="fas fa-copy"></i> Copy table
                    </button>
                </div>
            </div>
            <table class="table table-sm table-hover table-bordered table-striped table-responsive text-xs mb-3"
                style="white-space: nowrap;" id="tableToCopy">
                <tbody>
                    <tr>
                        <th>No</th>
                        <th>Tgl.Bayar</th>
                        <th>Nama Pasien</th>
                        <th>Jenis Bayar</th>
                        <th>Status Lanjut</th>
                        <th>No.RM</th>
                        <th>No.Rawat</th>
                        <th>No. Nota</th>
                        <th>Registrasi</th>
                        <th>Obat+Emb+Tsl</th>
                        <th>Retur Oabt</th>
                        <th>Resep Pulang</th>
                        <th>Paket Tindakan</th>
                        <th>Operasi</th>
                        <th>Laborat</th>
                        <th>Radiologi</th>
                        <th>Tambahan</th>
                        <th>Kamar+Service</th>
                        <th>Potongan</th>
                        <th>Total</th>
                    </tr>
                    @foreach ($bayarUmum as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->tgl_byr }}</td>
                            <td>{{ $item->nm_pasien }}</td>
                            <td>{{ $item->png_jawab }}</td>
                            <td>{{ $item->status_lanjut }}</td>
                            <td>{{ $item->no_rkm_medis }}</td>
                            <td>{{ $item->no_rawat }}</td>
                            <td>
                                @foreach ($item->getNomorNota as $detail)
                                    {{ str_replace(':', '', $detail->nm_perawatan) }}
                                @endforeach
                            </td>
                            <td>
                                {{ $item->getRegistrasi->sum('totalbiaya') }}
                            </td>
                            <td>
                                {{ $item->getObat->sum('totalbiaya') }}
                            </td>
                            <td>
                                {{ $item->getReturObat->sum('totalbiaya') }}
                            </td>
                            <td>
                                {{ $item->getResepPulang->sum('totalbiaya') }}
                            </td>
                            <td>
                                {{ $item->getRalanDokter->sum('totalbiaya') +
                                    $item->getRalanParamedis->sum('totalbiaya') +
                                    $item->getRalanDrParamedis->sum('totalbiaya') +
                                    $item->getRanapDokter->sum('totalbiaya') +
                                    $item->getRanapDrParamedis->sum('totalbiaya') +
                                    $item->getRanapParamedis->sum('totalbiaya') }}
                                <div class="badge-group-sm float-right">
                                    <a data-toggle="dropdown" href="#"><i class="fas fa-eye"></i></a>
                                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                        <div class="dropdown-item">
                                            Dokter =
                                            {{ $item->getRalanDokter->sum('totalbiaya') + $item->getRanapDokter->sum('totalbiaya') }}
                                        </div>
                                        <div class="dropdown-item">
                                            Paramedis =
                                            {{ $item->getRalanParamedis->sum('totalbiaya') + $item->getRanapParamedis->sum('totalbiaya') }}
                                        </div>
                                        <div class="dropdown-item">
                                            Dokter Paramedis =
                                            {{ $item->getRalanDrParamedis->sum('totalbiaya') + $item->getRanapDrParamedis->sum('totalbiaya') }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                {{ $item->getOprasi->sum('totalbiaya') }}
                            </td>
                            <td>
                                {{ $item->getLaborat->sum('totalbiaya') }}
                            </td>
                            <td>
                                {{ $item->getRadiologi->sum('totalbiaya') }}
                            </td>
                            <td>
                                {{ $item->getTambahan->sum('totalbiaya') }}
                            </td>
                            <td>
                                {{ $item->getKamarInap->sum('totalbiaya') }}
                            </td>
                            <td>
                                {{ $item->getPotongan->sum('totalbiaya') }}
                            </td>
                            <td>
                                {{ $item->getRegistrasi->sum('totalbiaya') +
                                    $item->getObat->sum('totalbiaya') +
                                    $item->getReturObat->sum('totalbiaya') +
                                    $item->getResepPulang->sum('totalbiaya') +
                                    $item->getRalanDokter->sum('totalbiaya') +
                                    $item->getRalanParamedis->sum('totalbiaya') +
                                    $item->getRalanDrParamedis->sum('totalbiaya') +
                                    $item->getRanapDokter->sum('totalbiaya') +
                                    $item->getRanapDrParamedis->sum('totalbiaya') +
                                    $item->getRanapParamedis->sum('totalbiaya') +
                                    $item->getOprasi->sum('totalbiaya') +
                                    $item->getLaborat->sum('totalbiaya') +
                                    $item->getRadiologi->sum('totalbiaya') +
                                    $item->getTambahan->sum('totalbiaya') +
                                    $item->getKamarInap->sum('totalbiaya') +
                                    $item->getPotongan->sum('totalbiaya') }}
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <th colspan="8">Total :</th>
                        <th>
                            {{ $bayarUmum->sum(function ($item) {
                                return $item->getRegistrasi->sum('totalbiaya');
                            }) }}
                        </th>
                        <th>
                            {{ $bayarUmum->sum(function ($item) {
                                return $item->getObat->sum('totalbiaya');
                            }) }}
                        </th>
                        <th>
                            {{ $bayarUmum->sum(function ($item) {
                                return $item->getReturObat->sum('totalbiaya');
                            }) }}
                        </th>
                        <th>
                            {{ $bayarUmum->sum(function ($item) {
                                return $item->getResepPulang->sum('totalbiaya');
                            }) }}
                        </th>
                        <th>
                            {{ $bayarUmum->sum(function ($item) {
                                return $item->getRalanDokter->sum('totalbiaya') +
                                    $item->getRalanParamedis->sum('totalbiaya') +
                                    $item->getRalanDrParamedis->sum('totalbiaya') +
                                    $item->getRanapDokter->sum('totalbiaya') +
                                    $item->getRanapDrParamedis->sum('totalbiaya') +
                                    $item->getRanapParamedis->sum('totalbiaya');
                            }) }}
                        </th>
                        <th>
                            {{ $bayarUmum->sum(function ($item) {
                                return $item->getOprasi->sum('totalbiaya');
                            }) }}
                        </th>
                        <th>
                            {{ $bayarUmum->sum(function ($item) {
                                return $item->getLaborat->sum('totalbiaya');
                            }) }}
                        </th>
                        <th>
                            {{ $bayarUmum->sum(function ($item) {
                                return $item->getRadiologi->sum('totalbiaya');
                            }) }}
                        </th>
                        <th>
                            {{ $bayarUmum->sum(function ($item) {
                                return $item->getTambahan->sum('totalbiaya');
                            }) }}
                        </th>
                        <th>
                            {{ $bayarUmum->sum(function ($item) {
                                return $item->getKamarInap->sum('totalbiaya');
                            }) }}
                        </th>
                        <th>
                            {{ $bayarUmum->sum(function ($item) {
                                return $item->getPotongan->sum('totalbiaya');
                            }) }}
                        </th>
                        <th>
                            {{ $bayarUmum->sum(function ($item) {
                                return $item->getRegistrasi->sum('totalbiaya') +
                                    $item->getObat->sum('totalbiaya') +
                                    $item->getReturObat->sum('totalbiaya') +
                                    $item->getResepPulang->sum('totalbiaya') +
                                    $item->getRalanDokter->sum('totalbiaya') +
                                    $item->getRalanParamedis->sum('totalbiaya') +
                                    $item->getRalanDrParamedis->sum('totalbiaya') +
                                    $item->getRanapDokter->sum('totalbiaya') +
                                    $item->getRanapDrParamedis->sum('totalbiaya') +
                                    $item->getRanapParamedis->sum('totalbiaya') +
                                    $item->getOprasi->sum('totalbiaya') +
                                    $item->getLaborat->sum('totalbiaya') +
                                    $item->getRadiologi->sum('totalbiaya') +
                                    $item->getTambahan->sum('totalbiaya') +
                                    $item->getKamarInap->sum('totalbiaya') +
                                    $item->getPotongan->sum('totalbiaya');
                            }) }}
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        document.getElementById("copyButton").addEventListener("click", function() {
            copyTableToClipboard("tableToCopy");
        });

        function copyTableToClipboard(tableId) {
            const table = document.getElementById(tableId);
            const range = document.createRange();
            range.selectNode(table);
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(range);
            try {
                document.execCommand("copy");
                window.getSelection().removeAllRanges();
                alert("Tabel telah berhasil disalin ke clipboard.");
            } catch (err) {
                console.error("Tidak dapat menyalin tabel:", err);
            }
        }
    </script>
@endsection
