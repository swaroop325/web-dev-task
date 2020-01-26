<?php
$link = mysqli_connect("localhost", "id12363457_root", "root@123", "id12363457_root");
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
else{
    $sql = "UPDATE Persons SET age=?,dob=?,contact_no=? WHERE email=?";
    if($stmt = mysqli_prepare($link, $sql)){
    mysqli_stmt_bind_param($stmt, "isis", $age, $dob, $contact_no, $email);
    $email = "swaroop@gmail.com";
    $age= $_POST['age'];
    $dob= $_POST['dob'];
    $contact_no = $_POST['contact'];
    if(mysqli_stmt_execute($stmt)){
        echo "Records updated successfully.";
        $input = file_get_contents('userdetails.json');
        $tempArray = json_decode($input, true);
        foreach ($tempArray as $key => $entry) {
            if ($entry['email'] == $email) {
                echo $key.$age.$dob;
                $tempArray[$key]['age'] = $age;
                $tempArray[$key]['dob'] = $dob;
                $tempArray[$key]['contact_no'] = $contact_no;
            }
        }
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