<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "siakad";

$connection = new mysqli($servername, $username, $password, $database);


$id ="";
$nama  = "";
$kodematkul = "";
$deskripsi = "";

$errorMessage = "";
$successMessage ="";

if($_SERVER['REQUEST_METHOD'] == 'GET'){

    if(!isset($_GET["ID"])){
        header("location: index.php");
        exit;
    }
    $id = $_GET['ID'];

    $sql = " SELECT * FROM matakuliah WHERE ID=$id";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if(!$row){
        header("location: index.php");
        exit;
    }    
    $nama  = $row["Nama"];
    $kodematkul = $row["Kode_Matakuliah"];
    $deskripsi = $row["Deskripsi"];
}
else{
    $id = $_POST["ID"];
    $nama = $_POST["Nama"];
    $kodematkul = $_POST["Kode_Matakuliah"];
    $deskripsi = $_POST["Deskripsi"];
    

    do {
        if(empty($nama) || empty($kodematkul) || empty($deskripsi)){
            $errorMessage = "All the fields are required";
            break;
        }

        try {
            $sql = "UPDATE matakuliah SET Nama = '$nama', Kode_Matakuliah='$kodematkul', Deskripsi = '$deskripsi' WHERE ID = $id";

            $result = $connection->query($sql);
        } catch (\Exception $e) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }
     
        $successMessage = "Data Berhasil diperbarui";

        header("location: index.php");
        exit;

    } while (false);

}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
  <script src="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>Edit Data</h2>

        <?php
        if( !empty($errorMessage)){
            echo "
                <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
            ";
        }

        ?>
         <form method="post">
            <input type="hidden" name="ID" value="<?php echo $id; ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-label">Nama</label>
                <div clas="col-sm-6">
                    <input type="text" class="form-control" name="Nama" value="<?php echo $nama; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-label">Kode</label>
                <div clas="col-sm-6">
                    <input type="text" class="form-control" name="Kode_Matakuliah" value="<?php echo $kodematkul; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-label">Deskripsi</label>
                <div clas="col-sm-6">
                    <input type="text" class="form-control" name="Deskripsi" value="<?php echo $deskripsi; ?>">
                </div>
            </div>
          

            <?php
              if(!empty($successMessage)){
                echo "
                <div class='row mb-3'>
                <div class='offset-sm-3 col-sm-6'>
                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>$successMessage</strong>
               <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
               </div>
               </di>
               </div>
                ";
              }
            ?>
          <div class="row mb-3">
            <div class="offset-sm-3 col-sm-3 d-grid">
                <button type="submit" class="btn btn-primary">Submit</button>
               </div>
              <div class="col-sm-3 d-grid">
                <a class="btn btn-outline-primary" href="index.php" role="button">Cancel</a>
            </div>
           </div>
         </form>
    </div>
</body>
</html>