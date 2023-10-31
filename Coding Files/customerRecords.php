<!--

rents
hotel_id(foreign key)
customer id(foreign key)
cc-info
start date
end date



ROOMS YOU HAVE BOOKED:
[EDIT] - Change Date
[CANCEL] - Cancel booking

These criteria should be: the dates (start, end) of booking or renting, the room capacity, the area, the hotel chain, the category
of the hotel, the total number of rooms in the hotel, the price of the rooms.

7 DROP DOWNS TOTAL:

1. [DROPDOWN] Choose a hotel chain:
2. [TEXT TYPE] Type in a city you would like to live in for the hotel:
3. [DROPDOWN] What hotel star category would you like?
4. [VIEW] Total number of rooms in the hotel: {HOW MANY OF THE HOTEL ROOMS ARE NOT BOOKED}
5. [DROPDOWN] Choose a price for the room:
6. [DROPDOWN] Which capacity of the room would you like? {SINGLE OR DOUBLE}
7. [TEXT TYPE] Select a date you would like to book for the room:
-->
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Customer Information</title>
	</head>

	<div id="header">Customer Record Details</div>
	<br>

	<script>

</script>

	<?php
	session_start();
	if (!isset($_SESSION['customerSSN']) && !isset($_SESSION['customerID']))
	{
		echo "Please" ."<a href='customerLogin.php'>Login</a>";
		exit;
	}

	$customerSSN = $_SESSION['customerSSN'];
	$customerName = $_SESSION['customerName'];
	$customerID = $_SESSION['customerID'];


	echo "Hello Customer: ". $customerName . "<br><br>";
	echo "Your SSN Is: " . $customerSSN . "<br><br>";
	
	if (isset($_SESSION['customerID']) && $_SESSION['customerID'] != '') {
		echo "Your Customer ID Is: " . $customerID . "<br><br>";
	}
	
	else {
		echo "Customer ID is not set or has an invalid value" . "<br><br>";
	}

	$conn_string = "host=localhost port = 5432 dbname=db_project user=postgres password = root";
	$dbh = pg_connect($conn_string) or die('Connection failed');

	$chosenChain = null;
	$cityName = null;
	$starCategory = null;
	$showRooms = null;
	$chosenPrice = null;
	$chosenCapacity = null;

	echo '<div style="display: inline-block; margin-right: 10px;">Would you like to view your current rentings and bookings?</div>';
	echo 
	'<div style="display: inline-block;">
	<form method = "POST" action = "customerView.php">
	<p>
		<input type="submit" value="View Rooms Currently Booked/Rented" name="showCurrentCustomer" />
	</p>
	</form>
	</div>';


	if (isset($_GET["hotelChains"])) {
		$chosenChain = $_GET["hotelChains"];
	}

	if (isset($_GET["cityName"])) {
		$cityName = $_GET['cityName'];
	}

	if (isset($_GET["starCategory"])) {
		$starCategory = $_GET['starCategory'];
	}

	if (isset($_GET["showRooms"])) {
		$showRooms = $_GET['showRooms'];
	}

	if (isset($_GET["choosePrice"])) {
		$chosenPrice = $_GET['choosePrice'];
	}

	if (isset($_GET["chooseCapacity"])) {
		$chosenCapacity = $_GET['chooseCapacity'];
	}
	
	if (isset($_GET["findDate"])) {
		$findDate= $_GET['findDate'];
	}

	// Do something with the selected option here
	echo '<br>';

	if (empty($chosenChain)) {
		echo "You selected: " . "Nothing". " for the hotel chain." . "<br><br>";
	}

	else if (!empty($chosenChain)) {
		echo "You selected: " . $chosenChain. " for the hotel chain." . "<br><br>";
	}

	if (empty($cityName)) {
		echo "You selected: " . "Nothing" . " for the city." . "<br><br>";
	}

	else if (!empty($cityName)) {
		echo "You selected: " . $cityName . " for the city." . "<br><br>";
	}

	if ($starCategory == 0) {
		echo "You selected: Nothing for the star category of the hotel." . "<br><br>";
	}

	else if ($starCategory != 0) {
		echo "You selected: " . $starCategory . " for the star category of the hotel." . "<br><br>";
	}

	if (empty($showRooms)) {
		echo "You selected: " . "Nothing". " for the showing of all rooms." . "<br><br>";
	}

	else if (!empty($showRooms)) {
		echo "You selected: " . $showRooms . " for the showing of all rooms." . "<br><br>";
	}

	if ($chosenPrice == 0) {
		echo "You selected: Nothing for the price of the hotel room." . "<br><br>";
	}

	else if ($chosenPrice != 0) {
		echo "You selected: " . $chosenPrice . " for the price of the hotel room." . "<br><br>";
	}

	if (empty($chosenCapacity)) {
		echo "You selected: " . "Nothing". " for capacity of hotel room" . "<br><br>";	
	}

	else if (!empty($chosenCapacity)) {
		echo "You selected: " . $chosenCapacity . " for capacity of hotel room" . "<br><br>";
	}

	if (empty($findDate)) {
		echo "You selected: " . "Nothing". " for date avalible of hotel room" . "<br><br>";	
	}

	else if (!empty($findDate)) {
		echo "You selected: " . $findDate . " for date avalible of hotel room" . "<br><br>";
	}

	$sql1 = "";
	$result1 = "";
	// php if statements start here

	//check if only chain is selected
	if (!empty($chosenChain) && empty($cityName) && empty($starCategory) && empty($showRooms) && empty($chosenPrice) && empty($chosenCapacity)) {
		$sql1 = "SELECT price, capacity, amenities, room.hotel_id, room_number FROM public.room
		INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
		INNER JOIN hotel_chain ON hotel.hq_address = hotel_chain.hq_address
		WHERE hotel_chain.hotel_chain_name = $1 AND room.booked = 'empty'";

		$stmt1 = pg_prepare($dbh,"ps1",$sql1);
		$result1 = pg_execute($dbh, "ps1", array($chosenChain));
		
		if(!$result1){
			die("Error in SQL query:" .pg_last_error());
		}
	}

	//check if only city is selected
	else if (!empty($cityName) && empty($chosenChain) && empty($starCategory) && empty($showRooms) && empty($chosenPrice) && empty($chosenCapacity)) {
		$sql1 = "SELECT price, capacity, amenities, room.hotel_id, room_number FROM public.room
		INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
		WHERE hotel.city = $1 AND room.booked = 'empty'";
		
		$stmt1 = pg_prepare($dbh,"ps1",$sql1);
		$result1 = pg_execute($dbh, "ps1", array($cityName));
		
		if(!$result1){
			die("Error in SQL query:" .pg_last_error());
		}
	}

	//check if only stars are selected
	else if (!empty($starCategory) && empty($cityName) && empty($chosenChain) && empty($showRooms) && empty($chosenPrice) && empty($chosenCapacity)) {
		$sql1 = "SELECT price, capacity, amenities, room.hotel_id, room_number
		FROM public.room
		INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
		WHERE room.booked = 'empty' AND hotel.stars = $1";
		
		$stmt1 = pg_prepare($dbh,"ps1",$sql1);
		$result1 = pg_execute($dbh, "ps1", array($starCategory));
		
		if(!$result1){
			die("Error in SQL query:" .pg_last_error());
		}
	}

	//check if only show rooms is selected and it has a value of yes
	else if ($showRooms == "Yes") {
		if (!empty($showRooms) && empty($starCategory) && empty($cityName) && empty($chosenChain) && empty($chosenPrice) && empty($chosenCapacity)) {
			$sql1 = "SELECT price, capacity, amenities, room.hotel_id, room_number
			FROM public.room
			INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
			WHERE booked IN ('empty', 'rented', 'booked')";
			
			$stmt1 = pg_prepare($dbh,"ps1",$sql1);
			$result1 = pg_execute($dbh, "ps1", array());
			
			if(!$result1){
				die("Error in SQL query:" .pg_last_error());
			}
		}
	}

	//check if only price is selected
	else if (!empty($chosenPrice) && empty($showRooms) && empty($starCategory) && empty($cityName) && empty($chosenChain) && empty($chosenCapacity)) {
		$sql1 = "SELECT price, capacity, amenities, room.hotel_id, room_number
		FROM public.room
		INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
		WHERE room.price = $1";

		$stmt1 = pg_prepare($dbh,"ps1",$sql1);
		$result1 = pg_execute($dbh, "ps1", array($chosenPrice));
		
		if(!$result1){
			die("Error in SQL query:" .pg_last_error());
		}
	}

	//check if only capacity is selected
	else if (!empty($chosenCapacity) && empty($chosenPrice) && empty($showRooms) && empty($starCategory) && empty($cityName) && empty($chosenChain)) {
		$sql1 = "SELECT price, capacity, amenities, room.hotel_id, room_number
		FROM public.room
		INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
		WHERE room.capacity = $1";

		$stmt1 = pg_prepare($dbh,"ps1",$sql1);
		$result1 = pg_execute($dbh, "ps1", array($chosenCapacity));
		
		if(!$result1){
			die("Error in SQL query:" .pg_last_error());
		}
	}
	
	else if (!empty($chosenCapacity) && empty($chosenPrice) && !empty($starCategory) && !empty($cityName) && !empty($chosenChain) && (!empty($showRooms) | (empty($showRooms)))) {
		// SQL query to retrieve rooms based on capacity, room type, star category, city, and hotel chain
				$sql1 = "SELECT price, capacity, amenities, room.hotel_id, room_number
				FROM public.room
				INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
				WHERE room.capacity = $4
				INTERSECT
				SELECT price, capacity, amenities, room.hotel_id, room_number FROM public.room
				INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
				WHERE hotel.city = $1
				INTERSECT
				SELECT price, capacity, amenities, room.hotel_id, room_number
				FROM public.room
				INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
				WHERE hotel.stars = $2";
	
				$stmt1 = pg_prepare($dbh,"ps1",$sql1);
				$result1 = pg_execute($dbh, "ps1", array($cityName, $starCategory, $chosenPrice, $chosenCapacity));
			
				if(!$result1){
				die("Error in SQL query:" .pg_last_error());
			}
		}	
	
		
	
		else if (!empty($chosenCapacity) && !empty($chosenPrice) && empty($starCategory) && empty($cityName) && empty($chosenChain)) {
		// SQL query to retrieve rooms based on capacity, and price
				$sql1 = "SELECT price, capacity, amenities, room.hotel_id, room_number
				FROM public.room
				INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
				WHERE room.capacity = $1
				INTERSECT
				SELECT price, capacity, amenities, room.hotel_id, room_number
				FROM public.room
				INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
				WHERE room.price = $2";
	
				$stmt1 = pg_prepare($dbh,"ps1",$sql1);
				$result1 = pg_execute($dbh, "ps1", array($chosenCapacity, $chosenPrice));
			
				if(!$result1){
				die("Error in SQL query:" .pg_last_error());
			}
		}	
	
		else if (empty($chosenCapacity) && !empty($chosenPrice) && empty($showRooms) && !empty($starCategory) && empty($cityName) && empty($chosenChain)) {
			// SQL query to retrieve rooms based on star, and price
					$sql1 = "SELECT price, capacity, amenities, room.hotel_id, room_number
					FROM public.room
					INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
					WHERE hotel.stars = $1
					INTERSECT
					SELECT price, capacity, amenities, room.hotel_id, room_number
					FROM public.room
					INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
					WHERE room.price = $2";
		
					$stmt1 = pg_prepare($dbh,"ps1",$sql1);
					$result1 = pg_execute($dbh, "ps1", array($starCategory, $chosenPrice));
				
					if(!$result1){
					die("Error in SQL query:" .pg_last_error());
				}
			}
	
		else if (empty($chosenCapacity) && !empty($chosenPrice) && empty($showRooms) && empty($starCategory) && !empty($cityName) && empty($chosenChain)) {
			// SQL query to retrieve rooms based on city, and price
					$sql1 = "SELECT price, capacity, amenities, room.hotel_id, room_number FROM public.room
					INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
					WHERE hotel.city = $1
					INTERSECT
					SELECT price, capacity, amenities, room.hotel_id, room_number
					FROM public.room
					INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
					WHERE room.price = $2";
	
					$stmt1 = pg_prepare($dbh,"ps1",$sql1);
					$result1 = pg_execute($dbh, "ps1", array($cityName, $chosenPrice));
				
					if(!$result1){
					die("Error in SQL query:" .pg_last_error());
				}
			}	
		else if (empty($chosenCapacity) && empty($chosenPrice) && empty($showRooms) && empty($starCategory) && !empty($cityName) && !empty($chosenChain)) {
			// SQL query to retrieve rooms based on city, and hotelchain
					$sql1 = "SELECT price, capacity, amenities, room.hotel_id, room_number FROM public.room
					INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
					WHERE hotel.city = $1
					INTERSECT
					SELECT price, capacity, amenities, room.hotel_id, room_number FROM public.room
					INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
					INNER JOIN hotel_chain ON hotel.hq_address = hotel_chain.hq_address
					WHERE hotel_chain.hotel_chain_name = $2 AND room.booked = 'empty'";
	
					$stmt1 = pg_prepare($dbh,"ps1",$sql1);
					$result1 = pg_execute($dbh, "ps1", array($cityName, $chosenChain));
				
					if(!$result1){
					die("Error in SQL query:" .pg_last_error());
				}
			}	
	
			
		else if (!empty($chosenCapacity) && empty($chosenPrice) && empty($showRooms) && !empty($starCategory) && empty($cityName) && empty($chosenChain)) {
			// SQL query to retrieve rooms based on capacity and star
				$sql1 = "SELECT price, capacity, amenities, room.hotel_id, room_number
				FROM public.room
				INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
				WHERE room.capacity = $1
				INTERSECT
				SELECT price, capacity, amenities, room.hotel_id, room_number
				FROM public.room
				INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
				WHERE hotel.stars = $2";
	
					$stmt1 = pg_prepare($dbh,"ps1",$sql1);
					$result1 = pg_execute($dbh, "ps1", array($chosenCapacity, $starCategory));
				
					if(!$result1){
					die("Error in SQL query:" .pg_last_error());
				}
			}
	
	
	
	
		else if (!empty($chosenCapacity) && !empty($chosenPrice) && empty($starCategory) && !empty($cityName) && empty($chosenChain)) {
			// SQL query to retrieve rooms based on capacity, city and price
					$sql1 = "SELECT price, capacity, amenities, room.hotel_id, room_number
					FROM public.room
					INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
					WHERE room.capacity = $1
					INTERSECT
					SELECT price, capacity, amenities, room.hotel_id, room_number
					FROM public.room
					INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
					WHERE room.price = $2
					INTERSECT
					SELECT price, capacity, amenities, room.hotel_id, room_number FROM public.room
					INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
					WHERE hotel.city = $3";
		
					$stmt1 = pg_prepare($dbh,"ps1",$sql1);
					$result1 = pg_execute($dbh, "ps1", array($chosenCapacity, $chosenPrice,$cityName));
				
					if(!$result1){
					die("Error in SQL query:" .pg_last_error());
				}
			}	
	
	
		else if (empty($chosenCapacity) && !empty($chosenPrice) && empty($starCategory) && !empty($cityName) && !empty($chosenChain) && (!empty($showRooms) | (empty($showRooms)))) {
			// SQL query to retrieve rooms based on Hotel chain, city and price
					$sql1 = "SELECT price, capacity, amenities, room.hotel_id, room_number FROM public.room
					INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
					INNER JOIN hotel_chain ON hotel.hq_address = hotel_chain.hq_address
					WHERE hotel_chain.hotel_chain_name = $1 AND room.booked = 'empty'
					INTERSECT
					SELECT price, capacity, amenities, room.hotel_id, room_number
					FROM public.room
					INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
					WHERE room.price = $2
					INTERSECT
					SELECT price, capacity, amenities, room.hotel_id, room_number FROM public.room
					INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
					WHERE hotel.city = $3";
		
					$stmt1 = pg_prepare($dbh,"ps1",$sql1);
					$result1 = pg_execute($dbh, "ps1", array($chosenChain, $chosenPrice,$cityName));
				
					if(!$result1){
					die("Error in SQL query:" .pg_last_error());
				}
			}	
	
		else if (empty($chosenCapacity) && !empty($chosenPrice) && empty($starCategory) && !empty($cityName) && !empty($chosenChain)) {
			// SQL query to retrieve rooms based on Hotel chain, city and price
					$sql1 = "SELECT price, capacity, amenities, room.hotel_id, room_number FROM public.room
					INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
					INNER JOIN hotel_chain ON hotel.hq_address = hotel_chain.hq_address
					WHERE hotel_chain.hotel_chain_name = $1 AND room.booked = 'empty'
					INTERSECT
					SELECT price, capacity, amenities, room.hotel_id, room_number
					FROM public.room
					INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
					WHERE room.price = $2
					INTERSECT
					SELECT price, capacity, amenities, room.hotel_id, room_number FROM public.room
					INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
					WHERE hotel.city = $3";
		
					$stmt1 = pg_prepare($dbh,"ps1",$sql1);
					$result1 = pg_execute($dbh, "ps1", array($chosenChain, $chosenPrice,$cityName));
				
					if(!$result1){
					die("Error in SQL query:" .pg_last_error());
				}
			}					
		else if (!empty($chosenCapacity) && !empty($chosenPrice) && empty($starCategory) && empty($cityName) && !empty($chosenChain)) {
			// SQL query to retrieve rooms based on Hotel chain, capacity and price
					$sql1 = "SELECT price, capacity, amenities, room.hotel_id, room_number FROM public.room
					INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
					INNER JOIN hotel_chain ON hotel.hq_address = hotel_chain.hq_address
					WHERE hotel_chain.hotel_chain_name = $1 AND room.booked = 'empty'
					INTERSECT
					SELECT price, capacity, amenities, room.hotel_id, room_number
					FROM public.room
					INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
					WHERE room.price = $2
					INTERSECT
					SELECT price, capacity, amenities, room.hotel_id, room_number
					FROM public.room
					INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
					WHERE room.capacity = $3";
		
					$stmt1 = pg_prepare($dbh,"ps1",$sql1);
					$result1 = pg_execute($dbh, "ps1", array($chosenChain, $chosenPrice,$chosenCapacity));
				
					if(!$result1){
					die("Error in SQL query:" .pg_last_error());
				}
			}	
		else if (!empty($chosenCapacity) && !empty($chosenPrice) && !empty($starCategory) && empty($cityName) && empty($chosenChain)) {
			// SQL query to retrieve rooms based on star, price, capacity
					$sql1 = "SELECT price, capacity, amenities, room.hotel_id, room_number
					FROM public.room
					INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
					WHERE hotel.stars = $1
					INTERSECT
					SELECT price, capacity, amenities, room.hotel_id, room_number
					FROM public.room
					INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
					WHERE room.price = $2
					INTERSECT
					SELECT price, capacity, amenities, room.hotel_id, room_number
					FROM public.room
					INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
					WHERE room.capacity = $3";
		
					$stmt1 = pg_prepare($dbh,"ps1",$sql1);
					$result1 = pg_execute($dbh, "ps1", array($starCategory, $chosenPrice,$chosenCapacity));
				
					if(!$result1){
					die("Error in SQL query:" .pg_last_error());
				}
			}		

	//check if theres a combination
	else {
		$sql1 = "SELECT price, capacity, amenities, room.hotel_id, room_number
		FROM public.room
		INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
		INNER JOIN hotel_chain ON hotel.hq_address = hotel_chain.hq_address
		WHERE hotel_chain.hotel_chain_name = $1 AND room.booked = 'empty'
		INTERSECT
		SELECT price, capacity, amenities, room.hotel_id, room_number
		FROM public.room
		INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
		WHERE hotel.city = $2 AND room.booked = 'empty'
		INTERSECT
		SELECT price, capacity, amenities, room.hotel_id, room_number
		FROM public.room
		INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
		WHERE room.booked = 'empty' AND hotel.stars = $3
		INTERSECT
		SELECT price, capacity, amenities, room.hotel_id, room_number
		FROM public.room
		WHERE room.price = $4
		INTERSECT
		SELECT price, capacity, amenities, room.hotel_id, room_number
		FROM public.room
		WHERE room.capacity = $5";

		$stmt1 = pg_prepare($dbh,"ps1",$sql1);

		$result1 = pg_execute($dbh, "ps1", array($chosenChain, $cityName, $starCategory, $chosenPrice, $chosenCapacity));

		if(!$result1){
			die("Error in SQL query:" .pg_last_error());
		}
	}
