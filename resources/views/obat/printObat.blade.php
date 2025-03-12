<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .table1 {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }
    </style>
</head>

<body>
    <table border="0" style="width:90%">

        <tr>
            <th align="center"> <img src="../img/rs.png" alt="Girl in a jacket" width="90" height="75"></th>
            <td align='center'><text><b>BILLING PERINCIAN RESEP APOTIK / BHP KAMAR OPRASI</b></text><br>
                <text><b>RUMAH SAKIT BUMI WARAS</b></text> <br style="margin-top:10px;">
                <text>Jalan Wolter Monginsidi NO. 235 - Bandar Lampung 252115</text><br style="margin-top:5px;">
            </td>
        </tr>
    </table>
    <hr style=" height:3px; border-top:1px solid black; border-bottom:2px solid black;">
    <p>No.RM &emsp;&emsp;&ensp;: &emsp;{{$getPasien->no_rkm_medis}}</p>
    <p>No.Rawat &emsp;&ensp;: &emsp;{{$getPasien->no_rawat}}</p>
    <p><text>Nama &emsp; &emsp; &ensp; : &emsp;{{$getPasien->nm_pasien}}</text></p>
    <p><text>Jenis Bayar &emsp;: &emsp;{{$getPasien->png_jawab}}</text></p>
    <table class="table1" border="1" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th colspan="8">
                    BILLING PERINCIAN RESEP APOTIK / BHP
                </th>
            </tr>
            <tr>
                <th width="20px">NO</th>
                <th width="80px">TGL BERI</th>
                <th width="300px">NAMA OBAT / ALKES</th>
                <th width="80px">EMBALASE</th>
                <th width="80px">TUSLAH</th>
                <th width="100px">JUMLAH OBAT</th>
                <th width="100px">BIAYA OBAT</th>
                <th width="120px">TOTAL BIAYA</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1;  @endphp
            @if ($getAllObat)
                @foreach ($getAllObat as $item)
                    <tr class="text-xs font-weight-bold">
                        <td align="center">{{ $no++ }}</td>
                        <td>{{ $item->tanggal_beri }}</td>
                        <td>{{ $item->nama_brng }}</td>
                        <td align="center">{{ $item->embalase }}</td>
                        <td align="center">{{ $item->tuslah }}</td>
                        <td align="center">{{ $item->jml }}</td>
                        <td>Rp. {{ number_format($item->biaya_obat, 2, ',', '.') }}</td>
                        <td>Rp. {{ number_format($item->total, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="10" class="text-center">Silahkan Cari data</td>
                </tr>
            @endif
            <tr class="font-weight-bold">
                <td colspan="7">
                    <b>TOTAL OBAT / ALKES</b>
                </td>
                <td colspan="2" style="text-align:center;">
                    <b>Rp. {{ number_format($sumAllObat, 2, ',', '.') }}</b>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- ================= RETUR ================= -->
    <table class="table1" border="1" width="100%" cellspacing="0" style="margin-top:10px;">
        <tbody>
            <tr>
                <th colspan="8">
                    RETUR OBAT
                </th>
            </tr>
            <tr>
                <th width="20px">NO</th>
                <th width="80px">TGL RETUR</th>
                <th width="300px">NAMA OBAT / ALKES</th>
                <th width="100px">JUMLAH RETUR</th>
                <th width="100px">BIAYA OBAT</th>
                <th width="120px">TOTAL BIAYA</th>
            </tr>
        </tbody>
        <tbody>
            @php $no = 1;  @endphp
            @foreach ($getAllRetur as $item)
            <tr class="text-xs font-weight-bold">
                <td>{{ $no++ }}</td>
                <td>{{ $item->tgl_retur }}</td>
                <td>{{ $item->nama_brng }}</td>
                <td align="center">{{ $item->jml_retur }}</td>
                <td>{{ $item->h_retur }}</td>
                <td>Rp. {{ number_format($item->subtotal, 2, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="5">
                    <b>TOTAL RETUR</b>
                </td>
                <td colspan="2" style="text-align:center;">
                    <b>Rp. {{ number_format($sumAllRetur, 2, ',', '.') }}</b>
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    <b>TOTAL OBAT / ALKES</b>
                </td>
                <td colspan="2" style="text-align:center;">
                    <b>Rp. {{ number_format($sumAllObat, 2, ',', '.') }}</b>
                </td>
            </tr>
            <tr>
                <td colspan=5">
                    <b>TOTAL OBAT BERSIH</b>
                </td>
                <td colspan="2" style="text-align:center;">
                    <b>Rp. {{ number_format($TotalObtBersih, 2, ',', '.') }}</b>
                </td>
            </tr>
        </tbody>
    </table>
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>
