<html>
    <head>
        <title>WedUP</title>
        <link rel="stylesheet" href="style.php">
    </head>
    <body>
        <a href="main_page.php" class="side-button">Main Menu</a>
         <form method="POST" action="staff.php">
            <h2>Wedding Information</h2>
            <label for="wedding">Select wedding to add staff to:</label>
            <input type="text" id="weddingnumber" name="weddingnumber" required>
			<!--Wedding1 will correspond with wedding number 1 and so on--> 
			
            <hr>	
            <h2>Staff Information</h2>
				<input type="hidden" id="insertStaff" name="insertStaff">
			
				<label for="stafffname">First name:</label>
				<input type="text" id="stafffname" name="stafffname" required>
				<label for="stafflname">Last name:</label>
				<input type="text" id="stafflname" name="stafflname" required><br>
				<label for="staffemail">Email:</label>
				<input type="email" id="staffemail" name="staffemail" required>
				<label for="staffcompany">Company:</label>
				<select id="company" name="company">
                <option value="Casablanca Co.">Casablanca Co.</option>
                <option value="Titanic Studio">Titanic Studio</option>
                <option value="La La Land Ltd.">La La Land Ltd.</option>
                <option value="Paramount">Paramount</option>
                <option value="Forrest Gump and Co.">Forrest Gump and Co.</option>
                <option value="Up Services">Up Services</option>
				</select>
								
            <input type="submit" value="Submit" name="insertSubmit"></p>
			
		</form>
		
		<hr />

        <h2>Display all staff</h2>
        <form method="GET" action="staff.php"> <!--refresh page when submitted-->
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
            echo "<tr><th>Email</th><th>Company</th><th>FirstName</th><th>LastName</th></tr>";

            while ($row = OCI_Fetch_Array($resultG, OCI_BOTH)) {
				echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>"  . $row[3] . "</td></tr>"; 
			}
			
            echo "</table>";
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
		
		
		 function handleInsertStaff() {
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
                ":bind1" => $_POST['staffemail'],
                ":bind2" => $_POST['company'],
				":bind3" => $_POST['stafffname'],
				":bind4" => $_POST['stafflname']
            );
			
            $alltuples = array (
                $tuple
            );
			
            executeBoundSQL("insert into Staff values (:bind1, :bind2, :bind3, :bind4)", $alltuples);		
				
            OCICommit($db_conn);
            echo "STAFF ADDED!</br>";
            handleInsertWorksAt();
        }
		
		function handleInsertWorksAt() {
            global $db_conn;
            			
			$tuple = array (
                ":bind1" => $_POST['weddingnumber'],
                ":bind2" => $_POST['staffemail']
            );
			
            $alltuples = array (
                $tuple
            );
			
            executeBoundSQL("insert into WorksAt values (:bind1, :bind2)", $alltuples);				
            OCICommit($db_conn);
            echo "STAFF ADDED TO WEDDING</br>";
        }
		
		function handleCountRequest() {
            global $db_conn;
           
			$resultG = executePlainSQL("SELECT * FROM Staff");
        
			echo printResultG($resultG);
        }

       
		function handlePOSTRequest() {
            if (connectToDB()) {
                if (array_key_exists('insertStaff', $_POST)) {
                    handleInsertStaff();
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


        if (isset($_POST['insertSubmit'])) {
                handlePOSTRequest();
        } else if (isset($_GET['countTupleRequest']) || isset($_GET['selectRequest'])) {
            handleGETRequest();
        }

        ?>
		
    </body>
</html>