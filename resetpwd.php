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
        $Code = $_POST['code'];

        $query2="SELECT * FROM adminpwd"; 
        $result=mysqli_query($conn, $query2);
        if(!$result)
            die("Database access failed.".$conn->error);
            
        $rows = mysqli_fetch_assoc($result);
        
        $code = $rows['Code'];
        $decrypted = decryptthis($code, $key);
        
        if($decrypted==$Code)
        {
            /*echo "<font size='5'><p>Verification Successful.</p>";
            echo "<p>You can now <a href='Login_Reset.html'>Create a New Password</a>.</p></font>";*/
            //alert("Verification Successful");
            header("Location: Login_Reset.html");
            
        }
        else
        {
            //echo "<font size='5'><p align=center>We could not recognize the security code given. <a href='Reset_Pwd.html'>Please try again</a>.</p>";
            //echo "<p>If the problem persist, check if you <a href='Register.html'>registered</a> yourself to avail reset password.</p></font>";
            header("Location: vererror.html");
        }     
    }
?>