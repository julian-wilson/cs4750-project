<?php

/** DATABASE SETUP **/
require('connect-db.php');
global $db; 

$error_msg = "";

// logout component
session_start();
session_destroy();

// Join the session or start a new one
session_start();

/** VALIDATE USER **/
if (isset($_POST["username"])) { 
    $username = $_POST["username"];
    $query = "select * from users where username = :username";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':username', $username);

    if (!$stmt->execute()) {
        $error_msg = "Error checking for user";
    } else { 
        // result succeeded
        $data = $stmt->fetch();
            
        if (!empty($data)) { 
            // user was found! validate the user's password
            //if (password_verify($_POST["password"], $data[0]["password"])) {
            if ($_POST["password"] == $data["password"]) {
                // Save user information into the session to use later
                $_SESSION["username"] = $data["username"];

                // redirect to main
                header("Location: main.php");
                exit();

            } else {
                // User was found, but entered an invalid password
                $error_msg = "Invalid Password";
            }
        } else {
            // user was not found, create an account
        
            $username = $_POST["username"];
            $name = $_POST["name"];
            $password = $_POST["password"];

            $query = "insert into users (name, username, password) values('" . $name . "', '" . $username . "', '" . $password . "')";

            $insert = $db->query($query);

            if(!$insert){                
                $error_msg = "Error creating new user!";
            }
                
            // Save user information into the session to use later
            $_SESSION["username"] = $_POST["username"];

            // redirect to main
            header("Location: main.php");
            exit();
        }
    }
}

?>

<!doctype html>

<html lang="en">
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="page for login/signup">  
    <title>Login/Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"> 
    <!-- <link rel="stylesheet" href="styles/main.css"> -->
</head>
<body>

    <!---- LOGIN CONTAINER ---->
    <div class="container" style="margin-top: 15px;">
        <div class="row d-flex justify-content-center">
            <div class="col-4 login-box">
                <p> To get started, login below or enter a new name, username, and password to create an account.</p>
                <hr style='margin-top:20px;'>
                <?php
                    if (!empty($error_msg)) {
                        echo "<div class='alert alert-danger'>$error_msg</div>";
                    }
                ?>
                <p class="alert-danger" id="error_message"></p>
                <?php if(isset($redirect)): ?>
                <form action="index.php?location=<?php echo $redirect ?>" method="post">
                <?php else: ?>
                <form action="index.php" method="post">
                <?php endif ?>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required/>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required/>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required/>
                        <div id="password_message" class="form-text"></div>
                    </div>
                    <div class="text-center">                
                        <button type="submit" class="btn btn-primary" id="submit">Log in / Create Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        
    // check if entered password is long enough
    var passwordCheck = (num) => {
        var pw = document.getElementById("password");
        var password_message = document.getElementById("password_message");
        var submit = document.getElementById("submit");
            
        if (pw.value.length < num) {
            password_message.textContent = "Password must be " + num + " characters or longer";
            pw.classList.add("is-invalid");
            submit.disabled = true;
        } else {
            password_message.textContent = "";
            pw.classList.remove("is-invalid");
            submit.disabled = false;
        }
    }
        
    // event listener for password input
    document.getElementById("password").addEventListener("keyup", function() {
        passwordCheck(5); 
    });

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>
</html>