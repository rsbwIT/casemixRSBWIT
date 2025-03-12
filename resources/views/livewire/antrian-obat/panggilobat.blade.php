<div>
    <div class="card mb-4 box-shadow">
        <div class="card-header text-center">
            {{ $kd_display_farmasi }}
            <h2 class="my-0 font-weight-bold">Petugas Farmasi {{ $kd_loket_farmasi }}</h2>
            {{ count($getAntrianObat) }}
        </div>
        <table class="table table-sm table-bordered table-hover text-sm mb-3" style="white-space: nowrap;" wire:poll.10000ms>
            <thead>
                <tr>
                    <th scope="col">No.Antrian</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">No Rawat</th>
                    <th scope="col">Jenis Obat</th>
                    <th scope="col" class="text-center">#</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($getAntrianObat as $item)
                    @php
                        $bg = ($item->status === '1') ? '#30E3DF' : (($item->status === '2') ? '#F97B22' : 'transparent');
                    @endphp
                    <tr style="background-color: {{ $bg }}">
                        <td>{{ $item->nomor_antrian }}</td>
                        <td>{{ $item->nama_pasien }}</td>
                        <td>{{ $item->tanggal }}</td>
                        <td>{{ $item->no_rawat }}</td>
                        <td>
                            @if($item->racik_non_racik === 'A')
                                Non Racik
                            @elseif($item->racik_non_racik === 'B')
                                Racik
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-center d-flex justify-content-center">
                            <button wire:click="panggilAntrian('{{ $item->nomor_antrian }}')" 
                                class="btn btn-xs btn-primary"   onclick="playAnnouncement('{{ $item->nomor_antrian }}', '{{ $item->nama_pasien }}')">
                                <i class="fas fa-bullhorn"></i> Panggil
                            </button>                   
                            <button wire:click="handleLog('{{ $item->id }}', '{{ $item->nomor_antrian }}', '{{ $kd_loket_farmasi }}', 'ada')"
                                class="btn btn-xs btn-success ml-2"><i class="fas fa-check"></i> Ada</button>
                            <button wire:click="handleLog('{{ $item->id }}', '{{ $item->nomor_antrian }}', '{{ $kd_loket_farmasi }}', 'tidakada')"
                                class="btn btn-xs btn-danger mx-2"><i class="fas fa-ban"></i> Tidak Ada</button>
                            <button wire:click="resetLog('{{ $item->id }}')"
                                class="btn btn-xs btn-default"><i class="fas fa-undo"></i> Ulang</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Tambahkan Script -->
<script>
    function playAnnouncement(nomor, nama) {
        // Putar suara lonceng
        let audio = new Audio('/sound/loket/airportcall.mp3'); // Ganti dengan path file lonceng
        audio.play();

        // Tunggu sampai lonceng selesai (misalnya 2 detik) sebelum berbicara
        setTimeout(() => {
            let text = `Nomor antrian ${nomor}, atas nama ${nama}, silakan menuju loket farmasi.`;
            let utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'id-ID'; // Bahasa Indonesia
            utterance.rate = 0.9; // Kecepatan bicara
            speechSynthesis.speak(utterance);
        }, 3000); // Jeda 2 detik setelah lonceng
    }

</script>


