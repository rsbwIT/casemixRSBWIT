<form action="{{ url('/cari-bayar-umum') }}">
    @csrf
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <div class="input-group input-group-xs">
                    <input type="text" name="cariNomor" class="form-control form-control-xs"
                        placeholder="Cari Nama/RM/No Rawat">
                    <div class="input-group-append">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <div class="input-group input-group-xs">
                    <input type="date" name="tgl1" class="form-control form-control-xs"
                        value="{{ request('tgl1', now()->format('Y-m-d')) }}">
                    <div class="input-group-append">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <div class="input-group input-group-xs">
                    <input type="date" name="tgl2" class="form-control form-control-xs"
                        value="{{ request('tgl2', now()->format('Y-m-d')) }}">
                    <div class="input-group-append">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <div class="input-group input-group-xs">
                    <select class="form-control" name="stsLanjut">
                        <option value="">Status Lanjut</option>
                        <option value="Ralan">Rawat Jalan</option>
                        <option value="Ranap">Rawat Inap</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <div class="input-group input-group-xs">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-md btn-primary">
                            <i class="fa fa-search"></i> Cari
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
