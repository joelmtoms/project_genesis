<?php
    require_once 'dbconnection.php';
    $key = 'qwerty123';

    function decryptthis($data, $key)
    {
        $encryption_key = base64_decode($key);
        list($encrypted_data, $iv) = array_pad(explode('::', base64_decode($data),2),2,null);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
    }

    if(isset($_POST['submit']))
    {
        $Email = $_POST['email'];
        $Password = $_POST['pswd'];

        $query1 = "select * from emails";
        $result1 = mysqli_query($conn, $query1);
        if(!$result1)
            die("Database access failed.".$conn->error);
            
        $rows = mysqli_fetch_assoc($result1);
        
        $mail = $rows['Email'];
        $decrypted1 = decryptthis($mail, $key);
        echo $decrypted1;
        $pass = $rows['Password'];
        $decrypted2 = decryptthis($pass, $key);
        
        
        if($decrypted1==$Email && $decrypted2==$Password)
        {
            header("Location: welcome.html");
        }    
        else
        {
            //echo "Your email doesn't exist in our database.".$conn->error;
            echo '<script language="javascript">alert("Your email does not exist in our database.")</script>';
            header("Location: loginpage1.html");
        }        
    }
?>