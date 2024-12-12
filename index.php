<?php
include 'koneksi.php';

// Mengambil data jumlah pengunjung dan peminjam per prodi
$query = "
    SELECT prodi, 
           COUNT(CASE WHEN fakultas IS NOT NULL THEN 1 END) AS jumlah_pengunjung,
           COUNT(CASE WHEN buku IS NOT NULL THEN 1 END) AS jumlah_peminjam
    FROM (
        SELECT prodi, fakultas, NULL AS buku FROM pengunjung
        UNION ALL
        SELECT prodi, fakultas, buku FROM peminjaman
    ) AS gabungan
    GROUP BY prodi
";

$result = $conn->query($query);
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Menyiapkan data untuk grafik
$prodi = array_column($data, 'prodi');
$pengunjung = array_column($data, 'jumlah_pengunjung');
$peminjam = array_column($data, 'jumlah_peminjam');

$query = "
    SELECT fakultas, 
           COUNT(CASE WHEN fakultas IS NOT NULL AND buku IS NULL THEN 1 END) AS jumlah_pengunjung,
           COUNT(CASE WHEN buku IS NOT NULL THEN 1 END) AS jumlah_peminjam
    FROM (
        SELECT fakultas, NULL AS buku FROM pengunjung
        UNION ALL
        SELECT fakultas, buku FROM peminjaman
    ) AS gabungan
    GROUP BY fakultas
";

$resultFakultas = $conn->query($query);
$dataFakultas = [];
while ($row = $resultFakultas->fetch_assoc()) {
    $dataFakultas[] = $row;
}

$fakultas = array_column($dataFakultas, 'fakultas');
$pengunjungFakultas = array_column($dataFakultas, 'jumlah_pengunjung');
$peminjamFakultas = array_column($dataFakultas, 'jumlah_peminjam');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Analisis Perpustakaan</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        h1 {
            text-align: center;
            background-color: #007bff;
            color: white;
            padding: 15px 0;
            margin: 0;
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
        }

        .chart-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 20px 0;
        }

        .chart-container canvas {
            max-width: 600px;
            margin: 0 auto;
        }

        .content-section {
            margin: 20px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        footer {
            text-align: center;
            padding: 10px 0;
            background-color: #007bff;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <h1>Analisis Perpustakaan</h1>

    <div class="content-section">
    <button onclick="window.location.href='form.php'">Tambah Data</button>
    <button onclick="window.location.href='apriori.php'">Algoritma Apriori</button>
        <h2>Analisis Kunjungan dan Peminjaman Berdasarkan Prodi</h2>

        <div class="chart-container">
            <canvas id="grafikProdi" width="400" height="200"></canvas>
        </div>

        <h2>Data Analisis Berdasarkan Prodi</h2>
        <ul>
            <?php foreach ($data as $row): ?>
                <li>
                    Prodi: <?php echo $row['prodi']; ?> - 
                    Pengunjung: <?php echo $row['jumlah_pengunjung']; ?>, 
                    Peminjam: <?php echo $row['jumlah_peminjam']; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="content-section">
        <h2>Analisis Kunjungan dan Peminjaman Berdasarkan Fakultas</h2>

        <div class="chart-container">
            <canvas id="grafikFakultas" width="400" height="200"></canvas>
        </div>

        <h2>Data Analisis Berdasarkan Fakultas</h2>
        <ul>
            <?php foreach ($dataFakultas as $row): ?>
                <li>
                    Fakultas: <?php echo $row['fakultas']; ?> - 
                    Pengunjung: <?php echo $row['jumlah_pengunjung']; ?>, 
                    Peminjam: <?php echo $row['jumlah_peminjam']; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <footer>
        &copy; 2024 Analisis Perpustakaan
    </footer>

    <script>
        var ctxProdi = document.getElementById('grafikProdi').getContext('2d');
        var chartProdi = new Chart(ctxProdi, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($prodi); ?>,
                datasets: [
                    {
                        label: 'Jumlah Pengunjung',
                        data: <?php echo json_encode($pengunjung); ?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Jumlah Peminjam',
                        data: <?php echo json_encode($peminjam); ?>,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var ctxFakultas = document.getElementById('grafikFakultas').getContext('2d');
        var chartFakultas = new Chart(ctxFakultas, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($fakultas); ?>,
                datasets: [
                    {
                        label: 'Jumlah Pengunjung',
                        data: <?php echo json_encode($pengunjungFakultas); ?>,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Jumlah Peminjam',
                        data: <?php echo json_encode($peminjamFakultas); ?>,
                        backgroundColor: 'rgba(153, 102, 255, 0.6)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>