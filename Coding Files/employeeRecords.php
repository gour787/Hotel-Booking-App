<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Employee Information</title>
	</head>

	<div id="header">Employee Record Details</div>

	<br>

	<?php
        session_start();
        if (!isset($_SESSION['employeeID']) && !isset($_SESSION['employeeName']) && !isset($_SESSION['empHotelID']))
        {
            echo "Please" ."<a href='employeeLogin.php'>Login</a>";
            exit;
        }

        $conn_string = "host=localhost port = 5432 dbname=db_project user=postgres password = root";

		$dbconn = pg_connect($conn_string) or die('Connection failed');

        $employeeName = $_SESSION['employeeName'];
        $employeeID = $_SESSION['employeeID'];
        $empHotelID = $_SESSION['empHotelID'];


        echo "Employee Name: ". $employeeName . "<br><br>";
        echo "Employee ID: ". $employeeID . "<br><br>";
        echo "Hotel ID: " . $empHotelID . "<br><br>";
    ?>

    <br>
    <br>

    <body>
        <div id="header"> COLLECT INFORMATION FOR CUSTOMERS RENTAL PROCESS </div>
            <form method="POST" action="">
                <p>Please Ask The Customer The HOTEL ID They Want To Rent A Room For: <input type="number" name="enteredHotelID" id="enteredHotelID" required/></p>
                <p><input type="submit" value="Assist Customer" name="help" /></p>
            </form> 
    </body>

    <?php
        if (isset($_POST['help'])) {
            $enteredHotelID = $_POST['enteredHotelID'];

            if (!($enteredHotelID == $empHotelID)) {
                echo "You cannot help the customer rent out their room, because you work in a different hotel.";
            }
            
            else {
                echo
                '<body>
                    <form method="POST" action="">
                        <p>
                            Please Ask The Customer For Their Customer ID:
                            <input type="number" name="enteredCustomerID" id="enteredCustomerID" required>
                        </p>
                        <p><input type="submit" value="Continue" name="continue" /></p>
                    </form> 
                </body>';
            }
        }
    ?>

    <?php
        if (isset($_POST['continue'])) {
            $enteredCustomerID = $_POST['enteredCustomerID'];

            if (!$enteredCustomerID || strlen($enteredCustomerID) != 9) {
                echo "Enter a valid Customer ID with 9 digits.";
            }            
            
            else {
                echo
                '<body>
                    <form method="POST" action="">
                        <p>
                            <label for="yes-no-radio"> Ask The Customer If They Have A Booking: </label>

                            <input type="radio" name="enteredBookingValue" id="enteredBookingValueYes" value="Yes" required>
                            <label for="enteredBookingValueYes"> Yes </label>
                            
                            <input type="radio" name="enteredBookingValue" id="enteredBookingValueNo" value="No" required>
                            <label for="enteredBookingValueNo"> No </label>
                        </p>
                        <p><input type="submit" value="Continue" name="booking" /></p>
                    </form> 
                </body>';
            }
        }
    ?>

    <?php
        if (isset($_POST['booking'])) {
            $enteredBookingValue = $_POST['enteredBookingValue'];
            $enteredRoomNumber = "";

            if ($enteredBookingValue == "Yes") {
                echo "The customer does have a booking. We will turn this booking into a renting, so the customer can now rent out their room.";

                echo
                '<body>
                    <form method="POST" action="">
                        <p>
                            Please Ask The Customer For The Room Number They Booked:
                            <input type="number" name="enteredRoomNumber" id="enteredRoomNumber" required min = "1" max = "5">

                            <br>
                            <br>

                            Please Ask The Customer For Their Credit Card Information:
                            <input type="text" name="enteredCCInfo" id="enteredCCInfo" required>

                            <p><input type="submit" value="Continue" name="numberOfRoom" /></p>
                        </p>
                    </form> 
                </body>';
            }

            else if ($enteredBookingValue == "No") {
                echo "The customer does not have a booking. However, we can rent a room for them straight away since they are conversating with the employee.";

                echo '<br> <br>';

                echo 'Here are all the available rooms for the current hotel. Please ask the customer to select one:';

                $sql1 = "SELECT price, capacity, amenities, room.hotel_id, room_number FROM public.room
                WHERE room.hotel_id = $1 AND room.booked = 'empty'";
        
                $stmt1 = pg_prepare($dbconn,"ps1",$sql1);
                $result1 = pg_execute($dbconn, "ps1", array($empHotelID));
                
                if(!$result1){
                    die("Error in SQL query:" .pg_last_error());
                }

                else {
                    $resultArr = pg_fetch_all($result1);
                ?>
                    <table style="border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="border: 1px solid black; padding: 8px;">Price</th>
                            <th style="border: 1px solid black; padding: 8px;">Capacity</th>
                            <th style="border: 1px solid black; padding: 8px;">Amenities</th>
                            <th style="border: 1px solid black; padding: 8px;">Hotel ID</th>
                            <th style="border: 1px solid black; padding: 8px;">Room Number</th>
                            <th style="border: 1px solid black; padding: 8px;">Rent It!</th>
                        </tr>
                    </thead>
                    <tbody>

                    <tbody>
                    <?php foreach($resultArr as $array) : ?>
                        <tr>
                            <form action="rentInPerson.php" method="get">
                                <input type="hidden" name="hotel_id" value="<?= $array['hotel_id'] ?>">
                                <input type="hidden" name="room_number" value="<?= $array['room_number'] ?>">
                                <td style="border: 1px solid black; padding: 8px;"><?= $array['price'] ?></td>
                                <td style="border: 1px solid black; padding: 8px;"><?= $array['capacity'] ?></td>
                                <td style="border: 1px solid black; padding: 8px;"><?= $array['amenities'] ?></td>
                                <td style="border: 1px solid black; padding: 8px;"><?= $array['hotel_id'] ?></td>
                                <td style="border: 1px solid black; padding: 8px;"><?= $array['room_number'] ?></td>
                                <td style="border: 1px solid black; padding: 8px;">
                                    <input type="submit" name="rentInPerson" value="Rent">
                                </td>
                            </form>
                        </tr>
                        <tr>
                            <td><br></td>
                            <td><br></td>
                            <td><br></td>
                            <td><br></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                <?php
                }
            }
        }
    ?>

    <?php
        if (isset($_POST['numberOfRoom'])) {
            $enteredRoomNumber = $_POST['enteredRoomNumber'];
            $enteredCCInfo = $_POST['enteredCCInfo'];

            echo "ENTERING DATA";

            echo '<br> <br>';
        
            $sql1 = "";
            $result1 = "";

            $sql2 = "";
            $result2 = "";

            $sql1 = "UPDATE public.room SET booked = 'occupied' WHERE room_number = $enteredRoomNumber AND hotel_id = $empHotelID";
            $result1 = pg_query($dbconn, $sql1);

            $sqlStartDate = "SELECT start_date FROM public.room WHERE room_number = $enteredRoomNumber AND hotel_id = $empHotelID";
            $sqlEndDate = "SELECT end_date FROM public.room WHERE room_number = $enteredRoomNumber AND hotel_id = $empHotelID";
            $sqlCustID = "SELECT customer_id FROM public.room WHERE room_number = $enteredRoomNumber AND hotel_id = $empHotelID";

            $result3 = pg_query($dbconn, $sqlStartDate);
            $result4 = pg_query($dbconn, $sqlEndDate);
            $result5 = pg_query($dbconn, $sqlCustID);

            if (!$result1 || !$result3 || !$result4 || !$result5) {
                die("Error in SQL query:" . pg_last_error());
            }

            $row3 = pg_fetch_row($result3);
            $row4 = pg_fetch_row($result4);
            $row5 = pg_fetch_row($result5);

            $resultingStartDate = $row3[0];
            $resultingEndDate = $row4[0];
            $resultingCustID = $row5[0];

            echo "START DATE: " . $resultingStartDate;
            echo '<br> <br>';
            echo "END DATE: " . $resultingEndDate;
            echo '<br> <br>';
            echo "CUSTOMER ID: " . $resultingCustID;

            $sql2 = "INSERT INTO public.rent VALUES ($empHotelID, $resultingCustID, $enteredRoomNumber, '$enteredCCInfo', '$resultingStartDate', '$resultingEndDate')";
            $result2 = pg_query($dbconn, $sql2);

            if(!$result2){
                die("Error in SQL query:" .pg_last_error());
            }
    
            echo "
            <br> <br>
            Data Successfully Entered.
            <br> <br>
            Updated Room Status to occupied AND entered values in Rent Table FOR BOOKING TO RENTING.";
    
            pg_free_result($result1);
            pg_free_result($result2);
            pg_free_result($result3);
            pg_free_result($result4);
            pg_free_result($result5);
            pg_close($dbconn);
        }
    ?>

</html>