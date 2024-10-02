<?php
require_once 'vendor/econea/nusoap/src/nusoap.php'; // Gunakan autoload dari composer atau sertakan file nusoap.php jika tanpa composer

// Inisialisasi client dengan URL dari server
$client = new nusoap_client('http://localhost/NuSoap/server.php?wsdl', true);

// Cek apakah ada error pada inisialisasi
$error = $client->getError();
if ($error) {
    echo "Constructor error: $error";
    exit();
}

// Lakukan pemanggilan fungsi penjumlahan
$result = $client->call('penjumlahan', array('num1' => 5, 'num2' => 3));

// Cek apakah ada error dalam pemanggilan
if ($client->fault) {
    echo "Fault: <pre>" . print_r($result, true) . "</pre>";
} else {
    $error = $client->getError();
    if ($error) {
        echo "Error: $error";
    } else {
        echo "Hasil penjumlahan: " . $result;
    }
}
?>
