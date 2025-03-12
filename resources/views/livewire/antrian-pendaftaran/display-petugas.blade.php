<div>
    <div class="card mb-4 box-shadow">
        <div class="card-header text-center">
            <h2 class="my-0 font-weight-bold">Petugas {{ $kdLoket }}</h2>
        </div>
        <table class="table" wire:poll.10000ms>
            <thead>
                <tr>
                    <th scope="col">NAMA</th>
                    <th scope="col">NO RM</th>
                    <th scope="col">NO REG</th>
                    <th scope="col">Dokter</th>
                    <th scope="col">kd dokter</th>
                    <th scope="col" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($getPasien as $item)
                    @php
                        $bg = $item->status === '0' ? '#30E3DF' : ($item->status === '1' ? '#F97B22' : '');
                    @endphp
                    <tr style="background-color: {{ $bg }}">
                        <td>{{ $item->nm_pasien }}</td>
                        <td>{{ $item->no_rkm_medis }}</td>
                        <td>{{ $item->no_reg }}</td>
                        <td>{{ $item->nama_dokter }}</td>
                        <td>{{ $item->kd_dokter }}</td>
                        <td class="text-center d-flex justify-content-center">
                            <audio id="{{ $item->no_reg }}" src="/sound/noreg/{{ $item->no_reg }}.mp3"></audio>
                            <audio id="{{ $item->kd_dokter }}"src="/sound/dokter/{{ $item->kd_dokter }}.mp3"></audio>
                            <audio id="{{ $kdLoket }}" src="/sound/loket/{{ $kdLoket }}.mp3"></audio>
                            <button
                                onclick="playSequentialSounds(['{{ $item->no_reg }}','{{ $item->kd_dokter }}','{{ $kdLoket }}'])"
                                class="btn btn-sm btn-primary" role="button" aria-disabled="true"><i class="fas fa-bullhorn"></i> Panggil
                            </button>
                            <button wire:click="handleLog('{{ $item->kd_dokter }}', '{{ $item->no_rawat }}', '{{ $kdLoket }}', 'ada')"
                                class="btn btn-sm btn-success ml-2" aria-disabled="true"><i class="fas fa-check"></i> Ada</button>
                            <button wire:click="handleLog('{{ $item->kd_dokter }}', '{{ $item->no_rawat }}', '{{ $kdLoket }}', 'tidakada')"
                                class="btn btn-sm btn-danger mx-2" aria-disabled="true"><i class="fas fa-ban"></i> Tidak Ada</button>
                            <button wire:click="resetLog('{{ $item->no_rawat }}')"
                                class="btn btn-sm btn-default" aria-disabled="true"><i class="fas fa-undo"></i> Ulang</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
