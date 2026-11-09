@extends('layout.utama')

@section('judul', 'Dashboard - Spotrasa')

@section('isi')
<div class="container page">
    <h1 class="page-title">Dashboard</h1>

    {{-- Ringkasan angka (khusus admin) --}}
        @if($ringkasan)
        <div class="row g-3 mb-4">
            <div class="col-6 col-lg-3"><div class="stat"><span class="stat-ikon"><i class="bi bi-cup-hot"></i></span><div class="stat-value">{{ $ringkasan['menu'] }}</div><div class="stat-label">Menu</div></div></div>
            <div class="col-6 col-lg-3"><div class="stat"><span class="stat-ikon"><i class="bi bi-chat-heart"></i></span><div class="stat-value">{{ $ringkasan['review'] }}</div><div class="stat-label">Total review</div></div></div>
            <div class="col-6 col-lg-3"><div class="stat"><span class="stat-ikon"><i class="bi bi-calendar-check"></i></span><div class="stat-value">{{ $ringkasan['bulan_ini'] }}</div><div class="stat-label">Review bulan ini</div></div></div>
            <div class="col-6 col-lg-3"><div class="stat"><span class="stat-ikon"><i class="bi bi-people"></i></span><div class="stat-value">{{ $ringkasan['pelanggan'] }}</div><div class="stat-label">Pelanggan terdaftar</div></div></div>
        </div>
    @endif

    @if($totalReview === 0)
        <div class="panel text-center">
            <p class="mb-1"><strong>Belum ada data review.</strong></p>
            <p class="mb-0 text-secondary">Grafik akan muncul setelah ada review yang disetujui.</p>
        </div>
    @else
        <div class="row g-4 mb-4">
            <div class="col-lg-7">
                <div class="panel">
                    <h2 class="section-title">Rata-rata rating per menu</h2>
                    <div class="chart-box"><canvas id="grafikMenu" aria-label="Grafik rata-rata rating menu tertinggi" role="img"></canvas></div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="panel h-100">
                    <h2 class="section-title">Menu terfavorit</h2>
                    <ol class="mb-0 ps-3">
                        @foreach($menuTerfavorit as $menu)
                            <li class="mb-2">
                        @if($ringkasan)
                            <strong>{{ $menu->nama_menu }}</strong><br>
                        @else
                            <a href="{{ route('menu.detail', $menu) }}">{{ $menu->nama_menu }}</a><br>
                        @endif
                                <span class="text-secondary small">
                                    {{ number_format($menu->rata_rata, 1) }} dari 5, {{ $menu->jumlah }} review
                                </span>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="panel">
                    <h2 class="section-title">Sebaran rating</h2>
                    <div class="chart-box"><canvas id="grafikSebaran" aria-label="Grafik jumlah review per bintang" role="img"></canvas></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="panel">
                    <h2 class="section-title">Review per bulan</h2>
                    <div class="chart-box"><canvas id="grafikBulan" aria-label="Grafik jumlah review 6 bulan terakhir" role="img"></canvas></div>
                </div>
            </div>
        </div>

        @push('skrip')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
        <script>
            Chart.defaults.font.family = "'Figtree', sans-serif";
            Chart.defaults.maintainAspectRatio = false;

            const warnaUtama = '#ea94ab';
            const warnaMerah = '#b84a68';

            // Grafik batang: rata-rata rating per menu
            new Chart(document.getElementById('grafikMenu'), {
                type: 'bar',
                data: {
                    labels: @json($labelMenu),
                    datasets: [{ label: 'Rata-rata rating', data: @json($dataMenu), backgroundColor: warnaUtama, borderRadius: 4 }]
                },
                options: {
                    indexAxis: 'y',
                    plugins: { legend: { display: false } },
                    scales: { x: { min: 0, max: 5, ticks: { stepSize: 1 } } }
                }
            });

            // Grafik batang: sebaran rating bintang 1 sampai 5
            new Chart(document.getElementById('grafikSebaran'), {
                type: 'bar',
                data: {
                    labels: ['1 bintang', '2 bintang', '3 bintang', '4 bintang', '5 bintang'],
                    datasets: [{ label: 'Jumlah review', data: @json($sebaranRating), backgroundColor: warnaMerah, borderRadius: 4 }]
                },
                options: {
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
                }
            });

            // Grafik garis: jumlah review per bulan
            new Chart(document.getElementById('grafikBulan'), {
                type: 'line',
                data: {
                    labels: @json($labelBulan),
                    datasets: [{ label: 'Jumlah review', data: @json($dataBulan), borderColor: warnaUtama, backgroundColor: warnaUtama, tension: .3 }]
                },
                options: {
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
                }
            });
        </script>
        @endpush
    @endif
</div>
@endsection