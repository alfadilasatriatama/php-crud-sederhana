<?php 
// connect to databases
$conn = mysqli_connect("localhost", "root", "", "phpdasar");


function query($query)  {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function add($data) {
    global $conn;

    $nrp = htmlspecialchars($data["nrp"]);
    $name = htmlspecialchars($data["username"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data ["jurusan"]);

    // upload picture
    $gambar = upload();
    if( !$gambar) {
        return false;
    }

    $query = "INSERT INTO  students
                 values
                ( '','$nrp', '$name', '$email', '$jurusan', '$gambar')  
           ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


function upload() {
    $nameFile = $_FILES['gambar']['name'];
    $sizeFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // check if no images have been uploaded
    if($error === 4) {
        echo "<script>
            alert('select the picture first!');
        </script>";
        return false;
    }

    // check if uploaded is picture
    $extensionPictureValid = ['jpg','jpeg','png'];
    $extensionPicture = explode('.',$nameFile);
    $extensionPicture = strtolower(end($extensionPicture));
    if( !in_array($extensionPicture,$extensionPictureValid)) {
        echo "<script>
            alert('You uploaded is not image!');
        </script>";
    }

    // check if sizing too big
    if( $sizeFile > 1000000) {
        echo"<script>
            alert('size picture too big!')
        </script>";
        return false;
    }

    // pass checking, picture ready to uploaded
    // generate new file name
    $namefileNew = uniqid();
    $namefileNew .= '.';
    $namefileNew .= $extensionPicture;

    move_uploaded_file($tmpName, 'img/' . $namefileNew);

    return $namefileNew;
}




function delete($id) {
    global $conn;
    mysqli_query($conn,"delete from students where id = $id");

    return mysqli_affected_rows($conn);
}

function change($data) {
    global $conn;
    $id = $data["id"];
    $nrp = htmlspecialchars($data["nrp"]);
    $name = htmlspecialchars($data["username"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $longPicture = htmlspecialchars($data["longPicture"]);

    // checks if user choise new picture or not
    if($_FILES['gambar']['error'] === 4) {
        $gambar = $longPicture;
    } else {
        $gambar = upload();
    }
    

    $query = "UPDATE students  SET
                nrp = '$nrp',
                name = '$name',
                email = '$email',
                jurusan = '$jurusan',
                gambar = '$gambar'
              WHERE id = $id
             ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function search($keyword) {
    $query = "SELECT * FROM students
                WHERE   
            name LIKE '%$keyword%' OR
            nrp LIKE '%$keyword%' OR
            email LIKE '%$keyword%'OR
            jurusan LIKE '%$keyword%'";
            return query($query);
}

function register($data) {
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $confrimPassword = mysqli_real_escape_string($conn, $data["confirmPassword"]);

    // check if username has used or not yet
    $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
    if(mysqli_fetch_assoc($result) ) {
        echo "<script>
            alert('username is already used! ');
        </script>";
        return false;
    }

    // check confirm password 
    if( $password !== $confrimPassword ) {
        echo "<script>
                alert('confirm password not appropriate!');
        </script>";
        return false;
    }
   
    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // add new user to databases
    mysqli_query($conn, "INSERT INTO users VALUES ('','$username','$password')");

    return mysqli_affected_rows($conn);
}

?>

