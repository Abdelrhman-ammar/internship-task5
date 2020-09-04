<?php session_start() ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Register</title>
        <link rel="stylesheet" href="../resources/style.css">
    </head>
    <body>
        <?php if(isset($_SESSION['login'])): ?>
            <form method="post" action="logout.php">
                <button type="submit" class="logOut-btn" id="SignUp">Log Out</button>
            </form>
            <h1>
                Welcom <?= $_SESSION['name'] ?>
            </h1>
            <?php else: 
                header("Location: ../index.php");
            ?>
        <?php endif; ?>
    </body>
</html>