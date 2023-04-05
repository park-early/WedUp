<html>
    <head>
        <title>WedUP</title>
        <link rel="stylesheet" href="style.php">
    </head>
    <body>
        <a href="main_page.php" class="side-button">Main Menu</a>
        <form method="POST" action="guests.php">
            <h2>Wedding Information</h2>
            <label for="wedding">Select wedding to add guest to:</label>
            <input type="text" id="weddingnumber" name="weddingnumber" required>
			<!--Wedding1 will correspond with wedding number 1 and so on--> 
			
            <hr>
            <h2>Guest Information</h2>
                <input type="hidden" id="insertGuest" name="insertGuest">
                <label for="guestfname">First name:</label>
                <input type="text" id="guestfname" name="guestfname" required>
                <label for="guestlname">Last name:</label>
                <input type="text" id="guestlname" name="guestlname" required></p>
                <label for="guestemail">Email:</label>
                <input type="text" id="guestemail" name="guestemail" required> 
                <!--guestemail use this for plus one as well since it is linked --> 
			
            <hr>
            <h2>Plus-One Information (Optional)</h2>
                <label for="plusonefname">First name:</label>
                <input type="text" id="plusonefname" name="plusonefname">
                <label for="plusonelname">Last name:</label>
                <input type="text" id="plusonelname" name="plusonelname"></p>
                <label for="plusoneemail">Email:</label>
                <input type="text" id="plusoneemail" name="plusoneemail">
            <hr>
            <input type="submit" value="Submit" name="insertSubmit"></p>
        </form> 
		
		<hr />

        <h2>Display all guests and plus ones</h2>
        <form method="GET" action="guests.php"> <!--refresh page when submitted-->
            <input type="hidden" id="countTupleRequest" name="countTupleRequest">
            <input type="submit" name="countTuples"></p>
        </form>

        <hr />
		<?php

        $success = True; //keep track of errors so it redirects the page only if there are no errors
        $db_conn = NULL; // edit the login credentials in connectToDB()
        $show_debug_alert_messages = False; // set to True if you want alerts to show you which methods are being triggered (see how it is used in debugAlertMessage())

        function debugAlertMessage($message) {
            global $show_debug_alert_messages;

            if ($show_debug_alert_messages) {
                echo "<script type='text/javascript'>alert('" . $message . "');</script>";
            }
        }

        function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
            //echo "<br>running ".$cmdstr."<br>";
            global $db_conn, $success;

            $statement = OCIParse($db_conn, $cmdstr);
            //There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn); // For OCIParse errors pass the connection handle
                echo htmlentities($e['message']);
                $success = False;
            }

            $r = OCIExecute($statement, OCI_DEFAULT);
            if (!$r) {
                echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
                echo htmlentities($e['message']);
                $success = False;
            }

            return $statement;
        }

        function executeBoundSQL($cmdstr, $list) {
            /* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
		In this case you don't need to create the statement several times. Bound variables cause a statement to only be
		parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection.
		See the sample code below for how this function is used */

			global $db_conn, $success;
			$statement = OCIParse($db_conn, $cmdstr);

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn);
                echo htmlentities($e['message']);
                $success = False;
            }

            foreach ($list as $tuple) {
                foreach ($tuple as $bind => $val) {
                    //echo $val;
                    //echo "<br>".$bind."<br>";
                    OCIBindByName($statement, $bind, $val);
                    unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
				}

                $r = OCIExecute($statement, OCI_DEFAULT);
                if (!$r) {
                    echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                    $e = OCI_Error($statement); // For OCIExecute errors, pass the statementhandle
                    echo htmlentities($e['message']);
                    echo "<br>";
                    $success = False;
                }
            }
        }

        function connectToDB() {
            global $db_conn;

            // Your username is ora_(CWL_ID) and the password is a(student number). For example,
            // ora_platypus is the username and a12345678 is the password.
            $db_conn = OCILogon("ora_parkerl6", "a35909605", "dbhost.students.cs.ubc.ca:1522/stu");

            if ($db_conn) {
                debugAlertMessage("Database is Connected");
                return true;
            } else {
                debugAlertMessage("Cannot connect to Database");
                $e = OCI_Error(); // For OCILogon errors pass no handle
                echo htmlentities($e['message']);
                return false;
            }
        }

        function disconnectFromDB() {
            global $db_conn;

            debugAlertMessage("Disconnect from Database");
            OCILogoff($db_conn);
        }
		
		function printResultG($resultG) { //prints results from a select statement
            echo "<table>";
            echo "<tr><th>Email</th><th>FirstName</th><th>LastName</th></tr>";

            while ($row = OCI_Fetch_Array($resultG, OCI_BOTH)) {
				echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td></tr>"; 
			}
			
            echo "</table>";
        }
		
		function handleInsertPlusOnesBring() {
            global $db_conn;          
				
			$tuple = array (
                ":bind1" => $_POST['guestemail'],
                ":bind2" => $_POST['plusoneemail'],
				":bind3" => $_POST['plusonefname'],
				":bind4" => $_POST['plusonelname']
            );
			
            $alltuples = array (
                $tuple
            );
					
            executeBoundSQL("insert into PlusOnesBring values (:bind1, :bind2, :bind3, :bind4)", $alltuples);				
            OCICommit($db_conn);
            echo "PLUSONE ADDED!</br>";
        }

        function handleInsertAttends() {
            global $db_conn;          
				
			$tuple = array (
                ":bind1" => $_POST['weddingnumber'],
                ":bind2" => $_POST['guestemail']
            );
			
            $alltuples = array (
                $tuple
            );
					
            executeBoundSQL("insert into Attends values (:bind1, :bind2)", $alltuples);				
            OCICommit($db_conn);
            echo "GUEST ADDED TO WEDDING</br>";
        }
		
		 function handleInsertGuests() {
            if (filter_var($_POST['weddingnumber'], FILTER_VALIDATE_INT) != true) {
                echo "WEDDING NUMBER MUST BE A NUMBER";
                return;
            }
            $result = executePlainSQL("SELECT max(weddingnumber) FROM WeddingsBookFor");
            $row = OCI_Fetch_Array($result, OCI_BOTH);
            if ($_POST['weddingnumber'] > $row[0]) {
                echo "INVALID WEDDING NUMBER.";
                return;
            }
            global $db_conn;
            		
            $tuple = array (
                ":bind1" => $_POST['guestemail'],
                ":bind2" => $_POST['guestfname'],
				":bind3" => $_POST['guestlname'],
            );
			
            $alltuples = array (
                $tuple
            );
			
			
            executeBoundSQL("insert into Guests values (:bind1, :bind2, :bind3)", $alltuples);
				
            OCICommit($db_conn);
            echo "GUEST ADDED!</br>";
            handleInsertAttends();
            if ($_POST['plusonefname'] != "" && $_POST['plusonelname'] != "" && $_POST['plusoneemail'] != "") {
                handleInsertPlusOnesBring();
            } else {
                echo "GUEST ADDED, BUT DID NOT ADD PLUSONE DUE TO MISSING FIELDS.";
            }
            
        }
		
		function handleCountRequest() {
            global $db_conn;
           
			$resultG = executePlainSQL("
            (SELECT Email, FirstName, LastName FROM Guests a) 
            UNION
            (SELECT b.PlusOneEmail AS Email, b.FirstName, b.LastName FROM Guests a, PlusOnesBring b
            WHERE b.GuestEmail = a.Email)
            ");
        
			echo printResultG($resultG);
        }

       
		function handlePOSTRequest() {
            if (connectToDB()) {
                if (array_key_exists('insertGuest', $_POST)) {
                    handleInsertGuests();
                } 
                disconnectFromDB();
            }
        }
		
		function handleGETRequest() {
            if (connectToDB()) {
                if (array_key_exists('countTuples', $_GET)) {
                    handleCountRequest();
                } else if (array_key_exists('selectRequest', $_GET)) {
                    handleSelectRequest();
                }

                disconnectFromDB();
            }
        }


        if (isset($_POST['insertGuest'])) {
            handlePOSTRequest();
        } else if (isset($_GET['countTupleRequest']) || isset($_GET['selectRequest'])) {
            handleGETRequest();
        }

        ?>
		
    </body>
	
	
</html>