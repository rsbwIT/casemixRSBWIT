<div>
    <div id="accordion">
        <div class="card-header bg-primary">
            <h4 class="card-title w-100">
                <a class="d-block w-100 text-white" data-toggle="collapse" href="#collapseThree">
                    <i class="fas fa-plus"></i> Setting Pendaftaran
                </a>
            </h4>
        </div>
        <div class="card-body">
            <div id="collapseThree" class="collapse show" data-parent="#accordion">
                @if (Session::has('message'))
                    <div class="alert alert-{{ Session::get('color') }} alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fas fa-{{ Session::get('icon') }}"></i> {{ Session::get('message') }}!
                    </div>
                @endif
                <form wire:submit.prevent="addPendaftaran">
                    <div class="row mb-2">
                        <div class="col-3">
                            <input type="text" class="form-control" placeholder="Kode Pendaftaran"
                                wire:model.lazy="KdPendaftaran">
                            @error('KdPendaftaran')
                                <span class="text-danger text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-3">
                            <input type="text" class="form-control" placeholder="Nama Pendaftaran"
                                wire:model.lazy="NamaPendaftaran">
                            @error('NamaPendaftaran')
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
                            <th>Kode Pendaftaran</th>
                            <th>Nama Pendaftaran</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Pendaftaran as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->kd_pendaftaran }}</td>
                                <td>{{ $item->nama_pendaftaran }}</td>
                                <td class="text-center">
                                    <div class="badge-group">
                                        <a class="mx-2" data-toggle="modal"
                                            data-target="#updateModal{{ $item->kd_pendaftaran }}" href=""><i
                                                class="fas fa-edit"></i></a>
                                        <a class="mx-2 text-danger" href=""
                                            wire:click.prevent="deltePendaftaran('{{ $item->kd_pendaftaran }}')"><i
                                                class="fas fa-trash"></i></a>
                                    </div>
                                    <div class="modal fade" id="updateModal{{ $item->kd_pendaftaran }}" tabindex="-1"
                                        role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="updateModalLabel{{ $key }}">
                                                        Edit Pendaftaran
                                                    </h5>
                                                    <button type="button" class="close"
                                                        data-dismiss="modal"aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                            wire:model.defer="Pendaftaran.{{ $key }}.kd_pendaftaran">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                            wire:model.defer="Pendaftaran.{{ $key }}.nama_pendaftaran">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary"
                                                            wire:click.prevent="editPendaftaran('{{ $key }}', '{{ $item->kd_pendaftaran }}')"
                                                            data-dismiss="modal">Ubah</button>
                                                    </div>
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
