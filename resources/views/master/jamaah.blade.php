<x-layouts.main :title="$title" :mainPage="$main_page" :page="$page">
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mt-2">
                        <h5 class="card-title">Data Jamaah</h5>
                        <div class="d-flex align-items-center gap-2">
                            <x-search placeholder="Search..." />
                            <div class="btn-action">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addJamaah">
                                    Tambah <span class="fw-semibold">+</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>No HP</th>
                                    <th>Alamat</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($jamaah) < 1)
                                    <tr>
                                        <td colspan="4" class="text-center">Data Kosong</td>
                                    </tr>
                                @else
                                    @foreach ($jamaah as $item)
                                        <tr>
                                            <td>{{ $item->user_data->nama }}</td>
                                            <td>{{ $item->user_data->nomor_hp }}</td>
                                            <td>{{ $item->user_data->alamat }}</td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button type="button" class="badge bg-light border-warning border"
                                                        data-bs-toggle="modal" data-bs-target="#updateJamaah"
                                                        data-jamaah="{{ $item }}">
                                                        <span class="fw-semibold"><i
                                                                class="bx bxs-edit text-warning"></i></span>
                                                    </button>
                                                    <a href="{{ url('jamaah/delete/' . $item->id) }}"
                                                        class="badge border-danger border" onclick="confirm(event)"><i
                                                            class='bx bxs-trash text-danger'></i></a>
                                                </div>
                                            </td>
                                        </tr>

                                        {{-- Modal Update Jamaah --}}
                                        <x-modal modalTitle="Update Jamaah" modalID="updateJamaah" btn="Update"
                                            action="" method="POST" method2="PUT" enctype="">
                                            <div class="row mb-3">
                                                <div class="input-box col-sm-12">
                                                    <label for="nama" class=" mb-2">Nama</label>
                                                    <input type="text" id="nama2" class="form-control"
                                                        name="nama" placeholder="Masukkan Nama">
                                                </div>

                                                <div class="mt-3">
                                                    <div class="input-box col-sm-12">
                                                        <label for="nomor_hp" class="mb-2 required">Nomor HP</label>
                                                        <input type="number" id="nomor_hp2" class="form-control "
                                                            name="nomor_hp" placeholder="Masukkan Nomor HP">

                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <div class="input-box col-sm-12">
                                                        <label for="alamat" class="mb-2 required">Alamat</label>
                                                        <textarea class="form-control " placeholder="Masukkan Alamat" id="alamat2" name="alamat"></textarea>
                                                    </div>
                                                </div>

                                            </div>
                                        </x-modal>
                                        {{-- Modal Update Jamaah --}}
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Jamaah --}}
    <x-modal modalTitle="Tambah Jamaah" modalID="addJamaah" btn="Tambah" action="{{ url('jamaah') }}" method="POST"
        method2="POST" enctype="">
        <div class="row mb-3">
            <div class="input-group justify-content-between">
                <div class="input-box col-sm-6" style="max-width: 48%">
                    <label for="email" class=" mb-2 required">Email</label>
                    <input type="text" id="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" placeholder="Masukkan Email" value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="input-box col-sm-6" style="max-width: 48%">
                    <label for="nama" class=" mb-2">Nama</label>
                    <input type="text" id="nama" class="form-control @error('nama') is-invalid @enderror"
                        name="nama" placeholder="Masukkan Nama" value="{{ old('nama') }}">
                    @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="input-group justify-content-between mt-3">
                <div class="input-box col-sm-6" style="max-width: 48%">
                    <label for="password" class=" mb-2 required">Password</label>
                    <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" placeholder="Masukkan Password" value="{{ old('password') }}">
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="input-box col-sm-6" style="max-width: 48%">
                    <label for="confirm_password" class=" mb-2">Confirm Password</label>
                    <input type="password" id="confirm_password"
                        class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password"
                        placeholder="Confirm Password" value="{{ old('confirm_password') }}">
                    @error('confirm_password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="mt-3">
                <div class="input-box col-sm-12">
                    <label for="nomor_hp" class="mb-2 required">Nomor HP</label>
                    <input type="number" id="nomor_hp" class="form-control @error('nomor_hp') is-invalid @enderror"
                        name="nomor_hp" placeholder="Masukkan Nomor HP" value="{{ old('nomor_hp') }}">
                    @error('nomor_hp')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="mt-3">
                <div class="input-box col-sm-12">
                    <label for="alamat" class="mb-2 required">Alamat</label>
                    <textarea class="form-control @error('alamat') is-invalid @enderror" placeholder="Masukkan Alamat" id="alamat"
                        name="alamat">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

        </div>
    </x-modal>
    {{-- Modal Tambah Jamaah --}}

    {{-- Modal Error --}}
    @if (session('addJamaah'))
        <script>
            toastr.error("{{ Session::get('addJamaah') }}");
            $(document).ready(function() {
                $('#addJamaah').modal('show');
            });
        </script>
    @endif

    @if (session('updateJamaah'))
        <script>
            swal("Error!", "{{ Session::get('updateJamaah') }}", "error"), {
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
