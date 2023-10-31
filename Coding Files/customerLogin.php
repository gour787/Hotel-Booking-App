<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Customer Login</title>
</head>
<?php
	session_start();

	if (isset($_POST['login'] ))
	{
		$customerName = $_POST['customerName'];
		$customerSSN = $_POST['customerSSN'];
		$customerID = $_SESSION['customerID'];

		$conn_string = "host=localhost port = 5432 dbname=db_project user=postgres password = root";

		$dbconn = pg_connect($conn_string) or die('Connection failed');

		$query = "SELECT * FROM public.customer WHERE customer_name =$1 AND customer_ssn = $2";

		$stmt = pg_prepare($dbconn,"ps",$query);
		$result = pg_execute($dbconn,"ps",array($customerName,$customerSSN));

		if(!$result){
			die("Error in SQL query:" .pg_last_error());
		}

		$row_count = pg_num_rows($result);

		if($row_count>0){
			$customer = pg_fetch_assoc($result);
			$_SESSION['customerID'] = $customer['customer_id'];
			$_SESSION['customerSSN'] = $customerSSN;
			$_SESSION['customerName'] = $customerName;
		
			header("location: http://localhost:8080/databases_project/customerRecords.php");
			exit;
		}

		echo "INVALID CUSTOMER DATA.";

		pg_free_result($result);
		pg_close($dbconn);
	}
?>
<body>
	<div id="header"> CUSTOMER LOGIN FORM</div>
	<form method="POST" action="">

		<p>Customer Name: <input type="text" name="customerName" id="customerName" required/></p>
		<p>Customer SSN: <input type="number" name="customerSSN" id="customerSSN" required /></p>
		<p><input type="submit" value="Login" name="login" /></p>

	</form>

	<a href="customerRegister.php">Register</a>

</body>
</html>
