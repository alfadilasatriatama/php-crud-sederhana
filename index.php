<?php
session_start();

if( !isset($_SESSION["login"])) {
	header("location: login.php");
	exit;
}
require 'functions.php';
$students = query("SELECT * FROM students");


// press button search 
if( isset($_POST["search"])) {
	$students = search($_POST["keyword"]);
}
?>




<!DOCTYPE html>
<html>
<head>
	<title>Halaman Admin</title>
</head>

<body>

<a href="logout.php">Logout</a>

<h1>Daftar Mahasiswa</h1>

<a href="add.php">Add data students</a>
<br><br>


<form action="" method="post">
	<input type="text" name="keyword" size="40" autofocus placeholder="input keyword searching.." autocomplete="off">
	<button type="submit" name="search">Search!</button>
</form>
<br>

<table border="1" cellpadding="10" cellspacing="0">

	<tr>
		<th>No.</th>
		<th>Aksi</th>
		<th>Gambar</th>
		<th>Nrp</th>
		<th>Nama</th>
		<th>Email</th>
		<th>Jurusan</th>
	</tr>

	<?php $i = 1; ?>
	<?php foreach ($students as $student ) : ?>
	<tr>
		<td><?php echo $i; ?></td>
		<td> 
			<a href="change.php?id=<?= $student["id"]; ?>">ubah</a>
			<a href="delete.php?id=<?php echo $student["id"]; ?>" onclick="return confirm('delete')"  >hapus</a>
		</td>
		<td><img src="img/<?php echo $student["gambar"]; ?>" width="50"></td>
		<td><?= $student["nrp"]; ?></td>
		<td><?= $student["name"]; ?></td>
		<td><?= $student["email"]; ?></td>
		<td><?= $student["jurusan"]; ?></td>
	</tr>
	<?php $i++; ?>
	<?php endforeach ; ?>
	
</table>


</body>
</html>