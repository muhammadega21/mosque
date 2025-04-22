<x-layouts.main :title="$title" :mainPage="$main_page" :page="$page">
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex align-items-center justify-content-between mt-2">
                        <h5 class="card-title">Data Donasi</h5>
                        <div class="d-flex align-items-center gap-2">
                            <x-search placeholder="Search..." />
                            <div class="btn-action">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addDonasi">
                                    Donasi <span class="fw-semibold">+</span>
                                </button>
                            </div>
                            <div class="btn-action">
                                <a href="{{ url('donasi/export') }}" target="_blank" class="btn btn-danger">
                                    <span class="fw-semibold">Export</span> <i class='bx bxs-file-export'></i>
                                </a>

                            </div>
                            <div class="btn-action">
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#addSaldo">
                                    Isi saldo <span class="fw-semibold">+</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jumlah</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($donasi) < 1)
                                    <tr>
                                        <td colspan="9" class="text-center">Data Kosong</td>
                                    </tr>
                                @else
                                    @foreach ($donasi as $item)
                                        <tr>
                                            <td>{{ $loop->iteration + $donasi->firstItem() - 1 }}</td>
                                            <td>Rp {{ number_format($item->jumlah, 2, ',', '.') }}</td>
                                            <td>{{ $item->keterangan }}</td>
                                            <td>{{ $item->status_transaksi }}</td>
                                            <td>{{ $item->tanggal }}</td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ url('donasi/cetak/' . encrypt($item->id)) }}"
                                                        target="_blank" class="badge bg-light border-danger border">
                                                        <span class="fw-bold text-danger"><i
                                                                class="bx bxs-file-pdf"></i>Cetak</span>
                                                    </a>
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

    {{ $donasi->links() }}

    {{-- Modal Donasi Online --}}
    <x-modal modalTitle="Donasi Online" modalID="addDonasi" btn="Donasi" action="{{ url('donasi') }}" method="POST"
        method2="POST" enctype="">
        <div class="row mb-3">
            <span><strong>Saldo anda </strong> : Rp
                {{ number_format(Auth::user()->user_data->saldo, 2, ',', '.') }}</span>
            <div class="mt-3">
                <div class="input-box col-sm-12">
                    <label for="jumlah" class="mb-2 required">Jumlah Donasi</label>
                    <input type="number" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror"
                        name="jumlah" placeholder="Masukkan Jumlah Donasi" value="{{ old('jumlah') }}">
                    @error('jumlah')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
    </x-modal>
    {{-- Modal Donasi Online --}}

    {{-- Modal Isi Saldo --}}
    <x-modal modalTitle="Isi Saldo" modalID="addSaldo" btn="Tambah" action="{{ url('donasi/saldo') }}" method="POST"
        method2="POST" enctype="">
        <div class="row mb-3">
            <span><strong>Saldo saat ini </strong> : Rp
                {{ number_format(Auth::user()->user_data->saldo, 2, ',', '.') }}</span>
            <div class="mt-3">
                <div class="input-box col-sm-12">
                    <label for="saldo" class="mb-2 required">Jumlah</label>
                    <input type="number" id="saldo" class="form-control @error('saldo') is-invalid @enderror"
                        name="saldo" placeholder="Masukkan Jumlah Saldo" value="{{ old('saldo') }}">
                    @error('saldo')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="mt-3">
                <div class="input-box col-sm-12">
                    <label for="metode_pembayaran" class="mb-2">Metode Pembayaran</label>
                    <select class="form-select" name="metode_pembayaran" id="metode_pembayaran">
                        <option value="" selected disabled>Pilih Metode Pembayaran</option>
                        <option value="bank">Bank</option>
                        <option value="gopay">Gopay</option>
                        <option value="ovo">Ovo</option>
                        <option value="dana">Dana</option>
                    </select>
                </div>
            </div>
    </x-modal>
    {{-- Modal Isi Saldo --}}

    {{-- Modal Error --}}
    @if (session('addDonasi'))
        <script>
            toastr.error("{{ Session::get('addDonasi') }}");
            $(document).ready(function() {
                $('#addDonasi').modal('show');
            });
        </script>
    @endif
    @if (session('addSaldo'))
        <script>
            toastr.error("{{ Session::get('addSaldo') }}");
            $(document).ready(function() {
                $('#addSaldo').modal('show');
            });
        </script>
    @endif

    @if (session('updateDonasi'))
        <script>
            swal("Error!", "{{ Session::get('updateDonasi') }}", "error"), {
                button: true,
                button: 'ok'
            }
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        </script>
    @endif

    @if (session('confirmCetak') && session('transaksi_id'))
        <script>
            const url = "{{ url('donasi/cetak/') }}/{{ session('transaksi_id') }}"
            swal({
                title: 'Donasi Berhasil!',
                text: "{{ session('confirmCetak') }}",
                icon: 'success',
                buttons: [
                    'Tidak',
                    'Cetak'
                ],
            }).then((confirm) => {
                if (confirm) {
                    window.open(url, '_blank');
                }
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
