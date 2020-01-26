<?php
$link = mysqli_connect("localhost", "id12363457_root", "root@123", "id12363457_root");
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
else{
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
}
?>