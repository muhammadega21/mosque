<x-layouts.main :title="$title" :mainPage="$main_page" :page="$page">
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mt-2">
                        <h5 class="card-title">Data Laporan Keuangan</h5>
                        <div class="d-flex align-items-center gap-2">
                            <x-search placeholder="Search..." />
                            <div class="btn-action">
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#addLaporanKeuangan">
                                    Export <span class="fw-semibold"><i class='bx bxs-file-pdf'></i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Periode</th>
                                    <th>Pengurus</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($laporanKeuangan) < 1)
                                    <tr>
                                        <td colspan="5" class="text-center">Data Kosong</td>
                                    </tr>
                                @else
                                    @foreach ($laporanKeuangan as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->tanggal }}</td>
                                            <td>{{ $item->laporan_periodik }}</td>
                                            <td>{{ $item->user->user_data->nama }}</td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('LaporanKeuangan.cetak', $item->id) }}"
                                                        class="badge border-warning border"><i
                                                            class='bx bxs-file-pdf text-warning'></i></a>
                                                    <a href="{{ url('laporan_keuangan/delete/' . $item->id) }}"
                                                        class="badge border-danger border" onclick="confirm(event)"><i
                                                            class='bx bxs-trash text-danger'></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Cetak Laporan Keuangan --}}
    <x-modal modalTitle="Cetak Laporan Keuangan" modalID="addLaporanKeuangan" btn="Cetak"
        action="{{ url('laporan_keuangan') }}" method="POST" method2="POST" enctype="">
        <div class="row mb-3">
            <div class="mt-3">
                <label for="periode" class="form-label">Pilih Periode</label>
                <select id="periode" name="laporan_periodik" class="form-select" required>
                    <option value="hari">Harian</option>
                    <option value="minggu">Mingguan</option>
                    <option value="bulan">Bulanan</option>
                </select>
            </div>

            <div class="mt-3">
                <label for="tanggal" class="form-label">Pilih Tanggal</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" required>
            </div>
            <div id="infoTanggal" class="text-muted fst-italic mt-3"></div>
        </div>

        <script>
            const periodeSelect = document.getElementById('periode');
            const tanggalInput = document.getElementById('tanggal');
            const infoTanggal = document.getElementById('infoTanggal');

            function updateInfoTanggal() {
                const periode = periodeSelect.value;
                const selectedDate = new Date(tanggalInput.value);
                if (!tanggalInput.value) {
                    infoTanggal.textContent = '';
                    return;
                }

                let text = '';

                const options = {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };

                if (periode === 'hari') {
                    text = `Tanggal dipilih: ${selectedDate.toLocaleDateString('id-ID', options)}`;
                } else if (periode === 'minggu') {
                    // Cari awal dan akhir minggu (Senin - Minggu)
                    const startOfWeek = new Date(selectedDate);
                    const day = selectedDate.getDay() || 7; // Minggu: 0 => 7
                    startOfWeek.setDate(selectedDate.getDate() - day + 1);

                    const endOfWeek = new Date(startOfWeek);
                    endOfWeek.setDate(startOfWeek.getDate() + 6);

                    text =
                        `Minggu dari ${startOfWeek.toLocaleDateString('id-ID', options)} hingga ${endOfWeek.toLocaleDateString('id-ID', options)}`;
                } else if (periode === 'bulan') {
                    const bulan = selectedDate.toLocaleDateString('id-ID', {
                        month: 'long'
                    });
                    const tahun = selectedDate.getFullYear();
                    text = `Bulan: ${bulan} ${tahun}`;
                }

                infoTanggal.textContent = text;
            }

            periodeSelect.addEventListener('change', updateInfoTanggal);
            tanggalInput.addEventListener('change', updateInfoTanggal);
        </script>
    </x-modal>
    {{-- Modal Cetak Laporan Keuangan --}}

    {{-- Modal Error --}}
    @if (session('addLaporanKeuangan'))
        <script>
            toastr.error("{{ Session::get('addLaporanKeuangan') }}");
            $(document).ready(function() {
                $('#addLaporanKeuangan').modal('show');
            });
        </script>
    @endif

    {{-- Alert --}}
    @if (Session::has('success'))
        <script>
            swal("Success!", "{{ Session::get('success') }}", "success"), {
                button: true,
                button: 'ok'
            }
        </script>
    @elseif (Session::has('error'))
        <script>
            swal("Error!", "{{ Session::get('error') }}", "error"), {
                button: true,
                button: 'ok'
            }
        </script>
    @endif
</x-layouts.main>
