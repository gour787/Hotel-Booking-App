<?php
    session_start();
    if (isset($_POST['showCurrentCustomer'])) {

        $customerID = $_SESSION['customerID'];
        if (isset($_SESSION['customerID']) && $_SESSION['customerID'] != '') {
            echo "Customer Viewing Page For Booked/Rented Rooms." . "<br><br>";
        }
        
        else {
            echo "Customer ID is not set or has an invalid value" . "<br><br>";
        }

        $conn_string = "host=localhost port = 5432 dbname=db_project user=postgres password = root";
		$dbconn = pg_connect($conn_string) or die('Connection failed');

        $sqlBooked = "SELECT price, capacity, amenities, room.hotel_id, room_number FROM public.room
        WHERE customer_id = $1 AND booked = 'booked'";
        $statementBooked = pg_prepare($dbconn,"ps1",$sqlBooked);
        $resultBooked = pg_execute($dbconn, "ps1", array($customerID));
        $resultArrBooked = pg_fetch_all($resultBooked);

        $sqlRented = "SELECT price, capacity, amenities, room.hotel_id, room_number FROM public.room
        WHERE customer_id = $1 AND booked = 'occupied'";
        $statementRented = pg_prepare($dbconn,"ps2",$sqlRented);
        $resultRented = pg_execute($dbconn, "ps2", array($customerID));
        $resultArrRented = pg_fetch_all($resultRented);

        ?>
        <table style="border-collapse: collapse;">
        <strong> <p> Table For Currently Booked Rooms </p> </strong>

        <thead>
            <tr>
                <th style="border: 1px solid black; padding: 8px;">Price</th>
                <th style="border: 1px solid black; padding: 8px;">Capacity</th>
                <th style="border: 1px solid black; padding: 8px;">Amenities</th>
                <th style="border: 1px solid black; padding: 8px;">Hotel ID</th>
                <th style="border: 1px solid black; padding: 8px;">Room Number</th>
                <th style="border: 1px solid black; padding: 8px;">Status</th>
                <th style="border: 1px solid black; padding: 8px;">Cancel</th>
            </tr>
        </thead>
        <tbody>

        <tbody>
        <?php foreach($resultArrBooked as $array) : ?>
            <tr>
                <form action="cancelRoom.php" method="get">
                    <input type="hidden" name="hotel_id" value="<?= $array['hotel_id'] ?>">
                    <input type="hidden" name="room_number" value="<?= $array['room_number'] ?>">
                    <td style="border: 1px solid black; padding: 8px;"><?= $array['price'] ?></td>
                    <td style="border: 1px solid black; padding: 8px;"><?= $array['capacity'] ?></td>
                    <td style="border: 1px solid black; padding: 8px;"><?= $array['amenities'] ?></td>
                    <td style="border: 1px solid black; padding: 8px;"><?= $array['hotel_id'] ?></td>
                    <td style="border: 1px solid black; padding: 8px;"><?= $array['room_number'] ?></td>
                    <td style="border: 1px solid black; padding: 8px;">
                    <p> Booked <p>
                    </td>
                    <td style="border: 1px solid black; padding: 8px;">
                        <input type="submit" name="cancelRoom" value="Cancel">
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


        <table style="border-collapse: collapse;">

        <br>
        <br>
        <br>

        <strong> <p> Table For Currently Rented Rooms </p> </strong>

        <thead>
            <tr>
                <th style="border: 1px solid black; padding: 8px;">Price</th>
                <th style="border: 1px solid black; padding: 8px;">Capacity</th>
                <th style="border: 1px solid black; padding: 8px;">Amenities</th>
                <th style="border: 1px solid black; padding: 8px;">Hotel ID</th>
                <th style="border: 1px solid black; padding: 8px;">Room Number</th>
                <th style="border: 1px solid black; padding: 8px;">Status</th>
            </tr>
        </thead>
        <tbody>

        <tbody>
        <?php foreach($resultArrRented as $array) : ?>
            <tr>
                <form action="" method="get">
                    <input type="hidden" name="hotel_id" value="<?= $array['hotel_id'] ?>">
                    <input type="hidden" name="room_number" value="<?= $array['room_number'] ?>">
                    <td style="border: 1px solid black; padding: 8px;"><?= $array['price'] ?></td>
                    <td style="border: 1px solid black; padding: 8px;"><?= $array['capacity'] ?></td>
                    <td style="border: 1px solid black; padding: 8px;"><?= $array['amenities'] ?></td>
                    <td style="border: 1px solid black; padding: 8px;"><?= $array['hotel_id'] ?></td>
                    <td style="border: 1px solid black; padding: 8px;"><?= $array['room_number'] ?></td>
                    <td style="border: 1px solid black; padding: 8px;">
                        <p> Rented <p>
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
?>