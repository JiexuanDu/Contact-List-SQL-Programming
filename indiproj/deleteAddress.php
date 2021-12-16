<?php
include('connect.php');
include('header.php');

if(isset($_GET['deleteAddressId'])){
    $addressId = $_GET['deleteAddressId'];

    $sql = "DELETE FROM ADDRESS WHERE Address_id='$addressId'";
    $result = $conn->query($sql);
    if($result){
        header('location:index.php');
    }else{
        // die(mysqli_error($conn));
        header('location:index.php');
    }
}
?>  