<?php 
session_start();

if( !isset($_SESSION["login"])) {
	header("location: login.php");
	exit;
}

require 'functions.php';

    $id = $_GET["id"];

    if( delete($id) > 0) {
        echo "
            <script>
                alert('data succeed to delete!'); 
                document.location.href = 'index.php'; 
            </script>
        ";
    }else{
        echo "
            <script>
                alert('data failed to delete!'); 
                document.location.href = 'index.php'; 
            </script>
        ";
    }

   
?>

