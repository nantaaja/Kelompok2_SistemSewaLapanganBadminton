<?php
include 'koneksiDB.php';

$pesan = "";


$query_users = mysqli_query($koneksi, "SELECT id_user, nama_user FROM user WHERE role = 'customer' ORDER BY nama_user ASC");
$users = [];
if ($query_users) {
    while ($row = mysqli_fetch_assoc($query_users)) {
        $users[] = $row;
    }
}


$query_lapangan = mysqli_query($koneksi, "SELECT id_lapangan, nama_lapangan, harga FROM lapangan ORDER BY nama_lapangan ASC");
$lapangan_list = [];
if ($query_lapangan) {
    while ($row = mysqli_fetch_assoc($query_lapangan)) {
        $lapangan_list[] = $row;
    }
}


$query_jadwal = mysqli_query($koneksi, "SELECT id_jadwal, hari, jam_mulai, jam_berakhir FROM jadwal ORDER BY FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'), jam_mulai ASC");
$jadwal_list = [];
if ($query_jadwal) {
    while ($row = mysqli_fetch_assoc($query_jadwal)) {
        $jadwal_list[] = $row;
    }
}



if (isset($_POST['tambah_reservasi'])) {
    
    $id_user = mysqli_real_escape_string($koneksi, $_POST['id_user']);
    $id_lapangan = mysqli_real_escape_string($koneksi, $_POST['id_lapangan']);
    $id_jadwal = mysqli_real_escape_string($koneksi, $_POST['id_jadwal']);
    $tanggal_booking = mysqli_real_escape_string($koneksi, $_POST['tanggal_booking']);
    $durasi = mysqli_real_escape_string($koneksi, $_POST['durasi']);
    $status_reservasi = mysqli_real_escape_string($koneksi, $_POST['status_reservasi']);

    
    if (empty($id_user) || empty($id_lapangan) || empty($id_jadwal) || empty($tanggal_booking) || empty($durasi) || empty($status_reservasi)) {
        $pesan = "Mohon isi semua kolom yang wajib!";
    } elseif (!is_numeric($durasi) || $durasi <= 0) {
        $pesan = "Durasi harus angka positif!";
    } else {
        
        $query_harga = mysqli_query($koneksi, "SELECT harga FROM lapangan WHERE id_lapangan = '$id_lapangan'");
        $data_harga = mysqli_fetch_assoc($query_harga);

        if ($data_harga) {
            $harga_per_jam = $data_harga['harga'];
            $total_harga = $harga_per_jam * $durasi;

        
            $query_insert_reservasi = "INSERT INTO reservasi (id_user, id_lapangan, id_jadwal, tanggal_booking, durasi, total_harga, status_reservasi)
                                      VALUES ('$id_user', '$id_lapangan', '$id_jadwal', '$tanggal_booking', '$durasi', '$total_harga', '$status_reservasi')";

            if (mysqli_query($koneksi, $query_insert_reservasi)) {
                $pesan = "Reservasi berhasil ditambahkan!";
                
                header("Location: tampilReservasi.php?status=sukses_tambah");
                exit();
            } else {
                $pesan = "Gagal menambahkan reservasi: " . mysqli_error($koneksi);
            }
        } else {
            $pesan = "Lapangan tidak ditemukan atau harga tidak tersedia.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Reservasi</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4; }
        h2 { color: #333; }
        hr { border: 0; border-top: 1px solid #eee; margin: 20px 0; }
        table { background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); width: 60%; }
        td { padding: 8px; }
        input[type="text"], input[type="number"], input[type="date"], select {
            width: calc(100% - 20px); /* Adjust width to fit padding */
            padding: 8px; margin: 5px 0; border: 1px solid #ddd; border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;
        }
        input[type="submit"]:hover { background-color: #0056b3; }
        .pesan-info {
            padding: 10px; margin-bottom: 15px; border-radius: 5px;
            background-color: #ffe0b2; color: #e65100; border: 1px solid #ffcc80;
        }
        .pesan-error {
            padding: 10px; margin-bottom: 15px; border-radius: 5px;
            background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;
        }
        .kembali-link { display: block; margin-top: 20px; color: #007bff; text-decoration: none; }
        .kembali-link:hover { text-decoration: underline; }
    </style>
</head>
<body>

<h2>Tambah Reservasi</h2>
<hr>

<?php if (!empty($pesan)): ?>
    <p class="<?php echo (strpos($pesan, 'berhasil') !== false) ? 'pesan-info' : 'pesan-error'; ?>">
        <?php echo $pesan; ?>
    </p>
<?php endif; ?>

<form action="" method="post">
    <table>
        <tr>
            <td>User Pemesan</td>
            <td>:</td>
            <td>
                <select name="id_user" required>
                    <option value="">-- Pilih User --</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?php echo htmlspecialchars($user['id_user']); ?>">
                            <?php echo htmlspecialchars($user['nama_user']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Lapangan</td>
            <td>:</td>
            <td>
                <select name="id_lapangan" id="id_lapangan" required>
                    <option value="">-- Pilih Lapangan --</option>
                    <?php foreach ($lapangan_list as $lapangan): ?>
                        <option value="<?php echo htmlspecialchars($lapangan['id_lapangan']); ?>" data-harga="<?php echo htmlspecialchars($lapangan['harga']); ?>">
                            <?php echo htmlspecialchars($lapangan['nama_lapangan'] . ' (Rp ' . number_format($lapangan['harga'], 0, ',', '.') . ' / jam)'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Jadwal (Hari & Jam)</td>
            <td>:</td>
            <td>
                <select name="id_jadwal" required>
                    <option value="">-- Pilih Jadwal --</option>
                    <?php foreach ($jadwal_list as $jadwal): ?>
                        <option value="<?php echo htmlspecialchars($jadwal['id_jadwal']); ?>">
                            <?php echo htmlspecialchars($jadwal['hari'] . ', ' . date('H:i', strtotime($jadwal['jam_mulai'])) . ' - ' . date('H:i', strtotime($jadwal['jam_berakhir']))); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Tanggal Booking</td>
            <td>:</td>
            <td><input type="date" name="tanggal_booking" min="<?php echo date('Y-m-d'); ?>" required></td>
        </tr>
        <tr>
            <td>Durasi (Jam)</td>
            <td>:</td>
            <td><input type="number" name="durasi" id="durasi" min="1" value="1" required></td>
        </tr>
        <tr>
            <td>Total Harga</td>
            <td>:</td>
            <td>
                <span id="display_total_harga">Rp 0</span>
                </td>
        </tr>
        <tr>
            <td>Status Reservasi</td>
            <td>:</td>
            <td>
                <select name="status_reservasi" required>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="cancelled">Cancelled</option>
                    <option value="completed">Completed</option>
                    <option value="rejected">Rejected</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="3" align="center">
                <input type="submit" name="tambah_reservasi" value="Tambah Reservasi">
            </td>
        </tr>
    </table>
</form>

<br>
<a href="tampilReservasi.php" class="kembali-link">Kembali ke Daftar Reservasi</a>

<script>
    
    document.addEventListener('DOMContentLoaded', function() {
        const selectLapangan = document.getElementById('id_lapangan');
        const inputDurasi = document.getElementById('durasi');
        const displayTotalHarga = document.getElementById('display_total_harga');

        function hitungDanTampilkanHarga() {
            const selectedOption = selectLapangan.options[selectLapangan.selectedIndex];
            
            const hargaPerJam = parseFloat(selectedOption.getAttribute('data-harga')) || 0;
            const durasi = parseFloat(inputDurasi.value) || 0;

            const totalHarga = hargaPerJam * durasi;
            displayTotalHarga.textContent = 'Rp ' + totalHarga.toLocaleString('id-ID');
            
        }

        
        selectLapangan.addEventListener('change', hitungDanTampilkanHarga);
        inputDurasi.addEventListener('input', hitungDanTampilkanHarga);

        
        hitungDanTampilkanHarga();
    });
</script>

</body>
</html>