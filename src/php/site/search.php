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
                <option value="ParticipateIn">Participating Entourages</option>
                <option value="WorksAt">Working Staff</option>
                <option value="Attends">Attending Guests</option>
                <option value="Bakes">Caterer Baking</option>
                <option value="ForWho">Reserved Cakes</option>
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
                } else if (table == "BridesHolds") {
                    document.getElementById("selectAttributes1").innerHTML = 
                    "<option value=\"*\" selected=\"selected\">All details</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"FirstName\">First Name</option>" +
                    "<option value=\"LastName\">Last Name</option>" +
                    "<option value=\"BouquetType\">Bouquet Type</option>";
                    document.getElementById("selectAttributes2").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"FirstName\">First Name</option>" +
                    "<option value=\"LastName\">Last Name</option>" +
                    "<option value=\"BouquetType\">Bouquet Type</option>";
                    document.getElementById("selectAttributes3").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"FirstName\">First Name</option>" +
                    "<option value=\"LastName\">Last Name</option>" +
                    "<option value=\"BouquetType\">Bouquet Type</option>";
                    document.getElementById("selectAttributes4").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"FirstName\">First Name</option>" +
                    "<option value=\"LastName\">Last Name</option>" +
                    "<option value=\"BouquetType\">Bouquet Type</option>";
                    document.getElementById("selectCondition").innerHTML = 
                    "<option value=\"\" selected=\"selected\">none</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"FirstName\">First Name</option>" +
                    "<option value=\"LastName\">Last Name</option>" +
                    "<option value=\"BouquetType\">Bouquet Type</option>";
                } else if (table == "GroomsMarry") {
                    document.getElementById("selectAttributes1").innerHTML = 
                    "<option value=\"*\" selected=\"selected\">All details</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"FirstName\">First Name</option>" +
                    "<option value=\"LastName\">Last Name</option>" +
                    "<option value=\"BrideEmail\">Bride Email</option>" +
                    "<option value=\"WeddingNumber\">Wedding ID</option>";
                    document.getElementById("selectAttributes2").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"FirstName\">First Name</option>" +
                    "<option value=\"LastName\">Last Name</option>" +
                    "<option value=\"BrideEmail\">Bride Email</option>" +
                    "<option value=\"WeddingNumber\">Wedding ID</option>";
                    document.getElementById("selectAttributes3").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"FirstName\">First Name</option>" +
                    "<option value=\"LastName\">Last Name</option>" +
                    "<option value=\"BrideEmail\">Bride Email</option>" +
                    "<option value=\"WeddingNumber\">Wedding ID</option>";
                    document.getElementById("selectAttributes4").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"FirstName\">First Name</option>" +
                    "<option value=\"LastName\">Last Name</option>" +
                    "<option value=\"BrideEmail\">Bride Email</option>" +
                    "<option value=\"WeddingNumber\">Wedding ID</option>";
                    document.getElementById("selectCondition").innerHTML = 
                    "<option value=\"\" selected=\"selected\">none</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"FirstName\">First Name</option>" +
                    "<option value=\"LastName\">Last Name</option>" +
                    "<option value=\"BrideEmail\">Bride Email</option>" +
                    "<option value=\"WeddingNumber\">Wedding ID</option>";
                } else if (table == "Bouquets") {
                    document.getElementById("selectAttributes1").innerHTML = 
                    "<option value=\"*\" selected=\"selected\">All details</option>" +
                    "<option value=\"BouquetType\">Bouquet Type</option>";
                    document.getElementById("selectAttributes2").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"BouquetType\">Bouquet Type</option>";
                    document.getElementById("selectAttributes3").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"BouquetType\">Bouquet Type</option>";
                    document.getElementById("selectAttributes4").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"BouquetType\">Bouquet Type</option>";
                    document.getElementById("selectCondition").innerHTML = 
                    "<option value=\"\" selected=\"selected\">none</option>" +
                    "<option value=\"BouquetType\">Bouquet Type</option>";
                } else if (table == "EntouragesAttire") {
                    document.getElementById("selectAttributes1").innerHTML = 
                    "<option value=\"*\" selected=\"selected\">All details</option>" +
                    "<option value=\"Role\">Role</option>" + 
                    "<option value=\"Attire\">Attire</option>";
                    document.getElementById("selectAttributes2").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Role\">Role</option>" + 
                    "<option value=\"Attire\">Attire</option>";
                    document.getElementById("selectAttributes3").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Role\">Role</option>" + 
                    "<option value=\"Attire\">Attire</option>";
                    document.getElementById("selectAttributes4").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Role\">Role</option>" + 
                    "<option value=\"Attire\">Attire</option>";
                    document.getElementById("selectCondition").innerHTML = 
                    "<option value=\"\" selected=\"selected\">none</option>" +
                    "<option value=\"Role\">Role</option>" + 
                    "<option value=\"Attire\">Attire</option>";
                } else if (table == "Entourages") {
                    document.getElementById("selectAttributes1").innerHTML = 
                    "<option value=\"*\" selected=\"selected\">All details</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"FirstName\">First Name</option>" +
                    "<option value=\"LastName\">Last Name</option>" +
                    "<option value=\"Role\">Role</option>";
                    document.getElementById("selectAttributes2").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"FirstName\">First Name</option>" +
                    "<option value=\"LastName\">Last Name</option>" +
                    "<option value=\"Role\">Role</option>";
                    document.getElementById("selectAttributes3").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"FirstName\">First Name</option>" +
                    "<option value=\"LastName\">Last Name</option>" +
                    "<option value=\"Role\">Role</option>";
                    document.getElementById("selectAttributes4").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"FirstName\">First Name</option>" +
                    "<option value=\"LastName\">Last Name</option>" +
                    "<option value=\"Role\">Role</option>";
                    document.getElementById("selectCondition").innerHTML = 
                    "<option value=\"\" selected=\"selected\">none</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"FirstName\">First Name</option>" +
                    "<option value=\"LastName\">Last Name</option>" +
                    "<option value=\"Role\">Role</option>";
                } else if (table == "VenuesProvince") {
                    document.getElementById("selectAttributes1").innerHTML = 
                    "<option value=\"*\" selected=\"selected\">All details</option>" +
                    "<option value=\"Postal Code\">Postal Code</option>" + 
                    "<option value=\"Province\">Province</option>";
                    document.getElementById("selectAttributes2").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Postal Code\">Postal Code</option>" + 
                    "<option value=\"Province\">Province</option>";
                    document.getElementById("selectAttributes3").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Postal Code\">Postal Code</option>" + 
                    "<option value=\"Province\">Province</option>";
                    document.getElementById("selectAttributes4").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Postal Code\">Postal Code</option>" + 
                    "<option value=\"Province\">Province</option>";
                    document.getElementById("selectCondition").innerHTML = 
                    "<option value=\"\" selected=\"selected\">none</option>" +
                    "<option value=\"Postal Code\">Postal Code</option>" + 
                    "<option value=\"Province\">Province</option>";
                } else if (table == "Venues") {
                    document.getElementById("selectAttributes1").innerHTML = 
                    "<option value=\"*\" selected=\"selected\">All details</option>" +
                    "<option value=\"StreetAddress\">Street Address</option>" + 
                    "<option value=\"Name\">Name</option>" +
                    "<option value=\"MaxCapacity\">Max Capacity</option>" +
                    "<option value=\"Postal Code\">Postal Code</option>";
                    document.getElementById("selectAttributes2").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"StreetAddress\">Street Address</option>" + 
                    "<option value=\"Name\">Name</option>" +
                    "<option value=\"MaxCapacity\">Max Capacity</option>" +
                    "<option value=\"Postal Code\">Postal Code</option>";
                    document.getElementById("selectAttributes3").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"StreetAddress\">Street Address</option>" + 
                    "<option value=\"Name\">Name</option>" +
                    "<option value=\"MaxCapacity\">Max Capacity</option>" +
                    "<option value=\"Postal Code\">Postal Code</option>";
                    document.getElementById("selectAttributes4").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"StreetAddress\">Street Address</option>" + 
                    "<option value=\"Name\">Name</option>" +
                    "<option value=\"MaxCapacity\">Max Capacity</option>" +
                    "<option value=\"Postal Code\">Postal Code</option>";
                    document.getElementById("selectCondition").innerHTML = 
                    "<option value=\"\" selected=\"selected\">none</option>" +
                    "<option value=\"StreetAddress\">Street Address</option>" + 
                    "<option value=\"Name\">Name</option>" +
                    "<option value=\"MaxCapacity\">Max Capacity</option>" +
                    "<option value=\"Postal Code\">Postal Code</option>";
                } else if (table == "Staff") {
                    document.getElementById("selectAttributes1").innerHTML = 
                    "<option value=\"*\" selected=\"selected\">All details</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"FirstName\">First Name</option>" +
                    "<option value=\"LastName\">Last Name</option>" +
                    "<option value=\"Company\">Company</option>";
                    document.getElementById("selectAttributes2").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"FirstName\">First Name</option>" +
                    "<option value=\"LastName\">Last Name</option>" +
                    "<option value=\"Company\">Company</option>";
                    document.getElementById("selectAttributes3").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"FirstName\">First Name</option>" +
                    "<option value=\"LastName\">Last Name</option>" +
                    "<option value=\"Company\">Company</option>";
                    document.getElementById("selectAttributes4").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"FirstName\">First Name</option>" +
                    "<option value=\"LastName\">Last Name</option>" +
                    "<option value=\"Company\">Company</option>";
                    document.getElementById("selectCondition").innerHTML = 
                    "<option value=\"\" selected=\"selected\">none</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"FirstName\">First Name</option>" +
                    "<option value=\"LastName\">Last Name</option>" +
                    "<option value=\"Company\">Company</option>";
                } else if (table == "StaffHourlyRate") {
                    document.getElementById("selectAttributes1").innerHTML = 
                    "<option value=\"*\" selected=\"selected\">All details</option>" +
                    "<option value=\"Company\">Company</option>" + 
                    "<option value=\"HourlyRate\">Hourly Rate</option>";
                    document.getElementById("selectAttributes2").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Company\">Company</option>" + 
                    "<option value=\"HourlyRate\">Hourly Rate</option>";
                    document.getElementById("selectAttributes3").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Company\">Company</option>" + 
                    "<option value=\"HourlyRate\">Hourly Rate</option>";
                    document.getElementById("selectAttributes4").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Company\">Company</option>" + 
                    "<option value=\"HourlyRate\">Hourly Rate</option>";
                    document.getElementById("selectCondition").innerHTML = 
                    "<option value=\"\" selected=\"selected\">none</option>" +
                    "<option value=\"Company\">Company</option>" + 
                    "<option value=\"HourlyRate\">Hourly Rate</option>";
                } else if (table == "Officiants") {
                    document.getElementById("selectAttributes1").innerHTML = 
                    "<option value=\"*\" selected=\"selected\">All details</option>" +
                    "<option value=\"Email\">Email</option>";
                    document.getElementById("selectAttributes2").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Email\">Email</option>";
                    document.getElementById("selectAttributes3").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Email\">Email</option>";
                    document.getElementById("selectAttributes4").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Email\">Email</option>";
                    document.getElementById("selectCondition").innerHTML = 
                    "<option value=\"\" selected=\"selected\">none</option>" +
                    "<option value=\"Email\">Email</option>";
                } else if (table == "Caterers") {
                    document.getElementById("selectAttributes1").innerHTML = 
                    "<option value=\"*\" selected=\"selected\">All details</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"Cuisine\">Cuisine</option>";
                    document.getElementById("selectAttributes2").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"Cuisine\">Cuisine</option>";
                    document.getElementById("selectAttributes3").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"Cuisine\">Cuisine</option>";
                    document.getElementById("selectAttributes4").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"Cuisine\">Cuisine</option>";
                    document.getElementById("selectCondition").innerHTML = 
                    "<option value=\"\" selected=\"selected\">none</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"Cuisine\">Cuisine</option>";
                } else if (table == "Photographers") {
                    document.getElementById("selectAttributes1").innerHTML = 
                    "<option value=\"*\" selected=\"selected\">All details</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"Camera\">First Name</option>";
                    document.getElementById("selectAttributes2").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"Camera\">First Name</option>";
                    document.getElementById("selectAttributes3").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"Camera\">First Name</option>";
                    document.getElementById("selectAttributes4").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"Camera\">First Name</option>";
                    document.getElementById("selectCondition").innerHTML = 
                    "<option value=\"\" selected=\"selected\">none</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"Camera\">First Name</option>";
                } else if (table == "Cakes") {
                    document.getElementById("selectAttributes1").innerHTML = 
                    "<option value=\"*\" selected=\"selected\">All details</option>" +
                    "<option value=\"Flavour\">Flavour</option>" + 
                    "<option value=\"NumberOfTiers\">Number of Tiers</option>";
                    document.getElementById("selectAttributes2").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"Flavour\">Flavour</option>" + 
                    "<option value=\"NumberOfTiers\">Number of Tiers</option>";
                    document.getElementById("selectAttributes3").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Flavour\">Flavour</option>" + 
                    "<option value=\"NumberOfTiers\">Number of Tiers</option>";
                    document.getElementById("selectAttributes4").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Flavour\">Flavour</option>" + 
                    "<option value=\"NumberOfTiers\">Number of Tiers</option>";
                    document.getElementById("selectCondition").innerHTML = 
                    "<option value=\"\" selected=\"selected\">none</option>" +
                    "<option value=\"Flavour\">Flavour</option>" + 
                    "<option value=\"NumberOfTiers\">Number of Tiers</option>";
                } else if (table == "Guests") {
                    document.getElementById("selectAttributes1").innerHTML = 
                    "<option value=\"*\" selected=\"selected\">All details</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"FirstName\">First Name</option>" +
                    "<option value=\"LastName\">Last Name</option>";
                    document.getElementById("selectAttributes2").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"FirstName\">First Name</option>" +
                    "<option value=\"LastName\">Last Name</option>";
                    document.getElementById("selectAttributes3").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"FirstName\">First Name</option>" +
                    "<option value=\"LastName\">Last Name</option>";
                    document.getElementById("selectAttributes4").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"FirstName\">First Name</option>" +
                    "<option value=\"LastName\">Last Name</option>";
                    document.getElementById("selectCondition").innerHTML = 
                    "<option value=\"\" selected=\"selected\">none</option>" +
                    "<option value=\"Email\">Email</option>" + 
                    "<option value=\"FirstName\">First Name</option>" +
                    "<option value=\"LastName\">Last Name</option>";
                } else if (table == "PlusOnesBring") {
                    document.getElementById("selectAttributes1").innerHTML = 
                    "<option value=\"*\" selected=\"selected\">All details</option>" +
                    "<option value=\"GuestEmail\">Guest Email</option>" + 
                    "<option value=\"PlusOneEmail\">Plus One Email</option>" + 
                    "<option value=\"FirstName\">First Name</option>" +
                    "<option value=\"LastName\">Last Name</option>";
                    document.getElementById("selectAttributes2").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"GuestEmail\">Guest Email</option>" + 
                    "<option value=\"PlusOneEmail\">Plus One Email</option>" + 
                    "<option value=\"FirstName\">First Name</option>" +
                    "<option value=\"LastName\">Last Name</option>";
                    document.getElementById("selectAttributes3").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"GuestEmail\">Guest Email</option>" + 
                    "<option value=\"PlusOneEmail\">Plus One Email</option>" + 
                    "<option value=\"FirstName\">First Name</option>" +
                    "<option value=\"LastName\">Last Name</option>";
                    document.getElementById("selectAttributes4").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"GuestEmail\">Guest Email</option>" + 
                    "<option value=\"PlusOneEmail\">Plus One Email</option>" + 
                    "<option value=\"FirstName\">First Name</option>" +
                    "<option value=\"LastName\">Last Name</option>";
                    document.getElementById("selectCondition").innerHTML = 
                    "<option value=\"\" selected=\"selected\">none</option>" +
                    "<option value=\"GuestEmail\">Guest Email</option>" + 
                    "<option value=\"PlusOneEmail\">Plus One Email</option>" + 
                    "<option value=\"FirstName\">First Name</option>" +
                    "<option value=\"LastName\">Last Name</option>";
                } else if (table == "ParticipateIn") {
                    document.getElementById("selectAttributes1").innerHTML = 
                    "<option value=\"*\" selected=\"selected\">All details</option>" +
                    "<option value=\"EntourageEmail\">Entourage Email</option>" + 
                    "<option value=\"WeddingNumber\">Wedding ID</option>";
                    document.getElementById("selectAttributes2").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"EntourageEmail\">Entourage Email</option>" + 
                    "<option value=\"WeddingNumber\">Wedding ID</option>";
                    document.getElementById("selectAttributes3").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"EntourageEmail\">Entourage Email</option>" + 
                    "<option value=\"WeddingNumber\">Wedding ID</option>";
                    document.getElementById("selectAttributes4").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"EntourageEmail\">Entourage Email</option>" + 
                    "<option value=\"WeddingNumber\">Wedding ID</option>";
                    document.getElementById("selectCondition").innerHTML = 
                    "<option value=\"\" selected=\"selected\">none</option>" +
                    "<option value=\"EntourageEmail\">Entourage Email</option>" + 
                    "<option value=\"WeddingNumber\">Wedding ID</option>";
                } else if (table == "WorksAt") {
                    document.getElementById("selectAttributes1").innerHTML = 
                    "<option value=\"*\" selected=\"selected\">All details</option>" +
                    "<option value=\"StaffEmail\">Staff Email</option>" + 
                    "<option value=\"WeddingNumber\">Wedding ID</option>";
                    document.getElementById("selectAttributes2").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"StaffEmail\">Staff Email</option>" + 
                    "<option value=\"WeddingNumber\">Wedding ID</option>";
                    document.getElementById("selectAttributes3").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"StaffEmail\">Staff Email</option>" + 
                    "<option value=\"WeddingNumber\">Wedding ID</option>";
                    document.getElementById("selectAttributes4").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"StaffEmail\">Staff Email</option>" + 
                    "<option value=\"WeddingNumber\">Wedding ID</option>";
                    document.getElementById("selectCondition").innerHTML = 
                    "<option value=\"\" selected=\"selected\">none</option>" +
                    "<option value=\"StaffEmail\">Staff Email</option>" + 
                    "<option value=\"WeddingNumber\">Wedding ID</option>";
                } else if (table == "Attends") {
                    document.getElementById("selectAttributes1").innerHTML = 
                    "<option value=\"*\" selected=\"selected\">All details</option>" +
                    "<option value=\"GuestEmail\">Guest Email</option>" + 
                    "<option value=\"WeddingNumber\">Wedding ID</option>";
                    document.getElementById("selectAttributes2").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"GuestEmail\">Guest Email</option>" + 
                    "<option value=\"WeddingNumber\">Wedding ID</option>";
                    document.getElementById("selectAttributes3").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"GuestEmail\">Guest Email</option>" + 
                    "<option value=\"WeddingNumber\">Wedding ID</option>";
                    document.getElementById("selectAttributes4").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"GuestEmail\">Guest Email</option>" + 
                    "<option value=\"WeddingNumber\">Wedding ID</option>";
                    document.getElementById("selectCondition").innerHTML = 
                    "<option value=\"\" selected=\"selected\">none</option>" +
                    "<option value=\"GuestEmail\">Guest Email</option>" + 
                    "<option value=\"WeddingNumber\">Wedding ID</option>";
                } else if (table == "Bakes") {
                    document.getElementById("selectAttributes1").innerHTML = 
                    "<option value=\"*\" selected=\"selected\">All details</option>" +
                    "<option value=\"CatererEmail\">Caterer Email</option>" + 
                    "<option value=\"Flavour\">Flavour</option>" + 
                    "<option value=\"NumberOfTiers\">Number of Tiers</option>";
                    document.getElementById("selectAttributes2").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"CatererEmail\">Caterer Email</option>" + 
                    "<option value=\"Flavour\">Flavour</option>" + 
                    "<option value=\"NumberOfTiers\">Number of Tiers</option>";
                    document.getElementById("selectAttributes3").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"CatererEmail\">Caterer Email</option>" + 
                    "<option value=\"Flavour\">Flavour</option>" + 
                    "<option value=\"NumberOfTiers\">Number of Tiers</option>";
                    document.getElementById("selectAttributes4").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"CatererEmail\">Caterer Email</option>" + 
                    "<option value=\"Flavour\">Flavour</option>" + 
                    "<option value=\"NumberOfTiers\">Number of Tiers</option>";
                    document.getElementById("selectCondition").innerHTML = 
                    "<option value=\"\" selected=\"selected\">none</option>" +
                    "<option value=\"CatererEmail\">Caterer Email</option>" + 
                    "<option value=\"Flavour\">Flavour</option>" + 
                    "<option value=\"NumberOfTiers\">Number of Tiers</option>";
                } else if (table == "ForWho") {
                    document.getElementById("selectAttributes1").innerHTML = 
                    "<option value=\"*\" selected=\"selected\">All details</option>" +
                    "<option value=\"WeddingNumber\">Wedding Number</option>" + 
                    "<option value=\"Flavour\">Flavour</option>" + 
                    "<option value=\"NumberOfTiers\">Number of Tiers</option>";
                    document.getElementById("selectAttributes2").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"WeddingNumber\">Wedding Number</option>" + 
                    "<option value=\"Flavour\">Flavour</option>" + 
                    "<option value=\"NumberOfTiers\">Number of Tiers</option>";
                    document.getElementById("selectAttributes3").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"WeddingNumber\">Wedding Number</option>" + 
                    "<option value=\"Flavour\">Flavour</option>" + 
                    "<option value=\"NumberOfTiers\">Number of Tiers</option>";
                    document.getElementById("selectAttributes4").innerHTML = 
                    "<option value=\"\" selected=\"selected\">------</option>" +
                    "<option value=\"WeddingNumber\">Wedding Number</option>" + 
                    "<option value=\"Flavour\">Flavour</option>" + 
                    "<option value=\"NumberOfTiers\">Number of Tiers</option>";
                    document.getElementById("selectCondition").innerHTML = 
                    "<option value=\"\" selected=\"selected\">none</option>" +
                    "<option value=\"WeddingNumber\">Wedding Number</option>" + 
                    "<option value=\"Flavour\">Flavour</option>" + 
                    "<option value=\"NumberOfTiers\">Number of Tiers</option>";
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

            $result = executePlainSQL($select . $from . $where);

            printResult($result);
        }

        function sanitizeArguments() {
            $attributeStr = $_GET['selectAttributes1'];
            
            if ($_GET['selectAttributes2'] != "" && 
            $_GET['selectAttributes2'] != $_GET['selectAttributes1']) {
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