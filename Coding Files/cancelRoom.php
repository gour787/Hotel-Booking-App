<?php
    session_start();
    if (isset($_GET['cancelRoom'])) {
        $customerID = $_SESSION['customerID'];
        $hotelID = $_GET['hotel_id'];
        $roomNumber = $_GET['room_number'];

        $conn_string = "host=localhost port = 5432 dbname=db_project user=postgres password = root";
		$dbconn = pg_connect($conn_string) or die('Connection failed');

        $sqlCancel = "";
        $resultCancel = "";

        $sqlCancel = "UPDATE public.room SET booked = 'empty', customer_id = null, start_date = null, end_date = null  WHERE room_number = $roomNumber AND hotel_id = $hotelID";
        $resultCancel = pg_query($dbconn, $sqlCancel);

        if(!$resultCancel){
			die("Error in SQL query:" .pg_last_error());
		}

        else {
            echo "We have cancelled your booking for the room number: " . $roomNumber . " in the hotel where the hotel ID is: " . $hotelID;
        }

        pg_free_result($resultCancel);
    }
?>