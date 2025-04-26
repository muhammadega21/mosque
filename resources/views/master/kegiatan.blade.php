<x-layouts.main :title="$title" :mainPage="$main_page" :page="$page">
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mt-2">
                        <h5 class="card-title">Data Kegiatan Masjid</h5>
                        <div class="d-flex align-items-center gap-2">
                            <x-search placeholder="Search..." />
                            <div class="btn-action">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addKegiatan">
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
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Pembuat</th>
                                    <th>Tanggal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($kegiatan) < 1)
                                    <tr>
                                        <td colspan="5" class="text-center">Data Kosong</td>
                                    </tr>
                                @else
                                    @foreach ($kegiatan as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->judul }}</td>
                                            <td>{{ $item->deskripsi }}</td>
                                            <td>{{ $item->user->user_data->nama }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('l, d F Y') }}
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button type="button" class="badge bg-light border-warning border"
                                                        data-bs-toggle="modal" data-bs-target="#updateKegiatan"
                                                        data-kegiatan="{{ $item }}">
                                                        <span class="fw-semibold"><i
                                                                class="bx bxs-edit text-warning"></i></span>
                                                    </button>
                                                    <a href="{{ url('kegiatan_masjid/delete/' . $item->id) }}"
                                                        class="badge border-danger border" onclick="confirm(event)"><i
                                                            class='bx bxs-trash text-danger'></i></a>
                                                </div>
                                            </td>
                                        </tr>

                                        {{-- Modal Update Kegiatan --}}
                                        <x-modal modalTitle="Update Kegiatan" modalID="updateKegiatan" btn="Update"
                                            action="" method="POST" method2="PUT" enctype="multipart/form-data">
                                            <div class="row mb-3">
                                                <div class="mt-3">
                                                    <div class="input-box col-sm-12">
                                                        <label for="judul" class="mb-2 required">Judul
                                                            Kegiatan</label>
                                                        <input type="text" id="judul2" class="form-control"
                                                            name="judul" placeholder="Masukkan Judul Kegiatan">
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <div class="input-box col-sm-12">
                                                        <label for="tgl_post" class="mb-2 required">Tanggal
                                                            Kegiatan</label>
                                                        <input type="date" id="tgl_post2" class="form-control"
                                                            name="tgl_post" placeholder="Masukkan Tanggal Kegiatan">
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <div class="input-box col-sm-12">
                                                        <label for="deskripsi" class="mb-2 required">Deskripsi
                                                            Kegiatan</label>
                                                        <textarea id="deskripsi2" class="form-control" name="deskripsi" placeholder="Masukkan Deskripsi Kegiatan"></textarea>
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <div class="input-box col-sm-12">
                                                        <label for="gambar" class="mb-2 required">Gambar
                                                            Kegiatan</label>
                                                        <input type="file" id="gambar2" class="form-control"
                                                            name="gambar" placeholder="Masukkan Gambar Kegiatan">
                                                        <input type="hidden" name="oldImage" id="oldImage">
                                                    </div>
                                                </div>
                                            </div>
                                        </x-modal>
                                        {{-- Modal Update Kategori --}}
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Kegiatan --}}
    <x-modal modalTitle="Tambah Kegiatan" modalID="addKegiatan" btn="Tambah" action="{{ url('kegiatan_masjid') }}"
        method="POST" method2="POST" enctype="multipart/form-data">
        <div class="row mb-3">
            <div class="mt-3">
                <div class="input-box col-sm-12">
                    <label for="judul" class="mb-2 required">Judul Kegiatan</label>
                    <input type="text" id="judul" class="form-control @error('judul') is-invalid @enderror"
                        name="judul" placeholder="Masukkan Judul Kegiatan" value="{{ old('judul') }}">
                    @error('judul')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="mt-3">
                <div class="input-box col-sm-12">
                    <label for="tgl_post" class="mb-2 required">Tanggal Kegiatan</label>
                    <input type="date" id="tgl_post" class="form-control @error('tgl_post') is-invalid @enderror"
                        name="tgl_post" placeholder="Masukkan Tanggal Kegiatan" value="{{ old('tgl_post') }}">
                    @error('tgl_post')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="mt-3">
                <div class="input-box col-sm-12">
                    <label for="deskripsi" class="mb-2 required">Deskripsi Kegiatan</label>
                    <textarea id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi"
                        placeholder="Masukkan Deskripsi Kegiatan">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="mt-3">
                <div class="input-box col-sm-12">
                    <label for="gambar" class="mb-2 required">Gambar Kegiatan</label>
                    <input type="file" id="gambar" class="form-control @error('gambar') is-invalid @enderror"
                        name="gambar" placeholder="Masukkan Gambar Kegiatan" value="{{ old('gambar') }}">
                    @error('gambar')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
    </x-modal>
    {{-- Modal Tambah Kegiatan --}}

    {{-- Modal Error --}}
    @if (session('addKegiatan'))
        <script>
            toastr.error("{{ Session::get('addKegiatan') }}");
            $(document).ready(function() {
                $('#addKegiatan').modal('show');
            });
        </script>
    @endif

    @if (session('updateKegiatan'))
        <script>
            swal("Error!", "{{ Session::get('updateKegiatan') }}", "error"), {
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
