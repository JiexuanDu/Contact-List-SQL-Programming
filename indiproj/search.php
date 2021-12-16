<?php
include('header.php');
include('connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact List</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"> 
</head>
<body>

<div class="container">
<div class="fs-3 text-center my-3 h2">Contact-Search</div>
<form class="input-group mb-3" method="post">
  <input type="text" class="form-control" placeholder="Name/Phone/Address..." aria-label="Recipient's username" aria-describedby="basic-addon2" name="search">
  <button type='submit' class="btn btn-primary" name="submit">Search</button>
</form>
<table class="table fs-6 text-center">
  <thead>
    <tr>
      <th scope="col">Contact ID</th>
      <th scope="col">First Name</th>
      <th scope="col">Middle Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Phone Type</th>
      <th scope="col">Area Code</th>
      <th scope="col">Phone Number</th>
      <th scope="col">Address Type</th>
      <th scope="col">Address</th>
      <th scope="col">City</th>
      <th scope="col">State</th>
      <th scope="col">Zipcode</th>
      <th scope="col">Date Type</th>
      <th scope="col">Date</th>
      <th scope="col" class="text-center">Operation</th>
    </tr>
  </thead>
  <tbody>
    <?php
        if(isset($_POST['submit'])){
            $search = $_POST['search'];
            $sql = "SELECT DISTINCT 
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
                    WHERE CONCAT_WS('', contact.Fname, contact.Mname, contact.Lname,
                    phone.Phone_type, phone.Area_code, phone.Phone_Number,
                    address.Address_type, address.Address, address.City, address.State, address.Zip,
                    dates.Date_type, dates.Date_value) LIKE '%".$search."%'
                    OR CONCAT(TRIM(contact.Fname), ' ', TRIM(contact.Mname), ' ', TRIM(contact.Lname)) LIKE '%".$search."%'
                    OR CONCAT(TRIM(contact.Fname), ' ', TRIM(contact.Lname)) LIKE '%".$search."%'
                    OR CONCAT(TRIM(contact.Fname), ' ', TRIM(address.City)) LIKE '%".$search."%'
                    ";

            $result = $conn->query($sql);
            if($result){
                while($row = mysqli_fetch_assoc($result)){
                    $id = $row['Contact_id'];
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
                    echo '<tr>
                    <th scope="row">'.$id.'</th>
                    <td>'.$fname.'</td>
                    <td>'.$mname.'</td>
                    <td>'.$lname.'</td>
                    <td>'.$phoneType.'</td>
                    <td>'.$areaCode.'</td>
                    <td>'.$phoneNo.'</td>
                    <td>'.$addressType.'</td>
                    <td>'.$address.'</td>
                    <td>'.$city.'</td>
                    <td>'.$state.'</td>
                    <td>'.$zip.'</td>
                    <td>'.$dateType.'</td>
                    <td>'.$date.'</td>
                    <td>
                        <button class="btn btn-primary"><a class="text-light" href="update.php?updateId='.$id.'&phoneId='.$phoneId.'&addressId='.$addressId.'&dateId='.$dateId.'">Update</a></button>
                        <button class="btn btn-info"><a class="text-light"  href="addNewInfo.php?addId='.$id.'">Add Info</a></button>
                        <button class="btn btn-danger"><a class="text-light"  href="delete.php?deleteId='.$id.'">Delete</a></button>
                    </td>
                </tr>';
                }
            }
        }
        
    ?>
    
  </tbody>
</table>

</div> 
<?php
    include('footer.php');
?>
</body>
</html>