<?php
include('connect.php');
include('header.php');
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
  INSERT INTO CONTACT (Fname, Mname, Lname) VALUES ('$fname', '$mname', '$lname');";
  

  $result = $conn->query($sql);
  if($result){
    $last_id = $conn->insert_id;
  }else{
    die(mysqli_error($conn));
  }

  $sql2="
  INSERT INTO ADDRESS (Contact_id, Address_type, Address, City, State, Zip)
  VALUES (
          '$last_id',
          '$addressType',
          '$address',
          '$city',
          '$state',
          '$zip'
      );";

  $sql3="INSERT INTO PHONE (Contact_id, Phone_type, Area_code, Phone_Number) VALUES ('$last_id', '$phoneType', '$areaCode', '$phoneNo');";
  $sql4="INSERT INTO DATES (Contact_id, Date_type, Date_value) VALUES ('$last_id', '$dateType', '$date');";
  
  $result2 = $conn->query($sql2);
  $result3 = $conn->query($sql3);
  $result4 = $conn->query($sql4);
  
  if($result2 && $result3 && $result4){
    // echo $sql, $sql2, $sql3, $sql4;
    // echo "data inserted success!";
    header('location:index.php');
  }else{
    // die(mysqli_error($conn));
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
    <title>Contact List--Insert</title>
  </head>
  <body>
    <div class="container">
    <div class="fs-3 text-center my-3 h2">Insert New Contact</div>
    <form method="post" name="insert-form">
        <div class="mb-3 fs-6">
            <label class="form-label">First Name</label>
            <input type="text" class="form-control" placeholder="First Name" name="fname">
            <label class="form-label">Middle Name</label>
            <input type="text" class="form-control" placeholder="Middle Name" name="mname">
            <label class="form-label">Last Name</label>
            <input type="text" class="form-control" placeholder="Last Name" name="lname">
            <label class="form-label">Phone Type</label>
            <select name="phoneType" id="phoneType" class="form-select form-select-sm fs-5">
                <option value="Cellular">Cellular</option>
                <option value="Home">Home</option>
                <option value="Work">Work</option>
            </select>
            <label class="form-label">Phone Number</label>
            <div>
              <input type="text" class="form-control" placeholder="phone number" name="phoneNo" id="phoneNo" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"><br>
              <p class="bg-light"><span class="text-danger">Note:</span> The phone number should like:123-123-1234 </p>
            </div>
            <label class="form-label">Address Type</label>
            <select name="addressType" id="addressType" class="form-select form-select-sm fs-5">
                <option value="Home">Home</option>
                <option value="Work">Work</option>
            </select>
            <label class="form-label">Address</label>
            <input type="text" class="form-control" placeholder="1234 Main St" name="address">
            <label class="form-label">City</label>
            <input type="text" class="form-control" placeholder="Dallas" name="city">
            <label class="form-label">State</label>
            <select name="state" id="state" class="form-select form-select-sm fs-5">
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
            <input type="text" class="form-control" placeholder="75075" name="zip" pattern=".{5,5}"><br>
            <p class="bg-light"><span class="text-danger">Note:</span> Zipcode length should be 5. </p>
            <label class="form-label">Date Type</label>
            <select name="dateType" id="dateType" class="form-select form-select-sm fs-5" >
                <option value="Birthday">Birthday</option>
                <option value="Anniversary">Anniversary</option>
                <option value="Other">Other</option>
            </select>
            <label class="form-label">Date</label>
            <div>
              <input type="date" class="form-control" name="date" id="date">
            </div>
            
        <button type='submit' class="btn btn-primary my-2" name="submit">Submit</button>
    </form>
    </div>

   <?php
   include('footer.php');
   ?>
  </body>
</html>