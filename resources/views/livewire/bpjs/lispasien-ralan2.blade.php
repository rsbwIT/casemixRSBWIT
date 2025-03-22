<div>
    @php
    function getCorrectFilePath($lokasi_file) {
        // Bersihkan path dari duplikasi
        $cleanPath = ltrim($lokasi_file, '/');

        // Jika path sudah dimulai dengan 'pages/upload/'
        if (strpos($cleanPath, 'pages/upload/') === 0) {
            $cleanPath = substr($cleanPath, strlen('pages/upload/'));
        }

        // Kembalikan URL lengkap
        return 'http://192.168.5.88/webapps/berkasrawat/pages/upload/' . $cleanPath;
    }
    @endphp

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

<!-- Modal Upload Scan -->
<div class="modal fade" id="UploadScan" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Pilih Berkas Digital untuk SCAN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form upload file manual -->
                <div class="form-group">
                    <label>Upload File SCAN Baru:</label>
                    <input type="file" class="form-control form-control" wire:model="upload_file_scan.{{ $keyModal }}">
                </div>

                <hr>
                <h6 class="font-weight-bold">Atau pilih dari berkas digital yang ada:</h6>

                @if(count($berkasList) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="bg-info text-white">
                                <tr>
                                    <th width="5%">
                                        Pilih
                                    </th>
                                    <th width="50%">Nama Berkas</th>
                                    @if(isset($berkasList[0]['kode']))
                                    <th width="20%">Kode</th>
                                    @endif
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($berkasList as $index => $berkas)
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox"
                                               wire:model="selectedFiles"
                                               value="{{ $berkas['lokasi_file'] }}"
                                               class="form-check-input">
                                    </td>
                                    <td>{{ basename($berkas['lokasi_file']) }}</td>
                                    @if(isset($berkas['kode']))
                                    <td>{{ $berkas['kode'] }}</td>
                                    @endif
                                    <td>
                                        <button type="button"
                                                class="btn btn-sm btn-success btn-preview"
                                                onclick="window.open('{{ getCorrectFilePath($berkas['lokasi_file']) }}', '_blank')">
                                            <i class="fas fa-eye"></i> Lihat
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-warning">
                        Tidak ada berkas digital yang ditemukan.
                    </div>
                @endif
            </div>
            <div class="modal-footer justify-content-between">
                <div>
                    <button type="button" class="btn btn-danger"
                            wire:click="$set('selectedFiles', [])">
                        <i class="fas fa-times"></i> Batal Pilih Berkas
                    </button>
                </div>
                <div>
                    <button type="button"
                            class="btn btn-success"
                            wire:click="pilihDanSimpanBerkas"
                            @if(count($selectedFiles) === 0) disabled @endif>
                        <i class="fas fa-check-circle"></i> Pilih & Simpan (<span>{{ count($selectedFiles) }}</span>)
                    </button>

                    <button type="button"
                            class="btn btn-primary"
                            wire:click="UploadScan('{{ $keyModal }}', '{{ $no_rawat }}', '{{ $no_rkm_medis }}')"
                            wire:loading.remove wire:target="upload_file_scan.{{ $keyModal }}"
                            @if(!isset($upload_file_scan[$keyModal])) disabled @endif>
                        <i class="fas fa-upload"></i> Upload File
                    </button>

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="UploadInacbg" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
    <!-- Modal content -->
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:load', function() {
        Livewire.on('showAlert', (data) => {
            Swal.fire({
                icon: data.type,
                title: data.message,
                showConfirmButton: false,
                timer: 3000
            });
        });
    });
</script>
@endpush
