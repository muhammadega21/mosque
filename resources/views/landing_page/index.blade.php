<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    {{-- <script src='https://cdn.tailwindcss.com'></script> --}}
    <script src='https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body>
    <header>
        @include('landing_page.navbar')
    </header>

    {{-- Start Modal Donasi --}}
    <div id="donationModal" class="fixed inset-0 z-50 shadow-md hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-white-100 bg-opacity-40 backdrop-blur-sm"></div>
            </div>

            <!-- Modal content -->
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative z-15">
                <form id="donationForm" action="{{ url('donasi') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Formulir Donasi</h3>


                        <!-- Name Input -->
                        <div class="mb-4">
                            <div class="flex items-center mb-2">
                                <input id="anonymousCheckbox" type="checkbox" name="anonymousCheckbox"
                                    class="h-4 w-4 text-[#019961] focus:ring-[#019961] border-gray-300 rounded cursor-pointer">
                                <label for="anonymousCheckbox" class="ml-2 block text-sm text-gray-700">Sembunyikan
                                    nama (Hamba Allah)</label>
                            </div>
                            <div id="nameInputContainer">
                                <label for="nama_donatur" class="block text-sm font-medium text-gray-700">Nama
                                    Donatur</label>
                                <input type="text" name="nama_donatur" id="nama_donatur"
                                    class="mt-1 py-2 px-6 focus:ring-[#019961] focus:border-[#019961] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    placeholder="Masukkan nama donatur">
                            </div>
                        </div>

                        <!-- Bank Selection -->
                        <div class="mb-4">
                            <label for="bank_tujuan" class="block text-sm font-medium text-gray-700">Rekening
                                Tujuan</label>
                            <select id="bank_tujuan"
                                class="mt-1 py-2 px-6 focus:ring-[#019961] focus:border-[#019961] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md cursor-pointer">
                                <option value="">Pilih Bank Tujuan</option>
                                <option value="bri">BRI</option>
                                <option value="bca">BCA</option>
                                <option value="mandiri">Mandiri</option>
                                <option value="bsi">BSI</option>
                            </select>
                        </div>

                        <!-- Bank Account Info (hidden by default) -->
                        <div id="bankInfoContainer" class="mb-4 hidden">
                            <div class="bg-gray-50 p-3 rounded-md">
                                <p class="text-sm font-medium text-gray-700">Nomor Rekening:</p>
                                <p id="noRekening" class="text-sm text-gray-600 mt-1 font-mono"></p>
                                <p class="text-sm font-medium text-gray-700 mt-2">Atas Nama:</p>
                                <p id="atasNama" class="text-sm text-gray-600 mt-1"></p>
                            </div>
                        </div>

                        <!-- Proof Upload -->
                        <div class="mb-4">
                            <label for="gambar" class="block text-sm font-medium text-gray-700">Bukti
                                Pembayaran</label>
                            <div class="mt-1 flex items-center">
                                <input type="file" name="gambar" id="gambar" required accept="image/*"
                                    class="focus:ring-[#019961] focus:border-[#019961] block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-[#019961] file:text-white hover:file:bg-[#249b6f] cursor-pointer">
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG (Maks. 2MB)</p>
                        </div>

                    </div>

                    <!-- Close Button -->
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end">
                        <button type="button" onclick="closeModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#019961] sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm cursor-pointer">
                            Tutup
                        </button>
                        <button type="submit"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-[#019961] text-base font-medium text-white hover:bg-[#249b6f] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#019961] sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm cursor-pointer">
                            Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- End Modal Donasi --}}

    <main>
        {{-- Hero --}}
        <section class="hero relative h-screen overflow-hidden">
            <div class="h-full overflow-hidden relative bg-cover bg-center">
                <img src="/img/masjid.jpg" alt="Masjid" class="h-full w-full object-cover">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-5% via-10% to-85% from-[#1A424E] via-[#1A424E] to-transparant opacity-100">
                    <div
                        class="px-[9%] absolute top-1/2 transform -translate-y-1/2 text-white flex flex-col gap-y-6 pt-[70px]">
                        <div class="flex flex-col gap-y-2 w-3/5">
                            <h1 class="text-5xl font-bold">Yuk, Tabung Pahala di Akhir Tahun!</h1>
                            <h2 class="text-2xl font-semibold">Galang dana untuk bangun Masjid, Insyaallah pahalamu
                                terus
                                mengalir</h2>
                        </div>
                        <button type="button"
                            class="text-xl font-semibold uppercase border border-transparent bg-[#019961] text-white hover:bg-[#249b6f] transition duration-200 rounded-full px-8 py-4 w-max cursor-pointer">Donasi
                            Sekarang</button>
                    </div>
                </div>
            </div>
        </section>
        {{-- End Hero --}}

        {{-- Donation --}}
        <section class="donation h-full my-16">
            <div class="donation-card flex flex-col items-center justify-center px-[9%]">
                <div class="mb-6">
                    <h1 class="text-4xl font-bold text-gray-800 text-center">Data Kas Masjid</h1>
                </div>
                <div class="overflow-x-auto w-full">
                    <table class="min-w-full divide-y divide-gray-200 shadow-sm rounded-lg overflow-hidden">
                        <thead class="bg-[#019961] text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tanggal
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Jenis Kas
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Kategori
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if (count($kas_masjid) < 1)
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                        Data Kosong</td>
                                </tr>
                            @else
                                @foreach ($kas_masjid as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->jenis_kas }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->kategori->nama_kategori }}
                                        </td>
                                        @if ($item->jenis_kas == 'kas masuk')
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->donasi->nama_donatur }}
                                            </td>
                                        @else
                                            <td class="px-6 py-4 whitespace-nowrap">Pengurus</td>
                                        @endif
                                        <td class="px-6 py-4 whitespace-nowrap">Rp
                                            {{ number_format($item->jumlah, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        {{-- End Donation --}}

        <hr class="border border-gray-300 w-[80%] rounded-full mx-auto my-10">

        {{-- Kegiatan Masjid --}}
        <section class="kegiatan_masjid h-full my-16 px-[9%] grid justify-center ">
            <h1 class="text-4xl font-bold text-gray-800 text-center">Kegiatan Masjid</h1>
            <div class="grid grid-cols-3 mt-10 gap-y-10 gap-x-5 items-start">
                @foreach ($kegiatan_masjid as $data)
                    <div
                        class="kegiatan-card flex flex-col items-center justify-center bg-white shadow-[0px_6px_15px_rgba(0,0,0,0.2)] rounded-3xl overflow-hidden">
                        <div class="kegiatan-card-image w-full h-[300px] overflow-hidden rounded-t-xl">
                            <img src="{{ asset('/storage/' . $data->gambar) }}" alt="Kegiatan Masjid"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="kegiatan-card-content text-center mt-5 px-4 pb-10 relative w-full">
                            <div class="mb-8">
                                <h2 class="text-2xl font-bold text-gray-800">{{ $data->judul }}</h2>
                                <p class="text-base text-gray-600 mt-2 text-center">{{ $data->deskripsi }}</p>
                            </div>
                            <button type="button"
                                class="font-semibold absolute bottom-0 left-0 right-0 py-4 text-center bg-[#019961] text-white hover:bg-[#249b6f] transition duration-200 ">Lihat
                                Detail</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        {{-- End Kegiatan Masjid --}}

        <hr class="border border-gray-300 w-[80%] rounded-full mx-auto my-10">

        {{-- Informasi Masjid --}}
        <section class="informasi_masjid h-full my-16 px-[9%] grid justify-center ">
            <h1 class="text-4xl font-bold text-gray-800 text-center">Informasi Masjid</h1>
            <div class="grid grid-cols-3 mt-10 gap-y-10 gap-x-5 items-start">
                @foreach ($informasi_masjid as $data)
                    <div
                        class="informasi-card flex flex-col items-center justify-center bg-white shadow-[0px_6px_15px_rgba(0,0,0,0.2)] rounded-3xl overflow-hidden">
                        <div class="informasi-card-image w-full h-[300px] overflow-hidden rounded-t-xl">
                            <img src="{{ asset('/storage/' . $data->gambar) }}" alt="Informasi Masjid"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="informasi-card-content text-center mt-5 px-4 pb-10 relative w-full">
                            <div class="mb-8">
                                <h2 class="text-2xl font-bold text-gray-800">{{ $data->judul }}</h2>
                                <p class="text-base text-gray-600 mt-2 text-justify">{{ $data->deskripsi }}</p>
                            </div>
                            <button type="button"
                                class="font-semibold absolute bottom-0 left-0 right-0 py-4 text-center bg-[#019961] text-white hover:bg-[#249b6f] transition duration-200 ">Lihat
                                Detail</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        {{-- End Informasi Masjid --}}

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
            // Bank account data
            const bankAccounts = {
                bri: {
                    noRek: '1234-5678-9012-3456',
                    name: 'Masjid Al-Hamujirin'
                },
                bca: {
                    noRek: '9876-5432-1098-7654',
                    name: 'Masjid Al-Hamujirin'
                },
                mandiri: {
                    noRek: '5678-1234-9012-3456',
                    name: 'Masjid Al-Hamujirin'
                },
                bsi: {
                    noRek: '3456-7890-1234-5678',
                    name: 'Masjid Al-Hamujirin'
                }
            };

            // Handle bank selection change
            document.getElementById('bank_tujuan').addEventListener('change', function() {
                const bankInfoContainer = document.getElementById('bankInfoContainer');
                const noRekening = document.getElementById('noRekening');
                const atasNama = document.getElementById('atasNama');

                if (this.value) {
                    const selectedBank = bankAccounts[this.value];
                    noRekening.textContent = selectedBank.noRek;
                    atasNama.textContent = selectedBank.name;
                    bankInfoContainer.classList.remove('hidden');
                } else {
                    bankInfoContainer.classList.add('hidden');
                }
            });

            // Toggle name input based on checkbox
            document.getElementById('anonymousCheckbox').addEventListener('change', function() {
                const nameInputContainer = document.getElementById('nameInputContainer');
                const nameInput = document.getElementById('nama_donatur');

                if (this.checked) {
                    nameInputContainer.classList.add('opacity-50');
                    nameInput.disabled = true;
                    nameInput.value = '';
                } else {
                    nameInputContainer.classList.remove('opacity-50');
                    nameInput.disabled = false;
                }
            });

            // Open modal function
            function openDonationModal() {
                document.getElementById('donationModal').classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            // Close modal function
            function closeModal() {
                document.getElementById('donationModal').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            // Add click event to donation button
            document.querySelector('.hero button').addEventListener('click', openDonationModal);
        </script>

        @include('landing_page.footer')
    </main>
</body>

</html>
