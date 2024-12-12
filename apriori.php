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

foreach ($dataFakultasProdi as $key => $transactions) {
    echo "<h3>Fakultas dan Prodi: $key</h3>";

    $patterns = apriori([$transactions], $minSupport, $minConfidence);

    foreach ($patterns as $item => $support) {
        echo "Pola: $item, Support: $support<br>";
    }
    echo "<hr>";
}
?>
