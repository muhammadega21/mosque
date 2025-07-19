<x-layouts.main :title="$title" :mainPage="$main_page" :page="$page">
    @if (Session::has('toastSuccess'))
        <script>
            toastr.success("{{ Session::get('toastSuccess') }}");
        </script>
    @endif
    <!-- Left side columns -->
    <div class="col-lg-8">
        <div class="row">
            <!-- Users Card -->
            <div class="col-xxl-4 col-xl-6">
                <div class="card info-card users-card">
                    <div class="card-body">
                        <h5 class="card-title">Users <span>| Total</span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $total_user }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Users Card -->

            <!-- Mosque Funds Card -->
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card donation-card">
                    <div class="card-body">
                        <h5 class="card-title">Kas Masjid <span>| Total</span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                            <div class="ps-3">
                                <h6>Rp {{ number_format($uang_masjid, 0, ',', '.') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Mosque Funds Card -->

            <!-- Reports -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Laporan <span>/Bulanan</span></h5>

                        <!-- Line Chart -->
                        <div id="reportsChart"></div>

                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new ApexCharts(document.querySelector("#reportsChart"), {
                                    series: [{
                                        name: 'Kas Masuk',
                                        data: {{ $uang_masuk }},
                                    }, {
                                        name: 'Kas Keluar',
                                        data: {{ $uang_keluar }}
                                    }],
                                    chart: {
                                        height: 350,
                                        type: 'line',
                                        toolbar: {
                                            show: false
                                        },
                                    },
                                    markers: {
                                        size: 5
                                    },
                                    colors: ['#33FF57', '#f02233'],
                                    fill: {
                                        type: "solid",
                                    },
                                    dataLabels: {
                                        enabled: false
                                    },
                                    stroke: {
                                        curve: 'straight',
                                        width: 3
                                    },
                                    xaxis: {
                                        categories: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus",
                                            "September", "Oktober", "November", "Desember",
                                        ]
                                    },
                                    tooltip: {
                                        x: {
                                            format: 'MM/yyyy'
                                        },
                                        y: {
                                            formatter: function(val) {
                                                return 'Rp ' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                            }
                                        }
                                    }
                                }).render();
                            });
                        </script>
                        <!-- End Line Chart -->
                    </div>
                </div>
            </div><!-- End Reports -->

        </div>
    </div><!-- End Left side columns -->

    <!-- Right side columns -->
    <div class="col-lg-4">
        <!-- Recent Activity -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Riwayat Kas</h5>

                <div class="activity">
                    @foreach ($riwayat_donasi as $item)
                        <div class="activity-item d-flex">
                            <div class="activite-label">{{ $item->created_at->diffForHumans() }}</div>
                            <i class='bi bi-circle-fill activity-badge align-self-start'
                                style="color: {{ $item->jenis_kas == 'kas masuk' ? '#33FF57' : '#f02233' }}"></i>
                            <div class="activity-content d-flex flex-column">
                                <span>
                                    @if ($item->jenis_kas == 'kas masuk')
                                        <strong>{{ $item->donasi->nama_donatur }}</strong> Memberi Donasi sebesar
                                    @else
                                        <strong>Pengurus</strong> Menggunakan Kas sebesar
                                    @endif
                                </span>
                                <span class="text-muted small">Rp
                                    {{ number_format($item->jumlah, 0, ',', '.') }}</span>
                                <span class="text-muted small">{{ $item->keterangan }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div><!-- End Recent Activity -->
    </div><!-- End Right side columns -->
</x-layouts.main>
