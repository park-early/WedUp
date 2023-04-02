<html>
    <head>
        <title>WedUP</title>
        <link rel="stylesheet" href="style.php">
    </head>
    <body>
        <a href="main_page.php" class="side-button">Main Menu</a>
        <form action="add_wedding.php">
            <h2>Wedding Information</h2>
            <label for="date">Wedding date:</label>
            <input type="date" id="wedding" name="wedding" required></p>
            <label for="venue">Wedding venue:</label>
            <select id="venue" name="venue" required>
                <option value="The Orpheum">The Orpheum</option>
                <option value="UBC Rose Garden">UBC Rose Garden</option>
                <option value="VanDusen Botanical Garden">VanDusen Botanical Garden</option>
                <option value="Vancouver Aquarium">Vancouver Aquarium</option>
                <option value="Fairmont Banff Springs">Fairmont Banff Springs</option>
            </select>
            <hr>
            <h2>Bride Information</h2>
            <label for="bridefname">First name:</label>
            <input type="text" id="bridefname" name="bridefname" required>
            <label for="bridelname">Last name:</label>
            <input type="text" id="bridelname" name="bridelname" required></p>
            <label for="brideemail">Email:</label>
            <input type="email" id="brideemail" name="brideemail" required>
            <label for="bouquet">Bouquet style:</label>
            <select id="bouquet" name="bouquet">
                <option value="None">None</option>
                <option value="cascade">Cascade</option>
                <option value="posy">Posy</option>
                <option value="hand-tied">Hand-tied</option>
                <option value="round">Round</option>
                <option value="pomander">Pomander</option>
                <option value="composite">Composite</option>
                <option value="nosegay">Nosegay</option>
            </select>
            <hr>
            <h2>Groom Information</h2>
            <label for="groomfname">First name:</label>
            <input type="text" id="groomfname" name="groomfname" required>
            <label for="groomlname">Last name:</label>
            <input type="text" id="groomlname" name="groomlname" required></p>
            <label for="groomemail">Email:</label>
            <input type="email" id="groomemail" name="groomemail" required>
            <hr>
            <h2>Officiant Information</h2>
            <label for="officiantfname">First name:</label>
            <input type="text" id="officiantfname" name="officiantfname" required>
            <label for="officiantlname">Last name:</label>
            <input type="text" id="officiantlname" name="officiantlname" required></p>
            <label for="officiantemail">Email:</label>
            <input type="email" id="officiantemail" name="officiantmail" required>
            <label for="company">Company:</label>
            <select id="company" name="company">
                <option value="Casablanca Co.">Casablanca Co.</option>
                <option value="Titanic Studio">Titanic Studio</option>
                <option value="La La Land Ltd.">La La Land Ltd.</option>
                <option value="Paramount">Paramount</option>
                <option value="Forrest Gump and Co.">Forrest Gump and Co.</option>
                <option value="Up Services">LUp Services</option>
            </select>
            <label for="priest">Priest:</label>
            <select id="priest" name="priest">
                <option value="---">---</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
            <hr>
            <input type="submit" value="Submit" name="insertSubmit"></p>
        </form>
    </body>
</html>