<?php
// Include config file
require "conn.php";
// Define variables and initialize with empty values
$username = $password = $confirm_password = $email = "";
$username_err = $password_err = $confirm_password_err = $email_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else
	{
        // Prepare a select statement
        $sql = "SELECT username FROM user_login_test WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql))
		{
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
			{
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1)
				{
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"])))
	{
        $password_err = "Please enter a password.";     
    } 
	elseif(strlen(trim($_POST["password"])) < 6)
	{
        $password_err = "Password must have atleast 6 characters.";
    } 
	else
	{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    //Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT username FROM user_login_test WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
			{
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO user_login_test (username, password, email, table_name, bill_table, goal_table) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            
            
            // Set parameters
            $param_username = $username;
            $param_password = hash('sha256', $password);// Creates a password hash
            //echo $email;
            $param_email = $email;
			$table_name = $username."_table";
            $tablenm = $username."_bills"; //setting the table_name
            $goal_table = $username."_goals";
            $param_table_name = $table_name;
            $param_bill_name = $tablenm;
            $param_goal_table = $goal_table;
			mysqli_stmt_bind_param($stmt, "ssssss",$param_username, $param_password, $param_email, $param_table_name, $param_bill_name, $param_goal_table);
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
			{
                $userAdd = "insert into user_master values('".$username."')";
				if ($link->query($userAdd) == TRUE)
				{
					$createUserTable = "create table ".$table_name." (id varchar(64) primary key,amount int(10), purpose varchar(25), date varchar(15), time varchar(15))";

                    $createUserTable1 = "create table ".$tablenm." (category varchar(40) DEFAULT NULL,amount float(15,2) DEFAULT NULL,date_of_bill varchar(10) DEFAULT NULL)";

                    $createUserTable2 = "create table ".$goal_table." (category varchar(40) DEFAULT NULL,note varchar(15) DEFAULT NULL, amount float(10,2) DEFAULT NULL)";
					if ($link->query($createUserTable) == TRUE)
					{
						if ($link->query($createUserTable1) == TRUE)
                        {
                            if ($link->query($createUserTable2) == TRUE) 
                            {
                                header("location: login.php");
                            }
                            else
                            {
                                echo "something went wrong in creating goals table";       
                            }
                        }
                        else
                        {
                            echo "something went wrong in creating bills table";
                        }
					}
					else
					{
						echo "something went wrong in adding the user in user_name table";
					}
					
				}
				else
				{
					echo "something went wrong in adding the user in user_master table";
				}
            } 
			else
			{
                echo "Something went wrong. Please try again later.";
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
    <title>Sign Up</title>
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
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
			<div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>
			
			
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>
	</center>    
</body>
</html>