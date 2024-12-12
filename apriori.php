<?php
include 'koneksi.php';

// Mengambil data peminjaman
$result = $conn->query("SELECT fakultas, GROUP_CONCAT(buku) as buku FROM peminjaman GROUP BY fakultas");

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = explode(',', $row['buku']);
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

// Menjalankan algoritma
$minSupport = 0.5;
$patterns = apriori($data, $minSupport, 0.5);

foreach ($patterns as $item => $support) {
    echo "Pola: $item, Support: $support<br>";
}
?>
