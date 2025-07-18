<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    {{-- <script src='https://cdn.tailwindcss.com'></script> --}}
    <script src='https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4'></script>
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
                        <a href="/dashboard"
                            class="text-xl font-semibold uppercase border border-transparent bg-[#019961] text-white hover:bg-[#249b6f] transition duration-200 rounded-full px-8 py-4 w-max">Donasi
                            Sekarang</a>
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
                                            {{ $loop->iteration + $kas_masjid->firstItem() - 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->tanggal }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->jenis_kas }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->kategori->nama_kategori }}
                                        </td>
                                        @if ($item->jenis_kas == 'kas masuk')
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->donasi->nama_donatur }}
                                            </td>
                                        @else
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->user->nama }}</td>
                                        @endif
                                        <td class="px-6 py-4 whitespace-nowrap">Rp
                                            {{ number_format($item->jumlah, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                {{-- Pagination dengan style --}}
                <div class="mt-8 w-full px-[9%]">
                    {{ $kas_masjid->onEachSide(1)->links('pagination::tailwind') }}
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


        @include('landing_page.footer')
    </main>
</body>

</html>
