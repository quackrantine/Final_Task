<?php
session_start();

$is_logged_in = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quack's Blackmarket</title>
    <style>
        body { font-family: sans-serif; margin: 0; padding: 0; display: flex; flex-direction: column; min-height: 100vh; background-image: url(background.avif); background-size: cover; background-repeat: no-repeat; background-position: center bottom; }
        header { background-color: #c22525; color: #ffffff; padding: 10px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; }
        .logo { width: 200px; height: auto; border-radius: 5px; margin-right: 10px; display: block; margin-left: 10px; }
        header a { text-decoration: none; display: inline-block; }
        header a:hover { opacity: 0.8; }
        nav ul { list-style: none; margin: 0; padding: 0; display: flex; flex-wrap: wrap;}
        nav li { margin-right: 15px; }
        nav a { color: #ffffff; text-decoration: none; }
        .container { flex: 1; padding: 20px; display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; }
        .page-section {
            margin-bottom: 20px;
            border: 1px solid #ff0000;
            padding: 15px;
            background-size: cover; /* Keep cover in case a general background is set */
            background-repeat: no-repeat;
            background-position: center;
            color: rgb(255, 255, 255);
            text-shadow: 1px 1px 2px #000000;
            background-color: rgba(200, 37, 37, 0.85); /* Default section background */
            width: calc(33% - 40px);
            min-width: 250px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
         }
         .page-section h2 { margin-top: 0; border-bottom: 1px solid rgba(255,255,255,0.5); padding-bottom: 5px;}
         .page-section a { color: white; text-decoration: none;}
         .page-section a:hover h2 { text-decoration: underline;}
        footer { background-color: #c22525; color: #ffffff; padding: 10px; text-align: center; margin-top: auto; }
        .button-group { display: flex; align-items: center; flex-wrap: wrap; }
        .button-group a, .button-group span { color: #ffffff; text-decoration: none; padding: 8px 12px; border-radius: 15px; background-color: #b40f0f; border: none; transition: background-color 0.3s ease; margin-left: 5px; font-size: 0.9em; margin-bottom: 5px; /* Added for wrapping */ }
        .button-group a:hover { background-color: #a01d1d; }
         .button-group span { background-color: transparent; font-weight: bold; }

         @media (max-width: 768px) {
             .container { justify-content: flex-start;}
             .page-section { width: calc(50% - 30px); }
             header { justify-content: center; } /* Center header items */
             nav { order: 3; width: 100%; margin-top: 10px;} /* Move nav below logo/buttons */
             nav ul { justify-content: center;}
            .button-group { order: 2; margin-top: 5px;} /* Move button group after logo */
         }
          @media (max-width: 480px) {
             header { flex-direction: column; align-items: center;} /* Stack header items */
              .logo { margin: 0 auto 10px auto;} /* Center logo */
             nav { order: 2; } /* Nav after logo */
             nav ul { flex-direction: column; width: 100%; margin-top: 10px;}
             nav li { margin-right: 0; margin-bottom: 5px; width: 100%; text-align: center; background: rgba(0,0,0,0.1);}
             .button-group { order: 3; width: 100%; justify-content: space-around; margin-top: 10px;} /* Buttons last */
             .container { padding: 10px;}
             .page-section { width: calc(100% - 20px); }
         }
    </style>
</head>
<body>

    <header>
        <a href="home.php"><img class="logo" src="wmremove-transformed.png" alt="Quack's Blackmarket Logo"></a>
        <nav>
            <ul>
                <li><a href="#">Announcements</a></li>
                <li><a href="#">Trade</a></li>
                <li><a href="#">Buy Games</a></li>
                <li><a href="#">Forum</a></li>
                <li><a href="#">Inventory</a></li>
            </ul>
        </nav>
        <div class="button-group">
            <?php if($is_logged_in): ?>
                <span>Welcome, <?php echo htmlspecialchars($_SESSION["first_name"]); ?>!</span>
                <a href="#">Cart</a>
                <a href="#">Support</a>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                 <a href="#">Cart</a>
                 <a href="#">Support</a>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php endif; ?>
        </div>
    </header>

    <div class="container">
        <?php if($is_logged_in): ?>
          <p style="width: 100%; text-align: center; color: white; font-size: 1.2em; text-shadow: 1px 1px 2px #000;">
              You are logged in! Explore the sections below.
          </p>
        <?php endif; ?>

        <section class="page-section" id="announcements">
            <a href="#"><h2>Announcements</h2></a>
            <p>Latest game updates and news will be posted here.</p>
        </section>

        <section class="page-section" id="trade">
            <a href="#"><h2>Trade</h2></a>
            <p>Trade your games with other players.</p>
        </section>

        <section class="page-section" id="buy-games">
            <a href="#"><h2>Buy Games</h2></a>
            <p>Purchase new and exciting games.</p>
        </section>

        <section class="page-section" id="forum">
            <a href="#"><h2>Forum & Discussion</h2></a>
            <p>Join the community and discuss your favorite games.</p>
        </section>

        <section class="page-section" id="inventory">
            <a href="#"><h2>Inventory</h2></a>
            <p>Check items in your inventory</p>
        </section>

    </div>

    <footer>
        <p>Gonzales, Carlo R. BSIT - 2E</p>
    </footer>

</body>
</html>
