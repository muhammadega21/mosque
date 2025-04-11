<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Register Page</title>

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

    <!-- My CSS File -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    {{-- CDN --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>

    <main>
        <div class="container">

            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-12 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <div class="logo d-flex align-items-center w-auto">
                                    <img src="{{ asset('img/logo2.png') }}">
                                    <span class="d-none d-lg-block text-success">DokuMosque</span>
                                </div>
                            </div><!-- End Logo -->

                            <div class="card mb-3 w-100 px-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4 fw-bold text-success">SIGN UP
                                        </h5>
                                        <p class="text-center small">Lengkapi form dibawah ini untuk mendaftar</p>
                                    </div>

                                    <form class="row g-3" action="{{ url('/register') }}" method="POST">
                                        @csrf

                                        <div class="col-12">
                                            <label for="nama" class="form-label">Nama</label>
                                            <div class="input-group has-validation">
                                                <input type="text" name="nama"
                                                    class="form-control @error('nama') is-invalid @enderror"
                                                    id="nama" placeholder="Masukkan Nama"
                                                    value="{{ old('nama') }}">
                                                @error('nama')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label for="email" class="form-label">Email</label>
                                            <div class="input-group has-validation">
                                                <input type="text" name="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    id="email" placeholder="Masukkan Email">
                                                @error('email')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="input-group">
                                            <div class="col-6 pe-2">
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password" name="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    id="password" placeholder="Masukkan Password">
                                                @error('password')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-6 ps-2">
                                                <label for="confirm_password" class="form-label">Confirm
                                                    Password</label>
                                                <input type="password" name="password_confirmation"
                                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                                    id="confirm_password" placeholder="Masukkan Password">
                                                @error('password_confirmation')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label for="nomor_hp" class="form-label">No Hp</label>
                                            <div class="input-group has-validation">
                                                <input type="number" name="nomor_hp"
                                                    class="form-control @error('nomor_hp') is-invalid @enderror"
                                                    id="nomor_hp" placeholder="Masukkan Nomor Hp"
                                                    value="{{ old('nomor_hp') }}">
                                                @error('nomor_hp')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <div class="input-group has-validation">
                                                <textarea class="form-control @error('alamat') is-invalid @enderror" placeholder="Masukkan Alamat" id="alamat"
                                                    name="alamat">{{ old('alamat') }}</textarea>
                                                @error('alamat')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-success w-100" type="submit">Register</button>
                                        </div>
                                        <p class="mt-1 text-center" style="font-size: 14px">Sudah memiliki akun? <a
                                                href="{{ url('/login') }}">Sign
                                                In</a>
                                        </p>

                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

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



    <!-- Vendor JS Files -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('js/main.js') }}"></script>

    <!-- My JS File -->
    <script src="{{ asset('js/script.js') }}"></script>

</body>

</html>
