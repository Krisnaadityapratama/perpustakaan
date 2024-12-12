<?php
include 'koneksi.php';

// Mengambil data peminjaman per fakultas dan prodi
$result = $conn->query("SELECT fakultas, prodi, GROUP_CONCAT(buku) as buku FROM peminjaman GROUP BY fakultas, prodi");

$dataFakultasProdi = [];
while ($row = $result->fetch_assoc()) {
    $key = $row['fakultas'] . ' - ' . $row['prodi'];
    $dataFakultasProdi[$key] = explode(',', $row['buku']);
}

// Fungsi Apriori
function apriori($data, $minSupport, $minConfidence) {
    $patterns = [];
    $totalTransactions = count($data);

    // Hitung support awal
    foreach ($data as $transaction) {
        foreach ($transaction as $item) {
            if (!isset($patterns[$item])) {
                $patterns[$item] = 0;
            }
            $patterns[$item]++;
        }
    }

    // Filter support minimum
    $frequentPatterns = [];
    foreach ($patterns as $item => $count) {
        $support = $count / $totalTransactions;
        if ($support >= $minSupport) {
            $frequentPatterns[$item] = $support;
        }
    }

    return $frequentPatterns;
}

// Menjalankan algoritma per fakultas dan prodi
$minSupport = 0.5;
$minConfidence = 0.5;

echo '<!DOCTYPE html>';
echo '<html>';
echo '<head>';
echo '<title>Apriori Algorithm Results - PustakaStats UMRAH</title>';
echo '<link rel="stylesheet" href="CSS/styles2.css">';  
echo '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';
echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">';
echo '</head>';
echo '<body>';

echo '<header>';
echo '<h1>';
echo '<img src="UMRAH.png" alt="">';
echo 'PustakaStats UMRAH';
echo '</h1>';
echo '</header>';

echo '<aside class="sidebar">';
echo '<ul>';
echo '<li><i class="fas fa-home"></i><a href="index.php">Kembali</a></li>';
echo '</ul>';
echo '</aside>';

echo '<div class="content">';

foreach ($dataFakultasProdi as $key => $transactions) {
    echo "<h3>Fakultas dan Prodi: $key</h3>";

    $patterns = apriori([$transactions], $minSupport, $minConfidence);

    // Display patterns in a table
    echo '<table class="table-container">';
    echo '<thead>';
    echo '<tr><th>Pola</th><th>Support</th></tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach ($patterns as $item => $support) {
        echo "<tr><td>$item</td><td>" . number_format($support, 4) . "</td></tr>";
    }

    echo '</tbody>';
    echo '</table>';
    echo '<hr>';
}

echo '</div>';  // Close content div
echo '</body>';
echo '</html>';
?>
