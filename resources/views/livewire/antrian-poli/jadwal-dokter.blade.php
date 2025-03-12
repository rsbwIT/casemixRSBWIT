<div>
    <div class="card">
        @if (Session::has('succsesEditJadwal'))
            <div class="ribbon-wrapper ribbon-lg" style="z-index: 100">
                <div class="ribbon bg-warning">
                    Sukses
                </div>
            </div>
        @endif
        @if (Session::has('sucsessHapusDokter'))
            <div class="ribbon-wrapper ribbon-lg" style="z-index: 100">
                <div class="ribbon bg-warning">
                    Sukses
                </div>
            </div>
        @endif
        <div class="card-header">
            <form wire:submit.prevent="jdawalDokter">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="input-group">
                            <input class="form-control form-control-sidebar form-control-sm" type="text"
                                wire:model.defer="cari_dokter" aria-label="Search"
                                placeholder="Cari Nama / Kode Dokter">

                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="input-group">
                            <select class="form-control form-control-sm" wire:model.defer="pilih_hari">
                                <option value="SENIN">SENIN</option>
                                <option value="SELASA">SELASA</option>
                                <option value="RABU">RABU</option>
                                <option value="KAMIS">KAMIS</option>
                                <option value="JUMAT">JUMAT</option>
                                <option value="SABTU">SABTU</option>
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-sidebar btn-default btn-sm">
                                    <i class="fas fa-search fa-fw" wire:loading.remove wire:target='jdawalDokter'></i>
                                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"
                                        wire:loading wire:target='jdawalDokter'></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body table-responsive p-0" style="height: 450px;">
            @if (!$getDokter->isEmpty())
                <table class="table table-sm table-bordered table-head-fixed p-3">
                    <thead>
                        <tr>
                            <th>Kode Dokter</th>
                            <th>Nama Dokter</th>
                            <th>Hari Kerja</th>
                            <th>Jam Mulai</th>
                            <th>Jam Akhir</th>
                            <th>Poli</th>
                            <th class="text-center">Act</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($getDokter as $key => $item)
                            <tr>
                                <td>{{ $item->kd_dokter }}</td>
                                <td>{{ $item->nm_dokter }}</td>
                                <td>{{ $item->hari_kerja }}</td>
                                <td>{{ $item->jam_mulai }}</td>
                                <td>{{ $item->jam_selesai }}</td>
                                <td>{{ $item->nm_poli }}</td>
                                <td class="text-center">
                                    <div class="badge-group">
                                        <a data-toggle="modal" data-target="#updateModal{{ $key }}"
                                            class="text-warning mx-2" href="#"><i class="fas fa-edit"></i></a>
                                        <a data-toggle="modal" data-target="#deleteModal{{ $key }}"
                                            class="text-danger mx-2" href="#"><i class="fas fa-trash"></i></a>
                                    </div>
                                    <div class="modal fade" id="updateModal{{ $key }}" tabindex="-1"
                                        role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title">Edit Jadwal <b>{{ $item->nm_dokter }}</b>
                                                    </h6>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label>Jam Mulai
                                                                </label>
                                                                <input type="time" class="form-control form-control"
                                                                    wire:model.defer="getDokter.{{ $key }}.jam_mulai">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label>Jam Selesai
                                                                </label>
                                                                <input type="time" class="form-control"
                                                                    wire:model.defer="getDokter.{{ $key }}.jam_selesai">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-primary"
                                                        wire:click="ubahJadwalDokter('{{ $key }}', '{{ $item->hari_kerja }}', '{{ $item->jam_mulai }}', '{{ $item->jam_selesai }}')"
                                                        data-dismiss="modal">Ubah</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="deleteModal{{ $key }}" tabindex="-1"
                                        role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Peringatan !!!</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h6>Anda yakin ingin menghapus jadwal {{ $item->nm_dokter }} ?</h6>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-danger"
                                                        wire:click="hapusJadwalDokter('{{ $key }}', '{{ $item->hari_kerja }}', '{{ $item->jam_mulai }}', '{{ $item->jam_selesai }}')"
                                                        data-dismiss="modal">
                                                        Hapus
                                                    </button>
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Batal</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h6 class="text-center mt-3">Tidak Ada Jadwal Pada Hari ini
                </h6>
            @endif
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <span class="text-header"><b>Tambah Jadwal Dokter</b></span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <form wire:submit.prevent="cariDokter">
                        <div class="input-group">
                            <input class="form-control form-control-sidebar form-control-sm" type="text"
                                placeholder="Cari Kode Dokter" wire:model.lazy="cari_kode_dokter"
                                aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-default btn-sidebar btn-primary btn-sm">
                                    <i class="fas fa-search fa-fw" wire:loading.remove wire:target='cariDokter'></i>
                                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"
                                        wire:loading wire:target='cariDokter'></span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    @if (!$getTambahDokter->isEmpty())
                        <table class="table table-valign-middle table-sm">
                            <thead>
                                <tr>
                                    <th>Kode Dokter</th>
                                    <th>Nama Dokter</th>
                                    <th class="text-center" width="15%">Hari Kerja</th>
                                    <th class="text-center" width="15%">Jam Mulai</th>
                                    <th class="text-center" width="15%">Jam Akhir</th>
                                    <th class="text-center" width="15%">Poli</th>
                                    <th class="text-center">Act</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($getTambahDokter as $key => $item)
                                    <tr>
                                        <td>{{ $item->kd_dokter }}</td>
                                        <td>{{ $item->nm_dokter }}</td>
                                        <td class="text-center">
                                            <select class="form-control form-control-sm"
                                                wire:model.defer="pilih_hari">
                                                <option value="SENIN">SENIN</option>
                                                <option value="SELASA">SELASA</option>
                                                <option value="RABU">RABU</option>
                                                <option value="KAMIS">KAMIS</option>
                                                <option value="JUMAT">JUMAT</option>
                                                <option value="SABTU">SABTU</option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <input
                                                class="form-control form-control-sm @error('jam_selesai.' . $key) is-invalid @enderror"
                                                type="time" wire:model.lazy="jam_mulai.{{ $key }}"
                                                aria-label="Search" required>
                                        </td>
                                        <td class="text-center">
                                            <input
                                                class="form-control form-control-sm @error('jam_selesai.' . $key) is-invalid @enderror"
                                                type="time" wire:model.lazy="jam_selesai.{{ $key }}"
                                                aria-label="Search" required>
                                        </td>
                                        <td class="text-center">
                                            <select class="form-control form-control-sm @error('poli.' . $key) is-invalid @enderror"
                                                wire:model.lazy="poli.{{ $key }}">
                                                <option>Pilih Poli</option>
                                                @foreach ($getPoli as $data)
                                                    <option value="{{$data->kd_poli}}">{{$data->nm_poli}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            @if (Session::has('sucsess' . $key))
                                                <span class="text-success"><i class="fas fa-check"></i>
                                                    Berhasil</span>
                                            @else
                                                <button class="btn btn-xs btn-primary"
                                                    wire:click="tambahJadwalDokter('{{ $key }}','{{ $item->kd_dokter }}')">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
