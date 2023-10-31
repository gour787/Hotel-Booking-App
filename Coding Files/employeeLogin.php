<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title> 
            Welcome Employee!
        </title>
    </head>

    <?php
        session_start();

        if (isset($_POST['login'] ))
        {
            $employeeName = $_POST['employeeName'];
            $employeeID = $_POST['employeeID'];
            $empHotelID = $_POST['empHotelID'];

            $conn_string = "host=localhost port = 5432 dbname=db_project user=postgres password = root";

            $dbconn = pg_connect($conn_string) or die('Connection failed');

            $query = "SELECT * FROM public.employee WHERE employee_name =$1 AND employee_id = $2 AND hotel_id = $3";

            $stmt = pg_prepare($dbconn,"ps",$query);
            $result = pg_execute($dbconn,"ps",array($employeeName,$employeeID, $empHotelID));

            if(!$result){
                die("Error in SQL query:" .pg_last_error());
            }

            $row_count = pg_num_rows($result);

            if($row_count>0){
                $customer = pg_fetch_assoc($result);
                $_SESSION['employeeName'] = $employeeName;
                $_SESSION['employeeID'] = $employeeID;
                $_SESSION['empHotelID'] = $empHotelID;
                
                
                header("location: http://localhost:8080/databases_project/employeeRecords.php");
                exit;
            }
            
            echo "INVALID EMPLOYEE DATA.";

            pg_free_result($result);
            pg_close($dbconn);
        }
    ?>

    <body>
        <div id="header"> EMPLOYEE LOGIN FORM</div>
        <form method="POST" action="">
            <p>Employee Name: <input type="text" name="employeeName" id="employeeName" required/></p>
            <p>Employee ID: <input type="number" name="employeeID" id="employeeID" required/></p>
            <p>Hotel ID of Hotel You Work At: <input type="number" name="empHotelID" id="empHotelID" required/></p>
            <p><input type="submit" value="Login" name="login" /></p>
        </form>
    </body>

</html>
