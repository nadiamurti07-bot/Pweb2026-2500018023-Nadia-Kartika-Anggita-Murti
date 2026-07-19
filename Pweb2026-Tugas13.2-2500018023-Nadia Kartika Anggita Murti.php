<?php
/* ============================================================
   TUGAS TEMU 13 - PWEB
   Aplikasi: Sistem Manajemen Data Barang Toko
   Konsep yang diterapkan: Array Asosiatif, Array Multidimensi,
   Function (dengan parameter, default value, return value),
   foreach, sorting, searching, filtering
   ============================================================ */

// ------------------------------------------------------------
// 1. DATA BARANG (Array Multidimensi / Array Asosiatif)
// ------------------------------------------------------------
$dataBarang = [
    ["kode" => "B001", "nama" => "Beras 5kg",     "harga" => 65000, "stok" => 25],
    ["kode" => "B002", "nama" => "Minyak Goreng 2L","harga" => 32000, "stok" => 8],
    ["kode" => "B003", "nama" => "Gula Pasir 1kg", "harga" => 15000, "stok" => 40],
    ["kode" => "B004", "nama" => "Telur 1kg",      "harga" => 28000, "stok" => 5],
    ["kode" => "B005", "nama" => "Kopi Sachet",    "harga" => 2000,  "stok" => 150],
    ["kode" => "B006", "nama" => "Mie Instan",     "harga" => 3500,  "stok" => 3],
];

// ------------------------------------------------------------
// 2. FUNCTION - format rupiah
// ------------------------------------------------------------
function formatRupiah($angka) {
    return "Rp " . number_format($angka, 0, ",", ".");
}

// ------------------------------------------------------------
// 3. FUNCTION - hitung total nilai stok (harga x stok semua barang)
// ------------------------------------------------------------
function hitungTotalNilaiStok($barang) {
    $total = 0;
    foreach ($barang as $item) {
        $total += $item["harga"] * $item["stok"];
    }
    return $total;
}

// ------------------------------------------------------------
// 4. FUNCTION - cari barang berdasarkan kode (searching dalam array)
// ------------------------------------------------------------
function cariBarang($barang, $kode) {
    foreach ($barang as $item) {
        if ($item["kode"] === $kode) {
            return $item;
        }
    }
    return null; // tidak ditemukan
}

// ------------------------------------------------------------
// 5. FUNCTION - filter barang dengan stok menipis
//    (default batas minimal = 10, bisa diubah saat pemanggilan)
// ------------------------------------------------------------
function filterStokMenipis($barang, $batasMinimal = 10) {
    $hasil = [];
    foreach ($barang as $item) {
        if ($item["stok"] < $batasMinimal) {
            $hasil[] = $item;
        }
    }
    return $hasil;
}

// ------------------------------------------------------------
// 6. FUNCTION - urutkan barang berdasarkan harga (ascending/descending)
//    memanfaatkan usort() dengan callback function
// ------------------------------------------------------------
function urutkanBerdasarkanHarga($barang, $urutan = "asc") {
    usort($barang, function ($a, $b) use ($urutan) {
        if ($urutan === "asc") {
            return $a["harga"] <=> $b["harga"];
        } else {
            return $b["harga"] <=> $a["harga"];
        }
    });
    return $barang;
}

// ------------------------------------------------------------
// 7. FUNCTION - tambah barang baru ke array (return array baru)
// ------------------------------------------------------------
function tambahBarang($barang, $kode, $nama, $harga, $stok) {
    $barang[] = [
        "kode"  => $kode,
        "nama"  => $nama,
        "harga" => $harga,
        "stok"  => $stok
    ];
    return $barang;
}

// Contoh pemakaian function tambahBarang()
$dataBarang = tambahBarang($dataBarang, "B007", "Sabun Mandi", 5000, 60);

?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Sistem Manajemen Data Barang Toko</title>
<style>
    body { font-family: Arial, sans-serif; margin: 30px; background: #f4f6f8; color: #222; }
    h1 { color: #1a3d7c; }
    h2 { margin-top: 40px; color: #1a3d7c; border-bottom: 2px solid #1a3d7c; padding-bottom: 5px; }
    table { border-collapse: collapse; width: 100%; margin-top: 10px; background: #fff; }
    th, td { border: 1px solid #ccc; padding: 8px 12px; text-align: left; }
    th { background: #1a3d7c; color: #fff; }
    tr:nth-child(even) { background: #f0f0f0; }
    .stok-menipis { color: #d9534f; font-weight: bold; }
    .box { background: #fff; padding: 15px 20px; border-left: 5px solid #1a3d7c; margin-top: 10px; }
</style>
</head>
<body>

<h1>Sistem Manajemen Data Barang Toko</h1>
<p>Contoh penerapan <strong>array</strong> dan <strong>function</strong> PHP dalam aplikasi nyata.</p>

<h2>1. Seluruh Data Barang</h2>
<table>
    <tr>
        <th>Kode</th><th>Nama Barang</th><th>Harga</th><th>Stok</th>
    </tr>
    <?php foreach ($dataBarang as $item): ?>
    <tr>
        <td><?= $item["kode"] ?></td>
        <td><?= $item["nama"] ?></td>
        <td><?= formatRupiah($item["harga"]) ?></td>
        <td><?= $item["stok"] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<h2>2. Total Nilai Seluruh Stok</h2>
<div class="box">
    Total nilai stok seluruh barang: <strong><?= formatRupiah(hitungTotalNilaiStok($dataBarang)) ?></strong>
</div>

<h2>3. Pencarian Barang (Kode: B004)</h2>
<div class="box">
<?php
$cari = cariBarang($dataBarang, "B004");
if ($cari) {
    echo "Ditemukan: <strong>{$cari['nama']}</strong> - Harga: " . formatRupiah($cari['harga']) . " - Stok: {$cari['stok']}";
} else {
    echo "Barang tidak ditemukan.";
}
?>
</div>

<h2>4. Barang dengan Stok Menipis (Batas &lt; 10)</h2>
<table>
    <tr><th>Kode</th><th>Nama Barang</th><th>Stok</th></tr>
    <?php foreach (filterStokMenipis($dataBarang, 10) as $item): ?>
    <tr>
        <td><?= $item["kode"] ?></td>
        <td><?= $item["nama"] ?></td>
        <td class="stok-menipis"><?= $item["stok"] ?> (segera restock!)</td>
    </tr>
    <?php endforeach; ?>
</table>

<h2>5. Barang Diurutkan Berdasarkan Harga (Termurah &rarr; Termahal)</h2>
<table>
    <tr><th>Kode</th><th>Nama Barang</th><th>Harga</th></tr>
    <?php foreach (urutkanBerdasarkanHarga($dataBarang, "asc") as $item): ?>
    <tr>
        <td><?= $item["kode"] ?></td>
        <td><?= $item["nama"] ?></td>
        <td><?= formatRupiah($item["harga"]) ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<h2>6. Barang Baru Ditambahkan (via function tambahBarang())</h2>
<div class="box">
    Barang terakhir: <strong><?= end($dataBarang)["nama"] ?></strong> berhasil ditambahkan ke daftar dengan kode <?= end($dataBarang)["kode"] ?>.
</div>

</body>
</html>
