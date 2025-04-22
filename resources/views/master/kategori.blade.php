<x-layouts.main :title="$title" :mainPage="$main_page" :page="$page">
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mt-2">
                        <h5 class="card-title">Data Kategori</h5>
                        <div class="d-flex align-items-center gap-2">
                            <x-search placeholder="Search..." />
                            <div class="btn-action">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addKategori">
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
                                    <th>Nama Kategori</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($kategori) < 1)
                                    <tr>
                                        <td colspan="4" class="text-center">Data Kosong</td>
                                    </tr>
                                @else
                                    @foreach ($kategori as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama_kategori }}</td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button type="button" class="badge bg-light border-warning border"
                                                        data-bs-toggle="modal" data-bs-target="#updateKategori"
                                                        data-kategori="{{ $item }}">
                                                        <span class="fw-semibold"><i
                                                                class="bx bxs-edit text-warning"></i></span>
                                                    </button>
                                                    <a href="{{ url('kategori/delete/' . $item->id) }}"
                                                        class="badge border-danger border" onclick="confirm(event)"><i
                                                            class='bx bxs-trash text-danger'></i></a>
                                                </div>
                                            </td>
                                        </tr>

                                        {{-- Modal Update Kategori --}}
                                        <x-modal modalTitle="Update Kategori" modalID="updateKategori" btn="Update"
                                            action="" method="POST" method2="PUT" enctype="">
                                            <div class="row mb-3">
                                                <div class="input-box col-sm-12">
                                                    <label for="nama_kategori2" class=" mb-2">Nama Kategori</label>
                                                    <input type="text" id="nama_kategori2" class="form-control"
                                                        name="nama_kategori" placeholder="Masukkan Nama Kategori">
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

    {{-- Modal Tambah Kategori --}}
    <x-modal modalTitle="Tambah Kategori" modalID="addKategori" btn="Tambah" action="{{ url('kategori') }}"
        method="POST" method2="POST" enctype="">
        <div class="row mb-3">
            <div class="mt-3">
                <div class="input-box col-sm-12">
                    <label for="nama_kategori" class="mb-2 required">Nama Kategori</label>
                    <input type="text" id="nama_kategori"
                        class="form-control @error('nama_kategori') is-invalid @enderror" name="nama_kategori"
                        placeholder="Masukkan Nama Kategori" value="{{ old('nama_kategori') }}">
                    @error('nama_kategori')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

        </div>
    </x-modal>
    {{-- Modal Tambah Kategori --}}

    {{-- Modal Error --}}
    @if (session('addKategori'))
        <script>
            toastr.error("{{ Session::get('addKategori') }}");
            $(document).ready(function() {
                $('#addKategori').modal('show');
            });
        </script>
    @endif

    @if (session('updateKategori'))
        <script>
            swal("Error!", "{{ Session::get('updateKategori') }}", "error"), {
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
