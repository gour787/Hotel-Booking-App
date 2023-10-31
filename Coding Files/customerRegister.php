<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="css/style1.css"/>
<title>Customer Register</title>

<script>

function validate() {
        var custSSN = document.getElementById("fieldCustomerSSN");
        var custName = document.getElementById("fieldCustomerName");
        var custAddress = document.getElementById("fieldCustomerAddress");
        var registrationDate = document.getElementById("fieldRegistrationDate");

        if(custSSN.value == "" || custName.value == "" || custAddress.value == "" || custPwdagain.value == "" ){
            alert("You need to fill all the information");
            return false;
        }
        
        else if(custSSN.value.length != 9){
            alert("The length of SSN needs to be 9");
            return false;
        }
        
        else return true;
    }

</script>

</head>
	<?php
	session_start();
		if (isset($_POST['save'] ))
		{
			$customerID = mt_rand(100000000, 999999999);
			$_SESSION['customerID'] = $customerID;

			$customerSSN = $_POST['fieldCustomerSSN'];
			$customerName = $_POST['fieldCustomerName'];
			$customerAddress = $_POST['fieldCustomerAddress'];
			$registrationDate = $_POST['fieldRegistrationDate'];

			$conn_string = "host=localhost port = 5432 dbname=db_project user=postgres password = root";

			$dbconn = pg_connect($conn_string) or die('Connection failed');

			$query = "INSERT INTO public.customer(customer_id, customer_ssn, customer_name, customer_address, registration_date) VALUES ('$customerID','$customerSSN','$customerName','$customerAddress','$registrationDate')";

			$result = pg_query($dbconn,$query);

			if(!$result){
				die("Error in SQL query:" .pg_last_error());
			}

			echo "Data Successfully Entered ". "<a href='customerLogin.php'>Login now</a>";

			pg_free_result($result);
			pg_close($dbconn);
		}
	?>

<body>
	<div id="header"> CUSTOMER REGISTRATION FORM </div>
	<form id="testform" name="testform" method="POST" action="">

		<p> <label for="fieldCustomerSSN"> Customer SSN: </label>
				<input name="fieldCustomerSSN" type="number" id="fieldCustomerSSN"/>
		</p>

		<p> <label for="fieldCustomerName"> Customer Name: </label>
				<input name="fieldCustomerName" type="text" id="fieldCustomerName"/>
		</p>

		<p> <label for="fieldCustomerAddress"> Customer Address: </label>
				<input name="fieldCustomerAddress" type="text" id="fieldCustomerAddress"/>
		</p>

		<p> <label for="fieldRegistrationDate"> Date of Registration: </label>
				<input name="fieldRegistrationDate" type="date" id="fieldRegistrationDate"/>
		</p>

		<p><input type="submit" value="Register" name="save" onclick = "return validate();" /></p>
	</form>

</body>
</html>
