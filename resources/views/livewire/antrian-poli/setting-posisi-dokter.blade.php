<div>
    <div id="dokter">
        <div class="card-header bg-primary">
            <h4 class="card-title w-100">
                <a class="d-block w-100 text-white" data-toggle="collapse" href="#collapseDokter">
                    <i class="fas fa-plus"></i> Setting Posisi Dokter
                </a>
            </h4>
        </div>
        <div class="card-body">
            <div id="collapseDokter" class="collapse show" data-parent="#dokter">
                @if (Session::has('message'))
                    <div class="alert alert-{{ Session::get('color') }} alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fas fa-{{ Session::get('icon') }}"></i> {{ Session::get('message') }}!
                    </div>
                @endif
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kd Dokter</th>
                            <th>Nama</th>
                            <th class="text-center">Lokasi Dokter</th>
                            <th>Act</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($getListDokter as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->kd_dokter }}</td>
                                <td>{{ $item->nm_dokter }}</td>
                                <td>
                                    <div class="form-group">
                                        @php
                                            $retVal = $item->nama_ruang_poli === null ? 'is-warning' : '';
                                        @endphp

                                        <select class="form-control form-control-sm {{ $retVal }}"
                                            wire:model.defer="getListDokter.{{ $key }}.kd_ruang_poli"
                                            placeholder="Lokasi">
                                            <option>Belum di setting</option>
                                            @foreach ($getPoli as $data)
                                                <option value="{{ $data->kd_ruang_poli }}">
                                                    {{ $data->nama_ruang_poli }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-primary"
                                        wire:click.prevent="editPoliDokter('{{ $key }}', '{{ $item->kd_dokter }}', '{{ $item->nm_dokter }}')"
                                        data-dismiss="modal">Ubah</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
