<?php
session_start();

if( !isset($_SESSION["login"])) {
	header("location: login.php");
	exit;
}
 
require 'functions.php';
// correct what button submit has push or not
if(isset($_POST["submit"]) ) { 
       

       

       // correct  what is data succeed add in RDBMS or not
     if( add($_POST) > 0) {
         echo "
            <script>
                alert('data succeed add!'); 
                document.location.href = 'index.php'; 
            </script>
         ";
     }else{
         echo"
            <script>
                alert('data failed add!'); 
                document.location.href = 'index.php'; 
            </script>";
     }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Add data students</title>
</head>
<body>
    <h1>Add data students</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <ul>
            <li>
                <label for="nrp">NRP : </label>
                <input type="text" name="nrp" id="nrp">
            </li>
            <li>
                <label for="usename">NAME : </label>
                <input type="text" name="username" id="username">
            </li>
            <li>
                <label for="email">Email : </label>
                <input type="text" name="email" id="email">
            </li>
            <li>
                <label for="jurusan">Jurusan : </label>
                <input type="text" name="jurusan" id="jurusan">
            </li>
            <li>
                <label for="gambar">Gambar : </label>
                <input type="file" name="gambar" id="gambar">
            </li>
            <li>
                <button type="submit" name="submit">Add data!</button>
            </li>
        </ul>

    </form>
</body>
</html>