<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <script src='https://cdn.tailwindcss.com'></script>
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
                <ul
                    class="flex items-center justify-center gap-x-4 text-center bg-[#019961] text-white w-max p-4 rounded-xl">
                    <li class="flex flex-col gap-y-2 px-8 py-4">
                        <h3 class="text-4xl font-bold">Rp {{ number_format($total_donasi, 0, ',', '.') }}</h3>
                        <span class="text-xl">Total Donasi Terkumpul</span>
                    </li>
                    <li class="bg-[#1eaf7a] w-[3px] h-20 block rounded-full"></li>
                    <li class="flex flex-col gap-y-2 px-8 py-4">
                        <h3 class="text-4xl font-bold">{{ $donatur }}</h3>
                        <span class="text-xl">Total Donatur</span>
                    </li>
                </ul>
                <div class="mt-10 text-center">
                    <div class="mb-5 text-gray-800">
                        <h3 class="text-3xl font-bold">"Ya Allah, berikanlah pahala dari apa yang telah diinfakkan dan
                            jadikanlah sedekah ini sebagai pintu pembuka rezeki yang lebih luas lagi. Aamiin ya
                            rabbal
                            alamin."</h3>
                    </div>
                    <div class="text-base text-gray-800 opacity-85">
                        <p>Membangun dan memakmurkan masjid merupakan salah satu jalan menuju surga.
                            Bagi sahabat yang belum memiliki kesempatan untuk membangun masjid secara fisik, DokuMosque
                            dapat menjadi sarana untuk berkontribusi dalam memakmurkan Masjid Al-Hamujirin.</p>
                        <p>Melalui donasi yang sahabat salurkan di DokuMosque, sahabat turut serta dalam menghidupkan
                            kegiatan keagamaan di masjid.
                            Mari kita raih pahala abadi dengan mendukung kemakmuran Masjid Al-Hamujirin.</p>
                    </div>
                </div>
            </div>
        </section>
        {{-- End Donation --}}

        <hr class="border border-gray-300 w-[90%] rounded-full mx-auto my-10">

        {{-- Kegiatan Masjid --}}
        <section class="kegiatan_masjid h-full my-16 px-[9%] grid justify-center ">
            <h1 class="text-4xl font-bold text-gray-800">Kegiatan Masjid</h1>
        </section>
        {{-- End Kegiatan Masjid --}}


        @include('landing_page.footer')
    </main>
</body>

</html>
