<html>
    <head>
        <title>WedUP</title>
        <link rel="stylesheet" href="style.php">
    </head>
    <body>
        <a href="main_page.php" class="side-button">Main Menu</a>
        <h1 style="text-align:center">Venues</h1>

        <form id="venuesInfo" method="GET" action="venues.php">
            <input type="hidden" id="selectRequest" name="selectRequest">
            <input type="hidden" name="selectAttributes" value="*">
            <input type="hidden" name="selectTable" value="Venues">
            <input type="hidden" name="selectCondition" value="">
            <input type="hidden" name="selectOperation" value="">
            <input type="hidden" name="selectArgument" value="">
        </form>
        
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

        // selectAttributes is an attribute or comma separated attributes
        // selectTable is a table name
        // selectCondition is an attribute
        // selectOperation is one of [=, <>, >, >=, <, <=, LIKE, IS NULL, IS NOT NULL]
        // selectArgument is a value of same domain as selectCondition (empty if IS (NOT) NULL)
        function handleSelectRequest() {
            global $db_conn;

            $select = "SELECT " . $_GET['selectAttributes'];
            $from = " FROM " . $_GET['selectTable'];
            $where = "";
            if ($_GET['selectCondition'] != "") {
                $where = " WHERE " . $_GET['selectCondition'] . " " . $_GET['selectOperation'];

                if ($_GET['selectArgument'] != "") {
                    if (filter_var($_GET['selectArgument'], FILTER_VALIDATE_INT) === true) {
                        $where = $where . $_GET['selectArgument'];
                    } else {
                        $where = $where . "'" . $_GET['selectArgument'] . "'";
                    }
                }
            }
            $result = executePlainSQL($select . $from . $where);

            printResult($result);
        }

        function handleGETRequest() {
            
            if (connectToDB()) {
                if (array_key_exists('selectRequest', $_GET)) {
                    handleSelectRequest();
                }
                disconnectFromDB();
            }
        }

        if (!isset($_GET['selectRequest'])) {
        ?>
        <script type="text/javascript">
            document.getElementById("venuesInfo").submit();
        </script>
        <?php
        } else {
            handleGETRequest();
        }
        ?>
    </body>
</html>