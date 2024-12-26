<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/logo-rsui.ico') }}" />
    <title>Monitoring OK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/echo.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        /* Modern Color Palette */
        :root {
            /* Primary Colors - Inspired by Material Design 3.0 & Tailwind */
            --primary-blue: #0F72EA;
            /* More vibrant blue, similar to Dropbox */
            --success-green: #10B981;
            /* Modern green like Shopify */
            --warning-yellow: #F59E0B;
            /* Warmer yellow like Stripe */
            --danger-red: #EF4444;
            /* Refined red from Tailwind */
            --info-blue: #06B6D4;
            /* Fresh cyan from modern design systems */
            --neutral-gray: #475569;
            /* Slate gray from modern palettes */

            /* Card Background Colors - Softer with better contrast */
            --card-1: #06B6D4;
            /* Soft blue background */
            --card-2: #aec4b5;
            /* Mint green background */
            --card-3: #f0e5ad;
            /* Warm yellow background */
            --card-4: #d3b4b4;
            /* Soft red background */
            --card-5: #85dade;
            /* Fresh cyan background */
            --card-6: #568abe;
            /* Clean slate background */
            --card-7: #efcd49;
            --card-8: #55bbc4;
            --card-9: #c09494;


            /* Gradient Variations for Cards */
            /* --gradient-1: linear-gradient(135deg, #00C2D1 0%, #2aecfe 100%);
            --gradient-2: linear-gradient(135deg, #357ded 0%, #E6FAF0 100%);
            --gradient-3: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 100%);
            --gradient-4: linear-gradient(135deg, #56eef4 0%, #FEE2E2 100%);
            --gradient-5: linear-gradient(135deg, #CFFAFE 0%, #b5d6d6 100%);
            --gradient-6: linear-gradient(135deg, #9cf6f6 0%, #f9b4ed 100%);
            --gradient-7: linear-gradient(135deg, #e574bc 0%, #ff81c8 100%);
            --gradient-8: linear-gradient(135deg, #0267c1 0%, #027be7 100%);
            --gradient-9: linear-gradient(135deg, #0075c4 0%, #F1F5F9 100%); */

            /* Hover State Colors */
            --hover-blue: #0056D6;
            /* Darker blue for hover */
            --hover-green: #059669;
            /* Darker green for hover */
            --hover-yellow: #D97706;
            /* Darker yellow for hover */
            --hover-red: #DC2626;
            /* Darker red for hover */
            --hover-cyan: #0891B2;
            /* Darker cyan for hover */
            --hover-gray: #334155;
            /* Darker gray for hover */

            /* Text Colors for Better Readability */
            --text-primary: #1E293B;
            /* Dark blue-gray for primary text */
            --text-secondary: #475569;
            /* Medium blue-gray for secondary text */
            --text-light: #94A3B8;
            /* Light blue-gray for tertiary text */
        }

        .card.card-disabled .room-info h2,
        .card.card-disabled h1,
        .card.card-disabled h5 {
            color: #aeaeae !important;
        }
        .card.card-disabled {
            background: #e5e5e5;
        }


        /* Example usage in cards */
        .card-bg-1 {
            background: var(--card-1);
            border-left: 4px solid var(--primary-blue);
        }

        .card-bg-2 {
            background: var(--card-2);
            border-left: 4px solid var(--success-green);
        }

        .card-bg-3 {
            background: var(--card-3);
            border-left: 4px solid var(--warning-yellow);
        }

        .card-bg-4 {
            background: var(--card-4);
            border-left: 4px solid var(--danger-red);
        }

        .card-bg-5 {
            background: var(--card-5);
            border-left: 4px solid var(--info-blue);
        }

        .card-bg-6 {
            background: var(--card-6);
            border-left: 4px solid var(--neutral-gray);
        }

        .card-bg-7 {
            background: var(--card-7);
            border-left: 4px solid var(--neutral-gray);
        }

        .card-bg-8 {
            background: var(--card-8);
            border-left: 4px solid var(--neutral-gray);
        }

        .card-bg-9 {
            background: var(--card-9);
            border-left: 4px solid var(--neutral-gray);
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Roboto', sans-serif;
        }

        .container {
            max-width: 97vw;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.95);
            padding: 1rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            backdrop-filter: blur(10px);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid #bdbdbb;
        }

        .header h5 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
        }

        #tanggal-hari {
            font-size: 1.2rem;
            color: #5c6ac4;
            font-weight: 500;
        }

        .card {
            /* min-height: 38vh; */
            min-height: 25.5vh;
            border: none;
            border-radius: 15px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 1.5rem;
        }

        .card h1 {
            position: absolute;
            top: 50%;
            /* Adjusted from 50% to make room for h3 */
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
            color: #2c3e50;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
            text-align: center;
        }



        /* Informasi ruangan */
        .card .room-info {
            position: absolute;
            top: 1rem;
            left: 1rem;
            display: flex;
            flex-direction: column;
        }

        .card .nama-ruangan {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
            text-shadow: 1px 1px 1px rgba(255, 255, 255, 0.5);
        }

        .card .nama-operator {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-secondary);
            margin: 0;
            text-shadow: 1px 1px 1px rgba(255, 255, 255, 0.5);
        }

        .card h5 {
            position: absolute;
            bottom: 1.5rem;
            left: 50%;
            transform: translateX(-50%);
            font-size: .9rem;
            font-weight: 500;
            color: black;
            margin: 0;
            width: 90%;
            text-align: center;
            opacity: 0.9;
            text-shadow: 1px 1px 1px rgba(255, 255, 255, 0.5);
        }

        /* Status indicators */
        .indicator-wrapper {
            position: absolute;
            top: 1rem;
            right: 1rem;
            display: flex;
        }

        .indicator-text {
            font-size: .8rem;
            font-weight: 700;
            color: #2c3e50;
            margin-right: .5rem;
            text-shadow: 1px 1px 1px rgba(255, 255, 255, 0.5);
        }

        .indicator-status {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            animation: pulse 2s infinite;
            margin-top: 2px;
        }

        .indicator-status.active {
            background-color: #4CAF50;
            box-shadow: 0 0 10px rgba(76, 175, 80, 0.5);
        }

        .indicator-status.maintenance {
            background-color: #b22222;
            box-shadow: 0 0 10px rgba(178, 34, 34, 0.5);
        }


        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.2);
                opacity: 0.8;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .card {
                margin-bottom: 1.5rem;
            }

            .card h5 {
                font-size: 1rem;
                bottom: 1rem;
            }

            .card h2 {
                font-size: 1.5rem;
            }

            .card h1 {
                font-size: 2.5rem;
            }

            .header h5 {
                font-size: 1.2rem;
            }

            #tanggal-hari {
                font-size: 1rem;
            }
        }

        /* Add smooth transitions */
        .card,
        .card h1,
        .card h2,
        .card h3,
        .card h5 {
            transition: all 0.3s ease-in-out;
        }

        /* Optional: Add card content animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-body {
            animation: fadeIn 0.5s ease-out forwards;
        }

        /* Class khusus untuk hover saat ajax */
        .card-active-hover {
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="header d-flex align-items-center justify-content-between w-100 p-3">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('img/logo-rsui.png') }}" alt="logoRSUI" style="width: 35px; height: auto;">
                <h5 class="mb-0">Monitor Ruang Operasi</h5>
            </div>
            <h5 class="mb-0" id="tanggal-hari"></h5>
        </div>

        <div class="row justify-content-center">
            @foreach ($rooms as $room)
                <div class="col-md-4 mt-4">
                    <div class="card card-bg-{{ $loop->iteration }} card-{{$room->is_active ? "active" : "disabled" }}" id="card-{{ $room->id }}">
                        <div class="indicator-wrapper">
                            <h2 class="indicator-text" id="indicatorText{{ $room->id }}">
                                {{ $room->is_active ? '' : '(Maintenance)' }}
                            </h2>
                            <div class="indicator-status {{ $room->is_active ? 'active' : 'maintenance' }}" id="indicatorStatus{{ $room->id }}"></div>
                        </div>
                        <div class="card-body">
                            <div class="room-info">
                                <h2 class="nama-ruangan" id="roomName{{ $room->nama_ruangan }}">{{ $room->nama_ruangan }}</h2>
                                <h2 class="nama-operator" id="operatorName{{ $room->nama_ruangan }}">{{ $room->nama_operator  }}</h2>
                            </div>
                            <h1 class="text-center" id="responseMessage{{ $room->id }}">{{ $room->status_operasi }}
                            </h1>
                            <h5 class="text-center" id="updatedTime{{ $room->id }}">Diperbarui Sejak:
                                {{ \Carbon\Carbon::parse($room->updated_at)->format('d/m/Y H:i:s') }} </h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        function updateClock() {
            const now = new Date();
            const day = String(now.getDate()).padStart(2, '0');
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const year = now.getFullYear();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');

            const formattedTime = `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
            document.getElementById('tanggal-hari').innerHTML = formattedTime;
        }

        // Update setiap detik
        setInterval(updateClock, 1000);
        // Panggil sekali untuk menghindari delay 1 detik pertama
        updateClock();

        function toTitleCase(str) {
            return str
                .toLowerCase() // Ubah semua huruf menjadi huruf kecil terlebih dahulu
                .split(' ') // Pisahkan string berdasarkan spasi
                .map(word => word.charAt(0).toUpperCase() + word.slice(1)) // Ubah huruf pertama menjadi besar
                .join(' '); // Gabungkan kembali menjadi string dengan spasi
        }

        document.addEventListener('DOMContentLoaded', function() {
            const rooms = @json($rooms); // Data Laravel

            // Loop melalui setiap room dan atur listener Echo
            rooms.forEach(room => {
                console.log(room.id);

                // Ambil elemen messages berdasarkan ID room
                const elementRoomName = document.getElementById(`roomName${room.nama_ruangan}`);
                const elementOperatorName = document.getElementById(`operatorName${room.nama_ruangan}`);
                const elementStatusKamar = document.getElementById(`responseMessage${room.id}`);
                const elementUpdatedTime = document.getElementById(`updatedTime${room.id}`);
                const elementIndicatorText = document.getElementById(`indicatorText${room.id}`);
                const elementIndicatorStatus = document.getElementById(`indicatorStatus${room.id}`);
                const elementCard = document.getElementById(`card-${room.id}`);

                // Pastikan elemen ditemukan
                if (!elementStatusKamar) {
                    console.error(`Element for room ${room.id} not found!`);
                    return; // Hentikan jika elemen tidak ditemukan
                }

                // Set listener untuk setiap channel Echo
                Echo.channel(`display-channel-${room.id}`)
                    .listen('RealTimeDisplay', (e) => {
                        console.log(`Message received for room ${room.id}:`, e);

                        // Buat elemen pesan baru
                        elementStatusKamar.innerHTML = `${toTitleCase(e.status)}`;
                        elementOperatorName.innerHTML = e.operatorName;
                        elementUpdatedTime.innerHTML = `Diperbarui Sejak: ${e.updatedAt}`;
                        elementRoomName.innerHTML = e.roomName;
                        elementIndicatorText.innerHTML = e.roomIsActive;
                        elementIndicatorText.innerHTML = e.roomIsActive  ? '' : '(Maintenance)';
                        if (e.roomIsActive) {
                            elementIndicatorStatus.classList.remove('maintenance');
                            elementIndicatorStatus.classList.add('active');
                            elementCard.classList.remove('card-disabled');
                            elementCard.classList.add('card-active');
                        } else {
                            elementIndicatorStatus.classList.remove('active');
                            elementIndicatorStatus.classList.add('maintenance');
                            elementCard.classList.remove('card-active');
                            elementCard.classList.add('card-disabled');
                        }

                        elementCard.classList.add('card-active-hover');
                        // Hapus class hover setelah 3 detik
                        setTimeout(() => {
                            elementCard.classList.remove('card-active-hover');
                        }, 3000); // 3000ms = 3 detik
                    });
            });
        });

        function tampilkanHariTanggal() {
            // Membuat objek Date untuk mendapatkan tanggal dan waktu sekarang
            const sekarang = new Date();

            // Array untuk nama hari (0 untuk Minggu, 1 untuk Senin, dst.)
            const namaHari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];

            // Array untuk nama bulan (0 untuk Januari, 1 untuk Februari, dst.)
            const namaBulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September",
                "Oktober", "November", "Desember"
            ];

            // Mengambil komponen tanggal
            const hari = sekarang.getDay(); // Mengambil hari (0-6)
            const tanggal = sekarang.getDate(); // Mengambil tanggal (1-31)
            const bulan = sekarang.getMonth(); // Mengambil bulan (0-11)
            const tahun = sekarang.getFullYear(); // Mengambil tahun

            // Format teks untuk ditampilkan
            const teksTanggal = `${namaHari[hari]}, ${tanggal} ${namaBulan[bulan]} ${tahun}`;

            // Menampilkan teks tanggal ke elemen dengan id 'tanggal-hari'
            document.getElementById("tanggal-hari").innerHTML = teksTanggal;
        }

        // Fungsi untuk mengubah status operasi
        // function ubahStatus(id, statusBaru) {
        //     document.getElementById(id).innerHTML = statusBaru;
        // }

        // Fungsi untuk memperbarui status di semua kartu
        // function updateSemuaStatus() {
        //     ubahStatus("status1", "Selesai Operasi");
        //     ubahStatus("status2", "Dalam Persiapan");
        //     ubahStatus("status3", "Operasi Ditunda");
        //     ubahStatus("status4", "Pasien Siap");
        //     ubahStatus("status5", "Menunggu Dokter");
        //     ubahStatus("status6", "Ruang Siap");
        // }

        // Memanggil fungsi saat halaman selesai dimuat
        // window.onload = function() {
        //     tampilkanHariTanggal(); // Memperbarui tanggal dan hari sesuai dengan hari ini
        //     // updateSemuaStatus(); // Memperbarui status pada setiap kartu
        // }
    </script>

</body>

</html>
