<?php
session_start(); // Mulai session untuk menyimpan riwayat

require_once 'vendor/econea/nusoap/src/nusoap.php'; // Gunakan autoload dari composer atau sertakan file nusoap.php jika tanpa composer

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil input dari form
    $num1 = isset($_POST['num1']) ? (int)$_POST['num1'] : 0;
    $num2 = isset($_POST['num2']) ? (int)$_POST['num2'] : 0;
    $operation = isset($_POST['operation']) ? $_POST['operation'] : 'penjumlahan'; // Default ke penjumlahan

    // Inisialisasi client dengan URL dari server
    $client = new nusoap_client('http://localhost/NuSoap/server.php?wsdl', true);

    // Cek apakah ada error pada inisialisasi
    $error = $client->getError();
    if ($error) {
        echo "Constructor error: $error";
        exit();
    }

    // Lakukan pemanggilan fungsi sesuai operasi
    $result = $client->call($operation, array('num1' => $num1, 'num2' => $num2));

    // Cek apakah ada error dalam pemanggilan
    if ($client->fault) {
        echo "Fault: <pre>" . print_r($result, true) . "</pre>";
    } else {
        $error = $client->getError();
        if ($error) {
            echo "Error: $error";
        } else {
            // Simpan hasil ke dalam riwayat
            if (!isset($_SESSION['history'])) {
                $_SESSION['history'] = array();
            }

            $opSymbol = ($operation == 'penjumlahan') ? '+' : '-';
            $operationResult = "$num1 $opSymbol $num2 = $result";
            $_SESSION['history'][] = $operationResult;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penjumlahan dan Pengurangan SOAP</title>
</head>
<body>
    <h2>Input Angka untuk Penjumlahan atau Pengurangan</h2>
    <form method="post" action="">
        <label for="num1">Angka Pertama:</label>
        <input type="number" name="num1" id="num1" required>
        <br><br>
        <label for="num2">Angka Kedua:</label>
        <input type="number" name="num2" id="num2" required>
        <br><br>
        <label for="operation">Pilih Operasi:</label>
        <select name="operation" id="operation">
            <option value="penjumlahan">Penjumlahan</option>
            <option value="pengurangan">Pengurangan</option>
        </select>
        <br><br>
        <input type="submit" value="Hitung">
    </form>

    <?php if (isset($result)): ?>
        <h3>Hasil: <?php echo $operationResult; ?></h3>
    <?php endif; ?>

    <!-- Tampilkan riwayat -->
    <?php if (isset($_SESSION['history']) && count($_SESSION['history']) > 0): ?>
        <h3>Riwayat Operasi:</h3>
        <ul>
            <?php foreach ($_SESSION['history'] as $entry): ?>
                <li><?php echo $entry; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
