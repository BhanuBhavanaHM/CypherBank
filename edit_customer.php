<?php
    if(!isset($_SESSION)) {
        session_start();
    }

    include "validate_admin.php";
    include "connect.php";
    include "header.php";
    include "user_navbar.php";
    include "admin_sidebar.php";
    include "session_timeout.php";

    if (isset($_GET['cust_id'])) {
        $_SESSION['cust_id'] = $_GET['cust_id'];
    }

    $sql0 = "SELECT * FROM customer WHERE cust_id=".$_SESSION['cust_id'];
    $sql1 = "SELECT * FROM passbook".$_SESSION['cust_id']." WHERE trans_id=(
                    SELECT MAX(trans_id) FROM passbook".$_SESSION['cust_id'].")";

    $result0 = $conn->query($sql0);
    $result1 = $conn->query($sql1);

    if ($result0->num_rows > 0) {
        // output data of each row
        while($row = $result0->fetch_assoc()) {
            $fname = $row["first_name"];
            $lname = $row["last_name"];
            $gender = $row["gender"];
            $dob = $row["dob"];
            $email = $row["email"];
            $phno = $row["phone_no"];
            $address = $row["address"];
            $branch = $row["branch"];
            $acno = $row["account_no"];
            $pin = $row["pin"];
            $cus_uname = $row["uname"];
            $cus_pwd = $row["pwd"];
        }
    }

    if ($result1->num_rows > 0) {
        // output data of each row
        while($row = $result1->fetch_assoc()) {
            $balance = $row["balance"];
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="customer_add_style.css">
</head>

<body>
    <form class="add_customer_form" action="edit_customer_action.php" method="post">
        <div class="flex-container-form_header">
            <h1 id="form_header">Edit/View Customer details . . .</h1>
        </div>

        <div class="flex-container">
            <div class=container>
                <label>Customer ID : <label id="info_label"> <?php echo $_SESSION['cust_id'] ?> </label></label>
            </div>
        </div>

        <div class="flex-container">
            <div class=container>
                <label>First Name :</label><br>
                <input name="fname" size="30" type="text" value="<?php echo $fname ?>" required />
            </div>
            <div  class=container>
                <label>Last Name :</label><br>
                <input name="lname" size="30" type="text" value="<?php echo $lname ?>" required />
            </div>
        </div>

        <div class="flex-container">
            <div class=container>
                
                 <label>Balance (INR) : <label id="info_label"> <?php echo number_format($balance) ?> </label></label>
                 + <input name="amt" size="24" type="number" value="" required />
            </div>
        </div>

        <div class="flex-container">
            <div class=container>
                <label>Gender :
                    <label id="info_label">
                    <?php
                        if ($gender == "male") {echo "Male";}
                        elseif ($gender == "female") {
							echo "Female";
							}
                        else {
							echo "Others";
							}
                    ?>
					</label>
				</label>
                  </div>
        </div>

        <div class="flex-container">
            <div class=container>
                <label>Date of Birth :</label><br>
                <input name="dob" size="30" type="text" placeholder="yyyy-mm-dd" value="<?php echo $dob ?>" required />
            </div>
        </div>

        <div class="flex-container">
            <div class=container>
                <label>Email-ID :</label><br>
                <input name="email" size="30" type="text" value="<?php echo $email ?>" required />
            </div>
            <div  class=container>
                <label>Phone No. :</label><br>
                <input name="phno" size="30" type="text" value="<?php echo $phno ?>" required />
            </div>
        </div>

        <div class="flex-container">
            <div class=container>
                <label>Address :</label><br>
                <textarea name="address" required ><?php echo $address ?></textarea>
            </div>
        </div>

        <div class="flex-container">
            <div class=container>
                <label>Bank Branch :</label>
            </div>
            <div  class=container>
                <select name="branch">
                    <option value="delhi" <?php if ($branch == 'delhi') {?> selected="selected" <?php }?>>Delhi</option>
                    <option value="Chennai" <?php if ($branch == 'Chennai') {?> selected="selected" <?php }?>>Chennai</option>
                    <option value="paris" <?php if ($branch == 'paris') {?> selected="selected" <?php }?>>Paris</option>
                    <option value="Bangalore" <?php if ($branch == 'Bangalore') {?> selected="selected" <?php }?>>Bangalore</option>
                    <option value="Hassan" <?php if ($branch == 'Hassan') {?> selected="selected" <?php }?>>Hassan</option>
                </select>
            </div>
        </div>

        <div class="flex-container">
            <div class=container>
                <label>Account No :</label><br>
                <input name="acno" size="25" type="text" value="<?php echo $acno ?>" required />
            </div>
        </div>

        <div class="flex-container">
            <div  class=container>
                <label>PIN(4 digit) :</label><br>
                <input name="pin" size="15" type="text" value="<?php echo $pin ?>" required />
            </div>
        </div>

        <div class="flex-container">
            <div class=container>
                <label>Username :</label><br>
                <input name="cus_uname" size="30" type="text" value="<?php echo $cus_uname ?>" required />
            </div>
            <div  class=container>
                <label>Password :</label><br>
                <input name="cus_pwd" size="30" type="text" value="<?php echo $cus_pwd ?>" required />
            </div>
        </div>

        <div class="flex-container">
            <div class="container">
                <a href="manage_customers.php" class="button">Go Back</a>
            </div>
            <div class="container">
                <button type="submit">Update</button>
            </div>
        </div>

    </form>

</body>
</html>
