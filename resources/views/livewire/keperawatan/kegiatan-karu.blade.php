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
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <form wire:submit.prevent="carinamaKegiatan()">
                                            <div class="input-group">
                                                <input class="form-control form-control-sidebar form-control-sm"
                                                    type="text" wire:model.lazy="cari_kode_kegiatan"
                                                    aria-label="Search"
                                                    placeholder="Cari Kode Kegiatan / Nama Kegiatan">
                                                <div class="input-group-append">
                                                    <button class="btn btn-sidebar btn-default btn-sm">
                                                        <i class="fas fa-search fa-fw" wire:loading.remove
                                                            wire:target='carinamaKegiatan'></i>
                                                        <span class="spinner-grow spinner-grow-sm" role="status"
                                                            aria-hidden="true" wire:loading
                                                            wire:target='carinamaKegiatan'></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-sm-4">
                                    </div>
                                    <div class="col-sm-2">
                                    </div>
                                    {{-- tanggal --}}
                                    <div class="col-lg-2 order-lg-last">
                                        <div class="card-tools">
                                            <input type="date"
                                                class="form-control form-control-sidebar form-control-sm"
                                                wire:model="tanggal" value="{{ now()->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body table-responsive p-0" style="height: 350px;">
                                @if (!$getKegiatan->isEmpty())
                                    <table class="table table-sm table-bordered table-head-fixed p-3">
                                        <thead>
                                            <tr>
                                                <th>Kd.Kegiatan</th>
                                                <th width="50%">Nama Kegiatan</th>
                                                <th>Kategori</th>
                                                <th class="text-center">Mandiri</th>
                                                <th class="text-center">Dibawah_Supervisi</th>
                                                <th class="text-center">Act</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($getKegiatan as $key => $data)
                                                <tr>
                                                    <td>{{ $data->kd_kegiatan }}</td>
                                                    <td class="text-sm">{{ $data->nama_kegiatan }}</td>
                                                    <td class="text-sm">{{ $data->kd_jns_kegiatan_karu }}</td>
                                                    <td class="text-center">
                                                        <input type="checkbox"
                                                            wire:model.defer ="mandiri.{{ $key }}">
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="checkbox"
                                                            wire:model.defer ="dibawahsupervisi.{{ $key }}">
                                                    </td>
                                                    <td class="text-center">
                                                        @php
                                                            $user = session()->has('auth')
                                                                ? session('auth')['id_user']
                                                                : '';
                                                        @endphp
                                                        @if (Session::has('sucsess' . $key))
                                                            <span class="text-success"><i class="fas fa-check"></i>
                                                            </span>
                                                        @else
                                                            <button class="btn btn-xs btn-primary"
                                                                wire:click="simpanKegiatan('{{ $key }}', '{{ $data->kd_kegiatan }}', '{{ $user }}')">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <h6 class="text-center mt-3">Silahkan Cari Data Pada Jenis Log Book !!!
                                    </h6>
                                @endif
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
        <div class="card-header">
            <form wire:submit.prevent="getListKegiatan">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="input-group">
                            <input class="form-control form-control-sidebar form-control-sm" type="text"
                                aria-label="Search" placeholder="Cari Kode Kegiatan / Nama Kegiatan"
                                wire:model.defer="cariKodeListKegiatan">
                        </div>
                    </div>
                    <div class="col-lg-2 order-lg-last">
                        <input type="date" class="form-control form-control-sidebar form-control-sm"
                            wire:model.defer="tanggal1">
                    </div>
                    <div class="col-lg-2 order-lg-last">
                        <div class="input-group">
                            <input type="date" class="form-control form-control-sidebar form-control-sm"
                                wire:model.defer="tanggal2">
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
                        <th width="60%">Kegiatan</th>
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
                                    <a data-toggle="modal" data-target="#deleteModal{{ $key }}"
                                        class="text-danger mx-2" href="#"><i class="fas fa-trash"></i></a>
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
                                                <h6>Anda yakin ingin menghapus kegiatan : {{ $item->nama_kegiatan }}?</h6>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-danger"
                                                    wire:click="hapusListKegiatan('{{ $key }}', '{{ $item->id_logbook }}')"
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
