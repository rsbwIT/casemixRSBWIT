@extends('..layout.layoutDashboard')
@section('title', 'Laporan Keperawatan 2')
@section('konten')
    <div class="card">
        <div class="card-body">
            <form action="{{ url('/laporan-logbook-keperawatan2') }}">
                @csrf
                <div class="row">
                    <div class="col-2">
                        <div class="form-group">
                            <div class="input-group input-group-xs">
                                <button type="button"
                                    class="btn btn-default form-control form-control-xs d-flex justify-content-between"
                                    data-toggle="modal" data-target="#modal-lg2">
                                    <p>Pilih Petugas</p>
                                    <p><i class="nav-icon fas fa-user-nurse"></i></p>
                                </button>
                            </div>
                            <div class="modal fade" id="modal-lg2">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Pilih Petugas</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <select multiple="multiple" size="10" name="duallistbox2[]">
                                                @foreach ($petugas as $item)
                                                    <option value="{{ $item->nip }}">{{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="kdPetugas">
                                            <script>
                                                var demo1 = $('select[name="duallistbox2[]"]').bootstrapDualListbox();
                                                $('form').submit(function(e) {
                                                    e.preventDefault();
                                                    $('input[name="kdPetugas"]').val($('select[name="duallistbox2[]"]').val().join(','));
                                                    this.submit();
                                                });
                                            </script>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                                        </div>
                                    </div>
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
            @foreach ($getPetugas as $petugas)
                @if ($petugas->getKegiatan->isEmpty())
                @else
                    <table class="table table-bordered table-sm mt-4 text-sm table-hover" id="tableToCopy">
                        @if ($petugas->getKegiatan->isEmpty())
                        @else
                            <thead>
                                <tr>
                                    <th colspan="4" class="text-center">LogBook Kegiatan Keperawatan {{ $petugas->nama }} Pada Tanggal {{ $tanggl1 . ' - ' . $tanggl2 }}</th>
                                </tr>
                                <tr>
                                    <th width="5%">No. </th>
                                    <th width="50%">Kegiatan Keperawatan Dasar</th>
                                    <th width="20%">Terhadap</th>
                                    <th >Jumlah Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($petugas->getKegiatan as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->nama_kegiatan }}</td>
                                        <td>
                                            @foreach ($item->getPasien as $pasien)
                                                <p>{{$pasien->no_rkm_medis}}  {{$pasien->jumlah_id_logbook}} Kali</p>
                                            @endforeach
                                        </td>
                                        <td>{{ $item->jumlah_id_logbook }} Kali</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @endif
                    </table>
                @endif
            @endforeach
        </div>
    </div>
@endsection
