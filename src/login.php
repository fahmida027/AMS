<?php

require_once "config.php";

$username = $email = $password = "";
$email_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email address.";
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($email_err) && empty($password_err)) {
        $sql = "SELECT userID, email, password FROM user WHERE email = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {

            mysqli_stmt_bind_param($stmt, "s", $param_email);
            $param_email = $email;
            
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);

                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["userID"] = $id;
                            $_SESSION["email"] = $email;
                            header("location: home.php");
                            exit();
                        } else {
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    $email_err = "No account found with that email.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
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
.btn:hover{
    background: #423a9e;
}

.form-group{
    color:black;
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
.nav-item a .nav-link active {
        background-color: #695cfe;
}
.nav-item:nth-child(2) .nav-link {
    background-color: #695cfe;
}
 </style>   
<body>

        <div class="hero"></div>
        <div class="container dfg">
            <ul class="nav nav-pills nav-justified " role="tablist">
                <li class="nav-item"><a href="register.php" class="nav-link " >Register</a></li>
                <li class="nav-item"><a href="#" class="nav-link active login" data-toggle="pill">Login</a></li>
            </ul>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : '' ;?>">
                <label for="email" style="color: #565656;"><i class='bx bxs-envelope' style="color: #565656;"></i> Email</label>
 
                    <input type="email" name="email" class="form-control" placeholder="Enter email" autofill="off">
                    <span class ="help-block">  <?php echo $email_err ;?> </span>
                </div>

                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : '' ;?>"> 
                    <label for="password" style="color: #565656;"><i class='bx bxs-lock-alt' style="color: #565656;"></i> Password</label>
                    <input type="password"  name="password" class="form-control" placeholder="Enter password" autofill="off">
                    <span class ="help-block">  <?php echo $password_err ;?> </span>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary" value="Login">Log in</button>
                </div>
            </form>

            <p style="color: #565656;"> Don't have an account? <a href="register.php" class="login-link">Sign Up</a></p>
        </div>   

</body>
</html>
