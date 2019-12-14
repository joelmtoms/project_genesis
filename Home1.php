<html>
    <head>
        <title>Home</title>
    </head>
    <style>
        body{
            background-image:url("logo.jpg");
            background-size: cover;
        }
        div{
            position: relative;
            padding-left:200px;
            padding-top: 130px;
            color:white;
        }
        p{
            font-size: 20px;
        }
        a{
            color: red;
        }
    </style>
    <body>
        <div>
            <img src="redhatlogo.png" style="width:100px; height: 100px;">
            <span style="font-size: 80px;">R3DHATS</span>
            <?php
                require_once 'dbconnection.php';
                session_start();

                echo "<p>RECORDS ADDED SUCCESSFULLY</p>";
                echo "<p>First Name: ".$_SESSION["fname"]."</p>";
                echo "<p>Last Name: ".$_SESSION["lname"]."</p>";
                echo "<p>Email: ".$_SESSION["email"]."</p>";
                echo "<p>DOB: ".$_SESSION["dob"]."</p>";
                echo "<p>Designation: ".$_SESSION["desig"]."</p>";
                echo "<p>Years of Service: ".$_SESSION["yos"]."</p><br>";
                echo "<p>Please note down this security code for future references:   ".$_SESSION["code"]."</p>";
            ?>
            <a HREF=javascript:window.print() onclick="document.title=''; window.print(); return false;">Click Here to Print</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="Login_Reset.html">Click to Proceed</a>
        </div>
    </body>
</html>