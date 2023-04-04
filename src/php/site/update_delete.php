<html>
    <head>
        <title>WedUP</title>
        <link rel="stylesheet" href="style.php">
    </head>
    <body>
        <a href="main_page.php" class="side-button">Main Menu</a>
		
       <h2>Update Data in Tables</h2>
        <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>

        <form method="POST" action="update_delete.php"> <!--refresh page when submitted-->
            <input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
            Attribute: <input type="text" name="selectAttribute"> <br /><br />		
            Table: <input type="text" name="selectTable"> <br /><br />			
			Old Value: <input type="text" name="oldValue"> <br /><br />			
			New Value: <input type="text" name="newValue"> <br /><br />	
			
            <input type="submit" value="Update" name="updateSubmit"></p>
        </form>

        <hr />
		
		<h2>Delete Tuples from Tables</h2>
		<p>The values are case sensitive and if you enter in the wrong case, the delete statement will not do anything.</p>
        <form method="POST" action="update_delete.php"> <!--refresh page when submitted-->
            <input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">          			
			ID: <input type="text" name="selectAttribute"> <br /><br />		
            Table: <input type="text" name="selectTable"> <br /><br />				
			Value: <input type="text" name="toDel"> <br /><br />
			
            <input type="submit" value="Delete" name="deleteSubmit"></p>
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
		

		function printResult($result) { //prints results from a select statement
            echo "<table>";
            $headers = "";
            $ncols = oci_num_fields($result);
            for ($i = 1; $i <= $ncols; $i++) {
                $column_name  = oci_field_name($result, $i);
                $headers = $headers . "<th>" . $column_name . "</th>";
            }
            $headers = "<tr>" . $headers . "</tr>";
            echo $headers;

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                $tuple = "";
                for ($i = 0; $i < $ncols; $i++) {
                    $tuple = $tuple . "<td>" . $row[$i] . "</td>";
                }
                echo "<tr>" . $tuple . "</tr>";
            }

            echo "</table>";
        }
		
		function handleUpdateRequest() {
            global $db_conn;
            global $success;
			
			$select = $_POST['selectAttribute'];
            $from = $_POST['selectTable'];
			$old_value = $_POST['oldValue'];
			$new_value = $_POST['newValue'];			
			
            executePlainSQL("UPDATE $from SET $select='" . $new_value . "' WHERE $select='" . $old_value . "'");
			
            OCICommit($db_conn);
            if ($success) {
                echo "SUCCESFULLY UPDATED";
            } else {
                echo "UNABLE TO UPDATE";
            }
        }
		
		
		
		function handleDeleteRequest() {
            global $db_conn;
            global $success;
			
			$pk = $_POST['selectAttribute'];
            $table = $_POST['selectTable'];
			$value = $_POST['toDel'];

			if (filter_var($_POST['toDel'], FILTER_VALIDATE_INT) == true) {
				executePlainSQL("DELETE FROM $table WHERE $pk = $value ");
			} else {
				executePlainSQL("DELETE FROM $table WHERE $pk = '$value' ");
			}		
            if ($success) {
                echo "SUCCESFULLY DELETED";
            } else {
                echo "UNABLE TO DELETE";
            }
		
            OCICommit($db_conn);
        }

       
		function handlePOSTRequest() {
            if (connectToDB()) {
                if (array_key_exists('updateQueryRequest', $_POST)) {
                    handleUpdateRequest();
                } else if (array_key_exists('deleteQueryRequest', $_POST)) {
                    handleDeleteRequest();
                } else if (array_key_exists('resetTablesRequest', $_POST)) {
                    handleResetRequest();
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

        if (isset($_POST['updateSubmit']) || isset($_POST['deleteSubmit'])) {
            handlePOSTRequest();
        } else if (isset($_GET['countTupleRequest']) || isset($_GET['selectRequest'])) {
            handleGETRequest();
        }

        ?>
		
    </body>
</html>