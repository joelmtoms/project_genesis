<?php
    require_once 'dbconnection.php';
    $key = 'qwerty123';

    function encryptthis($data, $key)
    {
        $encryption_key = base64_decode($key);
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }

    if(isset($_POST['submit']))
    {
        $Email = $_POST['email'];
        $encrypted1 = encryptthis($Email, $key);
        $Password = $_POST['pswd'];
        $encrypted2 = encryptthis($Password, $key);
        
        $query = "SELECT * FROM emails";
        $result = mysqli_query($conn, $query);
        
        if(mysqli_num_rows($result)==0)
        {
            $query1 = "INSERT INTO emails VALUES"."('slno','$encrypted1','$encrypted2')";
            $result1 = mysqli_query($conn, $query1);
            if(!$result1)
                die("Data insertion failed.".$conn->error);
            else{
                /*echo '<p align=center>Password has been set.</p>';
                echo '<script language="javascript">';
                echo 'alert("Password has been set")';
                echo '</script>';*/
                header("Location: set.html");
            }    
        }
        else 
        {
            $query2 = "UPDATE emails SET Email='$encrypted1' and Password='$encrypted2' WHERE slno=1";
            $result2 = mysqli_query($conn, $query2);
            if(!$result2)
                die("Password reset failed.".$conn->error);
            else{
                /*echo '<p align=center>Password has been reset.</p>';
                echo '<script language="javascript">';
                echo 'alert("Password has been reset")';
                echo '</script>';*/
                header("Location: reset.html");
            }     
        }
    }
?>