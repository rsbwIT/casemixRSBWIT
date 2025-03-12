@extends('..layout.layoutDashboard')
@section('title', 'Claim Bpjs')


@section('konten')
    {{-- Notification Container at Top Center --}}
    <div class="notification-container" style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999; min-width: 300px;">
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="animation: slideIn 0.3s, fadeOut 0.5s 3s forwards;">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if(session('successSaveINACBG'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="animation: slideIn 0.3s, fadeOut 0.5s 3s forwards;">
            {{ session('successSaveINACBG') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card  card-primary">
                <div class="card-header">
                    <h5 class="card-title">Claim Bpjs</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <section class="content">
                        {{-- <form action="{{ url('/cariNorawat-ClaimBpjs') }}" action="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="input-group input-group-lg">
                                            <input type="search" name="cariNorawat" class="form-control form-control-lg"
                                                placeholder="Cari berdasarkan nomor rawat">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-lg btn-default">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form> --}}
                        <form action="{{ url('/upload-berkas') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                            @csrf
                            <input type="hidden" name="selected_scan" id="selected_scan">
                            <div class="row mt-1">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="no_rkm_medis">No Rekam Medis</label>
                                        <input type="text" class="form-control" name="no_rkm_medis"
                                            value="@isset($getPasien) {{ $getPasien->no_rkm_medis }} @endisset"
                                            placeholder="No Rekam Medis">
                                    </div>
                                    <div class="form-group">
                                        <label for="no_rawat">No Rawat</label>
                                        <input type="text" class="form-control" name="no_rawat"
                                            value="@isset($getPasien){{ $getPasien->no_rawat }} @endisset"
                                            placeholder="No Rawat">
                                    </div>
                                    <div class="form-group">
                                        <label for="no_sep">No SEP</label>
                                        <input type="text" class="form-control" name="no_sep"
                                            value="@isset($getPasien){{ $getPasien->no_sep }} @endisset"
                                            placeholder="No SEP">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nm_pasien">Nama Pasien</label>
                                        <input type="text" class="form-control" name="nama_pasein"
                                            value="@isset($getPasien) {{ $getPasien->nm_pasien }} @endisset"
                                            placeholder="Nama Pasien">
                                    </div>
                                    <div class="form-group">
                                        <label for="berkas_claim">Berkas INACBG</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="file_inacbg">
                                            <label class="custom-file-label" for="berkas_claim">Berkas INACBG</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="berkas_claim">Berkas SCAN</label>
                                        <div class="input-group">
                                            <div class="custom-file" style="min-width: 75%">
                                                <input type="file" class="custom-file-input" name="file_scan" id="file_scan">
                                                <label class="custom-file-label" for="file_scan">Pilih File</label>
                                            </div>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-info" data-toggle="modal"
                                                        data-target="#modalBerkasDigital" style="white-space: nowrap">
                                                    <i class="fas fa-folder-open"></i> Pilih Berkas
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
                        </form>

                <div class="card-footer">
                    <div class="row">

                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
    /**
     * Fungsi untuk mendapatkan path file yang benar
     * @param string $lokasi_file Path file dari database
     * @return string URL lengkap yang benar
     */
    function getCorrectFilePath($lokasi_file) {
        // Bersihkan path dari duplikasi
        $cleanPath = ltrim($lokasi_file, '/');

        // Jika path sudah dimulai dengan 'pages/upload/', hapus bagian itu
        if (strpos($cleanPath, 'pages/upload/') === 0) {
            $cleanPath = substr($cleanPath, strlen('pages/upload/'));
        }

        // Kembalikan URL lengkap
        return 'http://192.168.5.88/webapps/berkasrawat/pages/upload/' . $cleanPath;
    }
    @endphp

    @if(isset($getPasien))
    <script>
        // Fungsi untuk menampilkan berkas yang dipilih
        function showBerkas(index) {
            // Anda perlu menggunakan AJAX untuk mengirim request ke server
            // atau memperbarui tampilan jika menggunakan JavaScript
            $.ajax({
                url: "{{ url('/show-berkas') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    no_rawat: "{{ $getPasien->no_rawat }}",
                    index: index
                },
                success: function(response) {
                    // Perbarui tampilan berdasarkan response
                    location.reload();
                },
                error: function(error) {
                    console.error("Error:", error);
                }
            });
        }

        // Untuk menangani pilihan berkas dari modal
        $(document).ready(function() {
            // Ketika berkas dipilih dari modal
            $('.pilih-berkas').on('click', function() {
                var berkasId = $(this).data('berkas-id');
                var berkasPath = $(this).data('berkas-path');

                // Hanya update berkas SCAN
                $('#selected_scan').val(berkasPath);
                $('.custom-file-label[for="file_scan"]').text('Berkas SCAN dipilih dari database');
                $('#file_scan').prop('disabled', true);

                $('#modalBerkasDigital').modal('hide');
            });

            // Reset pilihan berkas jika file diupload
            $('#file_scan').on('change', function() {
                $('#selected_scan').val('');
            });
        });

        // Fungsi untuk preview dokumen
        $(document).on('click', '.btn-preview', function() {
            const url = $(this).data('url');
            const title = $(this).data('title');

            $('#previewModalLabel').text(title);
            $('#previewFrame').attr('src', url);
            $('#previewModal').modal('show');
        });

        // Bersihkan iframe saat modal ditutup
        $('#previewModal').on('hidden.bs.modal', function () {
            $('#previewFrame').attr('src', '');
        });

        // Fungsi untuk pilih dan gabungkan berkas
        function pilihDanGabungkan() {
            const selectedFiles = [];

            $('.select-to-merge:checked').each(function() {
                selectedFiles.push($(this).val());
            });

            if (selectedFiles.length > 0) {
                // Selalu simpan sebagai JSON array, bahkan untuk satu file
                var jsonValue = JSON.stringify(selectedFiles);
                $('#selected_scan').val(jsonValue);

                if (selectedFiles.length === 1) {
                    $('.custom-file-label[for="file_scan"]').text('1 berkas dipilih (format JSON)');
                } else {
                    $('.custom-file-label[for="file_scan"]').text(selectedFiles.length + ' berkas dipilih (akan digabungkan)');
                }

                // Disable input file manual
                $('#file_scan').prop('disabled', true);

                // Tampilkan nilai yang akan dikirim untuk debugging
                console.log('Nilai selected_scan yang akan dikirim:', jsonValue);

                // Tutup modal
                $('#modalBerkasDigital').modal('hide');

                alert('Berkas berhasil dipilih: ' + selectedFiles.length + ' berkas' +
                    (selectedFiles.length > 1 ? ' (akan digabungkan menjadi 1 PDF)' : ''));
            }
        }

        // Fungsi untuk membatalkan pilihan berkas
        function batalPilihBerkas() {
            // Unchecked semua checkbox
            $('.select-to-merge').prop('checked', false);
            $('#selectAll').prop('checked', false);

            // Reset nilai input file
            $('#file_scan').val('').prop('disabled', false);

            // Reset label
            $('.custom-file-label').text('Pilih File');

            // Reset nilai selected_scan
            $('#selected_scan').val('');

            // Update counter dan status tombol
            updateSelectedFiles();

            // Tutup modal
            $('#modalBerkasDigital').modal('hide');
        }

        // Perbarui penampilan jumlah berkas terpilih
        $(document).ready(function() {
            // Ketika checkbox berubah
            $(document).on('change', '.select-to-merge', function() {
                updateSelectedFiles();
            });

            function updateSelectedFiles() {
                const selectedCount = $('.select-to-merge:checked').length;
                $('#selectedCount').text(selectedCount);

                // Enable/disable tombol berdasarkan jumlah file yang dipilih
                if (selectedCount > 0) {
                    $('#btnGabung').prop('disabled', false);
                    $('#btnPilihGabung').prop('disabled', false);
                } else {
                    $('#btnGabung').prop('disabled', true);
                    $('#btnPilihGabung').prop('disabled', true);
                }
            }

            // Handler untuk Select All checkbox
            $(document).on('change', '#selectAll', function() {
                $('.select-to-merge').prop('checked', $(this).prop('checked'));
                updateSelectedFiles();
            });

            // Inisialisasi tampilan awal
            updateSelectedFiles();
        });

        // Tambahkan listener untuk form submit
        $(document).ready(function() {
            $('#uploadForm').on('submit', function(e) {
                console.log('Form disubmit dengan data:');
                console.log('selected_scan:', $('#selected_scan').val());
                console.log('no_rkm_medis:', $('input[name="no_rkm_medis"]').val());
                console.log('no_rawat:', $('input[name="no_rawat"]').val());
                console.log('no_sep:', $('input[name="no_sep"]').val());
            });
        });

        // Fungsi untuk menggabungkan dan mengunduh berkas
        function gabungBerkasTerpilih() {
            const selectedFiles = [];

            $('.select-to-merge:checked').each(function() {
                selectedFiles.push($(this).val());
            });

            if (selectedFiles.length > 0) {
                // Buat form untuk submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ url("/gabung-download-berkas") }}';
                form.style.display = 'none';

                // Tambahkan CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                // Tambahkan nomor rawat
                const noRawat = document.createElement('input');
                noRawat.type = 'hidden';
                noRawat.name = 'no_rawat';
                noRawat.value = $('input[name="no_rawat"]').val();
                form.appendChild(noRawat);

                // Tambahkan file yang dipilih
                selectedFiles.forEach(function(file, index) {
                    const fileInput = document.createElement('input');
                    fileInput.type = 'hidden';
                    fileInput.name = 'selected_files[]';
                    fileInput.value = file;
                    form.appendChild(fileInput);
                });

                // Tambahkan form ke body dan submit
                document.body.appendChild(form);
                form.submit();

                // Hapus form setelah submit
                setTimeout(function() {
                    document.body.removeChild(form);
                }, 100);
            } else {
                alert('Harap pilih minimal satu berkas terlebih dahulu');
            }
        }
    </script>
    @endif

    <!-- Modal Berkas Digital -->
    <div class="modal fade" id="modalBerkasDigital" tabindex="-1" role="dialog" aria-labelledby="modalBerkasDigitalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="modalBerkasDigitalLabel">Pilih Berkas Digital untuk SCAN</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if(isset($berkasList) && count($berkasList) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="bg-info text-white">
                                    <tr>
                                        <th width="5%">Pilih</th>
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
                                            <input type="checkbox" class="form-check-input select-to-merge"
                                                   name="selected_files[]"
                                                   value="{{ $berkas['lokasi_file'] }}">
                                        </td>
                                        <td>{{ basename($berkas['lokasi_file']) }}</td>
                                        @if(isset($berkas['kode']))
                                        <td>{{ $berkas['kode'] }}</td>
                                        @endif
                                        <td>
                                            <button type="button" class="btn btn-sm btn-success btn-preview"
                                                    data-url="{{ getCorrectFilePath($berkas['lokasi_file']) }}"
                                                    data-title="Berkas {{ $index + 1 }}">
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
                        <button type="button" id="batalPilihBerkas" class="btn btn-danger" onclick="batalPilihBerkas()">
                            <i class="fas fa-times"></i> Batal Pilih Berkas
                        </button>
                    </div>
                    <div>
                        <button type="button" id="btnGabung" class="btn btn-success" disabled onclick="gabungBerkasTerpilih()">
                            <i class="fas fa-file-pdf"></i> Gabung & Download (<span id="selectedCount">0</span>)
                        </button>
                        <button type="button" id="btnPilihGabung" class="btn btn-primary" disabled onclick="pilihDanGabungkan()">
                            <i class="fas fa-check-circle"></i> Pilih & Gabungkan
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Preview Dokumen -->
    <div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="previewModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <iframe id="previewFrame" style="width: 100%; height: 80vh; border: none;"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes slideIn {
            from { transform: translateY(-100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }

        .alert {
            box-shadow: 0 2px 15px rgba(0,0,0,0.15);
            padding: 15px 35px 15px 20px;
            border-radius: 8px;
            margin-bottom: 10px;
        }
    </style>

    <script>
        $(document).ready(function() {
            // Auto-hide alerts after 3 seconds
            setTimeout(function() {
                $('.alert').alert('close');
            }, 3000);

            // Manual close handler
            $('.alert').on('closed.bs.alert', function() {
                $(this).remove();
            });
        });
    </script>
@endsection
