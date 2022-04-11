<?php 
session_start();

if( isset($_SESSION["login"])) {
    header("location: index.php");
    exit;
}
require 'functions.php';

if(isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

    //check username
    if( mysqli_num_rows($result) === 1) {

        //check password
        $row = mysqli_fetch_assoc($result);
        if(password_verify($password, $row["password"])) {
            // set session
            $_SESSION["login"] = true;

            header('Location: index.php');
            exit;
        }
    }

    $error = true;

}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
</head>
<body>
    <h1>Login Page</h1>

    <?php if( isset($error)) : ?>
        <p style="color: red; font-style:italic;">username or password wrong</p>
    <?php endif; ?>
    <form action="" method="post">
        <ul>
            <li>
                <label for="username">Username :</label>
                    <input type="text" name="username" id="username">               
            </li>
            <li>
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </li>
            <li>
               <button type="submit" name="login">Login</button>
            </li>
        </ul>
    </from>
</body>
</html>