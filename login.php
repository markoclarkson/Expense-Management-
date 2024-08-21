<?php

session_start();
 

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: home.html");
  exit;
}
 

require "conn.php";//changed to use dynamic db
$link -> select_db("ad");
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Check if username is empty
    if(empty(trim($_POST["username"])))
	{
        $username_err = "Please enter username.";
    } else
	{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"])))
	{
        $password_err = "Please enter your password.";
    } 
	else
	{
        $password = trim($_POST["password"]);
		$password = hash('sha256', $password);
    }
	
	$userExists = "select COUNT(*) from user_master where username = '".$username."'";
	
        if ($link->query($userExists) == TRUE) 
		{
			$data = $link->query($userExists);
			$value = mysqli_fetch_assoc($data);
			$value = $value['COUNT(*)'];
			if($value == 0)
			{
				$username_err="user doest not exists";
			}
			
		}
    
    // Validate credentials
    if(empty($username_err) && empty($password_err))
	{

		
        $sql = "SELECT  username, password, table_name FROM user_login_test WHERE username = ?";//select query for sql password verification
        
        if($stmt = mysqli_prepare($link, $sql))
		{
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
			{
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1)
				{       
                    // Bind result variables
					//add hashing function here
                    mysqli_stmt_bind_result($stmt, $username, $saved_password, $table_name);
                    
                    if(mysqli_stmt_fetch($stmt))
					{
                        if($password ==  $saved_password)//removed password_verify 
						{
                            // Password is correct, so start a new session
                            session_start();
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;                           
                            $_SESSION["username"] = $username;                            
                            $_SESSION["table_name"] = $table_name;
                            // Redirect user to welcome page
                            header("location: home.html");//add the next page here
                        } 
						else
						{
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } 
            } 
			else
			{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }

        @import url('https://fonts.googleapis.com/css2?family=Hammersmith+One&display=swap');
*{
    margin: 0;
    padding: 0;
    font-family: 'Hammersmith One', sans-serif;
    box-sizing: border-box;
}
body{
    height: 100vh;
    background: #594F4F;
    background: -moz-linear-gradient(-45deg, #1d4946  10%, #594F4F 100%);
    background: -webkit-linear-gradient(-45deg, #1d4946  10%, #594F4F    100%);
    background: linear-gradient(200deg, #1d4946  10%, #594F4F 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1d4946 ', endColorstr='594F4F   ', GradientType=1 );
}
.login-page{
    background: rgb(235, 235, 235);
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    color: #292929;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    transition: all .4s;
}
.login-page:hover{
    box-shadow: 0 0 50px rgba(0, 0, 0, 0.300);
}
.login-page h1{
    margin-bottom: 30px;
}
.login-page form{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
.login-page form input  {
    width: 250px;
    height: 35px;
    margin: 8px;
    background: rgb(218, 218, 218);
    border: none;
    padding-left: 10px;
    outline: none;
    transition: all .4s;
}
.login-page form input:focus{
    background: rgb(194, 194, 194);
}
.login-page form .btn{
    width: 250px;
    height: 35px;
    margin: 8px;
    background: #db02b0cc;
    color: #e2e2e2;
    border: none;
    outline: none;
    cursor: pointer;
    transition: all .4s;
}
.login-page form .btn:hover{
    background: #db02b08f;
}

.button {
    text-decoration: none;
    color: white;
    display: inline-flex;
    font-size: 140%;
    padding: 1%;
    margin-top: auto;
    margin-bottom: auto;
    margin-right: auto;
    margin-left: 2%;
}

.button:hover {
    background-color: white;
    color: black;
    text-decoration: none;
}
li {
    display: inline-flex;
    width: 100%;
}
    </style>
</head>
<body>
    <li><a type="button" class="button" href="home.html">Home</a></li>
<center>
    <div class="wrapper login-page">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account ? <a href="register.php">Sign up now</a>.</p>
            <p>Forgot Password ? <a href="reset-password.php">Reset Here</a>
        </form>
    </div>    
</center>
</body>
</html>
 
