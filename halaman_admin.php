<!DOCTYPE html>
<html>
<head>
	<title>Halaman admin</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
$jurusan            = "";
$alamat             = "";
$telephone          = "";
$agama              = "";
$jeniskelamin       = "";
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
    $fakultas           = $r1['fakultas'];
    $alamat             = $r1['alamat'];
    $telephone          = $r1['telephone'];
    $agama              = $r1['agama'];
    $jeniskelamin       = $r1['jeniskelamin'];

    if ($nim == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $nim                = $_POST['nim'];
    $nama               = $_POST['nama'];
    $fakultas            = $_POST['fakultas'];
    $alamat             = $_POST['alamat'];
    $telephone          = $_POST['telephone'];
    $agama              = $_POST['agama'];
    $jeniskelamin       = $_POST['jeniskelamin'];

    if ($nim && $nama && $fakultas && $alamat && $telephone && $agama && $jeniskelamin) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update mahasiswa set nim = '$nim',nama='$nama',fakultas ='$fakultas ',alamat='$alamat',telephone='$telephone', agama='$agama',jeniskelamin='$jeniskelamin' where id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into mahasiswa(nim,nama,fakultas,alamat,telephone,agama) values ('$nim','$nama','$fakultas','$alamat','$telephone','$agama')";
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
            width: 1000px
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
                        <label for="fakultas" class="col-sm-2 col-form-label">fakultas</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="fakultas" id="fakultas">
                                <option value="">- Pilih fakultas -</option>
                                <option value="teknik" <?php if ($fakultas == "teknik") echo "selected" ?>>teknik</option>
                                <option value="ekonomi" <?php if ($fakultas == "ekonomi") echo "selected" ?>>ekonomi</option>
                                <option value="fisip" <?php if ($fakultas == "fisip") echo "selected" ?>>fisip</option>
                                <option value="pertanian" <?php if ($fakultas == "pertanian") echo "selected" ?>>pertanian</option>
                                
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="telephone" class="col-sm-2 col-form-label">Telephone</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="telephone" name="telephone" value="<?php echo $telephone ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="agama" class="col-sm-2 col-form-label">Agama</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="agama" id="agama">
                                <option value="">- Pilih Agama -</option>
                                <option value="ISLAM" <?php if ($agama == "ISLAM") echo "selected" ?>>ISLAM</option>
                                <option value="KRISTEN" <?php if ($agama == "KRISTEN") echo "selected" ?>>KRISTEN</option>
                                <option value="HINDU" <?php if ($agama == "HINDU") echo "selected" ?>>HINDU</option>
                                <option value="BUDHA" <?php if ($agama== "BUDHA") echo "selected" ?>>BUDHA</option>
                                <option value="KOGHUCU" <?php if ($agama == "KONGHUCU") echo "selected" ?>>KONGHUCU</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jeniskelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="jeniskelamin" id="jeniskelamin">
                                <option value="">- Pilih Jenis Kelamin -</option>
                                <option value="laki-laki" <?php if ($jeniskelamin == "laki-laki") echo "selected" ?>>laki-laki</option>
                                <option value="perempuan" <?php if ($jeniskelamin == "perempuan") echo "selected" ?>>perempuan</option>
                            </select>
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
                <div style="width: 800px;margin: 0px auto;">
		<canvas id="myChart"></canvas>
	</div>
            <script>
		var ctx = document.getElementById("myChart").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: ["Teknik", "Fisip", "Ekonomi", "Pertanian"],
				datasets: [{
					label: '',
					data: [
					<?php 
					$jumlah_teknik = mysqli_query($koneksi,"select * from mahasiswa where fakultas='teknik'");
					echo mysqli_num_rows($jumlah_teknik);
					?>, 
					<?php 
					$jumlah_ekonomi = mysqli_query($koneksi,"select * from mahasiswa where fakultas='ekonomi'");
					echo mysqli_num_rows($jumlah_ekonomi);
					?>, 
					<?php 
					$jumlah_fisip = mysqli_query($koneksi,"select * from mahasiswa where fakultas='fisip'");
					echo mysqli_num_rows($jumlah_fisip);
					?>, 
					<?php 
					$jumlah_pertanian = mysqli_query($koneksi,"select * from mahasiswa where fakultas='pertanian'");
					echo mysqli_num_rows($jumlah_pertanian);
					?>
					],
					backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)'
					],
					borderColor: [
					'rgba(255,99,132,1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 206, 86, 1)',
					'rgba(75, 192, 192, 1)'
					],
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});
	</script>

            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nim</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Fakultas</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Telephone</th>
                            <th scope="col">Agama</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">Aksi</th>
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
                            $fakultas        = $r2['fakultas'];
                            $alamat         = $r2['alamat'];
                            $telephone      = $r2['telephone'];
                            $agama          = $r2['agama'];
                            $jeniskelamin   = $r2['jeniskelamin'];

                            

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++  ?></th>
                                <td scope="row"><?php echo $nim     ?></td>
                                <td scope="row"><?php echo $nama    ?></td>
                                <td scope="row"><?php echo $fakultas ?></td>
                                <td scope="row"><?php echo $alamat  ?></td>
                                <td scope="row"><?php echo $telephone   ?></td>
                                <td scope="row"><?php echo $agama   ?></td>
                                <td scope="row"><?php echo $jeniskelamin     ?></td>
                                <td scope="row">
                                    <a href="halaman_admin.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="halaman_admin.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>            
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
   
	<a href="logout.php">LOGOUT</a>
</body>
</html>