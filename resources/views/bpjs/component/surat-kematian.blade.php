@if ($getSudartKematian)
    <div class="card-body">
        <div class="card p-4 d-flex justify-content-center align-items-center">
            <table border="0px" width="1000px">
                <tr>
                    <td rowspan="3"> <img src="data:image/png;base64,{{ base64_encode($getSetting->logo) }}" alt="Girl in a jacket" width="80" height="80"></td>
                    <td class="text-center">
                        <h4>{{$getSetting->nama_instansi}} </h4>
                    </td>
                    <td class="text-center" width="100px">
                    </td>
                </tr>
                <tr class="text-center">
                    <td>{{$getSetting->alamat_instansi}} , {{$getSetting->kabupaten}}, {{$getSetting->propinsi}}
                        {{$getSetting->kontak}}</td>
                </tr>
                <tr class="text-center">
                    <td> E-mail : {{$getSetting->email}}</td>
                </tr>
            </table>
            <hr width="1000px" class="mt-1 mb-0"
                style=" height:2px; border-top:1px solid black; border-bottom:2px solid black;">
            <table border="0px" width="1000px">
                <tr class="text-center">
                    <td colspan="0">
                        <h5 class="mt-2">SURAT KEMATIAN</h5>
                    </td>
                </tr>
            </table>
            <table border="0px" width="1000px">
                <tr>
                    <td width="100px">No.RM</td>
                    <td width="150px">: {{ $getSudartKematian->no_rkm_medis }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Lamp.</td>
                    <td>: </td>
                    <td></td>
                </tr>
            </table>
            <table border="0px" width="1000px" class="mt-4">
                <tr>
                    <td>Yang bertanda tangan di bawah ini menerangkan bahwa :</td>
                </tr>
            </table>
            <table border="0px" width="1000px">
                <tr>
                    <td width="50px"></td>
                    <td width="100px">Nama </td>
                    <td>: {{ $getSudartKematian->nm_pasien }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Umur </td>
                    <td>: {{ $getSudartKematian->umur }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Alamat </td>
                    <td>: {{ $getSudartKematian->alamat }}</td>
                </tr>
            </table>
            <table border="0px" width="1000px" class="mt-4">
                <tr>
                    <td>Telah meninggal dunia pada &emsp;
                        <u>{{ date('d-m-Y', strtotime($getSudartKematian->tanggal)) }}</u> &emsp; Jam
                        &emsp; <u>{{ $getSudartKematian->jam }}</u>
                    </td>
                </tr>
                <tr>
                    <td>
                        di {{$getSetting->nama_instansi}} dikarenakan {{ $getSudartKematian->keterangan }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Demikian surat keterangan ini dibuat agar menjadikan maklum dan dapat
                    </td>
                </tr>
                <tr>
                    <td>
                        sebagaimana mestinya
                    </td>
                </tr>
            </table>
            <table width="1000px" border="0px" class="mt-4">
                <tr>
                    <td>
                    </td>
                    <td class="text-center" width="350px">
                        {{$getSetting->kabupaten}}, {{ date('d-m-Y', strtotime($getSudartKematian->tanggal)) }}<br>
                        Dokter Pemeriksa <br>
                        <div class="barcode mt-1">
                            <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG('Dikeluarkan di '.$getSetting->nama_instansi.', Kabupaten/Kota '.$getSetting->kabupaten.' Ditandatangani secara elektronik oleh ' . $getSudartKematian->nm_dokter . ' ID ' . $getSudartKematian->kd_dokter . ' ' . $getSudartKematian->tanggal, 'QRCODE') }}"
                                alt="barcode" width="80px" height="75px" />
                        </div>
                        {{ $getSudartKematian->nm_dokter }}
                    </td>
                </tr>
            </table>
        </div>
    </div>
@else
    {{-- NULL --}}
@endif
