
<html>
<head>
    <title>Aplikasi CRUD dengan PHP</title>
</head>
<body>
    <h1>Ubah Data Siswa</h1>
    <?php
    // Load file koneksi.php
    include "koneksi.php";
    
    // Ambil data ID yang dikirim oleh index.php melalui URL
    $id = $_GET['id']; // Corrected variable name and assignment
    
    // Query untuk menampilkan data siswa berdasarkan ID yang dikirim
    $sql = $pdo->prepare("SELECT * FROM siswa WHERE id=:id");
    $sql->bindParam(':id', $id);
    $sql->execute(); // Fixed method call
    $data = $sql->fetch(); // Fixed fetch method call
    ?>

    <form method="post" action="proses_ubah.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
        <table cellpadding="8">
            <tr>
                <td>NIS</td>
                <td><input type="text" name="nis" value="<?php echo $data['nis']; ?>"></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td><input type="text" name="nama" value="<?php echo $data['nama']; ?>"></td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>
                    <?php
                    if ($data['jenis_kelamin'] == "Laki-laki") {
                        echo "<input type='radio' name='jenis_kelamin' value='Laki-laki' checked='checked'> Laki-laki ";
                        echo "<input type='radio' name='jenis_kelamin' value='Perempuan'> Perempuan";
                    } else {
                        echo "<input type='radio' name='jenis_kelamin' value='Laki-laki'> Laki-laki ";
                        echo "<input type='radio' name='jenis_kelamin' value='Perempuan' checked='checked'> Perempuan";
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>Telepon</td>
                <td><input type="text" name="telp" value="<?php echo $data['telp']; ?>"></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td><textarea name="alamat"><?php echo $data['alamat']; ?></textarea></td>
            </tr>
            <tr>
                <td>Foto</td>
                <td><input type="file" name="foto"></td>
            </tr>
        </table>
        <hr>
        <input type="submit" value="Ubah">
        <a href="index.php"><input type="button" value="Batal"></a>
    </form>
</body>
</html>
