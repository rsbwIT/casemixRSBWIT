<div class="container-fluid mt-4">
    <div class="row justify-content-center" wire:poll.1000ms>
        <!-- Kolom Kiri: Antrian Utama & Daftar Antrian Berikutnya -->
        <div class="col-md-6 d-flex flex-column align-items-center">
            <div class="d-flex justify-content-center" style="width: 100%; height: 260px;">
                @foreach ($getLoket as $item)
                <div class="card mx-2 shadow-lg border border-3 border-dark"
                    style="width: 48%; height: 260px;">
           
                    <!-- Header Hijau Full Width -->
                    <div class="card-header bg-success text-center p-2">
                        <h6 class="my-0 text-white font-weight-bold" style="font-size: 20px;">
                            {{ $item->nama_loket_farmasi }}
                        </h6>
                    </div>
                    
                    <table class="table text-center font-weight-bold mb-0">
                        @if ($item->getAntrianObat->isEmpty())
                            <tr>
                                <td colspan="3" style="height: 200px; vertical-align: middle;">
                                    <h6 class="font-weight-bold text-center" style="font-size: 30px;">TIDAK ADA ANTRIAN</h6>
                                </td>                                
                            </tr>
                        @else
                            @php
                                $firstAntrian = $item->getAntrianObat->first();
                            @endphp

                            <thead>
                                <tr>
                                    <th class="display-3 text-bold">{{ $firstAntrian->nomor_antrian }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <h6 class="font-weight-bold">{{ $firstAntrian->nama_pasien }}</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6>Jam Masuk: {{ date('H:i', strtotime($firstAntrian->created_at)) }}</h6>
                                    </td>
                                </tr>
                            </tbody>
                        @endif
                    </table>
                </div>
                @endforeach
            </div>

            <!-- Daftar Antrian Berikutnya (Di Bawah Card Antrian) -->
            <div class="w-100 mt-3">
                <div class="card shadow-lg border border-3 border-dark">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="mb-0">DAFTAR ANTRIAN BERIKUTNYA</h5>
                    </div>
                    <div class="card-body p-2">
                        <table class="table table-sm table-bordered text-center">
                            <thead class="bg-light">
                                <tr>
                                    <th>Nomor Antrian</th>
                                    <th>Nama Pasien</th>
                                    <th>Jam Masuk</th>
                                    <th>Loket</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $adaAntrianBerikutnya = false;
                                @endphp
                                @foreach ($getLoket as $item)
                                    @foreach ($item->getAntrianObat->skip(1) as $next) <!-- Skip yang pertama -->
                                        @if ($next->status == null) <!-- Hanya tampilkan jika status kosong -->
                                            @php
                                                $adaAntrianBerikutnya = true;
                                            @endphp
                                            <tr>
                                                <td class="font-weight-bold">{{ $next->nomor_antrian }}</td>
                                                <td>{{ $next->nama_pasien }}</td>
                                                <td>{{ date('H:i', strtotime($next->created_at)) }}</td>
                                                <td>{{ $item->nama_loket_farmasi }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach

                                @if (!$adaAntrianBerikutnya)
                                    <tr>
                                        <td colspan="4" class="text-center">TIDAK ADA ANTRIAN BERIKUTNYA</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

     <!-- Kolom Kanan: Video YouTube -->
     <div class="card-body text-center p-1">
        <div class="ratio ratio-16x9 shadow-lg">
            <iframe width="100%" height="400"
                src="https://www.youtube.com/embed/2-Z68yYaYKE?autoplay=1&mute=1"
                title="YouTube video player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
            </iframe>
        </div>
    </div>
</div>




@push('scripts')
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    const urlParams = new URLSearchParams(window.location.search);
    const kdRuangPoli = urlParams.get('kd_display_farmasi');
    const pusherKey = @json($pusher_key);
    
    var pusher = new Pusher(pusherKey, {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('messages-antrian-obat'); // Perbaiki nama channel
    channel.bind('message', function(data) {
        function numberToText(number) {
            const ones = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan"];
            const teens = ["sepuluh", "sebelas", "dua belas", "tiga belas", "empat belas", "lima belas",
                "enam belas", "tujuh belas", "delapan belas", "sembilan belas"
            ];
            const tens = ["", "puluh", "dua puluh", "tiga puluh", "empat puluh", "lima puluh", "enam puluh",
                "tujuh puluh", "delapan puluh", "sembilan puluh"
            ];
            const hundreds = ["", "seratus", "dua ratus", "tiga ratus", "empat ratus", "lima ratus",
                "enam ratus", "tujuh ratus", "delapan ratus", "sembilan ratus"
            ];

            number = parseInt(number);
            if (number < 10) return ones[number];
            if (number < 20) return teens[number - 10];
            if (number < 100) return tens[Math.floor(number / 10)] + (number % 10 ? " " + ones[number % 10] : "");
            return hundreds[Math.floor(number / 100)] + (number % 100 ? " " + numberToText(number % 100) : "");
        }

        function speakText(data) {
            if ('speechSynthesis' in window) {
                var speech = new SpeechSynthesisUtterance(data);
                speech.lang = 'id-ID';
                speech.pitch = 1;
                speech.rate = 1.1;
                speech.volume = 1;
                window.speechSynthesis.speak(speech);
            } else {
                alert("Browser Anda tidak mendukung teks ke suara.");
            }
        }

        speakText('Antrian ' + numberToText(data['message']['nomor_antrian']));
        speakText('Atas nama ' + data['message']['nama_pasien']);
        speakText('Silakan ke ' + data['message']['kd_loket_farmasi']);
    });

    
</script>
@endpush