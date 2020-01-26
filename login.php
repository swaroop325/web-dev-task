<?php
session_start();
$link = mysqli_connect("localhost", "id12363457_root", "root@123", "id12363457_root");
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}else{
    if(isset($_POST['purpose'])){
        session_unset();
        session_destroy();
        echo "logged out successfully";
        exit();
    }
    $sql = "SELECT email, password FROM Persons WHERE email=? AND password=? LIMIT 1";
    if($stmt = mysqli_prepare($link, $sql)){
    mysqli_stmt_bind_param($stmt,'ss', $email, $password);
    $password = md5($_POST['password']);
    $email= $_POST['email'];
    if(mysqli_stmt_execute($stmt)){
       mysqli_stmt_store_result($stmt);
       if(mysqli_stmt_num_rows($stmt) == 1){
          $_SESSION['Logged'] = true;
          $_SESSION['email'] = $email;
          header("Location: /welcome.html"); 
          echo $email;
          exit;
       }else{
         echo "INVALID USERNAME/PASSWORD Combination!";
    }
    }
    } 
    mysqli_stmt_close($stmt);
    mysqli_close($link);
}
?>