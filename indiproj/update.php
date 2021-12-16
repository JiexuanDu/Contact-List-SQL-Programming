<?php
include('header.php');
include('connect.php');

$id = $_GET['updateId'];
$phoneId = $_GET['phoneId'];
$addressId = $_GET['addressId'];
$dateId = $_GET['dateId'];


// check whether this record has phone, address or date info
if(!empty($dateId)){
    $dateDisable = '';
}else{
    $dateDisable = 'disabled';
}

if(!empty($phoneId)){
    $phoneDisable = '';
}else{
    $phoneDisable = 'disabled';
}

if(!empty($addressId)){
    $addressDisable = '';
}else{
    $addressDisable = 'disabled';
}

$query = "
SELECT DISTINCT 
contact.Contact_id, contact.Fname,contact.Mname, contact.Lname,
phone.Phone_id, phone.Phone_type, phone.Area_code, phone.Phone_Number,
address.Address_id, address.Address_type, address.Address, address.City, address.State, address.Zip,
dates.Date_id,dates.Date_type, dates.Date_value
FROM contact
LEFT JOIN phone
ON contact.Contact_id = phone.Contact_id
LEFT JOIN address
ON phone.Contact_id = address.Contact_id
LEFT JOIN dates
ON address.Contact_id = dates.Contact_id
WHERE contact.Contact_id = $id";
if(!empty($phoneId)){
    $query .= " AND phone.Phone_id = $phoneId";
}
if(!empty($addressId)){
    $query .= " AND address.Address_id = $addressId";
}
if(!empty($dateId)){
    $query .= " AND dates.Date_id = $dateId";
}

// echo $query;


$result1 = $conn->query($query);
$row = mysqli_fetch_assoc($result1);
$fname = $row['Fname'];
$mname = $row['Mname'];
$lname = $row['Lname'];
$phoneId = $row['Phone_id'];
$phoneType = $row['Phone_type'];
$areaCode = $row['Area_code'];
$phoneNo = $row['Phone_Number'];
$addressId = $row['Address_id'];
$addressType = $row['Address_type'];
$address = $row['Address'];
$city = $row['City'];
$state = $row['State'];
$zip = $row['Zip'];
$dateId = $row['Date_id'];
$dateType = $row['Date_type'];
$date = $row['Date_value'];

