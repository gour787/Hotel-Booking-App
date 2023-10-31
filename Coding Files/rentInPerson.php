<?php
session_start();
if (isset($_GET['rentInPerson'])) {
    $inPersonRentalHotelID = $_GET['hotel_id'];
    $inPersonRentalRoomNumber = $_GET['room_number'];
    $startDate = "";
    $endDate = "";
    $enteredCCInfoInPerson = "";
    $enteredCustomerID = "";

    echo
        '
        <form method="get" action="rentInPerson.php">
            <input type="hidden" name="hotel_id" value="' . $inPersonRentalHotelID . '">
            <input type="hidden" name="room_number" value="' . $inPersonRentalRoomNumber . '">
            <p> Please enter the start date for the booking of the room: <input type="date" name="startDate" id="startDate" required/></p>
            <p> Please enter the end date for the booking of the room: <input type="date" name="endDate" id="endDate" required/></p>
            <p> Please enter the CUSTOMER ID again: <input type="number" name="enteredCustomerID" id="enteredCustomerID" required></p>
            <p> 
                Please Ask The Customer For Their Credit Card Information:
                <input type="text" name="enteredCCInfo" id="enteredCCInfo" required>
            </p>
            <p> <input type="submit"value="Complete Rental!" name="completed" required> </p>
        </form>
        ';
}

if (isset($_GET['completed'])) {
    $conn_string = "host=localhost port = 5432 dbname=db_project user=postgres password = root";
    $dbconn = pg_connect($conn_string) or die('Connection failed');

    $inPersonRentalRoomNumber = $_GET['room_number'];
    $inPersonRentalHotelID = $_GET['hotel_id'];

    if (isset($_GET["startDate"])) {
        $startDate = $_GET["startDate"];
        // echo "The start date is " . $startDate;
    }

    if (isset($_GET["endDate"])) {
        $endDate = $_GET["endDate"];
        // echo "The end date is " . $endDate;
    }

    if (isset($_GET["enteredCCInfo"])) {
        $enteredCCInfoInPerson = $_GET["enteredCCInfo"];
        // echo "The CC Information is " . $enteredCCInfoInPerson;
    }

    if (isset($_GET["enteredCustomerID"])) {
        $enteredCustomerID = $_GET["enteredCustomerID"];
        // echo "The customer ID is " . $enteredCustomerID;
    }

    // echo "The room number is " . $inPersonRentalHotelID;
    // echo "The hotel ID is " . $inPersonRentalHotelID;

    $sql1 = "UPDATE public.room SET customer_id=$enteredCustomerID, start_date='$startDate', booked = 'occupied', end_date='$endDate' WHERE room_number = $inPersonRentalRoomNumber AND hotel_id = $inPersonRentalHotelID";
    $result1 = pg_query($dbconn, $sql1);
    pg_free_result($result1);

    $sql2 = "INSERT INTO public.rent VALUES ($inPersonRentalHotelID, $enteredCustomerID, $inPersonRentalRoomNumber, '$enteredCCInfoInPerson', '$startDate', '$endDate')";
    $result2 = pg_query($dbconn, $sql2);
    pg_free_result($result2);

    pg_close($dbconn);

    echo "We have rented you room for the specified dates. Thank you. Please visit again soon!";
}
?>
