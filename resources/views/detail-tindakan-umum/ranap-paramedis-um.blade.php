@extends('..layout.layoutDashboard')
@section('title', 'Ranap Paramedis (Umum)')

@section('konten')
    <div class="card">
        <div class="card-body">
            @include('detail-tindakan-umum.component.cari-paramedis')
            <div class="row no-print">
                <div class="col-12">
                    <button type="button" class="btn btn-default float-right" id="copyButton">
                        <i class="fas fa-copy"></i> Copy table
                    </button>
                </div>
            </div>
            <table class="table table-sm table-bordered table-striped table-responsive text-xs" style="white-space: nowrap;"
                id="tableToCopy">
                <thead>
                    <tr>
                        <th>No.Rawat</th>
                        <th>No.RM</th>
                        <th>Nama Pasien</th>
                        <th>Kd.Tindakan</th>
                        <th>Nama Perawatan</th>
                        <th>NIP</th>
                        <th>Paramedis Yg Menangani</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Cara Bayar</th>
                        <th>Ruang</th>
                        <th>Jasa Sarana</th>
                        <th>Paket BHP</th>
                        <th>JM Paramedis</th>
                        <th>KSO</th>
                        <th>Manajemen</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $mergedData = $getRanapParamedis->merge($RalanParamedis);
                        $sortedData = $mergedData->sortBy('no_rawat');
                    @endphp

                    @foreach ($sortedData as $item)
                        <tr>
                            <td>{{ $item->no_rawat }}</td>
                            <td>{{ $item->no_rkm_medis }}</td>
                            <td>{{ $item->nm_pasien }}</td>
                            <td>{{ $item->kd_jenis_prw }}</td>
                            <td>{{ $item->nm_perawatan }}</td>
                            <td>{{ $item->nip }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->tgl_perawatan }}</td>
                            <td>{{ $item->jam_rawat }}</td>
                            <td>{{ $item->png_jawab }}</td>
                            <td>{{ $item->ruang ?? $item->nm_poli }}</td>
                            <!-- Tampilkan ruang jika ada, jika tidak, tampilkan nama poli -->
                            <td>{{ $item->material }}</td>
                            <td>{{ $item->bhp }}</td>
                            <td>{{ $item->tarif_tindakanpr }}</td>
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
