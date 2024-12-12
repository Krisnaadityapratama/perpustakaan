<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;
            max-width: 400px;
        }

        .form-container h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .form-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        .form-container input, .form-container select, .form-container button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
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
            transition: background-color 0.3s ease;
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
</body>
</html>
