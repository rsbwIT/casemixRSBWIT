<div>
    <div id="loket">
        <div class="card-header bg-primary">
            <h4 class="card-title w-100">
                <a class="d-block w-100 text-white" data-toggle="collapse" href="#collapseLoket">
                    <i class="fas fa-plus"></i> Setting Loket
                </a>
            </h4>
        </div>
        <div class="card-body">
            <div id="collapseLoket" class="collapse show" data-parent="#loket">
                @if (Session::has('message'))
                    <div class="alert alert-{{ Session::get('color') }} alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fas fa-{{ Session::get('icon') }}"></i> {{ Session::get('message') }}!
                    </div>
                @endif
                <form wire:submit.prevent="addLoket">
                    <div class="row mb-2">
                        <div class="col-3">
                            <input type="text" class="form-control" placeholder="Kode Loket" wire:model.lazy="kdLoket">
                            @error('kdLoket')
                                <span class="text-danger text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-3">
                            <input type="text" class="form-control" placeholder="Nama Loket" wire:model.lazy="NmLoket">
                            @error('NmLoket')
                                <span class="text-danger text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-3">
                            <select class="form-control" wire:model.lazy="kdPendaftaran" placeholder="Lokasi">
                                <option>Pilih Lokasi Pendaftaran</option>
                                @foreach ($Pendaftaran as $item)
                                    <option value="{{ $item->kd_pendaftaran }}">{{ $item->nama_pendaftaran }}</option>
                                @endforeach
                            </select>
                            @error('kdPendaftaran')
                                <span class="text-danger text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-3">
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </div>
                </form>

                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kd Loket</th>
                            <th>Loket</th>
                            <th>Tempat</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Loket as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->kd_loket }}</td>
                                <td>{{ $item->nama_loket }}</td>
                                <td>{{ $item->nama_pendaftaran }}</td>
                                <td class="text-center">
                                    <div class="badge-group">
                                        <a class="mx-2" data-toggle="modal"
                                            data-target="#updateLoket{{ str_replace(' ', '', $item->kd_loket) }}"
                                            href=""><i class="fas fa-edit"></i></a>
                                            <a class="mx-2 text-danger" href=""
                                            wire:click.prevent="delteLoket('{{ $item->kd_loket }}')"><i
                                                class="fas fa-trash"></i></a>
                                    </div>
                                    <div class="modal fade" id="updateLoket{{ str_replace(' ', '', $item->kd_loket) }}"
                                        tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="updateLoket{{ $key }}">
                                                        Edit {{ $item->kd_loket }}
                                                    </h5>
                                                    <button type="button" class="close"
                                                        data-dismiss="modal"aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                            wire:model.defer="Loket.{{ $key }}.nama_loket">
                                                    </div>
                                                    <div class="form-group">
                                                        <select class="form-control"
                                                            wire:model.defer="Loket.{{ $key }}.kd_pendaftaran"
                                                            placeholder="Lokasi">
                                                            @foreach ($Pendaftaran as $data)
                                                                <option value="{{ $data->kd_pendaftaran }}">
                                                                    {{ $data->nama_pendaftaran }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary"
                                                        wire:click.prevent="editLoket('{{ $key }}', '{{ $item->kd_loket }}')"
                                                        data-dismiss="modal">Ubah</button>
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
</div>
