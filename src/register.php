<?php

require_once "config.php";

$username = $email = $password = "";
$username_err = $email_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a name.";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email address.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email address.";
   } 
  else {
       
      $sql = "SELECT userID FROM user WHERE email = ?";
       if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_email);

          $param_email = trim($_POST["email"]);
            if (mysqli_stmt_execute($stmt)) {
               mysqli_stmt_store_result($stmt);
               if (mysqli_stmt_num_rows($stmt) == 1) {
                   $email_err = "This email is already taken.";
               } else {
                    $email = trim($_POST["email"]);
               }
           } else {
               echo "Oops! Something went wrong. Please try again later.";
           }
            mysqli_stmt_close($stmt);
       }
   }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 8) {
        $password_err = "Password must have at least 8 characters.";
    } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $_POST["password"])) {
        $password_err = "Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character.";
    } else {
        $password = trim($_POST["password"]);
    }


    if (empty($username_err) && empty($email_err) && empty($password_err)) {
        $sql = "INSERT INTO user (name, email, password) VALUES (?, ?, ?)";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_email, $param_password);
            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            if (mysqli_stmt_execute($stmt)) {
                header("location: login.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($conn);
}

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup and signin</title>
    <link rel="stylesheet" href="loginreg.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<style>
    
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap");
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}
    
body{
    background-image: url("background.jpg");
    position: relative;
    min-height: 100vh;
    background-size: cover;
    background-position: center;
    display: flex;
    justify-content: space-between;
    align-items: center;

}

.hero::after{
background-color:  #e4e9f7;
content: "";
display: block;
position:absolute;
background-size: cover;
top: 0px;
left: 0px;
width: 100%;
height: 100%;
z-index: -1;
opacity: 0.75;
}

.dfg{
    background: #f5f4fb;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    border-radius: 15px;
    backdrop-filter: blur(30px);
    color: black;
    width: 40%;
    height : 30%;
    padding: 20px; /* Added padding */
}
.form-control{
    border: none;
    background: transparent;
    border-bottom: 1px solid black;
}
.container .dfg p a {
    color:black;
    font-weight: 500;
    text-decoration: none;

}

.btn{
    margin-top: 10px;
    width: 100%;
    height: 45px;
    background: #695cfe;
    border:none;
    outline: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 500;
    color: whitesmoke;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    text-align: center; /* Center text */
}
.form-group{
    color:black;
}
.form-group label{
    margin-top: 10px;
}
.form-group input[type="email"],
.form-group input[type="password"] {
    margin-top: 5px; /* Adjust margin top for the input field */
    margin-bottom: 10px;
}
::placeholder{
    color: white;
    opacity: 0.4;
}

.nav-item:nth-child(1) .nav-link {
    background-color: #695cfe;
}
 </style>   
<body>

        <div class="hero"></div>
        <div class="container dfg">
            <ul class="nav nav-pills nav-justified " role="tablist">
                <li class="nav-item"><a href="#" class="nav-link active" data-toggle="pill">Register</a></li>
                <li class="nav-item"><a href="login.php" class="nav-link" >Login</a></li>
            </ul>

            
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="user">

                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : '' ;?>" > 
                <label for="name" style="color: #565656;"><i class='bx bxs-user' style="color: #565656;"></i> Name</label>   
                    <input type="text"  name="username" class="form-control" placeholder="Enter name" autofill="off">
                   <span class ="help-block">  <?php echo $username_err ;?> </span>
                </div>

                <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : '' ;?>">
                <label for="email" style="color: #565656;"><i class='bx bxs-envelope' style="color: #565656;"></i> Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter email" autofill="off">
                    <span class ="help-block">  <?php echo $email_err ;?> </span>
                </div>

                <div class="form-group  <?php echo (!empty($password_err)) ? 'has-error' : '' ;?>"> 
                    <label for="password" style="color: #565656;"><i class='bx bxs-lock-alt' style="color: #565656;"></i> Password</label>
                    <input type="password"  name="password" class="form-control" placeholder="Enter password" autofill="off">
                </div>

                <div class="form-group">
                        <button type="submit" class="btn btn-primary" value="Login" name="submit">Sign Up</button>
                </div>
                    <p>Already have an account?<a href="login.php" class="login-link">Log In</a>
                    </p>
                </div>   
            </form>
</body>
</html>
