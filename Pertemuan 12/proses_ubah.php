<?php
// Load file koneksi.php
include "koneksi.php";

// Ambil data ID yang dikirim oleh form_ubah.php melalui URL
$id = $_GET['id']; 

// Ambil Data yang Dikirim dari Form
$nis = $_POST['nis'];
$nama = $_POST['nama'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$telp = $_POST['telp'];
$alamat = $_POST['alamat'];

// Ambil data foto yang dipilih dari form
$foto = $_FILES['foto']['name'];
$tmp = $_FILES['foto']['tmp_name'];

// Cek apakah user ingin mengubah fotonya atau tidak
if (empty($foto)) { 
    // Jika user tidak memilih file foto pada form, update tanpa foto
    $sql = $pdo->prepare("UPDATE siswa SET nis=:nis, nama=:nama, jenis_kelamin=:jk, telp=:telp, alamat=:alamat WHERE id=:id");
    $sql->bindParam(':nis', $nis);
    $sql->bindParam(':nama', $nama);
    $sql->bindParam(':jk', $jenis_kelamin);
    $sql->bindParam(':telp', $telp);
    $sql->bindParam(':alamat', $alamat);
    $sql->bindParam(':id', $id);
    
    // Eksekusi query
    if ($sql->execute()) {
        header("location: index.php"); // Redirect ke halaman index.php
    } else {
        echo "Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data ke database.";
        echo "<br><a href='form_ubah.php'>Kembali Ke Form</a>";
    }
} else {
    // Jika user memilih foto, proses update termasuk mengganti foto
    $fotobaru = date('dmYHis') . $foto; // Rename foto dengan tanggal dan jam upload
    $path = "images/" . $fotobaru; // Set path folder tempat menyimpan foto

    // Proses upload foto
    var_dump($_FILES['foto']);
    if (move_uploaded_file($tmp, $path)) {
        // Ambil foto sebelumnya dari database
        $sql = $pdo->prepare("SELECT foto FROM siswa WHERE id=:id");
        $sql->bindParam(':id', $id);
        $sql->execute();
        $data = $sql->fetch(); // Ambil data foto sebelumnya
        
        // Cek apakah foto sebelumnya ada di folder images
        if (is_file("images/" . $data['foto'])) {
            unlink("images/" . $data['foto']); // Hapus foto sebelumnya
        }

        // Proses update data ke Database termasuk mengganti foto
        $sql = $pdo->prepare("UPDATE siswa SET nis=:nis, nama=:nama, jenis_kelamin=:jk, telp=:telp, alamat=:alamat, foto=:foto WHERE id=:id");
        $sql->bindParam(':nis', $nis);
        $sql->bindParam(':nama', $nama);
        $sql->bindParam(':jk', $jenis_kelamin);
        $sql->bindParam(':telp', $telp);
        $sql->bindParam(':alamat', $alamat);
        $sql->bindParam(':foto', $fotobaru);
        $sql->bindParam(':id', $id);
        
        // Eksekusi query
        if ($sql->execute()) {
            header("location: index.php"); // Redirect ke halaman index.php
        } else {
            echo "Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data ke database.";
            echo "<br><a href='form_ubah.php'>Kembali Ke Form</a>";
        }
    } else {
        // Jika gambar gagal diupload
        echo "Maaf, Gambar gagal untuk diupload.";
        echo "<br><a href='form_ubah.php'>Kembali Ke Form</a>";
    }
}
?>