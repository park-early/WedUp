<!--THIS HTML IS TEMPORARY -->

<html>
    <head>
        <title>WedUP</title>
    </head>

    <body>
        <h2>Reset</h2>
        <p>If you wish to reset the table press on the reset button. If this is the first time you're running this page, you MUST use reset</p>

        <form method="POST" action="wedup.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
            <p><input type="submit" value="Reset" name="reset"></p>
        </form>

        <hr />

        <h2>Insert Values into DemoTable</h2>
        <form method="POST" action="wedup.php"> <!--refresh page when submitted-->
            <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
            Number: <input type="text" name="insNo"> <br /><br />
            Name: <input type="text" name="insName"> <br /><br />

            <input type="submit" value="Insert" name="insertSubmit"></p>
        </form>

        <hr />

        <h2>Update Name in DemoTable</h2>
        <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>

        <form method="POST" action="wedup.php"> <!--refresh page when submitted-->
            <input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
            Old Name: <input type="text" name="oldName"> <br /><br />
            New Name: <input type="text" name="newName"> <br /><br />

            <input type="submit" value="Update" name="updateSubmit"></p>
        </form>

        <hr />

        <h2>Count the Tuples in DemoTable</h2>
        <form method="GET" action="wedup.php"> <!--refresh page when submitted-->
            <input type="hidden" id="countTupleRequest" name="countTupleRequest">
            <input type="submit" name="countTuples"></p>
        </form>

        <h2>Select from Table</h2>
        <form method="GET" action="wedup.php"> <!--refresh page when submitted-->
            <input type="hidden" id="selectRequest" name="selectRequest">
            Attributes: <input type="text" name="selectAttributes"> <br /><br />
            Table: <input type="text" name="selectTable"> <br /><br />
            Condition: <input type="text" name="selectCondition"> <br /><br />
            Operation: <input type="text" name="selectOperation"> <br /><br />
            Argument: <input type="text" name="selectArgument"> <br /><br />

            <input type="submit" value="Submit" name="selectSubmit"></p>
        </form>

        <h2>Select using Join</h2>
        <form method="GET" action="wedup.php"> <!--refresh page when submitted-->
            <input type="hidden" id="selectJoinRequest" name="selectJoinRequest">
            Attributes: <input type="text" name="selectAttributes"> <br /><br />
            Table1: <input type="text" name="joinTable1"> <br /><br />
            Table2: <input type="text" name="joinTable2"> <br /><br />
            Join on Table1's: <input type="text" name="joinTable1Attribute"> <br /><br />
            Join on Table2's: <input type="text" name="joinTable2Attribute"> <br /><br />
            Condition: <input type="text" name="selectCondition"> <br /><br />
            Operation: <input type="text" name="selectOperation"> <br /><br />
            Argument: <input type="text" name="selectArgument"> <br /><br />
            Attributes from Table: 
            <select name="joinDropdown" id="joinDropdown">
                <option value="1">1</option>
                <option value="2">2</option>
            </select>

            <input type="submit" value="Submit" name="selectJoinSubmit"></p>
        </form>

        <h2>Division (Staff who worked at every wedding)</h2>
        <form method="GET" action="wedup.php"> <!--refresh page when submitted-->
            <input type="hidden" id="divisionRequest" name="divisionRequest">
            <input type="submit" value="Submit" name="selectJoinSubmit"></p>
        </form>

        <?php
		//this tells the system that it's no longer just parsing html; it's now parsing PHP

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

        function printResult($result) { //prints results from a select statement
            echo "<br>Retrieved data:<br>";
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

        function handleUpdateRequest() {
            global $db_conn;

            $old_name = $_POST['oldName'];
            $new_name = $_POST['newName'];

            // you need the wrap the old name and new name values with single quotations
            executePlainSQL("UPDATE demoTable SET name='" . $new_name . "' WHERE name='" . $old_name . "'");
            OCICommit($db_conn);
        }

        function handleResetRequest() {
            global $db_conn;
            // Drop old table
            executePlainSQL("DROP TABLE demoTable");

            // Create new table
            echo "<br> creating new table <br>";
            executePlainSQL("CREATE TABLE demoTable (id int PRIMARY KEY, name char(30))");
            OCICommit($db_conn);
        }

        function handleInsertRequest() {
            global $db_conn;

            //Getting the values from user and insert data into the table
            $tuple = array (
                ":bind1" => $_POST['insNo'],
                ":bind2" => $_POST['insName']
            );

            $alltuples = array (
                $tuple
            );

            executeBoundSQL("insert into demoTable values (:bind1, :bind2)", $alltuples);
            OCICommit($db_conn);
        }

        function handleCountRequest() {
            global $db_conn;

            $result = executePlainSQL("SELECT Count(*) FROM demoTable");

            if (($row = oci_fetch_row($result)) != false) {
                echo "<br> The number of tuples in demoTable: " . $row[0] . "<br>";
            }
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

        function handleSelectJoinRequest() {
            global $db_conn;

            $tableUsed = "a";
            if ($_GET['joinDropdown'] == "2") {
                $tableUsed = "b";
            }

            $select = "SELECT ";
            $attributes = explode(",", $_GET['selectAttributes']);
            if ($attributes[0] != "*") {
                for ($i = 0; $i < sizeof($attributes) - 1; $i++) {
                    $select = $select . $tableUsed . "." . $attributes[$i] . ", ";
                }
                $select = $select . $tableUsed . "." . $attributes[sizeof($attributes) - 1];
            } else {
                $select = $select . "* ";
            }

            $from = " FROM " . $_GET['joinTable1'] . " a, " . $_GET['joinTable2'] . " b";
            $where = " WHERE a." . $_GET['joinTable1Attribute'] . " = b." . $_GET['joinTable2Attribute'];
            if ($_GET['selectCondition'] != "") {
                $where = $where . " AND " . $tableUsed . "." . $_GET['selectCondition'] . " " . $_GET['selectOperation'];

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

        function handleDivision() {
            global $db_conn;

            $select = "SELECT * ";

            $from = " FROM Staff S";
            $where = " WHERE NOT EXISTS ((SELECT *
                FROM Staff)
                MINUS
                (SELECT S.Email, S.Company, S.FirstName, S.LastName
                FROM WeddingsBookFor B, WorksAt W
                WHERE B.WeddingNumber = W.WeddingNumber AND W.StaffEmail = S.Email))";
            
            $result = executePlainSQL($select . $from . $where);

            printResult($result);
        }

        // HANDLE ALL POST ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handlePOSTRequest() {
            if (connectToDB()) {
                if (array_key_exists('resetTablesRequest', $_POST)) {
                    handleResetRequest();
                } else if (array_key_exists('updateQueryRequest', $_POST)) {
                    handleUpdateRequest();
                } else if (array_key_exists('insertQueryRequest', $_POST)) {
                    handleInsertRequest();
                }

                disconnectFromDB();
            }
        }

        // HANDLE ALL GET ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handleGETRequest() {
            if (connectToDB()) {
                if (array_key_exists('countTuples', $_GET)) {
                    handleCountRequest();
                } else if (array_key_exists('selectRequest', $_GET)) {
                    handleSelectRequest();
                } else if (array_key_exists('selectJoinRequest', $_GET)) {
                    handleSelectJoinRequest();
                } else if (array_key_exists('divisionRequest', $_GET)) {
                    handleDivision();
                }

                disconnectFromDB();
            }
        }

		if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit'])) {
            handlePOSTRequest();
        } else if (isset($_GET['countTupleRequest']) || isset($_GET['selectRequest']) || isset($_GET['selectJoinRequest']) || isset($_GET['divisionRequest'])) {
            handleGETRequest();
        }
		?>
	</body>
</html>