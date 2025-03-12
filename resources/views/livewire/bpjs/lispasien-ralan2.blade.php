<div>
    <div class="row">
        <div class="col-md-4 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="nav-icon fas fa-receipt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><b>Total List Pasien</b></span>
                    <span class="info-box-number">
                        <h4>{{ $getPasien->count() }}</h4>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-check"></i></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><b>Total Yang Sudah Terbundling</b></span>
                    <span class="info-box-number">
                        <h4>
                            @php
                                $sudahBundling = $getPasien
                                    ->filter(function ($item) {
                                        return !is_null($item->file);
                                    })
                                    ->count();
                            @endphp
                            {{ $sudahBundling }}
                        </h4>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fas fa-pen-nib"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><b>Total Yang Belum Terbundling</b></span>
                    <span class="info-box-number">
                        <h4>
                            {{ abs($sudahBundling - $getPasien->count()) }}
                        </h4>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <form wire:submit.prevent="getListPasienRalan">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="input-group">
                            <input class="form-control form-control-sidebar form-control-sm" type="text"
                                aria-label="Search" placeholder="Cari Sep / Rm / No.Rawat" wire:model.defer="carinomor">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <input type="date" class="form-control form-control-sidebar form-control-sm"
                            wire:model.defer="tanggal1">
                    </div>
                    <div class="col-lg-2">
                        <div class="input-group">
                            <input type="date" class="form-control form-control-sidebar form-control-sm"
                                wire:model.defer="tanggal2">
                            <div class="input-group-append">
                                <button class="btn btn-sidebar btn-primary btn-sm" wire:click="render()">
                                    <i class="fas fa-search fa-fw"></i>
                                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"
                                        wire:loading wire:target="getListPasienRalan"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 text-right">
                        @if (session()->has('successSaveINACBG'))
                            <span class="text-success"><i class="icon fas fa-check"> </i>
                                {{ session('successSaveINACBG') }} </span>
                        @endif
                        @if (session()->has('errorBundling'))
                            <span class="text-danger"><i class="icon fas fa-ban"> </i> {{ session('errorBundling') }}
                            </span>
                        @endif
                    </div>
                </div>
            </form>
        </div>
        @php
        // Fungsi untuk mengekstrak bagian numerik dari nomor rawat
        function extractNumericPart($noRawat) {
            $parts = explode('/', $noRawat);
            return (int)end($parts); // Mengambil bagian terakhir dan mengonversi ke integer
        }

        // Mengurutkan data berdasarkan bagian numerik dari nomor rawat
        $sortedPasien = $getPasien->sortBy(function($item) {
            return extractNumericPart($item->no_rawat);
        });
    @endphp

    <div class="card-body table-responsive p-0" style="height: 450px;">
        <table class="table table-sm table-bordered table-hover table-head-fixed p-3 text-sm">
            <thead>
                <tr>
                    <th width="25%">#</th>
                    <th>RM</th>
                    <th>No.Rawat</th>
                    <th>No.Sep</th>
                    <th>Pasien</th>
                    <th>Poli</th>
                    <th>Tgl.Sep</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sortedPasien as $key => $item)
                    <tr>
                        <td>
                            <div class="d-flex justify-content-between">
                                {{-- UPLOAD BERKAS --}}
                                <div class="btn-group">
                                    <button type="button"
                                        class="btn btn-block btn-outline-primary btn-xs btn-flat dropdown-toggle dropdown-icon"
                                        data-toggle="dropdown">
                                        Upload <span class="spinner-grow spinner-grow-sm" role="status"
                                            aria-hidden="true" wire:loading
                                            wire:target="UploadInacbg('{{ $key }}', '{{ $item->no_rawat }}', '{{ $item->no_rkm_medis }}')"></span>
                                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"
                                            wire:loading
                                            wire:target="UploadScan('{{ $key }}', '{{ $item->no_rawat }}', '{{ $item->no_rkm_medis }}')"></span>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                            wire:click="SetmodalInacbg('{{ $key }}')"
                                            data-target="#UploadInacbg"><i class="fas fa-upload"></i> Berkas Inacbg
                                        </a>
                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                            wire:click="SetmodalScan('{{ $key }}')"
                                            data-target="#UploadScan"><i class="fas fa-upload"></i>
                                            Berkas Scan </a>
                                    </div>
                                </div>
                                {{-- SIMPAN KHANZA  --}}
                                <div class="btn-group">
                                    <button type="button"
                                        class="btn btn-block btn-outline-dark btn-xs btn-flat dropdown-toggle dropdown-icon"
                                        data-toggle="dropdown">
                                        Khanza <span class="spinner-grow spinner-grow-sm" role="status"
                                            aria-hidden="true" wire:loading
                                            wire:target="SimpanKhanza('{{ $item->no_rawat }}', '{{ $item->no_sep }}')"></span>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                        <button type="button" class="dropdown-item"
                                            wire:click="SimpanKhanza('{{ $item->no_rawat }}', '{{ $item->no_sep }}')">
                                            <i class="nav-icon fas fa-save"></i> Simpan Khanza
                                        </button>
                                        <form action="{{ url('carinorawat-casemix') }}" method=""
                                            class="">
                                            @csrf
                                            <input name="cariNorawat" value="{{ $item->no_rawat }}" hidden>
                                            <input name="cariNoSep" value="{{ $item->no_sep }}" hidden>
                                            <button type="submit" class="dropdown-item"">
                                                <i class="nav-icon fas fa-eye"></i> Detail Khanza
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                {{-- GABUNG BERKAS --}}
                                <div class="btn-group">
                                    <button type="button"
                                        class="btn btn-block btn-outline-success btn-xs btn-flat"
                                        wire:click="GabungBerkas('{{ $item->no_rawat }}', '{{ $item->no_rkm_medis }}')">
                                        Gabung <span class="spinner-grow spinner-grow-sm" role="status"
                                            aria-hidden="true" wire:loading
                                            wire:target="GabungBerkas('{{ $item->no_rawat }}', '{{ $item->no_rkm_medis }}')"></span>
                                    </button>
                                </div>
                                <div class="btn-group">
                                    @if ($item->file)
                                        <a href="{{ url('hasil_pdf/' . $item->file) }}" download
                                            class="btn btn-block btn-outline-success btn-xs btn-flat"
                                            role="button">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    @else
                                        <a href="#" class="btn btn-block btn-outline-dark btn-xs btn-flat"
                                            role="button">
                                            <i class="fas fa-ban"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>{{ $item->no_rkm_medis }}</td>
                        <td>{{ $item->no_rawat }}</td>
                        <td>{{ $item->no_sep }}</td>
                        <td>{{ $item->nm_pasien }}</td>
                        <td>{{ $item->nm_poli }}</td>
                        <td>{{ $item->tglsep }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- PENTING: Pindahkan modal di luar table -->
<div class="modal fade" id="UploadScan" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Upload Berkas <b>SCAN</b> :
                    <u>{{ $nm_pasien }}</u>
                </h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        {{-- Form Upload File --}}
                        <div class="form-group">
                            <label>File Scan</label>
                            <input type="file" class="form-control form-control" wire:model="upload_file_scan.{{ $keyModal }}">
                        </div>

                        {{-- Debug Info - Hapus setelah masalah teratasi --}}
                        <div class="alert alert-info">
                            Jumlah berkas: {{ count($berkasList) }}<br>
                            @if(isset($selectedBerkasIndex))
                                Berkas terpilih: {{ $selectedBerkasIndex }}<br>
                            @endif
                        </div>

                        {{-- Daftar Berkas Digital dari Database --}}
                        @if (count($berkasList) > 0)
                            <div class="mt-4">
                                <h6>Berkas Digital Tersedia:</h6>
                                <div class="list-group mb-3">
                                    @foreach ($berkasList as $index => $berkas)
                                        <div class="list-group-item d-flex justify-content-between align-items-center {{ $selectedBerkasIndex == $index ? 'active' : '' }}">
                                            <button type="button"
                                                class="btn text-dark text-left p-0 border-0 bg-transparent"
                                                wire:click="showBerkas({{ $index }})">
                                                Berkas {{ $index + 1 }}
                                                @if (isset($berkas['kode']))
                                                    - Kode: {{ $berkas['kode'] }}
                                                @endif
                                            </button>

                                            {{-- Tombol Download --}}
                                            <a href="{{ $this->getDownloadFileUrl($index) }}"
                                               class="btn btn-sm btn-success"
                                               download="{{ $this->getFileName($index) }}"
                                               target="_blank">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        @else
                            <div class="alert alert-warning mt-4">
                                Tidak ada berkas digital yang ditemukan untuk nomor rawat ini.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="submit" class="btn btn-primary" data-dismiss="modal"
                    wire:click="UploadScan('{{ $keyModal }}', '{{ $no_rawat }}', '{{ $no_rkm_medis }}')"
                    wire:loading.remove wire:target="upload_file_scan.{{ $keyModal }}">Submit
                </button>
                <div wire:loading wire:target="upload_file_scan.{{ $keyModal }}">
                    Uploading...
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="UploadInacbg" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
    <!-- Modal content -->
</div>
