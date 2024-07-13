<?php 
require 'connect.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>SignIn</title>
    <link rel="stylesheet" href="login_signup.css"/>
    <link rel="stylesheet" type="text/css" href="slide navbar style.css">
<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <?php 
    $username = $password = $confirm_password = "";
    $username_err = $password_err = $confirm_password_err = "";
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        if(isset($_POST["signup"]))
        {
            // Check if username is empty
            if(empty(trim($_POST["sname"])))
            {
                $username_err = "Username cannot be blank";
            }
            else
            {
                $sql = "SELECT session_id FROM users WHERE username = ?";
                $stmt = mysqli_prepare($conn, $sql);
                if($stmt)
                {
                    mysqli_stmt_bind_param($stmt, "s", $param_username);

                    // Set the value of param username
                    $param_username = trim($_POST['sname']);

                    // Try to execute this statement
                    if(mysqli_stmt_execute($stmt))
                    {
                        mysqli_stmt_store_result($stmt);
                        if(mysqli_stmt_num_rows($stmt) == 1)
                        {
                            $username_err = "This username is already taken . Please enter another name"; 
                        }
                        else
                        {
                                $username = trim($_POST['sname']);
                        }
                    }
                        else
                        {
                            echo "Something went wrong";
                        }
                }
           }
        
        mysqli_stmt_close($stmt);

        // Check for password
        if(empty(trim($_POST['spwd'])))
        {
            $password_err = "Password cannot be blank";
        }
        elseif(strlen(trim($_POST['spwd'])) < 5)
        {
            $password_err = "Password cannot be less than 5 characters";
        }
        else if(strlen(trim($_POST['spwd'])) >10 )
        {
            $password_err = "Password cannot be more than 10 characters";
        }
        else
        {
            $password = trim($_POST['spwd']);
        }

        // Check for confirm password field
        if(trim($_POST['spwd']) !=  trim($_POST['rpwd']))
        {
            $password_err = "Passwords didn't match";
        }


        // If there were no errors, go ahead and insert into the database
        if(empty($username_err) && empty($password_err) && empty($confirm_password_err))
        {
            $sql = "INSERT INTO users (session_id,username,password,date_time) VALUES (?,?,?,?)";
            $stmt = mysqli_prepare($conn, $sql);
            if ($stmt)
            {
                $random_number=uniqid() . mt_rand(1,9999999);
                date_default_timezone_set('Asia/Kolkata');
                $date=date("Y-m-d H:i:s");
                mysqli_stmt_bind_param($stmt, "ssss",$param_session,$param_username,$param_password,$param_date);
                // Set these parameters
                $param_session= $random_number;
                $param_username = $username;
                $param_password = hash('sha256',$password);
                $param_date=$date;
                // Try to execute the query
                if (mysqli_stmt_execute($stmt))
                {
                    header("location: login.php");
                }
                else
                {
                    echo "Something went wrong... cannot redirect!";
                }
            }
            mysqli_stmt_close($stmt);
        }
            mysqli_close($conn);
        }
    }
    ?>
    <h1>TodoSphere</h1>
    <div class="display_error"><?php echo  $username_err . "<br>" . $password_err ."<br>" . $confirm_password_err ?></div>
    <div class="main">      
            <div class="authen">
                <form method="post" action="/todo/signup.php">
                    <!-- <label for="chk" >Sign up</label> -->
                    <h2 style="margin:10px 0px 20px 120px;font-size:30px;color:white;">Sign Up</h2>
                    <input type="text" name="sname" placeholder="User name" required="">
                    <input type="password" name="spwd" placeholder="Password" required="">
                    <input type="password" name="rpwd" placeholder="Re-enter Password" required="">
                    <button name="signup">Sign up</button>
                </form>
                <a href="login.php" style="margin:40px 0px 0px 120px;color:white;">Already a user?</a>
            </div>
</div>
            
   </body>
</html>
