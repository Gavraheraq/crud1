<?php
session_start();

if(!isset($_SESSION["login"])){
    header("Location: /crud1/login.php");
    exit;
}

    //Konek ke databse
    $koneksi = mysqli_connect("localhost","root","","crud-siswa")or die(mysqli_error($koneksi));
    //jika tombol simpan diklik
    if(isset($_POST['bsimpan']))
    {

        if($_GET['hal'] == "edit")
        {
            $edit = mysqli_query($koneksi, "UPDATE tsiswa set nim = '$_POST[tnim]', nama='$_POST[tnama]', alamat='$_POST[talamat]',jurusan='$_POST[tprodi]' WHERE id_siswa = '$_GET[id]' ");
if($edit){
echo "<script>
alert('Edit data sukses!');
document.location='index.php';
</script>";
}else{
echo "<script>
alert('Edit data GAGAL!');
document.location='index.php';
</script>";
}

        }else{
            $simpan = mysqli_query($koneksi, "INSERT INTO tsiswa (nim, nama, alamat, jurusan)
                                              VALUES ('$_POST[tnim]','$_POST[tnama]', '$_POST[talamat]','$_POST[tprodi]') ");
            if($simpan){
                echo "<script>
                        alert('Simpan data sukses!');
                        document.location='index.php';
                        </script>";
            }else{
                echo "<script>
                        alert('Simpan data GAGAL!');
                        document.location='index.php';
                        </script>";
            }
            
        }
        
    }

    if(isset($_GET['hal'])){
        if($_GET['hal'] == "edit"){
            $tampil = mysqli_query($koneksi, "SELECT * FROM tsiswa WHERE id_siswa= '$_GET[id]' ");
            $data = mysqli_fetch_array($tampil);
            if($data){
                $vnim = $data ['nim'];
                $vnama = $data ['nama'];
                $valamat = $data ['alamat'];
                $vprodi = $data ['jurusan'];
            }
        }else if($_GET['hal']=="hapus"){
            $hapus = mysqli_query($koneksi, "DELETE FROM tsiswa WHERE id_siswa = '$_GET[id]' ");
            if($hapus){
                echo "<script>
                alert('Hapus data Suksess!');
                document.location='index.php';
                </script>";
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
    <title>CRUD|Siswa</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
      #log{
        margin-left:50rem;
      }
      
    </style>
</head>
<body class="bg-secondary">
    <div class="container">

        <h1 class="text-center ">CRUD|Siswa With Bootstrap</h1>
        <!-- Awal Card Form -->
        <div class="card mt-4">
            <div class="card-header bg-primary text-white fs-3">
                Form Input Data Siswa <button class="btn btn-danger" id="log"><a href="logout.php" class="text-white">Logout</a></button>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="">Nim</label>
                        <input type="text" name="tnim" value="<?=@$vnim?>" class="form-control" placeholder="Input Nim Siswa disini!" Required>
                    </div>
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="Input Nama Siswa disini!" Required>
                    </div>
                    <div class="form-group">
                        <label for="">Alamat</label>
                      <textarea name="talamat" class="form-control"  placeholder="Input Alamat anda disini!"><?=@$vnim?></textarea required>
                    </div>
                    <div class="form-group">
                        <label for="">Jurusan</label>
                        <select name="tprodi" class="form-control" placeholder="Pilih Jurusan">
                            <option value="<?=@$vprodi?>"><?=@$vprodi?></option>
                            <option value="RPL">Rekayasa Perangkat Lunak</option>
                            <option value="AKL">Akutansi Keuangan Lembaga</option>
                            <option value="TBSM">Teknik Sepeda Motor</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
                </form>
            </div>
        </div>
        <!-- Akhir card form -->
        <div class="card mt-4">
          <div class="card-header bg-success text-white">
             Daftar Siswa
          </div>
        <table class="table table-striped table-bordered table-hover">
  <thead>
    <tr>
      <th scope="col">No.</th>
      <th scope="col">Nim</th>
      <th scope="col">Nama</th>
      <th scope="col">Alamat</th>
      <th scope="col">Jurusan</th>
      <th scope="col">Action</th>
    </tr>
</thead>
<tbody>
    <tr>
        
    <?php
    $i= 1;
    $tampil = mysqli_query($koneksi, "SELECT * FROM tsiswa order by id_siswa desc");
    while($data = mysqli_fetch_array($tampil)):
        ?>
      <th scope="row"><?= $i++;  ?></th>
      <td><?= $data['nim'];  ?></td>
      <td><?= $data['nama'];  ?></td>
      <td><?= $data['alamat'];  ?></td>
      <td><?= $data['jurusan'];  ?></td>
      <td>
      <a class="btn btn-warning" href="index.php?hal=edit&id=<?=$data['id_siswa']?>">Edit</a>
            <a class="btn btn-danger" href="index.php?hal=hapus&id=<?=$data['id_siswa']?>" onclick="return confirm('Apakah yakin ingin menghapus data ini?')">Hapus</a>
      </td>
    </tr>
    <tr>
    <?php
        endwhile;
        ?>
  </tbody>
</table>
          <!-- Awal Card Tabel -->
        </div>
    </div>
    <!-- Akhir card Tabel -->
</div>
<script src="js/bootstrap.min.css"></script>
</body>
</html>
