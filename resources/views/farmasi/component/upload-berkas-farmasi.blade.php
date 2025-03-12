<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Upload</h3>
        </div>
        <form action="{{ url('/upload-berkas-farmasi') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body px-5">
                <div class="row">
                    <div class="col-md-6">
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
                                placeholder="No Rawat">
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
                            <label for="exampleInputFile">Berkas Tambahan</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="exampleInputFile"
                                        name="file_scan_farmasi" required>
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary mt-5 float-right btn-flat"><i class="fas fa-save"></i>
                                Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
