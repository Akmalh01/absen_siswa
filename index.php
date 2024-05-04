<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Absensi Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        td:last-child {
            text-align: center;
        }
        .detail-button {
            padding: 8px 12px;
            background-color: #1d4ed8; /* Warna biru */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .delete-button {
            padding: 8px 12px;
            background-color: #b91c1c; /* Warna merah */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .detail-button:hover {
            background-color: #3b82f6; /* Warna biru saat hover */
        }
        .delete-button:hover {
            background-color: #ef4444; /* Warna merah saat hover */
        }
        .delete-link {
            color: red;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Data Absensi Siswa</h2>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>NIS</th>
                    <th>Kelas</th>
                    <th>Hari</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Detail</th>
                    <th>Hapus</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Baca file JSON
                $file = file_get_contents('siswa.json');
                $data = json_decode($file, true);

                // Loop melalui data dan tampilkan dalam tabel
                foreach ($data['records'] as $index => $siswa) {
                    echo "<tr>";
                    echo "<td>" . $siswa['nama'] . "</td>";
                    echo "<td>" . $siswa['nis'] . "</td>";
                    echo "<td>" . $siswa['kelas'] . "</td>";
                    echo "<td>" . $siswa['hari'] . "</td>";
                    echo "<td>" . $siswa['tanggal'] . "</td>";
                    echo "<td>" . $siswa['keterangan'] . "</td>";

                    // Tampilkan detail berdasarkan keterangan
                    echo "<td>";
                    if ($siswa['keterangan'] === 'Hadir') {
                        echo "Jam Kehadiran: " . $siswa['jam'];
                    } elseif ($siswa['keterangan'] === 'Izin') {
                        echo '<button class="detail-button" onclick="showDetail(\''. $siswa['fileIzin'] .'\')">Lihat Surat Izin</button>';
                    } elseif ($siswa['keterangan'] === 'Sakit') {
                        echo '<button class="detail-button" onclick="showDetail(\''. $siswa['fileSakit'] .'\')">Lihat Surat Sakit</button>';
                    }
                    echo "</td>";

                    // Tambahkan tautan "Hapus" dengan mengirimkan indeks sebagai parameter
                    echo "<td><a class='delete-link' href='delete.php?index=$index'>Hapus</a></td>";

                    echo "</tr>";
                }
                ?>
            
            </tbody>
        </table>
    </div>

    <script>
        function showDetail(imagePath) {
            window.open(imagePath, '_blank');
        }
    </script>
</body>
</html>
