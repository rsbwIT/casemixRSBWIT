@extends('..layout.layoutDashboard')
@section('title', 'Laporan pasien')

@section('konten')
    <div class="card">
        <div class="row">
            <div class="col-lg-6">
                <div id="myPlotJnsByr" style="width:100%;max-width:700px; "></div>
            </div>
            <div class="col-lg-6">
                <div id="myPlot" style="width:100%;max-width:100%"></div>
            </div>
        </div>
    </div>
    <script>
        // JUMLAH PASIEN BERDASARKAN JENIS BAYAR
        const xJenisBayar = [];
        const yTotal = [];
        var pasein = @json($pasein);
        pasein.forEach(function(item) {
            xJenisBayar.push(item.png_jawab);
            yTotal.push(item.total);
        });
        const layoutJnsByr = {
            title: "Jenis Bayar"
        };
        const JenisBayar = [{
            labels: xJenisBayar,
            values: yTotal,
            hole: .4,
            type: "pie"
        }];
        Plotly.newPlot("myPlotJnsByr", JenisBayar, layoutJnsByr);

        // JUMLAH PASIEN PERBULAN
        const xTglReg = [];
        const yjmLPasien = [];
        var dataCounts = @json($dataCounts);
        dataCounts.forEach(function(item) {
            xTglReg.push(item.tgl_registrasi);
            yjmLPasien.push(item.jumlah_pas);
        });
        const data = [{
        x: xTglReg,
        y: yjmLPasien,
        mode:"lines"
        }];
        const layout = {
        xaxis: {range: [], title: "Jumlah Pasien"},
        yaxis: {range: [], title: "Tanggal"},
        };
        Plotly.newPlot("myPlot", data, layout);
    </script>
@endsection
