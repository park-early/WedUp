<html>
    <head>
        <title>WedUP</title>
        <link rel="stylesheet" href="style.php">
    </head>
    <body>
        <a href="main_page.php" class="side-button">Main Menu</a>
        <h1 style="text-align:center">Search</h1>
        <form action="search.php" style="text-align:center">
            <input type="hidden" id="selectRequest" name="selectRequest">
            Search in:
            <select id="selectTable" name="selectTable" required>
                <option value="" selected="selected">Please select</option>
                <option value="WeddingsBookFor">Weddings</option>
                <option value="GroomsMarry">Grooms</option>
                <option value="BridesHolds">Brides</option>
                <option value="Bouquets">Bouquets</option>
                <option value="EntouragesAttire">Entourages Attires</option>
                <option value="Entourages">Entourages</option>
                <option value="Venues">Venues</option>
                <option value="VenuesProvince">Provincial Postal Codes</option>
                <option value="Staff">Staff</option>
                <option value="StaffHourlyRate">Company Hourly Rates</option>
                <option value="Officiants">Officiants</option>
                <option value="Caterers">Caterers</option>
                <option value="Photographers">Photographers</option>
                <option value="Cakes">Cakes</option>
                <option value="Guests">Guests</option>
                <option value="PlusOnesBring">Plus Ones</option>
                <option value="ParticipatesIn">Participating Entourages</option>
                <option value="WorksAt">Working Staff</option>
                <option value="Attends">Attending Guests</option>
                <option value="Bakes">Caterer Specialties</option>
                <option value="For">Reserved Cakes</option>
            </select> <br /><br />
            What are you looking for? <br /><br />
            <select id="selectAttributes1" name="selectAttributes1" required>
                <option value="*" selected="selected">All details</option>
            </select>
            <select id="selectAttributes2" name="selectAttributes2">
                <option value="" selected="selected">------</option>
            </select>
            <select id="selectAttributes3" name="selectAttributes3">
                <option value="" selected="selected">------</option>
            </select>
            <select id="selectAttributes4" name="selectAttributes4">
                <option value="" selected="selected">------</option>
            </select>
            <br /><br />
            Filter by: 
            <select id="selectCondition" name="selectCondition">
                <option value="" selected="selected">none</option>
            </select>
            <select id="selectOperation" name="selectOperation" required>
                <option value="=">is</option>
                <option value="<>">is not</option>
                <option value="<">less than</option>
                <option value="<=">less than or equal to</option>
                <option value=">">greater than</option>
                <option value=">=">greater than or equal to</option>
                <option value="IS NULL">does not exist</option>
                <option value="IS NOT NULL">exists</option>
                <option value="LIKE">contains</option>
            </select>
            <input type="text" name="selectArgument"> <br /><br />
            Group By: <input type="text" name="selectGroupBy"> <br /><br />

            <input type="submit" value="Submit" name="insertSubmit"></p>
        </form>


        <!-- THIS PROBABLY VIOLATES A LOT OF CODING PRINCIPLES BUT IDK HOW ELSE TO DO IT
        If you're reading this, you are a wonderful human being :) -->
        <script type="text/javascript">
            function setDropdowns() {
                var table = document.getElementById("selectTable").value;
                if (table == "WeddingsBookFor") {
                    document.getElementById("selectAttributes1").innerHTML = 
                    "<option value=\"*\" selected=\"selected\">All details</option>" +
                    "<option value=\"WeddingNumber\">Wedding ID</option>" + 
                    "<option value=\"StreetAddress\">Venue Address</option>" +
                    "<option value=\"WeddingDate\">WeddingDate</option>";
                    document.getElementById("selectAttributes2").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"WeddingNumber\">Wedding ID</option>" + 
                    "<option value=\"StreetAddress\">Venue Address</option>" +
                    "<option value=\"WeddingDate\">WeddingDate</option>";
                    document.getElementById("selectAttributes3").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"WeddingNumber\">Wedding ID</option>" + 
                    "<option value=\"StreetAddress\">Venue Address</option>" +
                    "<option value=\"WeddingDate\">WeddingDate</option>";
                    document.getElementById("selectAttributes4").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"WeddingNumber\">Wedding ID</option>" + 
                    "<option value=\"StreetAddress\">Venue Address</option>" +
                    "<option value=\"WeddingDate\">WeddingDate</option>";
                    document.getElementById("selectCondition").innerHTML = 
                    "<option value=\"\" selected=\"selected\">none</option>" +
                    "<option value=\"WeddingNumber\">Wedding ID</option>" + 
                    "<option value=\"StreetAddress\">Venue Address</option>" +
                    "<option value=\"WeddingDate\">WeddingDate</option>";
                }
            }

            document.getElementById("selectTable").addEventListener("change", setDropdowns);
        </script>

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

        // selectAttributes is an attribute or comma separated attributes
        // selectTable is a table name
        // selectCondition is an attribute
        // selectOperation is one of [=, <>, >, >=, <, <=, LIKE, IS NULL, IS NOT NULL]
        // selectArgument is a value of same domain as selectCondition (empty if IS (NOT) NULL)
        // selectGroupBy is an attribute or comma seperated attributes
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

            $groupby = "";
            if ($_GET['selectGroupBy'] != "") {
                $groupByAttributes = explode(",", $_GET['selectGroupBy']);
                $attributes = explode(",", $_GET['selectAttributes']);
                foreach ($attributes as $attr1 ) {
                    $err = true;
                    foreach ($groupByAttributes as $attr2) {
                        if ($attr1 == $attr2) $err = false;
                    }
                    if ($err) {
                        print_r("SELECTED ATTRIBUTES MUST APPEAR IN GROUP BY OR BE AGGREGATED");
                        return;
                    }
                }
                $groupby = " GROUP BY " . $_GET['selectGroupBy'];
            }

            $result = executePlainSQL($select . $from . $where . $groupby);

            printResult($result);
        }

        function sanitizeArguments() {
            $attributeStr = $_GET['selectAttributes1'];
            
            if ($_GET['selectAttributes2'] != "" && 
            $_GET['selectAttributes2'] != $_GET['selectAttributes1']) {
                printf("test inside");
                $attributeStr = $attributeStr . "," . $_GET['selectAttributes2'];
            }
            if ($_GET['selectAttributes3'] != "" && 
            $_GET['selectAttributes3'] != $_GET['selectAttributes1'] &&
            $_GET['selectAttributes3'] != $_GET['selectAttributes2']) {
                $attributeStr = $attributeStr . "," . $_GET['selectAttributes3'];
            }
            if ($_GET['selectAttributes4'] != "" && 
            $_GET['selectAttributes4'] != $_GET['selectAttributes1'] &&
            $_GET['selectAttributes4'] != $_GET['selectAttributes2'] &&
            $_GET['selectAttributes4'] != $_GET['selectAttributes3']) {
                $attributeStr = $attributeStr . "," . $_GET['selectAttributes4'];
            }
            $_GET['selectAttributes'] = $attributeStr;
            return true;
        }

        // HANDLE ALL GET ROUTES
        // A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handleGETRequest() {
            if (connectToDB()) {
                if (array_key_exists('selectRequest', $_GET)) {
                    handleSelectRequest();
                } else if (array_key_exists('selectJoinRequest', $_GET)) {
                    handleSelectJoinRequest();
                }

                disconnectFromDB();
            }
        }

        if (isset($_GET['selectRequest']) || isset($_GET['selectJoinRequest'])) {
            if (sanitizeArguments()) {
                handleGETRequest();
            }
        }

        ?>
    </body>
</html>