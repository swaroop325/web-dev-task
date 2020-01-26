<?php
session_start();
$link = mysqli_connect("localhost", "id12363457_root", "root@123", "id12363457_root");
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}else{
    $purpose = isset($_POST['purpose']) ? $_POST['purpose'] : '';
    if($purpose == "register"){
        $sql = "INSERT INTO Persons (name, password, email, age, dob, contact_no) VALUES (?, ?, ?, ?, ?, ?)";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sssisi",$name, $password, $email, $age, $dob, $contact_no);
            $usedId = '';
            $name = $_POST['name'];
            $password = md5($_POST['password']);
            $email= $_POST['email'];
            $age= $_POST['age'];
            $dob= $_POST['dob'];
            $contact_no = $_POST['contact_no'];
            if(mysqli_stmt_execute($stmt)){
                echo "Records inserted successfully.";
                $array = array('name' => $name,'password' => $password,'email' => $email, 'age' => $age, 'dob' => $dob, 'contact_no' => $contact_no);
                $input = file_get_contents('userdetails.json');
                $tempArray = json_decode($input);
                array_push($tempArray, $array);
                $jsonData = json_encode($tempArray);
                file_put_contents('userdetails.json', $jsonData);
            } else{
                echo "Problem in query execution".mysqli_error($link);
                }
            }
            mysqli_stmt_close($stmt);
            mysqli_close($link);
    }else if($purpose == "login"){
        $sql = "SELECT email, password FROM Persons WHERE email=? AND password=?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt,'ss', $email, $password);
            $email= $_POST['email'];
            $password = md5($_POST['password']);
            if(mysqli_stmt_execute($stmt)){
              mysqli_stmt_execute($stmt);
              mysqli_stmt_store_result($stmt);
               if(mysqli_stmt_num_rows($stmt) == 1){
                  $_SESSION['Logged'] = true;
                  $_SESSION['email'] = $email;
                  echo "true";
               }else{
                 echo "false";
               }
            }
        } 
        mysqli_stmt_close($stmt);
        mysqli_close($link);
    }else if($purpose == "update"){
        $sql = "UPDATE Persons SET age=?,dob=?,contact_no=? WHERE email=?";
        if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "isis", $age, $dob, $contact_no, $email);
        $email = $_SESSION['email'];
        $age= $_POST['age'];
        $dob= $_POST['dob'];
        $contact_no = $_POST['contact_no'];
        if(mysqli_stmt_execute($stmt)){
            $input = file_get_contents('userdetails.json');
            $tempArray = json_decode($input, true);
            foreach ($tempArray as $key => $entry) {
                if ($entry['email'] == $email) {
                    $tempArray[$key]['age'] = $age;
                    $tempArray[$key]['dob'] = $dob;
                    $tempArray[$key]['contact_no'] = $contact_no;
                }
            }
            $jsonData = json_encode($tempArray);
            file_put_contents('userdetails.json', $jsonData);
            header("Location: /welcome.html"); 
            echo "Records updated successfully.";
        } else{
            echo "Problem in query execution".mysqli_error($link);
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($link);
    }else if($purpose == "logout"){
        session_unset();
        session_destroy();
        echo "Logged out successfully";
        exit();
    }else{
        echo "Invalid purpose";
    }  
}
?>