if(isset($_POST['submit'])){
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $phoneType = $_POST['phoneType'];
    $phoneNo = $_POST['phoneNo'];
    $areaCode = substr($phoneNo, 0, 3);
    $address = $_POST['address'];
    $addressType = $_POST['addressType'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $dateType = $_POST['dateType'];
    $date = $_POST['date'];
    $sql = "
    UPDATE contact, address, phone, dates
    SET contact.Fname = '$fname',
    contact.Mname = '$mname',
    contact.Lname = '$lname'";
    if(!empty($phoneId)){
        $sql .= "
        , phone.Phone_type = '$phoneType', 
        phone.Area_code = '$areaCode', 
        phone.Phone_Number = '$phoneNo'
        ";
    }
    if(!empty($addressId)){
        $sql .= ", 
        address.Address_type = '$addressType', 
        address.Address = '$address', 
        address.City = '$city', 
        address.State = '$state', 
        address.Zip = '$zip'
        ";
    }
    if(!empty($dateId)){
        $sql .= "
        , dates.Date_type = '$dateType', 
        dates.Date_value = '$date'
        ";
    }
    $sql .= "  
    WHERE contact.Contact_id = $id
    ";
    if(!empty($phoneId)){
        $sql .= " AND phone.Contact_id = $id AND phone.Phone_id = $phoneId";
    }
    if(!empty($addressId)){
        $sql .= " AND address.Contact_id = $id AND address.Address_id = $addressId";
    }
    if(!empty($dateId)){
        $sql .= " AND dates.Contact_id = $id AND dates.Date_id = $dateId";
    }
    
    
  
    $result = $conn->query($sql);
    if($result){

        header('location:index.php');
    }else{
    //   die(mysqli_error($conn));
        header('location:index.php');
    }

}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"> 
    <!-- Date validaiton javascript-->
    <title>Contact List--Update</title>
  </head>
  <body>
    <div class="container">
    <div class="fs-3 text-center my-3 h2">Contact Update</div>
    <form method="post" name="update-form">
        <div class="mb-3 fs-6">
            <label class="form-label">First Name</label>
            <input type="text" class="form-control" placeholder="First Name" name="fname" value=<?php echo $fname;?>>
            <label class="form-label">Middle Name</label>
            <input type="text" class="form-control" placeholder="Middle Name" name="mname" value=<?php echo $mname;?>>
            <label class="form-label">Last Name</label>
            <input type="text" class="form-control" placeholder="Last Name" name="lname" value=<?php echo $lname;?>>
            <label class="form-label">Phone Type</label>
            <select name="phoneType" id="phoneType" class="form-select form-select-sm fs-5" <?php echo $phoneDisable;?>>
                <option value=<?php echo $phoneType;?>><?php echo $phoneType;?></option>
                <option value="Cellular">Cellular</option>
                <option value="Home">Home</option>
                <option value="Work">Work</option>
            </select>
            <label class="form-label">Phone Number</label>
            <input type="text" class="form-control" placeholder="phone number" name="phoneNo" <?php echo $phoneDisable;?> value=<?php echo $phoneNo;?> pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"><br>
            <p class="bg-light"><span class="text-danger">Note:</span> The phone number should like:123-123-1234 </p>
            <label class="form-label">Address Type</label>
            <select name="addressType" id="addressType" class="form-select form-select-sm fs-5" <?php echo $addressDisable;?>>
                <option value=<?php echo $addressType;?>><?php echo $addressType;?></option>
                <option value="Home">Home</option>
                <option value="Work">Work</option>
            </select>
            <label class="form-label">Address</label>
            <input type="text" class="form-control" placeholder="1234 Main St" name="address" <?php echo $addressDisable;?> value=<?php echo $address;?>>
            <label class="form-label">City</label>
            <input type="text" class="form-control" placeholder="Dallas" name="city" <?php echo $addressDisable;?> value=<?php echo $city;?>>
            <label class="form-label">State</label>
            <select name="state" id="state" class="form-select form-select-sm fs-5" <?php echo $addressDisable;?>>
                <option value=<?php echo $state;?>><?php echo $state;?></option>
                <option value="Connecticut">Connecticut</option>
                <option value="Delaware">Delaware</option>
                <option value="District Of Columbia">District Of Columbia</option>
                <option value="Florida">Florida</option>
                <option value="Georgia">Georgia</option>
                <option value="Hawaii">Hawaii</option>
                <option value="Idaho">Idaho</option>
                <option value="Illinois">Illinois</option>
                <option value="Indiana">Indiana</option>
                <option value="Iowa">Iowa</option>
                <option value="Kansas">Kansas</option>
                <option value="Kentucky">Kentucky</option>
                <option value="Louisiana">Louisiana</option>
                <option value="Maine">Maine</option>
                <option value="Maryland">Maryland</option>
                <option value="Massachusetts">Massachusetts</option>
                <option value="Michigan">Michigan</option>
                <option value="Minnesota">Minnesota</option>
                <option value="Mississippi">Mississippi</option>
                <option value="Missouri">Missouri</option>
                <option value="Montana">Montana</option>
                <option value="Nebraska">Nebraska</option>
                <option value="Nevada">Nevada</option>
                <option value="New Hampshire">New Hampshire</option>
                <option value="New Jersey">New Jersey</option>
                <option value="New Mexico">New Mexico</option>
                <option value="New York">New York</option>
                <option value="North Carolina">North Carolina</option>
                <option value="North Dakota">North Dakota</option>
                <option value="Ohio">Ohio</option>
                <option value="Oklahoma">Oklahoma</option>
                <option value="Oregon">Oregon</option>
                <option value="Pennsylvania">Pennsylvania</option>
                <option value="Rhode Island">Rhode Island</option>
                <option value="South Carolina">South Carolina</option>
                <option value="South Dakota">South Dakota</option>
                <option value="Tennessee">Tennessee</option>
                <option value="Texas">Texas</option>
                <option value="Utah">Utah</option>
                <option value="Vermont">Vermont</option>
                <option value="Virginia">Virginia</option>
                <option value="Washington">Washington</option>
                <option value="West Virginia">West Virginia</option>
                <option value="Wisconsin">Wisconsin</option>
                <option value="Wyoming">Wyoming</option>
            </select>
            <label class="form-label">Zipcode</label>
            <input type="text" class="form-control" placeholder="75075" name="zip" <?php echo $addressDisable;?> value=<?php echo $zip;?> pattern=".{5,5}"><br>
            <p class="bg-light"><span class="text-danger">Note:</span> Zipcode length should be 5. </p>
            <label class="form-label">Date Type</label>
            <select name="dateType" id="dateType" class="form-select form-select-sm fs-5" <?php echo $dateDisable;?>>
                <option  value=<?php echo $dateType;?>><?php echo $dateType;?></option>
                <option value="Birthday">Birthday</option>
                <option value="Anniversary">Anniversary</option>
                <option value="Other">Other</option>
            </select>
            <label class="form-label">Date</label>
            <input type="date" class="form-control" placeholder="1986-01-01" name="date" <?php echo $dateDisable;?> value=<?php echo $date;?> >
        <button type='submit' class="btn btn-primary my-2" name="submit">Update</button>
        <button class="btn btn-danger" <?php echo $addressDisable;?>><a class="text-light"  href="deleteAddress.php?deleteAddressId=<?php echo $addressId;?>">Delete Address</a></button>
        <button class="btn btn-danger" <?php echo $dateDisable;?>><a class="text-light"  href="deleteDate.php?deleteDateId=<?php echo $dateId;?>">Delete Date</a></button>
        <button class="btn btn-danger" <?php echo $phoneDisable;?>><a class="text-light"  href="deletePhone.php?deletePhoneId=<?php echo $phoneId;?>">Delete Phone</a></button>
    </form>
    </div>

   
  </body>
</html>