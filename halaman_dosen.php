<!DOCTYPE html>
<html>
<head>
	<title>HALAMAN_DOSEN</title>
</head>
<body>
<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "akademik";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$nim                = "";
$nama               = "";
$nilai              = "";
$sukses             = "";
$error              = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $id         = $_GET['id'];
    $sql1       = "delete from mahasiswa where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $id                 = $_GET['id'];
    $sql1               = "select * from mahasiswa where id = '$id'";
    $q1                 = mysqli_query($koneksi, $sql1);
    $r1                 = mysqli_fetch_array($q1);
    $nim                = $r1['nim'];
    $nama               = $r1['nama'];
    $nilai              = $r1['nilai'];

    if ($nim == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $nim                = $_POST['nim'];
    $nama               = $_POST['nama'];
    $nilai              = $_POST['nilai'];

    if ($nim && $nama && $nilai) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update mahasiswa set nim = '$nim',nama='$nama',nilai='$nilai' where id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into mahasiswa(nim,nama,nilai) values ('$nim','$nama','$nilai')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 900px
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
<div class="mx-auto">
        <!-- untuk memasukkan data -->
        <div class="card">
            <div class="card-header">
                <h5>MASUKAN DATA</h5>
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");//5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="nim" class="col-sm-2 col-form-label">Nim</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $nim ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nilai" class="col-sm-2 col-form-label">Nilai</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nilai" name="nilai" value="<?php echo $nilai ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>


        <!-- untuk mengeluarkan data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                <h3>Data Mahasiswa</h3>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nim</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from mahasiswa order by id desc";
                        $q2     = mysqli_query($koneksi, $sql2);    
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id             = $r2['id'];
                            $nim            = $r2['nim'];
                            $nama           = $r2['nama'];
                            $nilai          = $r2['nilai'];

                            

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++  ?></th>
                                <td scope="row"><?php echo $nim     ?></td>
                                <td scope="row"><?php echo $nama    ?></td>
                                <td scope="row"><?php echo $nilai     ?></td>
                                <td scope="row">
                                <a href="halaman_dosen.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                <a href="halaman_dosen.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a> 
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
	<a href="logout.php">LOGOUT</a>
</body>
</html>