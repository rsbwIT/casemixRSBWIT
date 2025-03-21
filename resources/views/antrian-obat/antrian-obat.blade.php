@extends('..layout.layoutDashboard')
@section('title', 'Antrian Obat')

@section('konten')
    <div class="row">
        <div class="col-md-12 card">
            <table class="table">
                <thead>
                    <tr>
                        <th>Kd Display</th>
                        <th>Nama Display</th>
                        <th class="text-center">Display Loket</th>
                        <th class="text-center">Panggilan</th>
                        <th class="text-center">Download autorun</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($antrianObat as $item)
                        <tr>
                            <td>{{ $item->kd_display_farmasi }}</td>
                            <td>{{ $item->nama_display_farmasi }}</td>
                            <td class="text-center">
                                <form action="{{ url('display-farmasi') }}" method="">
                                    @csrf
                                    <input name="kd_display_farmasi" value="{{ $item->kd_display_farmasi }}" hidden>
                                    <button class="" style="background: none; border: none;">
                                        <i class="nav-icon fas fa-search"></i>
                                    </button>
                                </form>
                            </td>
                            <td class="text-center">
                                <div class="badge-group-sm">
                                    <a data-toggle="dropdown" href="#">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-xs dropdown-menu-right">
                                        @foreach ($item->getLoket as $data)
                                            <form action="{{ url('panggil-obat') }}" method="">
                                                <div class="dropdown-item">
                                                    @csrf
                                                    <input name="kd_display_farmasi" value="{{ $item->kd_display_farmasi }}" hidden>
                                                    <input name="kd_loket_farmasi" value="{{ $data->kd_loket_farmasi }}" hidden>
                                                    <button class="btn btn-block btn-flat btn-primary">
                                                        {{ $data->nama_loket_farmasi }}
                                                    </button>
                                                </div>
                                            </form>
                                        @endforeach
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <form action="{{ url('antrian-obat-download') }}" method="">
                                    @csrf
                                    <input name="kd_display_farmasi" value="{{ $item->kd_display_farmasi }}" hidden>
                                    <button class="" style="background: none; border: none;">
                                        <i class="nav-icon fas fa-download"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
