<?php
include('connect.php');
include('header.php');

if(isset($_GET['deletePhoneId'])){
    $phoneId = $_GET['deletePhoneId'];

    $sql = "DELETE FROM PHONE WHERE Phone_id='$phoneId'";
    $result = $conn->query($sql);
    if($result){
        header('location:index.php');
    }else{
        // die(mysqli_error($conn));
        header('location:index.php');
    }
}
?>  