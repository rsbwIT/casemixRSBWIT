@extends('..layout.layoutDashboard')
@section('title', 'Ralan Dokter (Umum)')

@section('konten')
    <div class="card">
        <div class="card-body">
            @include('detail-tindakan-umum.component.cari-dokter')
            <div class="row no-print">
                <div class="col-12">
                    <button type="button" class="btn btn-default float-right" id="copyButton">
                        <i class="fas fa-copy"></i> Copy table
                    </button>
                </div>
            </div>
            <table class="table table-sm table-bordered table-striped table-responsive text-xs" style="white-space: nowrap;"
                id="tableToCopy">
                <tbody>
                    <tr>
                        <th>No.</th>
                        <th>Tgl Bayar</th>
                        <th>No.Rawat</th>
                        <th>No.RM</th>
                        <th>Nama Pasien</th>
                        <th>Kd.Tnd</th>
                        <th>Perawatan/Tindakan</th>
                        <th>Kd.Dokter</th>
                        <th>Dokter</th>
                        <th>Tanggal Perawatan</th>
                        <th>Jam Perawatan</th>
                        <th>Cara Bayar</th>
                        <th>Ruangan</th>
                        <th>Jasa Sarana</th>
                        <th>Paket BHP</th>
                        <th>JM Dokter</th>
                        <th>KSO</th>
                        <th>Menejemen</th>
                        <th>Total</th>
                    </tr>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($RalanDokterUmum as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->tgl_byr }}</td>
                            <td>{{ $item->no_rawat }}</td>
                            <td>{{ $item->no_rkm_medis }}</td>
                            <td>{{ $item->nm_pasien }}</td>
                            <td>{{ $item->kd_jenis_prw }}</td>
                            <td>{{ $item->nm_perawatan }}</td>
                            <td>{{ $item->kd_dokter }}</td>
                            <td>{{ $item->nm_dokter }}</td>
                            <td>{{ $item->tgl_perawatan }}</td>
                            <td>{{ $item->jam_rawat }}</td>
                            <td>{{ $item->png_jawab }}</td>
                            <td>{{ $item->nm_poli }}</td>
                            <td>{{ $item->material }}</td>
                            <td>{{ $item->bhp }}</td>
                            <td>{{ $item->tarif_tindakandr }}</td>
                            <td>{{ $item->kso }}</td>
                            <td>{{ $item->menejemen }}</td>
                            <td>{{ $item->biaya_rawat }}</td>
                        </tr>
                    @endforeach
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
