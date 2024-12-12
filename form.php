<!DOCTYPE html>
<html>
<head>
    <title>PustakaStats UMRAH</title>
    <link rel="stylesheet" href="CSS/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> 
</head>
<body>
    <style>
        /* General body styling */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f9;
    color: #333;
}

/* Header styling */
header {
    background-color: #007bff;
    color: white;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 5px 10px; /* Mengurangi padding untuk memperkecil ukuran header */
    position: fixed;
    top: 0;
    width: 100%;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    z-index: 1000;
    height: 53px; /* Memberikan tinggi tetap lebih kecil untuk header */
}

header h1 {
    margin: 0;
    font-size: 1.7em; /* Memperbesar ukuran teks */
}

header h1 img {
    height: 50px; /* Memperkecil logo */
    margin-right: 5px;
}

h1 {
    text-align: center;
    background-color: #007bff;
    color: white;
    padding: 10px 0;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

h1 img {
    max-height: 80px;
    margin-right: 15px;
}

h2 {
    color: #007bff;
    margin-left: 20px;
}

ul {
    list-style-type: none;
    padding: 0;
}

li {
    background-color: #ffffff;
    margin: 10px 20px;
    padding: 10px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
}

li i {
    margin-right: 10px;
    color: rgb(255, 255, 255); 
}

li a {
    text-decoration: none;
    color: #333;
    flex-grow: 1;
}

li:hover a {
    color: #003366; /* Dark blue */
}

/* Sidebar styling */
.sidebar {
    width: 250px;
    background-color: #1e90ff; /* Mengubah warna kolom sidebar */
    color: white;
    height: 100vh;
    display: flex;
    flex-direction: column;
    padding: 0;
    position: fixed;
    transform: translateX(0);
    transition: transform 0.3s ease-in-out;
    padding-top: 80px; /* Tambahkan padding agar menu mulai di bawah header */
}

.sidebar-collapsed {
    transform: translateX(-250px);
}

.sidebar h2 {
    text-align: center;
    padding: 20px 0;
    margin: 0;
    font-size: 1; /* Mengurangi ukuran font sidebar */
    background-color: #1e90ff; /* Warna lebih gelap untuk header sidebar */
    border-bottom: 1px solid #104e8b;
}

.sidebar ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}

.sidebar ul li {
    padding: 15px 20px;
    border-bottom: 1px solid #104e8b;
    cursor: pointer;
    transition: background-color 0.3s ease, color 0.3s ease;
    background-color: #1e90ff; /* Warna dasar menu sidebar */
    color: #fff;
    display: flex; /* Menyusun ikon dan teks secara horizontal */
    align-items: center;
}

.sidebar ul li i {
    margin-right: 10px; /* Memberikan jarak antara ikon dan teks */
    font-size: 1em;
    color: white; /* Warna ikon default */
    transition: color 0.3s ease; /* Animasi transisi warna ikon */
}

.sidebar ul li:hover {
    background-color: #ffe83a; /* Warna hover menu sidebar */
    color: #0f3c68; /* Warna teks saat hover */
}

.sidebar ul li:hover i {
    color: #0f3c68; /* Warna ikon saat hover */
}

.sidebar ul li a {
    text-decoration: none;
    color: inherit; /* Warna teks mengikuti warna elemen induk */
    flex-grow: 1; /* Membuat teks memenuhi ruang yang tersedia */
    transition: color 0.3s ease; /* Animasi transisi warna teks */
}

.sidebar ul li:hover a {
    color: #0f3c68; /* Warna teks saat hover */
}


        /* Content styling */
        .content {
            margin-left: 250px;
            padding: 20px;
            padding-top: 80px; /* Ensure no overlap with header */
        }

        /* Form container styling */
        .form-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 15px;
            margin-bottom: 20px;
            max-width: 600px; /* Set a max-width to reduce the width */
            margin-left: auto;  /* Center the form horizontally */
            margin-right: auto; /* Center the form horizontally */
        }

        .form-container h2 {
            text-align: center;
            color: #333;
            margin-bottom: 15px;
        }

        .form-container label {
            display: block;
            margin-bottom: 1px;
            font-weight: bold;
            color: #555;
        }

        .form-container input, .form-container select, .form-container button {
            width: 100%;
            padding: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 15px;
        }

        .form-container input:focus, .form-container select:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 4px rgba(0, 123, 255, 0.5);
        }

        .form-container button {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }

        .form-container button:active {
            background-color: #004085;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <h1>
            <img src="UMRAH.png" alt="">
            PustakaStats UMRAH
        </h1>
    </header>

    <aside class="sidebar">
        <ul>
            <li><i class="fas fa-home"></i><a href="index.php">kembali</a></li>
        </ul>
    </aside>
<head>
    <!-- Main Content -->
    <div class="content">
        <!-- Form 1 -->
        <div class="form-container">
            <form action="proses.php" method="post">
                <h2>Data Pengunjung</h2>
                <label for="nama_pengunjung">Nama:</label>
                <input type="text" id="nama_pengunjung" name="nama_pengunjung" required>

                <label for="fakultas_pengunjung">Fakultas:</label>
                <select id="fakultas_pengunjung" name="fakultas_pengunjung">
                    <option>FKIP</option>
                    <option>FISIP</option>
                    <option>FEBM</option>
                    <option>FIKP</option>
                    <option>FTTK</option>
                </select>

                <label for="prodi_pengunjung">Prodi:</label>
                <input type="text" id="prodi_pengunjung" name="prodi_pengunjung" required>

                <button type="submit" name="submit_pengunjung">Simpan Pengunjung</button>
            </form>
        </div>

        <!-- Form 2 -->
        <div class="form-container">
            <form action="proses.php" method="post">
                <h2>Data Peminjaman</h2>
                <label for="nama_peminjam">Nama:</label>
                <input type="text" id="nama_peminjam" name="nama_peminjam" required>

                <label for="fakultas_peminjam">Fakultas:</label>
                <select id="fakultas_peminjam" name="fakultas_peminjam">
                    <option>FKIP</option>
                    <option>FISIP</option>
                    <option>FEBM</option>
                    <option>FIKP</option>
                    <option>FTTK</option>
                </select>

                <label for="prodi_peminjam">Prodi:</label>
                <input type="text" id="prodi_peminjam" name="prodi_peminjam" required>

                <label for="buku">Buku:</label>
                <input type="text" id="buku" name="buku" required>

                <button type="submit" name="submit_peminjaman">Simpan Peminjaman</button>
            </form>
        </div>
    </div>
</body>
</html>

