<?php 
session_start();

if( !isset($_SESSION["login"])) {
	header("location: login.php");
	exit;
}

require 'functions.php';

// take data in url
$id = $_GET["id"];
// query data student by id
$student = query("SELECT *  FROM  students WHERE id = $id")[0];



// correct what button submit has press or not
if(isset($_POST["submit"]) ) { 
       

       

       // correct  what is data succeed change in RDBMS or not
     if( change($_POST) > 0) {
         echo "
            <script>
                alert('data succeed change!'); 
                document.location.href = 'index.php'; 
            </script>
         ";
     }else{
         echo"
            <script>
                alert('data failed to change!'); 
                document.location.href = 'index.php'; 
            </script>";
     }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>change data students</title>
</head>
<body>
    <h1>Add data students</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value ="<?php echo $student["id"];?> "> 
        <input type="hidden" name="longPicture" value ="<?php echo $student["gambar"];?> "> 
        <ul>
            <li>
                <label for="nrp">NRP : </label>
                <input type="text" name="nrp" id="nrp" required value="<?= $student["nrp"];?>">
            </li>
            <li>
                <label for="usename">NAME : </label>
                <input type="text" name="username" id="username" required value="<?= $student["name"];?>">
            </li>
            <li>
                <label for="email">Email : </label>
                <input type="text" name="email" id="email"  value="<?= $student["email"];?>">
            </li>
            <li>
                <label for="jurusan">Jurusan : </label>
                <input type="text" name="jurusan" id="jurusan"  value="<?= $student["jurusan"];?>">
            </li>
            <li>
                <label for="gambar">Gambar : </label> <br>
                <img src="img/<?=$student['gambar']; ?>" width="40"> <br>
                <input type="file" name="gambar" id="gambar" > 
            </li>
            <li>
                <button type="submit" name="submit">Change data!</button>
            </li>
        </ul>

    </form>
</body>
</html>