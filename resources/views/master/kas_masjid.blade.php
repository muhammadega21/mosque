<x-layouts.main :title="$title" :mainPage="$main_page" :page="$page">
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mt-2">
                        <h5 class="card-title">Data Kas Masjid</h5>
                        <div class="d-flex align-items-center gap-2">
                            <x-search placeholder="Search..." />
                            <div class="btn-action">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addKasMasjid">
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
                                    <th>Jenis Kas</th>
                                    <th>Kategori</th>
                                    <th>Jumlah</th>
                                    <th>Keterangan</th>
                                    <th>Tanggal</th>
                                    <th>User</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($kas_masjid) < 1) <tr>
                                    <td colspan="9" class="text-center">Data Kosong</td>
                                    </tr>
                                    @else
                                    @foreach ($kas_masjid as $item)
                                    <tr>
                                        <td>{{ $loop->iteration + $kas_masjid->firstItem() - 1 }}</td>
                                        <td>{{ $item->jenis_kas }}</td>
                                        <td>{{ $item->kategori->nama_kategori }}</td>
                                        <td>Rp {{ number_format($item->jumlah, 2, ',', '.') }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                        <td>{{ $item->tanggal }}</td>
                                        @if ($item->jenis_kas == 'kas masuk')
                                        <td>{{ $item->donasi->nama_donatur }}</td>
                                        @else
                                        <td>{{ $item->user->nama }}</td>
                                        @endif
                                        <td>
                                            <div class="d-flex gap-1">
                                                @if ($item->jenis_kas == 'kas masuk' && $item->donasi)
                                                <button type="button" class="badge bg-light border-primary border"
                                                    data-bs-toggle="modal" data-bs-target="#showBuktiDonasi"
                                                    data-gambar="{{ asset('storage/' . $item->donasi->gambar) }}"
                                                    data-nama="{{ $item->donasi->nama_donatur }}"
                                                    data-tanggal="{{ $item->donasi->tanggal }}"
                                                    data-jumlah="Rp {{ number_format($item->jumlah, 0, ',', '.') }}">
                                                    <span class="fw-semibold"><i
                                                            class="bx bxs-show text-primary"></i></span>
                                                </button>
                                                @endif
                                                <button type="button" class="badge bg-light border-warning border"
                                                    data-bs-toggle="modal" data-bs-target="#updateKasMasjid"
                                                    data-kas="{{ $item }}" data-kategori="{{ $kategori }}">
                                                    <span class="fw-semibold"><i
                                                            class="bx bxs-edit text-warning"></i></span>
                                                </button>
                                                <a href="{{ url('kas-masjid/delete/' . $item->id) }}"
                                                    class="badge border-danger border" onclick="confirm(event)"><i
                                                        class='bx bxs-trash text-danger'></i></a>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Modal Update Kas Masjid --}}
                                    <x-modal modalTitle="Update Kas Masjid" modalID="updateKasMasjid" btn="Update"
                                        action="{{ url('kas-masjid/update/' . $item->id) }}" method="POST" method2="PUT"
                                        enctype="">
                                        <div class="row mb-3">
                                            <div class="input-group justify-content-between mt-3">
                                                <div class="input-box col-sm-6" style="max-width: 48%">
                                                    <label class="mb-2 required">Jenis Kas</label>
                                                    <select class="form-select" id="jenis_kas2" name="jenis_kas"
                                                        required>
                                                        <option value="kas masuk">Kas Masuk</option>
                                                        <option value="kas keluar">Kas Keluar</option>
                                                    </select>
                                                </div>
                                                <div class="input-box col-sm-6" style="max-width: 48%">
                                                    <label for="kategori" class=" mb-2 required">Kategori</label>
                                                    <select class="form-select" id="kategori2" name="kategori_id">
                                                        @foreach ($kategori as $kat)
                                                        <option value="{{ $kat->id }}">
                                                            {{ $kat->nama_kategori }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <div class="input-box col-sm-12">
                                                    <label for="jumlah2" class="mb-2 required">Jumlah</label>
                                                    <input type="number" id="jumlah2" class="form-control" name="jumlah"
                                                        placeholder="Masukkan Jumlah">
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <div class="input-box col-sm-12">
                                                    <label for="keterangan2" class="mb-2 required">Keterangan</label>
                                                    <input type="text" id="keterangan2" class="form-control"
                                                        name="keterangan" placeholder="Masukkan Keterangan">
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <label for="tanggal2" class="mb-2">Tanggal</label>
                                                <input type="date" id="tanggal2" class="form-control" name="tanggal">
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
                                    {{-- Modal Update Kas Masjid --}}
                                    @endforeach
                                    @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{ $kas_masjid->links() }}

    {{-- Modal Tambah Kas Masjid --}}
    <x-modal modalTitle="Tambah Kas Masjid" modalID="addKasMasjid" btn="Tambah" action="{{ url('kas-masjid') }}"
        method="POST" method2="POST" enctype="">
        <div class="row mb-3">
            <div class="input-group justify-content-between mt-3">
                <div class="input-box col-sm-6" style="max-width: 48%">
                    <label class="mb-2 required">Jenis Kas</label>
                    <select class="form-select @error('jenis_kas') is-invalid @enderror" name="jenis_kas">
                        <option selected value="">- Pilih Jenis Kas -</option>
                        <option value="kas masuk">Kas Masuk</option>
                        <option value="kas keluar">Kas Keluar</option>
                    </select>
                    @error('jenis_kas')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="input-box col-sm-6" style="max-width: 48%">
                    <label for="kategori" class=" mb-2 required">Kategori</label>
                    <select class="form-select @error('kategori_id') is-invalid @enderror" name="kategori_id">
                        <option selected value="">- Pilih Kategori -</option>
                        @foreach ($kategori as $kat)
                        <option value="{{ $kat->id }}" @if (old('kategori_id')==$kat->id) selected @endif>
                            {{ $kat->nama_kategori }}</option>
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
                    <label for="jumlah" class="mb-2 required">Jumlah</label>
                    <input type="number" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror"
                        name="jumlah" placeholder="Masukkan Jumlah" value="{{ old('jumlah') }}">
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
                    <input type="text" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                        name="keterangan" placeholder="Masukkan Keterangan" value="{{ old('keterangan') }}">
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
                <label for="bukti_pembayaran" class="mb-2">Bukti Pembayaran</label>
                <input type="file" id="bukti_pembayaran"
                    class="form-control @error('bukti_pembayaran') is-invalid @enderror" name="bukti_pembayaran"
                    accept="image/*,application/pdf">
                @error('bukti_pembayaran')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
    </x-modal>
    {{-- Modal Tambah Kas Masjid --}}

    {{-- Modal Show Bukti Donasi --}}
    <div class="modal fade" id="showBuktiDonasi" tabindex="-1" aria-labelledby="showBuktiDonasiLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showBuktiDonasiLabel">Bukti Donasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <img id="buktiDonasiImage" src="" class="img-fluid rounded" alt="Bukti Donasi">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6>Informasi Donasi</h6>
                                <hr>
                                <p><strong>Nama Donatur:</strong> <span id="donaturNama"></span></p>
                                <p><strong>Tanggal:</strong> <span id="donaturTanggal"></span></p>
                                <p><strong>Jumlah:</strong> <span id="donaturJumlah"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Show Bukti Donasi --}}

    {{-- Modal Error --}}
    @if (session('addKasMasjid'))
    <script>
        toastr.error("{{ Session::get('addKasMasjid') }}");
            $(document).ready(function() {
                $('#addKasMasjid').modal('show');
            });
    </script>
    @endif

    @if (session('updateKasMasjid'))
    <script>
        swal("Error!", "{{ Session::get('updateKasMasjid') }}", "error"), {
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

    <script>
        // Update modal with kas data
        $('#updateKasMasjid').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var kas = button.data('kas');
            var kategori = button.data('kategori');
            var modal = $(this);

            modal.find('#jenis_kas2').val(kas.jenis_kas);
            modal.find('#kategori2').empty();

            // Populate kategori options
            kategori.forEach(function(kat) {
                var selected = kat.id == kas.kategori_id ? 'selected' : '';
                modal.find('#kategori2').append('<option value="' + kat.id + '" ' + selected + '>' + kat
                    .nama_kategori + '</option>');
            });

            modal.find('#jumlah2').val(kas.jumlah);
            modal.find('#keterangan2').val(kas.keterangan);
            modal.find('#tanggal2').val(kas.tanggal);
            modal.find('#status_transaksi2').val(kas.status_transaksi);
        });
    </script>
</x-layouts.main>