<?php
    require_once 'dbconnection.php';
    $key = 'qwerty123';
    session_start();

    function encryptthis($data, $key)
    {
        $encryption_key = base64_decode($key); //base64_decode is a local decoder
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc')); //openssl_random_pseudo_bytes is an inbuilt function which provides a random string, 
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv); //iv is initialization vector which adds more randomness to the string so that 2 strings 
        return base64_encode($encrypted . '::' . $iv); //are not a duplicate of each other, openssl_encrypt is an inbuilt function which encrypts the data, aes-256-cbc is a                                                    non crackable encryption
    }

    function decryptthis($data, $key)
    {
        $encryption_key = base64_decode($key);
        list($encrypted_data, $iv) = array_pad(explode('::', base64_decode($data),2),2,null);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
    }

    if(isset($_POST['submit']))
    {
        $FirstName = $_POST['fname'];
        $_SESSION["fname"] = $FirstName;
        $encrypted1 = encryptthis($FirstName, $key);
        $LastName = $_POST['lname'];
        $_SESSION["lname"] = $LastName;
        $encrypted2 = encryptthis($LastName, $key);
        $DOB = $_POST['dob'];
        $_SESSION["dob"] = $DOB;
        $encrypted3 = encryptthis($DOB, $key);
        $Email = $_POST['email'];
        $_SESSION["email"] = $Email;
        $encrypted4 = encryptthis($Email, $key);
        $Designation = $_POST['desig'];
        $_SESSION["desig"] = $Designation;
        $encrypted5 = encryptthis($Designation, $key);
        $YOS = $_POST['yos'];
        $_SESSION["yos"] = $YOS;
        $encrypted6 = encryptthis($YOS, $key);
        
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
        $Code = substr(str_shuffle($chars), 0, 8);
        $_SESSION["code"] = $Code;
        $encrypted7 = encryptthis($Code, $key);
        
        $query = "SELECT * FROM adminpwd WHERE Flag=1";
        $result=mysqli_query($conn,$query);
        if(mysqli_num_rows($result)==0)
        {
            $Flag = "1";
            $query1 = "INSERT INTO adminpwd VALUES ('slno','$encrypted1','$encrypted2','$encrypted3','$encrypted4','$encrypted5','$encrypted6','$encrypted7','$Flag')";
            $result1 = mysqli_query($conn,$query1);
            if(!$result1)
                die("Data insertion failed.".$conn->error);
            else
                header("Location: Home1.php");  
        }            
        else
        {
            $query2="SELECT * FROM adminpwd"; 
            $result2=mysqli_query($conn, $query2);
            if(!$result2)
                die("Database access failed.".$conn->error);
            
            $rows = mysqli_fetch_assoc($result2);
            
            $fname = $rows['FirstName'];
            $decrypted1 = decryptthis($fname, $key);
            $lname = $rows['LastName'];
            $decrypted2 = decryptthis($lname, $key);
            $dob = $rows['DOB'];
            $decrypted3 = decryptthis($dob, $key);
            $email = $rows['Email'];
            $decrypted4 = decryptthis($email, $key);
            $desig = $rows['Designation'];
            $decrypted5 = decryptthis($desig, $key);
            $yos = $rows['YOS'];
            $decrypted6 = decryptthis($yos, $key);
            
            if($decrypted1==$FirstName && $decrypted2==$LastName && $decrypted3==$DOB && $decrypted4==$Email && $decrypted5==$Designation && $decrypted6==$YOS)
            {
                header("Location: vercode.html");
            }
            else
            {
                header("Location: verfail.html");
            }
        }
    }
?>