<?php
if (!empty($_POST)) {
    // Baca tipe keterangan
    $keterangan = $_POST['keterangan'];

    // Menyiapkan data untuk disimpan dalam file JSON
    $new_entry = [
        "nama" => $_POST['nama'],
        "nis" => $_POST['nis'],
        "kelas" => $_POST['kelas'],
        "hari" => $_POST['hari'],
        "tanggal" => $_POST['tanggal'],
        "keterangan" => $keterangan
    ];

    // Jika siswa hadir, simpan jam kehadiran
    if ($keterangan === 'Hadir') {
        $new_entry['jam'] = isset($_POST['jam']) ? $_POST['jam'] : '';
    }
    // Jika siswa sakit, simpan file surat sakit
    elseif ($keterangan === 'Sakit') {
        $allowed_extensions = array('jpg', 'jpeg', 'png');
        $upload_dir = 'uploads/';
        $gambar = $_FILES['fileSakit']['name'];
        $gambar_temp = $_FILES['fileSakit']['tmp_name'];
        $gambar_path = $upload_dir . basename($gambar);
        $file_extension = strtolower(pathinfo($gambar_path, PATHINFO_EXTENSION));

        // Pemeriksaan ekstensi file
        if (!in_array($file_extension, $allowed_extensions)) {
            echo "Hanya file JPG, JPEG, dan PNG yang diizinkan.";
            exit();
        }

        // Pindahkan file yang diunggah ke lokasi penyimpanan yang ditentukan
        if (!move_uploaded_file($gambar_temp, $gambar_path)) {
            echo "Gagal mengunggah file.";
            exit();
        }

        $new_entry['fileSakit'] = $gambar_path;
    }
    // Jika siswa izin, simpan file surat izin
    elseif ($keterangan === 'Izin') {
        $allowed_extensions = array('jpg', 'jpeg', 'png');
        $upload_dir = 'uploads/';
        $gambar = $_FILES['fileIzin']['name'];
        $gambar_temp = $_FILES['fileIzin']['tmp_name'];
        $gambar_path = $upload_dir . basename($gambar);
        $file_extension = strtolower(pathinfo($gambar_path, PATHINFO_EXTENSION));

        // Pemeriksaan ekstensi file
        if (!in_array($file_extension, $allowed_extensions)) {
            echo "Hanya file JPG, JPEG, dan PNG yang diizinkan.";
            exit();
        }

        // Pindahkan file yang diunggah ke lokasi penyimpanan yang ditentukan
        if (!move_uploaded_file($gambar_temp, $gambar_path)) {
            echo "Gagal mengunggah file.";
            exit();
        }

        $new_entry['fileIzin'] = $gambar_path;
    }

    // Baca file JSON
    $file = file_get_contents('siswa.json');
    $data = json_decode($file, true);

    // Tambahkan data baru ke dalam array records
    $data["records"][] = $new_entry;

    // Simpan kembali data ke dalam file JSON
    file_put_contents("siswa.json", json_encode($data));

    // Redirect ke halaman utama
    header("Location: index.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Absensi Siswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Form Absensi Siswa</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="nis">NIS:</label>
                <input type="text" id="nis" name="nis" required>
            </div>
            <div class="form-group">
                <label for="kelas">Kelas:</label>
                <select id="kelas" name="kelas" required>
                    <option value="">Pilih Kelas</option>
                    <option value="X">X</option>
                    <option value="XI">XI</option>
                    <option value="XII">XII</option>
                </select>
            </div>
            <div class="form-group">
                <label for="hari">Hari:</label>
                <input type="text" id="hari" name="hari" required>
            </div>
            <div class="form-group">
                <label for="tanggal">Tanggal:</label>
                <input type="date" id="tanggal" name="tanggal" required>
            </div>
            <div class="form-group">
                <label for="keterangan">Keterangan:</label>
                <select id="keterangan" name="keterangan" onchange="showInput(this.value)" required>
                    <option value="">Pilih Keterangan</option>
                    <option value="Hadir">Hadir</option>
                    <option value="Sakit">Sakit</option>
                    <option value="Izin">Izin</option>
                </select>
            </div>
            <div id="jamHadir" style="display: none;" class="form-group">
                <label for="jam">Jam Kehadiran:</label>
                <input type="time" id="jam" name="jam">
            </div>
            <div id="suratSakit" style="display: none;" class="form-group">
                <label for="fileSakit">File Surat Sakit:</label>
                <input type="file" id="fileSakit" name="fileSakit">
            </div>
            <div id="suratIzin" style="display: none;" class="form-group">
                <label for="fileIzin">File Surat Izin:</label>
                <input type="file" id="fileIzin" name="fileIzin">
            </div>
            <div class="form-group">
                <input type="submit" value="Submit">
            </div>
        </form>
    </div>

    <script>
        function showInput(keterangan) {
            var jamHadir = document.getElementById('jamHadir');
            var suratSakit = document.getElementById('suratSakit');
            var suratIzin = document.getElementById('suratIzin');

            if (keterangan === 'Hadir') {
                jamHadir.style.display = 'block';
                suratSakit.style.display = 'none';
                suratIzin.style.display = 'none';
            } else if (keterangan === 'Sakit') {
                jamHadir.style.display = 'none';
                suratSakit.style.display = 'block';
                suratIzin.style.display = 'none';
            } else if (keterangan === 'Izin') {
                jamHadir.style.display = 'none';
                suratSakit.style.display = 'none';
                suratIzin.style.display = 'block';
            } else {
                jamHadir.style.display = 'none';
                suratSakit.style.display = 'none';
                suratIzin.style.display = 'none';
            }
        }
    </script>
</body>
</html>
