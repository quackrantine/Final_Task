<?php
session_start();

if (isset($_SESSION["email"])) {
    header("Location: home.php");
    exit();
}

include "db.php";

$first_name = "";
$last_name = "";
$email = "";
$phone = "";
$address = "";

$fname_err = "";
$lname_err = "";
$email_err = "";
$pass_err = "";
$cpass_err = "";

$success_msg = "";
$error = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = trim($_POST['fname']);
    $last_name = trim($_POST['Lname']);
    $email = trim($_POST['em']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $password = $_POST['pass'];
    $confirmed_pass = $_POST['Cpass'];

    if (empty($first_name)) {
        $fname_err = "First Name is required.";
        $error = true;
    }
    if (empty($last_name)) {
        $lname_err = "Last Name is required.";
        $error = true;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Email format invalid.";
        $error = true;
    } else {
        $dbConnection = getDBConnection();
        $stmt = $dbConnection->prepare("SELECT id FROM users WHERE email = ?");
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $email_err = "Email already registered.";
                $error = true;
            }
            $stmt->close();
        } else {
            die("Database prepare statement failed: " . $dbConnection->error);
        }
        $dbConnection->close();
    }

    if (empty($password)) {
        $pass_err = "Password is required.";
        $error = true;
    } elseif (strlen($password) < 8) {
        $pass_err = "Password must be at least 8 characters long.";
        $error = true;
    }

    if (empty($confirmed_pass)) {
        $cpass_err = "Please confirm password.";
        $error = true;
    } elseif ($confirmed_pass !== $password) {
        $cpass_err = "Passwords do not match.";
        $error = true;
    }

    if (!$error) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $created_at = date('Y-m-d H:i:s');
        $default_role = "user"; // 👈 Add default role here

        $dbConnection = getDBConnection();

        $stmt = $dbConnection->prepare(
            "INSERT INTO users (first_name, last_name, email, phone, address, password, created_at, role)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );

        if ($stmt) {
            $stmt->bind_param(
                'ssssssss',
                $first_name,
                $last_name,
                $email,
                $phone,
                $address,
                $hashed_password,
                $created_at,
                $default_role
            );

            if ($stmt->execute()) {
                $success_msg = "Registration successful! You can now log in.";
                $first_name = $last_name = $email = $phone = $address = "";
            } else {
                echo "<div style='color: red; text-align: center; padding: 10px;'>Error executing statement: " . $stmt->error . "</div>";
            }
            $stmt->close();
        } else {
            echo "<div style='color: red; text-align: center; padding: 10px;'>Error preparing statement: " . $dbConnection->error . "</div>";
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
    <title>Register - Quack's Blackmarket</title>
    <style>
        body { font-family: sans-serif; margin: 0; padding: 0; display: flex; flex-direction: column; min-height: 100vh; background-color: #f4f4f4; }
        header { background-color: #c22525; color: #ffffff; padding: 10px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; }
        .logo { width: 200px; height: auto; border-radius: 5px; margin-right: 10px; display: block; margin-left: 10px; }
        header a { text-decoration: none; display: inline-block; }
        nav ul { list-style: none; margin: 0; padding: 0; display: flex; flex-wrap: wrap; }
        nav li { margin-right: 15px; }
        nav a { color: #ffffff; text-decoration: none; }
        .container { flex: 1; padding: 20px; max-width: 600px; margin: 20px auto; background-color: #fff; border: 1px solid #ddd; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        footer { background-color: #c22525; color: #ffffff; padding: 10px; text-align: center; margin-top: auto; }
        .button-group { display: flex; align-items: center; flex-wrap: wrap; }
        .button-group a { color: #ffffff; text-decoration: none; padding: 8px 12px; border-radius: 15px; background-color: #b40f0f; border: none; transition: background-color 0.3s ease; margin-left: 5px; font-size: 0.9em; margin-bottom: 5px; }
        .button-group a:hover { background-color: #a01d1d; }

        .form-container h2 { text-align: center; color: #333; }
        .form-container form { display: flex; flex-direction: column; gap: 15px; }
        .form-container label { margin-bottom: -10px; font-weight: bold; color: #555; }
        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="password"] { padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1em; }
        .form-container button[type="submit"],
        .form-container .form-button { padding: 10px 15px; border: none; border-radius: 4px; background-color: #c22525; color: white; font-size: 1em; cursor: pointer; transition: background-color 0.3s; text-align: center; text-decoration: none; display: inline-block;}
         .form-container .form-button { background-color: #555; margin-top: 5px;}
        .form-container button[type="submit"]:hover,
        .form-container .form-button:hover { background-color: #a01d1d; }
         .form-container .form-button:hover { background-color: #333; }
        .text-danger { color: red; font-size: 0.9em; margin-top: -10px; display: block; }
        .text-success { color: green; font-size: 1em; text-align: center; background-color: #e6ffed; border: 1px solid #b7ebc2; padding: 10px; border-radius: 4px; margin-bottom: 15px;}

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
    <h2>Register New Account</h2>

    <?php if (!empty($success_msg)): ?>
        <div class="text-success"><?php echo htmlspecialchars($success_msg); ?></div>
    <?php endif; ?>

    <form method="post" action="register.php" id="registerForm">
        <label for="fname">First Name:</label>
        <input type="text" id="fname" name="fname" value="<?php echo htmlspecialchars($first_name); ?>" required>
        <span class="text-danger"><?php echo $fname_err; ?></span>

        <label for="Lname">Last Name:</label>
        <input type="text" id="Lname" name="Lname" value="<?php echo htmlspecialchars($last_name); ?>" required>
        <span class="text-danger"><?php echo $lname_err; ?></span>

        <label for="em">Email Address:</label>
        <input type="email" id="em" name="em" value="<?php echo htmlspecialchars($email); ?>" required>
        <span class="text-danger"><?php echo $email_err; ?></span>

        <label for="phone">Phone (Optional):</label>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">

        <label for="address">Address (Optional):</label>
        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>">

        <label for="pass">Password:</label>
        <input type="password" id="pass" name="pass" required>
        <span class="text-danger"><?php echo $pass_err; ?></span>

        <label for="Cpass">Confirm Password:</label>
        <input type="password" id="Cpass" name="Cpass" required>
        <span class="text-danger"><?php echo $cpass_err; ?></span>

        <button type="submit">Register</button>
        <a href="login.php" class="form-button">Already have an account? Log In</a>
    </form>
</div>

<footer>
    <p>Gonzales, Carlo R. BSIT - 2E</p>
</footer>

</body>
</html>
