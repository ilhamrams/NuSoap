<?php
require_once 'vendor/econea/nusoap/src/nusoap.php'; // Pastikan path benar

// Buat instance dari nusoap_server
$server = new nusoap_server();

// Inisialisasi WSDL
$server->configureWSDL('MathWebService', 'urn:mathws');

// Registrasi fungsi penjumlahan
$server->register('penjumlahan', 
    array('num1' => 'xsd:int', 'num2' => 'xsd:int'),   // Parameter input
    array('return' => 'xsd:int'),                      // Tipe output
    'urn:mathws',                                      // Namespace
    'urn:mathws#penjumlahan',                          // SOAP action
    'rpc',                                             // Style
    'encoded',                                         // Encoding
    'Menghitung penjumlahan dua angka'                 // Documentation
);

// Registrasi fungsi pengurangan
$server->register('pengurangan', 
    array('num1' => 'xsd:int', 'num2' => 'xsd:int'),   // Parameter input
    array('return' => 'xsd:int'),                      // Tipe output
    'urn:mathws',                                      // Namespace
    'urn:mathws#pengurangan',                          // SOAP action
    'rpc',                                             // Style
    'encoded',                                         // Encoding
    'Menghitung pengurangan dua angka'                 // Documentation
);

// Definisi fungsi penjumlahan
function penjumlahan($num1, $num2) {
    return $num1 + $num2;
}

// Definisi fungsi pengurangan
function pengurangan($num1, $num2) {
    return $num1 - $num2;
}

// Tangani request
$server->service(file_get_contents("php://input"));
?>
