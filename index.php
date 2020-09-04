<?php session_start();
    $_SESSION["client_id"] = "334d1c0497cf37566efd";
    $_SESSION["client_secret"] = "918d8e1f666e5bc52c66deb8d06d91f48c35e140";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Register</title>
        <link rel="stylesheet" href="./resources/style.css">
    </head>
    <body>
        <div class="main-div">
            <?php if(!isset($_SESSION['login'])): ?>
                <?php if(!isset($_SESSION['register'])): ?>
                    <form method="get" action="https://github.com/login/oauth/authorize">
                        <input name="client_id" value="334d1c0497cf37566efd" hidden>
                        <button class="btn" name="register" class="btn-submit" type="submit">Register With Github</button>
                    </form>
                <?php endif ?>
                <form method="post"
                    <?= (isset($_SESSION['register']))?"action='pages/signup.php'":"action='pages/signin.php'"?>
                    class="form">
                    <input name="userName" type="text" placeholder="Enter Your Username" <?php if(isset($_SESSION['name'])){echo "value={$_SESSION['name']}";} ?> required>
                    <input name="password" type="password" placeholder="Enter Password" required>
                    <?= (isset($_SESSION['register']))?'<input name="confirm-password" type="password" placeholder="Confirm Password" required>':''?>
                    <button class="btn-submit" type="submit">Login</button>
                </form>
                <p class="info">
                    <?php if(isset($_SESSION["alert"])){echo $_SESSION["alert"];} ?>
                </p>
            <?php else: 
                header("Location: ./pages/home.php");
            ?>
            <?php endif; ?>
        </div>
    </body>
</html>