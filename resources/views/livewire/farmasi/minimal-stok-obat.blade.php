<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah List Stok Minimal Obat</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <form wire:submit.prevent="submitForm">
                        <div class="input-group">
                            <input class="form-control form-control-sidebar" type="text"
                                placeholder="Cari Nama Obat di Databarang" wire:model.lazy="kode_barang"
                                aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-sidebar btn-primary">
                                    <i class="fas fa-search fa-fw" wire:loading.remove wire:target='submitForm'></i>
                                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"
                                        wire:loading wire:target='submitForm'></span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    @if (!$dataBarang->isEmpty())
                        <table class="table table-valign-middle table-sm text-center">
                            <thead>
                                <tr>
                                    <th>Kd Barang</th>
                                    <th>Nm Barang</th>
                                    <th>Bangsal</th>
                                    <th>Stok Minimal</th>
                                    <th>Act</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataBarang as $key => $item)
                                    <tr>
                                        <td>{{ $item->kode_brng }}</td>
                                        <td>{{ $item->nama_brng }}</td>
                                        <td><b>{{ $item->kd_bangsal }}</b></td>
                                        <td width="10%">
                                            <input class="form-control" type="text"
                                                wire:model.lazy="add_stok_minimal.{{ $key }}"
                                                aria-label="Search" required>
                                            @error('add_stok_minimal.' . $key)
                                                <span class="text-danger">Wajib di isi</span>
                                            @enderror
                                        </td>
                                        <td width="15%">
                                            @if (Session::has('ready' . $key))
                                                <span class="text-danger">Data Sudah Ada !!!</span>
                                            @elseif (Session::has('sucsess' . $key))
                                                <span class="text-success"><i class="fas fa-check"></i> Berhasil</span>
                                            @else
                                                <button class="btn btn-xs btn-primary"
                                                    wire:click="tambahListObat('{{ $key }}','{{ $item->kode_brng }}','{{ $item->kd_bangsal }}')">
                                                    <i class="fas fa-save"></i>
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
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">List Stok Minimal Obat <b>{{$bangsal === 'DepRI' ? 'Depo Rawat Inap' : 'Depo Rawat Jalan' }}</b></h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                </button>
            </div>
        </div>
        <div class="card-body">
            <section class="content ">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group input-group-xs">
                                <select class="form-control" name="bangsal" id="" wire:model="bangsal"
                                    wire:loading.remove wire:target='bangsal'>
                                    <option value="DepRI">Depo Rawat Inap</option>
                                    <option value="DepRJ">Depo Rawat Jalan</option>
                                </select>
                                <span wire:loading wire:target='bangsal'>
                                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                    Mencari...
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            @if (Session::has('sucsessDelete'))
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fas fa-check"></i> {{ Session::get('sucsessDelete') }}!
                    </div>
                @endif
            <table class="table table-sm table-hover table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">No</th>
                        <th>Kd Barang</th>
                        <th>Nama Barang</th>
                        <th>Stok Tersedia</th>
                        <th contenteditable="true">Stok Minimal</th>
                        <th>Satuan</th>
                        <th>Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        try {
                            $listObat = $getListObat->sortByDesc(function ($item) {
                                return $item->stok < $item->stok_minimal_medis;
                            });
                            $counter = 1;
                        } catch (\Exception $e) {
                            $listObat = [];
                            $counter = 1;
                            $errorMessage = $e->getMessage();
                        }
                    @endphp
                    @foreach ($listObat as $key => $item)
                        @php
                            $color_tr = $item->stok < $item->stok_minimal_medis ? 'bg-danger' : '';
                        @endphp
                        <tr>
                            <td class="{{ $color_tr }}">{{ $counter++ }}</td>
                            <td>{{ $item->kode_brng }}</td>
                            <td>{{ $item->nama_brng }}</td>
                            <td>{{ $item->stok }}</td>
                            <td>
                                {{ $item->stok_minimal_medis }}
                                <div class="badge-group-sm float-right">
                                    <a data-toggle="modal" data-target="#updateModal{{ $item->kode_brng }}"
                                        class="text-xs" href="#"><i class="fas fa-edit"></i></a>
                                </div>
                                <div class="modal fade" id="updateModal{{ $item->kode_brng }}" tabindex="-1"
                                    role="dialog" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="updateModalLabel{{ $key }}">Edit
                                                    Stok Minimal Barang <b>{{ $item->kode_brng }}</b></h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <input wire:model.defer="stok_minimal_medis" type="number"
                                                    class="form-control" required>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary"
                                                    wire:click="update('{{ $item->kode_brng }}')"
                                                    data-dismiss="modal">Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $item->satuan }}</td>
                            <td class="text-center ">
                                <button class="badge badge-xs badge-danger text-xs"
                                    wire:click="deleteListObat('{{ $item->kode_brng }}', '{{ $item->kd_bangsal }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @if ($confirmingEdit)
        <div class="modal fade show"  tabindex="-100" role="dialog" style="padding-right: 17px; display: block;"
            aria-modal="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h5>Anda yakin ingin menghapus daftar obat dari list stok minimal medis?</h5>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="cancelDeleteObat()">Tidak
                                !</button>
                            <button type="button" class="btn btn-danger" wire:click="confirmDelteObat()">Ya !</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
