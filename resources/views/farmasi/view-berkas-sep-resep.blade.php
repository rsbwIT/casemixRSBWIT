@extends('..layout.layoutDashboard')
@section('title', 'Farmasi')

@section('konten')
    <div class="row">
        @include('farmasi.component.upload-berkas-farmasi')
        <div class="col-md-12 mb-3">
            <div class="d-flex justify-content-center align-items-center">
                @if ($cekBerkas->contains('jenis_berkas', 'FILE-SCAN-FARMASI') && $cekBerkas->contains('jenis_berkas', 'SEP-RESEP'))
                    <form action="{{ url('gabung-berkas-farmasi') }}" method="">
                        @csrf
                        <input name="no_rawat" value="{{ $getPasien->no_rawat }}" hidden>
                        <button type="submit" class="btn btn-block btn-outline-primary btn-flat">
                            <i class="fas fa-arrow-up"></i>
                            Gabungkan
                            <i class="fas fa-arrow-down"></i>
                        </button>
                    </form>
                @endif
                @if ($cekBerkas->contains('jenis_berkas', 'HASIL-FARMASI'))
                    <form action="{{ url('/download-hasilgabungberks') }}" method="">
                        @csrf
                        <input name="no_rawat" value="{{ $getPasien->no_rawat }}" hidden>
                        <input name="tgl1" value="{{ session('tgl1') }}" hidden>
                        <input name="tgl2" value="{{ session('tgl2') }}" hidden>
                        <input name="cariNomor" value="{{ session('cariNomor') }}" hidden>
                        <button id="ButtonDownloadHASIL" class="btn btn-outline-primary btn-flat" type="submit">
                            <i class="fas fa-download"></i>
                        </button>
                    </form>
                @endif
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Berkas Khanza</h3>
                </div>
                <div class="card-body">
                    @if ($jumlahData > 0)
                        <div class="card-body">
                            <div class="btn-group float-right">
                                <form action="{{ url('/print-sep-resep') }}" method="">
                                    @csrf
                                    <input name="cariNoRawat" value="{{ $noRawat }}" hidden>
                                    <input name="cariNoSep" value="{{ $noSep }}" hidden>
                                    <button type="submit" class="btn btn-primary btn-flat">
                                        <i class="fas fa-save"></i> Save pdf
                                    </button>
                                </form>
                                @if ($cekBerkas->contains('jenis_berkas', 'SEP-RESEP'))
                                    <form action="{{ url('/download-sepresep-farmasi') }}" method="">
                                        @csrf
                                        <input name="no_rawat" value="{{ $getPasien->no_rawat }}" hidden>
                                        <input name="tgl1" value="{{ session('tgl1') }}" hidden>
                                        <input name="tgl2" value="{{ session('tgl2') }}" hidden>
                                        <input name="cariNomor" value="{{ session('cariNomor') }}" hidden>
                                        <button id="ButtonDownloadSEPRESEP" class="btn btn-outline-primary btn-flat"
                                            type="submit">
                                            <i class="fas fa-download"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        {{-- BERKAS SEP ============================================================= --}}
                        @if ($getSEP)
                            @include('farmasi.component.berkas-sep')
                        @else
                            {{-- NULL --}}
                        @endif
                        {{-- BERKAS FARMASI (RESEP) --}}
                        @if ($berkasResep)
                        @include('farmasi.component.berkas-resep')
                        @else
                        {{-- NULL --}}
                        @endif
                        {{-- BERKAS LAB --}}
                        @if ($getLaborat)
                            @include('farmasi.component.berkas-lab')
                        @else
                            {{-- NULL --}}
                        @endif
                        {{-- ERROR HANDLING ============================================================= --}}
                    @else
                        <div class="card-body">
                            <div class="card p-4 d-flex justify-content-center align-items-center">

                            </div>
                        </div>
                    @endif
                    <div class="card-footer">
                        <div class="row">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('ButtonDownloadSEPRESEP').addEventListener('click', function() {
            setTimeout(function() {
                var cariNomor = encodeURIComponent('{{ session('cariNomor') }}');
                var tgl1 = encodeURIComponent('{{ session('tgl1') }}');
                var tgl2 = encodeURIComponent('{{ session('tgl2') }}');
                var url = '/cari-list-pasien-farmasi?cariNomor=' + cariNomor + '&tgl1=' + tgl1 + '&tgl2=' +
                    tgl2;
                window.location.href = url;
            }, 2000);
        });
        document.getElementById('ButtonDownloadHASIL').addEventListener('click', function() {
            setTimeout(function() {
                var cariNomor = encodeURIComponent('{{ session('cariNomor') }}');
                var tgl1 = encodeURIComponent('{{ session('tgl1') }}');
                var tgl2 = encodeURIComponent('{{ session('tgl2') }}');
                var url = '/cari-list-pasien-farmasi?cariNomor=' + cariNomor + '&tgl1=' + tgl1 + '&tgl2=' +
                    tgl2;
                window.location.href = url;
            }, 2000);
        });
    </script>


@endsection
