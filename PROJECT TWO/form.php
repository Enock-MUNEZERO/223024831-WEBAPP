<!DOCTYPE html>
<html>

<head>
    <title>Student Form</title>
    <style>
    body {
        font-family: Arial;
        background: #ddd;
        color: #2F4F4F;
    }

    .container {
        width: 700px;
        margin: auto;
        background: white;
        padding: 20px;
    }

  
    label {
        display: inline-block;
        width: 150px;
        margin-top: 10px;
        font-size: 13px;
        margin-left: 10px;
        color: #2F4F4F;
        text-transform: uppercase;
    }

    input,
    select,
    textarea {
        margin-top: 10px;
        padding: 3px;
        color: #2F4F4F;

    }

    .qual {
        width: 200px;
        margin-left: 125px;
        color: #2F4F4F;

    }


    .qual input,
    label {
        padding: 0px;
        width: 120px;
        color: #2F4F4F;

    }

    button {
        color: #2F4F4F;
    }

    p {
        color: #2F4F4F;
        margin-left: 315px;
        font-size: 12px;
        text-weight: bold;
        font-weight: bold;

    }

    table,
    th,
    td {
        border: none;
        border-collapse: collapse;
        padding: 2px;
        color: #2F4F4F;
    }

    h2 {
        margin-left: 10px;
        color: #2F4F4F;
    }
    </style>
</head>

<body>

    <div class="container">
        <h2>STUDENT REGISTRATION FORM</h2>

        <form action="insert.php" method="POST">

            <label>First Name</label>
            <input type="text" name="first_name"><br>

            <label>Last Name</label>
            <input type="text" name="last_name"><br>

            <label>date of borth</label>

            <select name="day">
                <?php for($i=1;$i<=31;$i++) echo "<option>$i</option>"; ?>
            </select>

            <select name="month">
                <?php for($i=1;$i<=12;$i++) echo "<option>$i</option>"; ?>
            </select>

            <select name="year">
                <?php for($i=1990;$i<=2025;$i++) echo "<option>$i</option>"; ?>
            </select><br>

            <label>Email id</label>
            <input type="email" name="email"><br>

            <label>Mobile number</label>
            <input type="text" name="mobile"><br>

            <label>Gender</label>
            <input type="radio" name="gender" value="Male">Male
            <input type="radio" name="gender" value="Female">Female<br>

            <label>Address</label>
            <textarea name="address"></textarea><br>

            <label>City</label>
            <input type="text" name="city"><br>

            <label>Pin code</label>
            <input type="text" name="pin_code"><br>

            <label>State</label>
            <input type="text" name="state"><br>

            <label>Country</label>
            <select name="country">
                <option>Select Country</option>
                <option>Rwanda</option>
                <option>India</option>
                <option>USA</option>
                <option>Canada</option>
                <option>Germany</option>
                <option>France</option>
                <option>Italy</option>
                <option>Japan</option>
                <option>China</option>
                <option>Brazil</option>
                <option>South Africa</option>
                <option>Australia</option>
                <option>Mexico</option>
                <option>Russia</option>
                <option>Egypt</option>
                <option>Kenya</option>
                <option>Turkey</option>
                <option>United Kingdom</option>
                <option>Spain</option>
                <option>Saudi Arabia</option>
            </select><br><br>

            <label>Hobbies</label>
            Drawing<input type="checkbox" name="hobbies[]" value="Drawing">
            Singing<input type="checkbox" name="hobbies[]" value="Singing">
            Dancing<input type="checkbox" name="hobbies[]" value="Dancind">
            Sketcking<input type="checkbox" name="hobbies[]" value="Sketching">
            Others<input type="checkbox" name="hobbies[]" value="Others">
            <input type="text" style="width:100px;padding:1px;"><br><br>


            <!-- QUALIFICATION -->
            <label>Qualification</label>
            <div class="qual">
                <table>
                    <tr> 
                        <th>SI.No.Examamination</th>
                        <th>Board</th>
                        <th>Percentage</th>
                        <th>Year of Passing</th>
                    </tr>

                    <tr>
                        <td>1&nbsp;&nbsp;&nbsp;Class X</td>
                        <td><input type="text" name="x_board"></td>
                        <td><input type="text" name="x_percent"></td>
                        <td><input type="text" name="x_year"></td>
                    </tr>

                    <tr>
                        <td>2&nbsp;&nbsp;&nbsp;Class XII</td>
                        <td><input type="text" name="xii_board"></td>
                        <td><input type="text" name="xii_percent"></td>
                        <td><input type="text" name="xii_year"></td>
                    </tr>

                    <tr>
                        <td>3&nbsp;&nbsp;&nbsp;Graduation</td>
                        <td><input type="text" name="grad_board"></td>
                        <td><input type="text" name="grad_percent"></td>
                        <td><input type="text" name="grad_year"></td>
                    </tr>

                    <tr>
                        <td>4&nbsp;&nbsp;&nbsp;Masters</td>
                        <td><input type="text" name="masters_board"></td>
                        <td><input type="text" name="masters_percent"></td>
                        <td><input type="text" name="masters_year"></td>
                    </tr>

                </table>

            </div>

            <p>(10 char max)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(up to 2 decimal)</p>

            <label>Courses applied for</label>
            BCA<input type="radio" name="course" value="BCA">
            B.Com<input type="radio" name="course" value="BCom">
            B.Sc<input type="radio" name="course" value="B.Sc">
            BA<input type="radio" name="course" value="BA"><br><br>
            <center><button type="submit">Submit</button>
                <button type="Reset">Reset</button>
                <center><br>

        </form>
    </div>
</body>

</html>