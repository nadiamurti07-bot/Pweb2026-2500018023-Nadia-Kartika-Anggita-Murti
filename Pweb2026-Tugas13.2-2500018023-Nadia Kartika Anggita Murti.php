<?php
$nilai = 80;

if ($nilai >= 80 && $nilai <= 100) {
    $huruf = "A";
} elseif ($nilai >= 65 && $nilai < 80) {
    $huruf = "B";
} elseif ($nilai >= 50 && $nilai < 65) {
    $huruf = "C";
} elseif ($nilai >= 25 && $nilai < 50) {
    $huruf = "D";
} elseif ($nilai >= 0 && $nilai < 25) {
    $huruf = "E";
} else {
    $huruf = "Nilai tidak valid";
}

echo "Nilai Anda $nilai, Nilai Huruf Anda adalah $huruf";
?>