?>

<br>

<body>
	<form method="get">
		<label for="hotelChains"> Please select a hotel chain: </label>

		<select name="hotelChains" id="hotelChains">
			<option value=""> --Select a hotel-- </option>
			<option value="CityScape Resorts"> CityScape Resorts </option>
			<option value="EliteSleep Lodging"> EliteSleep Lodging </option>
			<option value="DeluxyStay Suites"> DeluxyStay Suites </option>
			<option value="Sunrise Suites"> Sunrise Suites </option>
			<option value="OrangeWave Hotels"> OrangeWave Hotels </option>
		</select>

		<br>

		<p> Please enter a city name: <input type="text" name="cityName" id="cityName"/></p>

		<p> Please choose a hotel star category: <input type="number" name="starCategory" id="starCategory" min="0" max="5" value="0"/></p>

		<p> Show total number of rooms in the hotel/Show all rooms:
			<select name="showRooms" id="showRooms">
				<option value=""> --Select an option-- </option>
				<option value="Yes">Yes</option>
				<option value="No">No</option>
			</select>
		</p>

		<p> Please select a price for the hotel room: <input type="number" name="choosePrice" id="choosePrice" min="0" max="500" step="50" value = "0"> </p>

		<p> Choose capcaity for hotel room:
			<select name="chooseCapacity" id="chooseCapacity">
				<option value=""> --Select an option-- </option>
				<option value="single">Single</option>
				<option value="double">Double</option>
			</select>
		</p>
		<p> Please enter a date: <input name="findDate" type="date" id="findDate"/></p>
		<br>
		<br>
		<input type="submit" value="Submit">
	</form>

	<table style="border-collapse: collapse;">
	<thead>
		<tr>
			<th style="border: 1px solid black; padding: 8px;">Price</th>
			<th style="border: 1px solid black; padding: 8px;">Capacity</th>
			<th style="border: 1px solid black; padding: 8px;">Amenities</th>
			<th style="border: 1px solid black; padding: 8px;">Hotel ID</th>
			<th style="border: 1px solid black; padding: 8px;">Room Number</th>
			<th style="border: 1px solid black; padding: 8px;">Book It!</th>
		</tr>
	</thead>
	<tbody>

	<tbody>
    <?php
        $resultArr = array();

        if (!$result1) {
            try {
                // your code that may throw an error
            }
            catch(Exception $e) {
                // do nothing
            }
        }
        else {
            $resultArr = pg_fetch_all($result1);
        }

        foreach($resultArr as $array) :
    ?>
        <tr>
            <form action="roomBooking.php" method="get">
                <input type="hidden" name="hotel_id" value="<?= $array['hotel_id'] ?>">
                <input type="hidden" name="room_number" value="<?= $array['room_number'] ?>">
                <td style="border: 1px solid black; padding: 8px;"><?= $array['price'] ?></td>
                <td style="border: 1px solid black; padding: 8px;"><?= $array['capacity'] ?></td>
                <td style="border: 1px solid black; padding: 8px;"><?= $array['amenities'] ?></td>
                <td style="border: 1px solid black; padding: 8px;"><?= $array['hotel_id'] ?></td>
                <td style="border: 1px solid black; padding: 8px;"><?= $array['room_number'] ?></td>
                <td style="border: 1px solid black; padding: 8px;">
                    <input type="submit" name="book" value="Book">
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

</body>

</html>

