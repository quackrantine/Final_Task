<?php
session_start();

if(isset($_SESSION["email"])){
    header("Location: home.php");
    exit();
}

include "db.php";

$email = "";
$login_err = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = trim($_POST['em-auth']);
    $password = $_POST['pass-auth'];

    if(empty($email) || empty($password)){
        $login_err = "Email and Password are required.";
    } else {
        $dbConnection = getDBConnection();

        $stmt = $dbConnection->prepare(
            "SELECT id, first_name, last_name, email, phone, password, created_at FROM users WHERE email = ?"
        );

         if ($stmt) {
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->store_result();

            if($stmt->num_rows == 1){
                $stmt->bind_result($id, $first_name, $last_name, $db_email, $phone, $stored_hashed_password, $created_at);

                if($stmt->fetch()){
                    if(password_verify($password, $stored_hashed_password)){
                        session_regenerate_id();

                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["first_name"] = $first_name;
                        $_SESSION["last_name"] = $last_name;
                        $_SESSION["email"] = $db_email;
                        $_SESSION["phone"] = $phone;
                        $_SESSION["created_at"] = $created_at;

                        header("Location: home.php");
                        exit();
                    } else{
                        $login_err = "Invalid email or password.";
                    }
                }
            } else{
                $login_err = "Invalid email or password.";
            }
             $stmt->close();
         } else {
             die("Database prepare statement failed: " . $dbConnection->error);
         }
          $dbConnection->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Quack's Blackmarket</title>
    <style>
        body { font-family: sans-serif; margin: 0; padding: 0; display: flex; flex-direction: column; min-height: 100vh; background-color: #f4f4f4; }
        header { background-color: #c22525; color: #ffffff; padding: 10px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; }
        .logo { width: 200px; height: auto; border-radius: 5px; margin-right: 10px; display: block; margin-left: 10px; }
        header a { text-decoration: none; display: inline-block; }
        nav ul { list-style: none; margin: 0; padding: 0; display: flex; flex-wrap: wrap; }
        nav li { margin-right: 15px; }
        nav a { color: #ffffff; text-decoration: none; }
        .container { flex: 1; padding: 20px; max-width: 500px; margin: 20px auto; background-color: #fff; border: 1px solid #ddd; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        footer { background-color: #c22525; color: #ffffff; padding: 10px; text-align: center; margin-top: auto; }
        .button-group { display: flex; align-items: center; flex-wrap: wrap; }
        .button-group a { color: #ffffff; text-decoration: none; padding: 8px 12px; border-radius: 15px; background-color: #b40f0f; border: none; transition: background-color 0.3s ease; margin-left: 5px; font-size: 0.9em; margin-bottom: 5px; /* Added for wrapping */}
        .button-group a:hover { background-color: #a01d1d; }

        .form-container h2 { text-align: center; color: #333; }
        .form-container form { display: flex; flex-direction: column; gap: 15px; }
        .form-container label { margin-bottom: -10px; font-weight: bold; color: #555; }
        .form-container input[type="email"],
        .form-container input[type="password"] { padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1em; }
        .form-container button[type="submit"],
        .form-container .form-button { padding: 10px 15px; border: none; border-radius: 4px; background-color: #c22525; color: white; font-size: 1em; cursor: pointer; transition: background-color 0.3s; text-align: center; text-decoration: none; display: inline-block;}
         .form-container .form-button { background-color: #555; margin-top: 5px;}
        .form-container button[type="submit"]:hover,
        .form-container .form-button:hover { background-color: #a01d1d; }
         .form-container .form-button:hover { background-color: #333; }
        .text-danger { color: red; font-size: 0.9em; margin-top: 5px; display: block; text-align: center; background-color: #ffe6e6; border: 1px solid #ffb3b3; padding: 10px; border-radius: 4px; }

         @media (max-width: 480px) {
             header { flex-direction: column; align-items: center;}
             .button-group { width: 100%; justify-content: space-around; margin-top: 10px;}
             nav { margin-top: 10px; width: 100%;}
             nav ul { justify-content: center;}
             .container { padding: 10px; margin: 10px auto;}
         }
    </style>
</head>
<body>

    <header>
        <a href="home.php"><img class="logo" src="wmremove-transformed.png" alt="Quack's Blackmarket Logo"></a>
        <nav>
             <ul>
                 <li><a href="home.php">Home</a></li>
             </ul>
         </nav>
        <div class="button-group">
             <a href="login.php">Login</a>
             <a href="register.php">Register</a>
        </div>
    </header>

    <div class="container form-container">
        <h2>Login</h2>

        <?php if(!empty($login_err)): ?>
            <div class="text-danger"><?php echo htmlspecialchars($login_err); ?></div>
        <?php endif; ?>

        <form method="post" action="login.php" id="loginForm">
            <label for="em-auth">Email Address:</label>
            <input type="email" id="em-auth" name="em-auth" value="<?php echo htmlspecialchars($email); ?>" required>

            <label for="pass-auth">Password:</label>
            <input type="password" id="pass-auth" name="pass-auth" required>

            <button type="submit">Log In</button>
             <a href="register.php" class="form-button">Need an account? Register</a>
        </form>
    </div>

    <footer>
        <p>Gonzales, Carlo R. BSIT - 2E</p>
    </footer>

</body>
</html>