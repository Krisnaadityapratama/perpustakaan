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
    <title>PustakaStats UMRAH</title>
    <link rel="stylesheet" href="CSS/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> 
</head>
<body>
    <header>
        <h1>
            <img src="UMRAH.png" alt="Logo">
            PustakaStats UMRAH
        </h1>
    </header>

    <aside class="sidebar">
        <ul>
            <li><i class="fas fa-home"></i><a href="index.php">Beranda</a></li>
            <li><i class="fas fa-user-friends"></i><a href="form.php">Data Pengunjung & Peminjaman</a></li>
            <li><i class="fas fa-chart-bar"></i><a href="apriori.php">Algoritma Apriori</a></li>
            <li><i class="fas fa-info-circle"></i><a href="about.php">About</a></li>
        </ul>
    </aside>

    <!-- Main Content Section -->
    <main class="content">
        <!-- Prodi Analysis -->
        <div class="content-section">
            <h2>Analisis Kunjungan dan Peminjaman Berdasarkan Prodi</h2>
            <div class="chart-container">
                <canvas id="grafikProdi"></canvas>
            </div>
            <h3>Data Analisis Berdasarkan Prodi</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Prodi</th>
                            <th>Jumlah Pengunjung</th>
                            <th>Jumlah Peminjam</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $row): ?>
                            <tr>
                                <td><?php echo $row['prodi']; ?></td>
                                <td><?php echo $row['jumlah_pengunjung']; ?></td>
                                <td><?php echo $row['jumlah_peminjam']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Fakultas Analysis -->
        <div class="content-section">
            <h2>Analisis Kunjungan dan Peminjaman Berdasarkan Fakultas</h2>
            <div class="chart-container">
                <canvas id="grafikFakultas"></canvas>
            </div>
            <h3>Data Analisis Berdasarkan Fakultas</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Fakultas</th>
                            <th>Jumlah Pengunjung</th>
                            <th>Jumlah Peminjam</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dataFakultas as $row): ?>
                            <tr>
                                <td><?php echo $row['fakultas']; ?></td>
                                <td><?php echo $row['jumlah_pengunjung']; ?></td>
                                <td><?php echo $row['jumlah_peminjam']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Footer Section -->
    <footer>
        &copy; 2024 PustakaStats UMRAH
    </footer>

    <!-- Chart.js Script -->
    <script>
        // Data for Prodi Analysis
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

        // Data for Fakultas Analysis
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
