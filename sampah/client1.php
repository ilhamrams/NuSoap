<?php
require_once 'vendor/econea/nusoap/src/nusoap.php'; // Gunakan autoload dari composer atau sertakan file nusoap.php jika tanpa composer

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil input dari form
    $num1 = isset($_POST['num1']) ? (int)$_POST['num1'] : 0;
    $num2 = isset($_POST['num2']) ? (int)$_POST['num2'] : 0;

    // Inisialisasi client dengan URL dari server
    $client = new nusoap_client('http://localhost/NuSoap/server.php?wsdl', true);

    // Cek apakah ada error pada inisialisasi
    $error = $client->getError();
    if ($error) {
        echo "Constructor error: $error";
        exit();
    }

    // Lakukan pemanggilan fungsi penjumlahan
    $result = $client->call('penjumlahan', array('num1' => $num1, 'num2' => $num2));

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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penjumlahan SOAP</title>
</head>
<body>
    <h2>Input Angka untuk Penjumlahan</h2>
    <form method="post" action="">
        <label for="num1">Angka Pertama:</label>
        <input type="number" name="num1" id="num1" required>
        <br><br>
        <label for="num2">Angka Kedua:</label>
        <input type="number" name="num2" id="num2" required>
        <br><br>
        <input type="submit" value="Hitung Penjumlahan">
    </form>

    <?php if (isset($result)): ?>
        <h3>Hasil: <?php echo $result; ?></h3>
    <?php endif; ?>
</body>
</html>
