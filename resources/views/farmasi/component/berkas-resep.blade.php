@foreach ($berkasResep as $itemresep)
    <div class="card-body">
        <div class="card p-4 d-flex justify-content-center align-items-center">
            <table border="0px" width="1000px">
                <tr>
                    <td rowspan="4"><img src="data:image/png;base64,{{ base64_encode($getSetting->logo) }}"
                        alt="Girl in a jacket" width="80" height="80">
                    </td>
                    <td class="text-center">
                        <h4>{{ $getSetting->nama_instansi }} </h4>
                    </td>
                </tr>
                <tr class="text-center">
                    <td>{{ $getSetting->alamat_instansi }} , {{ $getSetting->kabupaten }},
                        {{ $getSetting->propinsi }}
                        {{ $getSetting->kontak }}</td>
                </tr>
                <tr class="text-center">
                    <td> E-mail : {{ $getSetting->email }}</td>
                </tr>
            </table>
            <hr width="1000px" style=" height:2px; border-top:1px solid black; border-bottom:2px solid black;">
            <table border="0px" width="1000px">
                <tr>
                    <td width="148px">Faktur No</td>
                    <td width="416px">: {{ $itemresep->nota_piutang }}</td>
                    <td width="148px">Nama Pasien</td>
                    <td width="288px">: {{ $itemresep->nm_pasien }}</td>
                </tr>
                <tr>
                    <td>Sales</td>
                    <td>: {{ $itemresep->nama_petugas }}</td>
                    <td>Tanggal Piutang</td>
                    <td>: {{ $itemresep->tgl_piutang }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Jatuh Tempo</td>
                    <td>: {{ $itemresep->tgltempo }}</td>
                </tr>
            </table>
            <table border="1px" width="1000px" class="mt-2">
                @php
                    $no = 1;
                    $totalResep = 0;
                    $ongkir = $itemresep->ongkir;
                    $uangmuka = $itemresep->uangmuka;
                @endphp
                    <tr class="text-center">
                        <td width="30px">No</td>
                        <td width="454px">Barang</td>
                        <td width="149px">Harga</td>
                        <td width="79px">Jml</td>
                        <td width="138px">Diskon</td>
                        <td width="150px">Total</td>
                    </tr>
                @foreach ($itemresep->detailberkasResep as $itemresep)
                    <tr>
                        <td class="text-center">{{$no++}}</td>
                        <td>{{$itemresep->nama_brng}}</td>
                        <td>{{number_format($itemresep->h_jual, 0, ',', '.')}}</td>
                        <td>{{$itemresep->jumlah}}</td>
                        <td>{{$itemresep->dis}}</td>
                        <td>{{ number_format($itemresep->total, 0, ',', '.') }}</td>
                    </tr>
                    @php
                        $totalResep += $itemresep->total; // Menambahkan nilai $itemresep->total ke dalam total
                    @endphp
                @endforeach
            </table>
            <table width="1000px" class="mt-1">
                <tr>
                    <td colspan="4"></td>
                    <td width="138px">Total Beli:</td>
                    <td width="150px">{{ number_format($totalResep, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td>Ongkir :</td>
                    <td>{{ number_format($ongkir, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td>Uang Muka :</td>
                    <td>{{ number_format($uangmuka, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td><b>TOTAL :</b></td>
                    <td><b>Rp. {{ number_format($totalResep, 0, ',', '.') }}</b></td>
                </tr>
            </table>
        </div>
    </div>
@endforeach
{{-- RESEP --}}
@foreach ($berkasResep as $itemresep)
    <div class="card-body">
        <div class="card p-4 d-flex justify-content-center align-items-center">
            <table border="0px" width="1000px">
                <tr>
                    <td rowspan="4"> <img src="data:image/png;base64,{{ base64_encode($getSetting->logo) }}"
                        alt="Girl in a jacket" width="80" height="80">
                    </td>
                    <td class="text-center">
                        <h4>RS. BUMI WARAS </h4>
                    </td>
                </tr>
                <tr class="text-center">
                    <td>{{ $getSetting->alamat_instansi }} , {{ $getSetting->kabupaten }},
                        {{ $getSetting->propinsi }}
                        {{ $getSetting->kontak }}</td>
                </tr>
                <tr class="text-center">
                    <td> E-mail : {{ $getSetting->email }}</td>
                </tr>
            </table>
            <hr width="1000px" style=" height:2px; border-top:1px solid black; border-bottom:2px solid black;">
            <table border="0px" width="1000px">
                <tr>
                    <td width="148px">Nama Pasien</td>
                    <td>: {{ $itemresep->nm_pasien }}</td>
                </tr>
                <tr>
                    <td>No. R.M</td>
                    <td>: {{ $itemresep->no_rkm_medis }}</td>
                </tr>
                <tr>
                    <td>No. Rawat</td>
                    <td>: {{ $itemresep->no_rawat }}</td>
                </tr>
                <tr>
                    <td>Jenis Bayar</td>
                    <td>: {{ $itemresep->catatan }}</td>
                </tr>
                <tr>
                    <td>Pemberi Resep</td>
                    <td>: {{ $itemresep->nm_dokter }}</td>
                </tr>
                <tr>
                    <td>No. Resep</td>
                    <td>: {{ $itemresep->no_resep }} </td>
                </tr>
            </table>
            <hr width="1000px" style=" height:1px; border-top:1px solid black; border-bottom:1px solid black;">
            <table border="1px" width="1000px" class="mt-2">
                    <tr class="text-center">
                        <td colspan="3">RESEP</td>
                    </tr>
                @php
                    $nm_dokter= $itemresep->nm_dokter;
                    $kd_dokter= $itemresep->kd_dokter;
                    $tgl_peresepan= $itemresep->tgl_peresepan;
                @endphp
                @foreach ($itemresep->detailberkasResep as $itemresep)
                    <tr>
                        <td width="500px">R/ {{$itemresep->nama_brng}}</td>
                        <td width="250px">{{$itemresep->jumlah}} {{$itemresep->satuan}}</td>
                        <td width="250px">S_ _ _ _ _ _{{$itemresep->aturan_pakai}}</td>
                    </tr>
                @endforeach
            </table>
            <table width="1000px" border="0px" class="mt-1">
                <tr>
                    <td>
                    </td>
                    <td class="text-center" width="350px">
                        Bandar Lampung, {{$tgl_peresepan}}<br>
                        <div class="barcode mt-1">
                            <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG('Dikeluarkan di '.$getSetting->nama_instansi.', Kabupaten/Kota ' . $getSetting->kabupaten . ' Ditandatangani secara elektronik oleh ' . $nm_dokter . ' ID ' . $kd_dokter . ' ' . $tgl_peresepan, 'QRCODE') }}"
                                alt="barcode" width="80px" height="75px" />
                        </div>
                        <b>{{ $nm_dokter }}</b>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endforeach
