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
			Attribute: <input type="text" name="selectAttribute"> <br /><br />		
            Table: <input type="text" name="selectTable"> <br /><br />				
			Value: <input type="text" name="toDel"> <br /><br />
			
            <input type="submit" value="Delete" name="deleteSubmit"></p>
        </form>

        <hr />
        <h2>Display the Tuples in Venues Table</h2>
        <form method="GET" action="update_delete.php"> <!--refresh page when submitted-->
            <input type="hidden" id="countTupleRequest" name="countTupleRequest">
            <input type="submit" name="countTuples"></p>
        </form>
		
		
	    <hr />
		
		<h2>Reset</h2>
        <p>If you wish to reset the table press on the reset button. If this is the first time you're running this page, you MUST use reset</p>

        <form method="POST" action="update_delete.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
            <p><input type="submit" value="Reset" name="reset"></p>
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
            $db_conn = OCILogon("ora_jliu2814", "a16585622", "dbhost.students.cs.ubc.ca:1522/stu");

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
            echo "<br>Retrieved data from table Guests Table:<br>";
            echo "<table>";
            echo "<tr><th>Email</th><th>FirstName</th><th>LastName</th></tr>";

            while ($row = OCI_Fetch_Array($resultG, OCI_BOTH)) {
				echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td></tr>"; 
			}
			
            echo "</table>";
        }
		
				 function handleResetRequest() {
            global $db_conn;
            // Drop old table
            executePlainSQL("drop table GroomsMarry");
			executePlainSQL("drop table BridesHolds");
			executePlainSQL("drop table Bouquets");
			executePlainSQL("drop table ParticipateIn");
			executePlainSQL("drop table WorksAt");
			executePlainSQL("drop table Attends");
			executePlainSQL("drop table ForWho");
			executePlainSQL("drop table WeddingsBookFor");
			executePlainSQL("drop table Venues");
			executePlainSQL("drop table Staff");
			executePlainSQL("drop table PlusOnesBring");
			executePlainSQL("drop table Entourages");
			executePlainSQL("drop table Bakes");
			executePlainSQL("drop table EntouragesAttire");
			executePlainSQL("drop table VenuesProvince");
			executePlainSQL("drop table StaffHourlyRate");
			executePlainSQL("drop table Officiants");
			executePlainSQL("drop table Caterers");
			executePlainSQL("drop table Photographers");
			executePlainSQL("drop table Cakes");
			executePlainSQL("drop table Guests");		
	
            // Create new table
            echo "<br> creating new tables <br>";
			executePlainSQL("create table Bouquets(
BouquetType char(30) null,
primary key (BouquetType)
)");
			executePlainSQL("create table BridesHolds(
Email char(30) null,
FirstName char(30) null,
LastName char(30) null,
BouquetType char(30) null,
primary key (Email),
foreign key (BouquetType) references Bouquets
)");
			executePlainSQL("create table EntouragesAttire(
Role char(30) null ,
Attire char(30) null,
primary key (Role)
)
");
			executePlainSQL("create table VenuesProvince(
PostalCode char(30) null,
Province char(30) null,
primary key (PostalCode)
)");
			executePlainSQL("create table StaffHourlyRate(
Company char(30) null,
HourlyRate int null,
primary key (Company)
)
");
			executePlainSQL("create table Officiants(
Email char(30) null,
IsAPriest number(1) null,
primary key (Email)
)");
			executePlainSQL("create table Caterers(
Email char(30) null,
Cuisine char(30) null, 
primary key (Email)
)");
			executePlainSQL("create table Photographers(
Email char(30) null,
Camera char(30) null,
primary key (Email)
)");
			executePlainSQL("create table Cakes(
Flavour char(30) null,
NumberOfTiers int null,
primary key (Flavour, NumberOfTiers)
)
");
			executePlainSQL("create table Guests(
Email char(30) null,
FirstName char(30) null,
LastName char(30) null,
primary key (Email)
)");
			executePlainSQL("create table Venues(
StreetAddress char(30) null,
Name char(30) null,
MaxCapacity int null,
PostalCode char(30) null,
primary key (StreetAddress),
foreign key (PostalCode) references VenuesProvince ON DELETE CASCADE
)");
			executePlainSQL("create table Staff(
Email char(30) null,
Company char(30) null,
FirstName char(30) null,
LastName char(30) null,
primary key (Email),
foreign key (Company) references StaffHourlyRate ON DELETE CASCADE
)
");
			executePlainSQL("create table Entourages(
Email char(30) null,
Role char(30) null,
FirstName char(30) null,
LastName char(30) null,
primary key (Email),
foreign key (Role) references EntouragesAttire ON DELETE CASCADE
)");
			executePlainSQL("create table WeddingsBookFor(
WeddingNumber int null,
StreetAddress char(30) not null,
WeddingDate date null,
primary key (WeddingNumber),
foreign key (StreetAddress) references Venues ON DELETE CASCADE
)");
			executePlainSQL("create table PlusOnesBring(
GuestEmail char(30) null,
PlusOneEmail char(30) null,
FirstName char(30) null,
LastName char(30) null,
primary key (GuestEmail, PlusOneEmail),
foreign key (GuestEmail) references Guests
)
");
			executePlainSQL("create table Bakes(
CatererEmail char(30) null,
Flavour char(30) null,
NumberOfTiers int null,
primary key (CatererEmail, Flavour, NumberOfTiers),
foreign key (CatererEmail) references Caterers,
foreign key (Flavour, NumberOfTiers) references Cakes
)
");
			executePlainSQL("create table ForWho(
Flavour char(30) null,
NumberOfTiers int null,
WeddingNumber int null,
primary key (Flavour, NumberOfTiers, WeddingNumber),
foreign key (Flavour, NumberOfTiers) references Cakes,
foreign key (WeddingNumber) references WeddingsBookFor
)");
			executePlainSQL("create table Attends(
WeddingNumber int null,
GuestEmail char(30) null,
primary key (WeddingNumber, GuestEmail),
foreign key (WeddingNumber) references WeddingsBookFor,
foreign key (GuestEmail) references Guests
)");
			executePlainSQL("create table WorksAt(
WeddingNumber int null,
StaffEmail char(30) null,
primary key (WeddingNumber, StaffEmail),
foreign key (WeddingNumber) references WeddingsBookFor,
foreign key (StaffEmail) references Staff
)
");
			executePlainSQL("create table ParticipateIn(
WeddingNumber int null,
EntourageEmail char(30) null,
primary key (WeddingNumber, EntourageEmail),
foreign key (WeddingNumber) references WeddingsBookFor,
foreign key (EntourageEmail) references Entourages
)
");
			executePlainSQL("create table GroomsMarry(
Email char(30) null,
FirstName char(30) null,
LastName char(30) null,
BrideEmail char(30) not null unique,
WeddingNumber int not null unique,
primary key (Email),
foreign key (BrideEmail) references BridesHolds ON DELETE CASCADE,
foreign key (WeddingNumber) references WeddingsBookFor ON DELETE CASCADE
)");
				
			executePlainSQL("insert into Guests
values('signorferrari@gmail.com', 'Signor', 'Ferrari')");
			executePlainSQL("insert into Guests
values('brocklovett@gmail.com', 'Brock', 'Lovett')");
			executePlainSQL("insert into Guests
values('caledonhockley@gmail.com', 'Caledon', 'Hockley')");
			executePlainSQL("insert into Guests
values('captsmith@gmail.com', 'Edward John', 'Smith')");
			executePlainSQL("insert into Guests
values('amybrandt@gmail.com', 'Amy', 'Brandt')");

			executePlainSQL("insert into Bouquets
values('cascade')");
			executePlainSQL("
insert into Bouquets
values('posy')
");
			executePlainSQL("insert into Bouquets
values('hand-tied')");
			executePlainSQL("insert into Bouquets
values('round')");
			executePlainSQL("insert into Bouquets
values('pomander')
");
			executePlainSQL("insert into Bouquets
values('composite')
");
			executePlainSQL("insert into Bouquets
values('nosegay')");

			executePlainSQL("insert into BridesHolds
values('ilsalund@gmail.com', 'Ilsa', 'Lund', 'cascade')");
			executePlainSQL("insert into BridesHolds
values('rosedewittbukater@gmail.com', 'Rose', 'DeWitt Bukater', 'posy')");
			executePlainSQL("insert into BridesHolds
values('miadolan@gmail.com', 'Amelia', 'Dolan', 'hand-tied')");
			executePlainSQL("insert into BridesHolds
values('jennycurran@gmail.com', 'Jenny', 'Curran', 'round')");
			executePlainSQL("insert into BridesHolds
values('elliedocter@gmail.com', 'Elizabeth', 'Docter', 'pomander')");
			executePlainSQL("insert into EntouragesAttire
values('best man', 'suit')
");
			executePlainSQL("insert into EntouragesAttire
values('groomsman', 'suit')");
			executePlainSQL("insert into EntouragesAttire
values('bridesmaid', 'dress')");
			executePlainSQL("insert into EntouragesAttire
values('flower girl', 'dress')
");
			executePlainSQL("insert into EntouragesAttire
values('usher', 'suit')");
			executePlainSQL("insert into EntouragesAttire
values('ring bearer', 'suit')");
			executePlainSQL("insert into VenuesProvince
values('V6B 3L4', 'BC')");
			executePlainSQL("insert into VenuesProvince
values('V6T 1Z2', 'BC')");
			executePlainSQL("insert into VenuesProvince
values('V6M 4H1', 'BC')");
			executePlainSQL("insert into VenuesProvince
values('V6G 3E2', 'BC')");
			executePlainSQL("
insert into VenuesProvince
values('T1L 1J4', 'Alberta')
");

			executePlainSQL("insert into StaffHourlyRate
values('Casablanca Co.', 30)
");
			executePlainSQL("insert into StaffHourlyRate
values('Titanic Studio', 28)
");
			executePlainSQL("insert into StaffHourlyRate
values('La La Land Ltd.', 22)
");
			executePlainSQL("insert into StaffHourlyRate
values('Paramount', 20)");
			executePlainSQL("insert into StaffHourlyRate
values('Forrest Gump and Co.', 23)");
			executePlainSQL("insert into StaffHourlyRate
values('Up Services', 22)
");
			executePlainSQL("insert into Officiants
values('michaelcurtiz@gmail.com', 1)");
			executePlainSQL("insert into Officiants
values('jamescameron@gmail.com', 0)");
			executePlainSQL("insert into Officiants
values('damienchazelle@gmail.com', 0)
");
			executePlainSQL("insert into Caterers
values('maxsteiner@gmail.com', 'austrian')");
			executePlainSQL("
insert into Caterers
values('jameshorner@gmail.com', 'dessert')");
			executePlainSQL("
insert into Caterers
values('brianrobins@gmail.com', 'dessert')");
			executePlainSQL("insert into Caterers
values('johnlegend@gmail.com', 'american')
");
			executePlainSQL("insert into Photographers
values('celinedion@gmail.com', 'canon')");
			executePlainSQL("insert into Photographers
values('petedocter@gmail.com', 'nikon')");

			executePlainSQL("insert into Cakes
values('tiramisu', 3)
");
			executePlainSQL("insert into Cakes
values('tiramisu', 2)");
			executePlainSQL("insert into Cakes
values('red velvet', 7)");
			executePlainSQL("insert into Cakes
values('black forest', 4)");
			executePlainSQL("insert into Cakes
values('creme brulee', 1)");

			executePlainSQL("insert into Venues
values('601 Smithe St', 'The Orpheum', 2780, 'V6B 3L4')");
			executePlainSQL("insert into Venues
values('6301 Crescent Rd', 'UBC Rose Garden', 250, 'V6T 1Z2')");
			executePlainSQL("insert into Venues
values('5251 Oak St', 'VanDusen Botanical Garden', 400, 'V6M 4H1')");			
			executePlainSQL("insert into Venues
values('845 Avison Way', 'Vancouver Aquarium', 1000, 'V6G 3E2')");
			executePlainSQL("insert into Venues
values('405 Spray Ave', 'Fairmont Banff Springs', 2500, 'T1L 1J4')");

			executePlainSQL("insert into Staff
values('michaelcurtiz@gmail.com', 'Casablanca Co.', 'Michael', 'Curtiz')");
			executePlainSQL("insert into Staff
values('maxsteiner@gmail.com', 'Casablanca Co.', 'Max', 'Steiner')");
			executePlainSQL("insert into Staff
values('jamescameron@gmail.com', 'Titanic Studio', 'James', 'Cameron')");
			executePlainSQL("insert into Staff
values('jameshorner@gmail.com', 'Titanic Studio', 'James', 'Horner')");
			executePlainSQL("insert into Staff
values('celinedion@gmail.com', 'Titanic Studio', 'Celine', 'Dion')");
			executePlainSQL("insert into Staff
values('damienchazelle@gmail.com', 'La La Land Ltd.', 'Damien', 'Chazelle')");
			executePlainSQL("insert into Staff
values('johnlegend@gmail.com', 'La La Land Ltd.', 'John', 'Legend')");
			executePlainSQL("insert into Staff
values('brianrobins@gmail.com', 'Paramount', 'Brian', 'Robins')");
			executePlainSQL("
insert into Staff
values('robertzemeckis@gmail.com', 'Forrest Gump and Co.', 'Robert', 'Zemeckis')");
			executePlainSQL("insert into Staff
values('petedocter@gmail.com', 'Up Services', 'Pete', 'Docter')");


			executePlainSQL("insert into Entourages
values('captrenault@gmail.com', 'best man', 'Louis', 'Renault')");
			executePlainSQL("insert into Entourages
values('victorlaszlo@gmail.com', 'usher', 'Victor', 'Laszlo')");
			executePlainSQL("insert into Entourages
values('ruthdewittbukater@gmail.com', 'bridesmaid', 'Ruth', 'DeWitt Bukater')");
			executePlainSQL("insert into Entourages
values('lizzyclavert@gmail.com', 'flower girl', 'Lizzy', 'Calvert')");
			executePlainSQL("insert into Entourages
values('tommyryan@gmail.com', 'best man', 'Tommy', 'Ryan')");
			executePlainSQL("insert into Entourages
values('laurawilder@gmail.com', 'bridesmaid', 'Laura', 'Wilder')");
			executePlainSQL("insert into Entourages
values('ltdan@gmail.com', 'best man', 'Dan', 'Taylor')");
			executePlainSQL("insert into Entourages
values('bubba@gmail.com', 'groomsman', 'Benjamin Buford', 'Blue')");
			executePlainSQL("insert into Entourages
values('charlesmuntz@gmail.com', 'usher', 'Charles', 'Muntz')");
			executePlainSQL("insert into Entourages
values('russelnagai@gmail.com', 'ring bearer', 'Russel', 'Nagai')");
			executePlainSQL("insert into WeddingsBookFor
values(1, '601 Smithe St', to_date('2023/08/23', 'yyyy/mm/dd'))");
			
			executePlainSQL("insert into WeddingsBookFor
values(2, '6301 Crescent Rd', to_date('2023/09/24', 'yyyy/mm/dd'))");
			executePlainSQL("insert into WeddingsBookFor
values(3,'5251 Oak St', to_date('2023/10/25', 'yyyy/mm/dd'))");
			executePlainSQL("insert into WeddingsBookFor
values(4, '845 Avison Way', to_date('2023/11/26', 'yyyy/mm/dd'))");
			executePlainSQL("insert into WeddingsBookFor
values(5, '405 Spray Ave', to_date('2023/12/27', 'yyyy/mm/dd'))");
			executePlainSQL("insert into PlusOnesBring
values('signorferrari@gmail.com', 'majstrasser@gmail.com', 'Heinrich', 'Strasser')");
			executePlainSQL("insert into PlusOnesBring
values('signorferrari@gmail.com', 'janbrandel@gmail.com', 'Jan', 'Brandel')");
			executePlainSQL("insert into PlusOnesBring
values('brocklovett@gmail.com', 'fabrizioderossi@gmail.com', 'Fabrizio', 'De Rossi')");
			executePlainSQL("insert into PlusOnesBring
values('caledonhockley@gmail.com', 'spicerlovejoy@gmail.com', 'Spicer', 'Lovejoy')");
			executePlainSQL("insert into PlusOnesBring
values('captsmith@gmail.com', 'archibaldgracie@gmail.com', 'Archibald', 'Gracie')");
			executePlainSQL("insert into Bakes
values('jameshorner@gmail.com', 'tiramisu', 3)");
			executePlainSQL("
insert into Bakes
values('jameshorner@gmail.com', 'black forest', 4)
");
			executePlainSQL("insert into Bakes
values('brianrobins@gmail.com', 'tiramisu', 2)");
			executePlainSQL("insert into Bakes
values('brianrobins@gmail.com', 'red velvet', 7)");
			executePlainSQL("insert into Bakes
values('brianrobins@gmail.com', 'creme brulee', 1)");
			executePlainSQL("insert into ForWho
values('tiramisu', 3, 1)");
			executePlainSQL("insert into ForWho
values('black forest', 4, 1)");
			executePlainSQL("insert into ForWho
values('tiramisu', 2, 4)");
			executePlainSQL("insert into ForWho
values('red velvet', 7, 3)");
			executePlainSQL("insert into ForWho
values('creme brulee', 1, 3)");
			executePlainSQL("insert into Attends
values(1, 'signorferrari@gmail.com')");
			executePlainSQL("insert into Attends
values(2, 'brocklovett@gmail.com')");
			executePlainSQL("insert into Attends
values(2, 'caledonhockley@gmail.com')");
			executePlainSQL("insert into Attends
values(2, 'captsmith@gmail.com')
");
			
			executePlainSQL("insert into Attends
values(3, 'amybrandt@gmail.com')");
			executePlainSQL("insert into WorksAt
values(1, 'michaelcurtiz@gmail.com')");
			executePlainSQL("insert into WorksAt
values(1, 'maxsteiner@gmail.com')");
			executePlainSQL("insert into WorksAt
values(2, 'jamescameron@gmail.com')");
			executePlainSQL("insert into WorksAt
values(2, 'jameshorner@gmail.com')
");
			executePlainSQL("insert into WorksAt
values(2, 'celinedion@gmail.com')");
			executePlainSQL("insert into WorksAt
values(3, 'damienchazelle@gmail.com')");
			executePlainSQL("insert into WorksAt
values(3, 'johnlegend@gmail.com')");
			executePlainSQL("insert into WorksAt
values(3, 'brianrobins@gmail.com')");
			executePlainSQL("insert into WorksAt
values(4, 'brianrobins@gmail.com')");
			executePlainSQL("insert into WorksAt
values(4, 'robertzemeckis@gmail.com')");
			executePlainSQL("insert into WorksAt
values(5, 'petedocter@gmail.com')");
			executePlainSQL("insert into ParticipateIn
values(1, 'captrenault@gmail.com')");
			executePlainSQL("insert into ParticipateIn
values(1, 'victorlaszlo@gmail.com')");
			executePlainSQL("
insert into ParticipateIn
values(2, 'ruthdewittbukater@gmail.com')
");
			executePlainSQL("insert into ParticipateIn
values(2, 'lizzyclavert@gmail.com')");
			executePlainSQL("insert into ParticipateIn
values(2, 'tommyryan@gmail.com')");
			executePlainSQL("insert into ParticipateIn
values(3, 'laurawilder@gmail.com')");
			executePlainSQL("insert into ParticipateIn
values(4, 'ltdan@gmail.com')");
			executePlainSQL("insert into ParticipateIn
values(4, 'bubba@gmail.com')");
			executePlainSQL("insert into ParticipateIn
values(5, 'charlesmuntz@gmail.com')");
			executePlainSQL("insert into ParticipateIn
values(5, 'russelnagai@gmail.com')");
			executePlainSQL("insert into GroomsMarry
values('rickblaine@gmail.com', 'Rick', 'Blaine', 'ilsalund@gmail.com', 1)");
			
			executePlainSQL("insert into GroomsMarry
values('jackdawson@gmail.com', 'Jack', 'Dawson', 'rosedewittbukater@gmail.com', 2)");
			executePlainSQL("insert into GroomsMarry
values('sebwilder@gmail.com', 'Sebastian', 'Wilder', 'miadolan@gmail.com', 3)");
			executePlainSQL("insert into GroomsMarry
values('forrestgump@gmail.com', 'Forrest', 'Gump', 'jennycurran@gmail.com', 4)");
			executePlainSQL("insert into GroomsMarry
values('carlfredrickson@gmail.com', 'Carl', 'Fredrickson', 'elliedocter@gmail.com', 5)");
		

            OCICommit($db_conn);
        }
		
		function handleUpdateRequest() {
            global $db_conn;
			
			$select = $_POST['selectAttribute'];
            $from = $_POST['selectTable'];
			$old_value = $_POST['oldValue'];
			$new_value = $_POST['newValue'];			
			
            executePlainSQL("UPDATE $from SET $select='" . $new_value . "' WHERE $select='" . $old_value . "'");
			
            OCICommit($db_conn);
        }
		
		
		
		function handleDeleteRequest() {
            global $db_conn;
			
			$select = $_POST['selectAttribute'];
			
            $from = $_POST['selectTable'];
			
			$value = $_POST['toDel'];
			
			executePlainSQL("DELETE FROM $from WHERE $select = '$value' ");		
		
            OCICommit($db_conn);
        }
		 
		
		function handleCountRequest() {
            global $db_conn;
           
			$resultG = executePlainSQL("SELECT * FROM Guests");
        
			echo printResultG($resultG);
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


        if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['deleteSubmit'])) {
                handlePOSTRequest();
        } else if (isset($_GET['countTupleRequest']) || isset($_GET['selectRequest'])) {
            handleGETRequest();
        }

        ?>
		
    </body>
</html>