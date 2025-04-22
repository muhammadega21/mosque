<x-layouts.main :title="$title" :mainPage="$main_page" :page="$page">
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mt-2">
                        <h5 class="card-title">Data Keuangan</h5>
                        <div class="d-flex align-items-center gap-2">
                            <x-search placeholder="Search..." />
                            <div class="btn-action">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addKeuangan">
                                    Tambah <span class="fw-semibold">+</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Transaksi</th>
                                    <th>Kategori</th>
                                    <th>Jumlah</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>User</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($keuangan) < 1)
                                    <tr>
                                        <td colspan="9" class="text-center">Data Kosong</td>
                                    </tr>
                                @else
                                    @foreach ($keuangan as $item)
                                        <tr>
                                            <td>{{ $loop->iteration + $keuangan->firstItem() - 1 }}</td>
                                            <td>{{ $item->jenis_transaksi }}</td>
                                            <td>{{ $item->kategori->nama_kategori }}</td>
                                            <td>Rp {{ number_format($item->jumlah, 2, ',', '.') }}</td>
                                            <td>{{ $item->keterangan }}</td>
                                            <td>{{ $item->status_transaksi }}</td>
                                            <td>{{ $item->tanggal }}</td>
                                            <td>{{ $item->user->user_data->nama }}</td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button type="button" class="badge bg-light border-warning border"
                                                        data-bs-toggle="modal" data-bs-target="#updateKeuangan"
                                                        data-keuangan="{{ $item }}"
                                                        data-kategori="{{ $kategori }}">
                                                        <span class="fw-semibold"><i
                                                                class="bx bxs-edit text-warning"></i></span>
                                                    </button>
                                                    <a href="{{ url('keuangan/delete/' . $item->id) }}"
                                                        class="badge border-danger border" onclick="confirm(event)"><i
                                                            class='bx bxs-trash text-danger'></i></a>
                                                </div>
                                            </td>
                                        </tr>

                                        {{-- Modal Update Keuangan --}}
                                        <x-modal modalTitle="Update Keuangan" modalID="updateKeuangan" btn="Update"
                                            action="" method="POST" method2="PUT" enctype="">
                                            <div class="row mb-3">
                                                <div class="input-group justify-content-between mt-3">
                                                    <div class="input-box col-sm-6" style="max-width: 48%">
                                                        <label class="mb-2 required">Jenis Transaksi</label>
                                                        <select class="form-select" id="jenis_transaksi2"
                                                            name="jenis_transaksi" required>
                                                            <option value="masuk">Masuk</option>
                                                            <option value="keluar">Keluar</option>
                                                        </select>
                                                    </div>
                                                    <div class="input-box col-sm-6" style="max-width: 48%">
                                                        <label for="kategori" class=" mb-2 required">Kategori</label>
                                                        <select class="form-select" id="kategori2" name="kategori_id">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <div class="input-box col-sm-12">
                                                        <label for="jumlah2" class="mb-2 required">Jumlah
                                                            Transaksi</label>
                                                        <input type="number" id="jumlah2" class="form-control"
                                                            name="jumlah" placeholder="Masukkan Jumlah Transaksi">
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <div class="input-box col-sm-12">
                                                        <label for="keterangan2"
                                                            class="mb-2 required">Keterangan</label>
                                                        <input type="text" id="keterangan2" class="form-control"
                                                            name="keterangan" placeholder="Masukkan Keterangan">
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <label for="tanggal2" class="mb-2">Tanggal</label>
                                                    <input type="date" id="tanggal2" class="form-control"
                                                        name="tanggal">
                                                </div>
                                                <div class="mt-3">
                                                    <label class="mb-2">Status</label>
                                                    <select class="form-select" id="status_transaksi2"
                                                        name="status_transaksi" required>
                                                        <option value="selesai">Selesai</option>
                                                        <option value="pending">Pending</option>
                                                        <option value="batal">Batal</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </x-modal>
                                        {{-- Modal Update Keuangan --}}
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{ $keuangan->links() }}

    {{-- Modal Tambah Keuangan --}}
    <x-modal modalTitle="Tambah Keuangan" modalID="addKeuangan" btn="Tambah" action="{{ url('keuangan') }}"
        method="POST" method2="POST" enctype="">
        <div class="row mb-3">
            <div class="input-group justify-content-between mt-3">
                <div class="input-box col-sm-6" style="max-width: 48%">
                    <label class="mb-2 required">Jenis Transaksi</label>
                    <select class="form-select @error('jenis_transaksi') is-invalid @enderror "
                        name="jenis_transaksi">
                        <option selected value="">- Pilih Jenis Transaksi -</option>
                        <option value="masuk">Masuk</option>
                        <option value="keluar">Keluar</option>
                    </select>
                    @error('jenis_transaksi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="input-box col-sm-6" style="max-width: 48%">
                    <label for="kategori" class=" mb-2 required">Kategori</label>
                    <select class="form-select @error('kategori_id') is-invalid @enderror " name="kategori_id">
                        <option selected value="">- Pilih Kategori -</option>
                        @foreach ($kategori as $kategori)
                            <option value="{{ $kategori->id }}" @if (old('kategori_id') == $kategori->id) selected @endif>
                                {{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="mt-3">
                <div class="input-box col-sm-12">
                    <label for="jumlah" class="mb-2 required">Jumlah Transaksi</label>
                    <input type="number" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror"
                        name="jumlah" placeholder="Masukkan Jumlah Transaksi" value="{{ old('jumlah') }}">
                    @error('jumlah')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="mt-3">
                <div class="input-box col-sm-12">
                    <label for="keterangan" class="mb-2 required">Keterangan</label>
                    <input type="text" id="keterangan"
                        class="form-control @error('keterangan') is-invalid @enderror" name="keterangan"
                        placeholder="Masukkan Keterangan" value="{{ old('keterangan') }}">
                    @error('keterangan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="mt-3">
                <label for="tanggal" class="mb-2">Tanggal</label>
                <input type="date" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
                    name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}">
                @error('tanggal')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mt-3">
                <label class="mb-2">Status</label>
                <select class="form-select @error('status_transaksi') is-invalid @enderror " name="status_transaksi">
                    <option selected value="">- Pilih Status -</option>
                    <option value="selesai">Selesai</option>
                    <option value="pending">Pending</option>
                    <option value="batal">Batal</option>
                </select>
                @error('status_transaksi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </x-modal>
    {{-- Modal Tambah Keuangan --}}

    {{-- Modal Error --}}
    @if (session('addKeuangan'))
        <script>
            toastr.error("{{ Session::get('addKeuangan') }}");
            $(document).ready(function() {
                $('#addKeuangan').modal('show');
            });
        </script>
    @endif

    @if (session('updateKeuangan'))
        <script>
            swal("Error!", "{{ Session::get('updateKeuangan') }}", "error"), {
                button: true,
                button: 'ok'
            }
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
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
