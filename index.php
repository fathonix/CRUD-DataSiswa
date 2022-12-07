<?php
$host = "localhost";
$user = "aldo";
$pass = "";
$db = "datasiswa";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Tidak terhubung ke database!");
}

$id = "";
$nis = "";
$nama = "";
$alamat = "";
$kelas = "";
$sukses = "";
$error = "";

// Untuk edit data
$op = $_GET['op'] ?? '';

if ($op == 'edit') {
    $id = $_GET['id'];
    $crud1 = "SELECT * FROM siswa WHERE id = '$id'";
    $c1 = mysqli_query($koneksi, $crud1);
    $r1 = mysqli_fetch_array($c1);
    $nis = $r1['nis'];
    $nama = $r1['nama'];
    $alamat = $r1['alamat'];
    $kelas = $r1['kelas'];

    if ($nis == '') {
        $error = "Data tidak ditemukan.";
    }
}

// Untuk delete data
if ($op == 'delete') {
    $id = $_GET['id'];
    $crud1 = "DELETE FROM siswa WHERE id = '$id'";
    $c1 = mysqli_query($koneksi, $crud1);

    if ($c1) {
        $sukses = "Data berhasil dihapus.";
    } else {
        $error = "Gagal menghapus data.";
    }
}

// Untuk create data
if (isset($_POST['simpan'])) {
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $kelas = $_POST['kelas'];

    if ($nis && $nama && $alamat && $kelas) {
        if ($op == 'edit') {
            $crud1 = "UPDATE siswa SET nis='$nis', nama='$nama', alamat='$alamat', kelas='$kelas' WHERE id = '$id'";
            $cr1 = mysqli_query($koneksi, $crud1);

            if ($cr1) {
                $sukses = "Data berhasil diubah.";
            }
        } else {
            $crud1 = "INSERT INTO siswa (nis, nama, alamat, kelas) VALUES ('$nis', '$nama', '$alamat', '$kelas')";
            $c1 = mysqli_query($koneksi, $crud1);

            if ($c1) {
                $sukses = "Berhasil memasukkan data.";
            } else {
                $error = "Gagal memasukkan data.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="./assets/img/favicon.ico">
    <style>
        :root {
            --bs-font-sans-serif: "Poppins", sans-serif;
        }
        body {
            height: 100vh;
            background: url(./assets/img/bg.png);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
        }
        a {
            text-decoration:none;
        }
        .mx-auto {
            width: 800px;
        }
        .card {
            margin-top: 20px;
            backdrop-filter: blur(7px);
            background: rgba(255, 255, 255, 0.6);
        }
        .card-end {
            margin-bottom: 20px;
        }
        @media (max-width: 840px) {
            .mx-auto {
                width: 100%;
                padding-left: 20px;
                padding-right: 20px;
            }
        }
    </style>
    <title>Data Siswa</title>
</head>

<body>
    <div class="mx-auto">
        <div class="card shadow">
            <div class="card-body text-center">
                <img src="./assets/img/favicon.ico" height="100">
                <h1 class="fw-bold">Data Siswa</h1>
            </div>
        </div>
        <!-- Create Data -->
        <div class="card shadow">
            <div class="card-header">
                Tambahkan/Ubah
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                header("refresh: 3; url: index.php");
                }
                ?>

                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                header("refresh: 3; url: index.php");
                }
                ?>
                <form action="" method="post">
                    <div class="mb-3 row">
                        <label for="nis" class="col-sm-2 col-form-label">NIS</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="nis" name="nis" value="<?php echo $nis ?>" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama Siswa</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat ?>" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="kelas" class="col-sm-2 col-form-label">Kelas</label>
                        <div class="col-sm-10">
                            <select class="form-select" id="kelas" name="kelas" required>
                                <option value="">--- Pilih Kelas ---</option>
                                <option value="X" <?php if ($kelas == 'X') echo 'selected' ?>>X</option>
                                <option value="XI" <?php if ($kelas == 'XI') echo 'selected' ?>>XI</option>
                                <option value="XII" <?php if ($kelas == 'XII') echo 'selected' ?>>XII</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-center">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary fw-bold" />
                    </div>
                </form>
            </div>
        </div>
        <!-- Read Data -->
        <div class="card shadow card-end">
            <div class="card-header text-white bg-secondary">
                Data Siswa
            </div>
            <div class="card-body overflow-scroll">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">NIS</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $crud2 = "SELECT * FROM siswa ORDER BY id DESC";
                        $c2 = mysqli_query($koneksi, $crud2);
                        $urut = 1;
                        while ($r2 = mysqli_fetch_array($c2)) {
                            $id = $r2['id'];
                            $nis = $r2['nis'];
                            $nama = $r2['nama'];
                            $alamat = $r2['alamat'];
                            $kelas = $r2['kelas'];
                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $nis ?></td>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $alamat ?></td>
                                <td scope="row"><?php echo $kelas ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id ?>">
                                        <button type="button" class="btn btn-warning">Ubah</button>
                                    </a>
                                    <a href="index.php?op=delete&id=<?php echo $id ?>" onclick="return confirm('Apakah anda yakin?')">
                                        <button type="button" class="btn btn-danger">Hapus</button>
                                    </a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>