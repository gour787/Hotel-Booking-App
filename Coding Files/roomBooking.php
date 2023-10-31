<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Booking Information</title>
	</head>

    <?php
    session_start();
	$customerSSN = $_SESSION['customerSSN'];
    $customerID = $_SESSION['customerID'];
	$customerName = $_SESSION['customerName'];
    $hotel_id = $_GET['hotel_id'];
    $room_number = $_GET['room_number'];    

	echo "Hello Customer: ". $customerName . "<br><br>";
    echo "Customer ID: " . $customerID . "<br><br>";
	echo "Your SSN Is: " . $customerSSN . "<br><br>";
    echo "Hotel ID: ". $hotel_id. "<br><br>";
	echo "Room #: " . $room_number . "<br><br>";

    $conn_string = "host=localhost port = 5432 dbname=db_project user=postgres password = root";

    $dbconn = pg_connect($conn_string) or die('Connection failed');

    $startDate = null;
    $endDate = null;

    if (isset($_GET["startDate"])) {
		$startDate= $_GET["startDate"];
	}

    if (isset($_GET["endDate"])) {
		$endDate = $_GET["endDate"];
	}

    // Do something with the selected option here
	if (empty($startDate)) {
		echo "You have not entered a starting date." . "<br><br>";
	}

	else if (!empty($startDate)) {
		echo "The starting date is " . $startDate . "<br><br>";
	}

    if (empty($endDate)) {
		echo "You have not entered an ending date." . "<br><br>";
	}

	else if (!empty($endDate)) {
		echo "The ending date is " . $endDate . "<br><br>";
	}

    $sql1 = "";
    $result1 = "";

    if (!empty($startDate) && !empty($endDate)) {
        // $sql1 = "INSERT INTO public.rent(hotel_id, customer_id, room_number, start_date, end_date) VALUES ('$hotel_id', '$customerID', '$room_number', '$startDate', '$endDate')";
        // $result1 = pg_query($dbconn,$sql1);

        // if(!$result1){
        //     die("Error in SQL query:" .pg_last_error());
        // }

        $sql2 = "UPDATE public.room SET booked = 'booked', customer_id = '$customerID', start_date = '$startDate', end_date = '$endDate' WHERE room_number = $room_number AND hotel_id = $hotel_id";
        $result2 = pg_query($dbconn, $sql2);;

        if(!$result2){
            die("Error in SQL query:" .pg_last_error());
        }

        echo "Data Successfully Entered. Updated Room Status to BOOKED.";

        // pg_free_result($result1);
        pg_free_result($result2);
        pg_close($dbconn);
    }
    ?>

    <body>

        <p> Credit Card Information/Customer Payment will be collected via in person for security and safe transactions. </p>

        <form method = "get">
            <input type="hidden" name="hotel_id" value="<?php echo $hotel_id ?>">
            <input type="hidden" name="room_number" value="<?php echo $room_number ?>">
            <p> Please enter the start date for the booking of the room: <input type="date" name="startDate" id="startDate" required/></p>
            <p> Please enter the end date for the booking of the room: <input type="date" name="endDate" id="endDate" required/></p>
            <input type="submit" value="Submit">
        </form>

    </body>

</html>    