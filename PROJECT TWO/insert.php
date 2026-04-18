<?php
require 'db.php';

$hobbies = isset($_POST['hobbies']) ? implode(",", $_POST['hobbies']) : "";

$sql = "INSERT INTO students (first_name,last_name,day,month,year,email,mobile,gender,address,city,pin_code,state,country,hobbies,course,
x_board,x_percent,x_year,
xii_board,xii_percent,xii_year,
grad_board,grad_percent,grad_year,
masters_board,masters_percent,masters_year) VALUES ('".$_POST['first_name']."',
'".$_POST['last_name']."',
'".$_POST['day']."',
'".$_POST['month']."',
'".$_POST['year']."',
'".$_POST['email']."',
'".$_POST['mobile']."',
'".$_POST['gender']."',
'".$_POST['address']."',
'".$_POST['city']."',
'".$_POST['pin_code']."',
'".$_POST['state']."',
'".$_POST['country']."',
'$hobbies',
'".$_POST['course']."',

'".$_POST['x_board']."',
'".$_POST['x_percent']."',
'".$_POST['x_year']."',

'".$_POST['xii_board']."',
'".$_POST['xii_percent']."',
'".$_POST['xii_year']."',

'".$_POST['grad_board']."',
'".$_POST['grad_percent']."',
'".$_POST['grad_year']."',

'".$_POST['masters_board']."',
'".$_POST['masters_percent']."',
'".$_POST['masters_year']."'

)";

if($conn->query($sql)){
    echo "Data inserted successfully";
}else{
    echo "Error: ".$conn->error;
}

$conn->close();
?>
