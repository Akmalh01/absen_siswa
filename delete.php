<?php
// Memeriksa apakah ada parameter indeks yang diterima dari URL
if (isset($_GET['index'])) {
    $index = $_GET['index'];
    deleteEntryByIndex($index);
    header("Location: index.php"); // Redirect kembali ke halaman utama setelah menghapus
    exit();
}

// Fungsi untuk menghapus entri berdasarkan indeks
function deleteEntryByIndex($index) {
    // Baca file JSON
    $file = file_get_contents('siswa.json');
    $data = json_decode($file, true);

    // Hapus entri berdasarkan indeks
    if (isset($data['records'][$index])) {
        unset($data['records'][$index]);

        // Simpan kembali data ke dalam file JSON
        file_put_contents("siswa.json", json_encode($data));
    }
}
?>
