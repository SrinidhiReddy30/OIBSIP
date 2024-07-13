<?php
require 'connect.php';
$login = false;
$showError = false;
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST["lname"];
    $password = $_POST["lpwd"]; 
    $hashedLoginPassword=hash('sha256',$password);
    $sql = "Select * from users where username='$username'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1){
        while($row=mysqli_fetch_assoc($result)){
            $storedHashedPassword=$row['password'];
            //if (password_verify($password, $row['password'])){ 
                if($hashedLoginPassword === $storedHashedPassword ){
                $login = true;
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                header("location: welcome.php");
            } 
            else{
                $showError = "Invalid Credentials " . $hashedLoginPassword . "<br>" . $storedHashedPassword;
            }
        }
        
    } 
    else{
        $showError = "Invalid Credentials";
    }
}
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login_signup.css"/>
    <link rel="stylesheet" type="text/css" href="slide navbar style.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap">
</head>
<body>
    
 <h1>TodoSphere</h1>
 <div class="display_error"><?php echo $showError; ?></div>
    <div class="main">
    <div class="authen">
                <form method="post" action="/todo/login.php">
                    <label class="label">Login</label>
                    <input  type="text" name="lname" placeholder="Username" required="">
                    <input type="password" name="lpwd" placeholder="Password" required="">
                    <button  name="login">Login</button>
                    <a href="signup.php" style="margin:20px 0px 0px 120px;color:white;">Not Registered</a>
                </form>
                
            </div>
    </div>
</body>
</html>
