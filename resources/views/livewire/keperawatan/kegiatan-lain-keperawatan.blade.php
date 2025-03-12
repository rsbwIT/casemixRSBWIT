<div>
    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="card-title">Form Input Kegiatan |
                {{ session()->has('auth') ? session('auth')['id_user'] : '' }}</h3>
        </div>
        @if (!$getPegawai->isEmpty())
            @foreach ($getPegawai as $key => $pegawai)
                <div class="row m-2">
                    <div class="col-md-3">
                        <div class="card card-primary ">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="img-circle" height="80px" width="80px" src="/img/user.jpg"
                                        alt="User profile picture">
                                </div>
                                <h3 class="profile-username text-center">{{ $pegawai->nama }}</h3>
                                <p class="text-muted text-center">{{ $pegawai->nik }}</p>
                                <ul class="list-group list-group-unbordered">
                                    <li class="list-group-item">
                                        <b>Tanggal Lahir</b> <span class="float-right">{{ $pegawai->tgl_lahir }}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Nomor Telpon</b> <span class="float-right">-</span>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Jenis Kelamin</b> <span class="float-right">{{ $pegawai->jk }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card">
                            @if (Session::has('succsesInputKegiatan'))
                                <div class="ribbon-wrapper ribbon-lg">
                                    <div class="ribbon bg-success">
                                        Tersimpan
                                    </div>
                                </div>
                            @endif
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label>Jenis Kegiatan
                                                @error('id_kegiatan')
                                                    <span class="text-danger text-xs"> (Pilih jenis kegiatan)</span>
                                                @enderror
                                            </label>
                                            <select class="form-control" wire:model.lazy="id_kegiatan">
                                                <option>Pilih Jenis Kegiatan</option>
                                                @foreach ($getJenisKegiatan as $item)
                                                    <option value="{{ $item->id_kegiatan }}">{{ $item->nama_kegiatan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Tanggal
                                                @error('tanggal')
                                                    <span class="text-danger text-xs"> (Wajib diisi)</span>
                                                @enderror
                                            </label>
                                            <input type="date" class="form-control form-control-sideba"
                                                wire:model.lazy="tanggal">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Judul
                                                @error('judul')
                                                    <span class="text-danger text-xs"> (Wajib diisi)</span>
                                                @enderror
                                            </label>
                                            <input type="text" class="form-control" placeholder="Enter ..."
                                                wire:model.lazy="judul">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Deskripsi
                                                @error('deskripsi')
                                                    <span class="text-danger text-xs"> (Wajib diisi)</span>
                                                @enderror
                                            </label>
                                            <textarea class="form-control" rows="3" placeholder="Enter ..." wire:model.lazy="deskripsi"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    wire:model.lazy="mandiri">
                                                <label>Mandiri</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    wire:model.lazy="supervisi">
                                                <label>Dibawah Supervisi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary"
                                                wire:click="simpanKegiatan('{{ $pegawai->nik }}')"><i
                                                    class="icon fas fa-save"></i> Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    <div class="card">
        @if (Session::has('succsesDeleteKegiatan'))
            <div class="ribbon-wrapper ribbon-lg" style="z-index: 100">
                <div class="ribbon bg-danger">
                    Terhapus
                </div>
            </div>
        @endif
        @if (Session::has('succsesEditKegiatan'))
            <div class="ribbon-wrapper ribbon-lg" style="z-index: 100">
                <div class="ribbon bg-warning">
                    Sukses
                </div>
            </div>
        @endif
        <div class="card-header">
            <form wire:submit.prevent="getListKegiatan">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="input-group">
                            <input class="form-control form-control-sidebar form-control-sm" type="text"
                                aria-label="Search" placeholder="Cari Kode Kegiatan / Nama Kegiatan"
                                wire:model.lazy="cariKodeListKegiatan">
                        </div>
                    </div>
                    <div class="col-lg-2 order-lg-last">
                        <input type="date" class="form-control form-control-sidebar form-control-sm"
                            wire:model.lazy="tanggal1">
                    </div>
                    <div class="col-lg-2 order-lg-last">
                        <div class="input-group">
                            <input type="date" class="form-control form-control-sidebar form-control-sm"
                                wire:model.lazy="tanggal2">
                            <div class="input-group-append">
                                <button class="btn btn-sidebar btn-default btn-sm" wire:click="render()">
                                    <i class="fas fa-search fa-fw"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body table-responsive p-0" style="height: 350px;"">
            <table class="table table-sm table-bordered table-hover table-head-fixed p-3 text-sm">
                <thead>
                    <tr>
                        <th class="text-center" width="3%">No.</th>
                        <th width="10%">Tanggal</th>
                        <th width="15%">Kegiatan</th>
                        <th width="15%">Judul</th>
                        <th width="30%">Deskripsi</th>
                        <th>Mandiri</th>
                        <th>Dibawah_Supervisi</th>
                        <th class="text-center">Act</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($getListKegiatan as $key => $item)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td>{{ date('Y-m-d', strtotime($item->tanggal)) }}</td>
                            <td>{{ $item->nama_kegiatan }}</td>
                            <td>{{ $item->judul }}</td>
                            <td>
                                @if (strlen($item->deskripsi) > 50)
                                    {{ substr($item->deskripsi, 0, 50) }}<b>.....</b>
                                @else
                                    {{ $item->deskripsi }}
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($item->mandiri == 1)
                                    <i class="fas fa-check"></i>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($item->supervisi == 1)
                                    <i class="fas fa-check"></i>
                                @endif
                            </td>
                            <td>
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
                                                <h5 class="modal-title">Edit Kegiatan Perawat</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-8">
                                                        <div class="form-group">
                                                            <label>Jenis Kegiatan
                                                            </label>
                                                            <select class="form-control"
                                                                wire:model.defer="getListKegiatan.{{ $key }}.id_kegiatan">
                                                                @foreach ($getJenisKegiatan as $data)
                                                                    <option value="{{ $data->id_kegiatan }}"
                                                                        @if ($data->id_kegiatan == $select) selected @endif>
                                                                        {{ $data->nama_kegiatan }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Tanggal
                                                            </label>
                                                            <input type="date"
                                                                class="form-control form-control-sideba"
                                                                wire:model.defer="getListKegiatan.{{ $key }}.tanggal">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Judul
                                                            </label>
                                                            <input type="text" class="form-control"
                                                                placeholder="Enter ..."
                                                                wire:model.defer="getListKegiatan.{{ $key }}.judul">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Deskripsi
                                                            </label>
                                                            <textarea class="form-control" rows="3" placeholder="Enter ..."
                                                                wire:model.defer="getListKegiatan.{{ $key }}.deskripsi"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input"
                                                                    wire:model.defer ="edit_mandiri.{{ $key }}">
                                                                <label>Mandiri</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input"
                                                                    wire:model.defer ="edit_dibawahsupervisi.{{ $key }}">
                                                                <label>Dibawah Supervisi</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-primary"
                                                    wire:click="editListKegiatan('{{ $key }}', '{{ $item->id_kegiatan_keperawatanlain }}')"
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
                                                <h6>Anda yakin ingin menghapus kegiatan {{ $item->judul }} ?</h6>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-danger"
                                                    wire:click="hapusListKegiatan('{{ $key }}', '{{ $item->id_kegiatan_keperawatanlain }}')"
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
        </div>
    </div>
</div>
