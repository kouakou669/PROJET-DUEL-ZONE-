<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="indexstyle.css">
    <title>Login</title>
</head>
<body>
    <div class="bg-image">
        <img src="cyber.jpg" class="image" alt="Background Image">
    </div>

    <div class="login">
        <?php
        require('db.php');
        session_start();

        if (isset($_POST['username'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows === 1) {
                $stmt->bind_result($hashed_password);
                $stmt->fetch();

                if (password_verify($password, $hashed_password)) {
                    $_SESSION['username'] = $username;
                    session_regenerate_id(true); // Regenerate session ID
                    header("Location: start.php");
                    exit();
                } else {
                    echo "<div class='form'><h3>Invalid login credentials.</h3><br/>Click here to <a href='index.php'>Login</a></div>";
                }
            } else {
                echo "<div class='form'><h3>Invalid login credentials.</h3><br/>Click here to <a href='index.php'>Login</a></div>";
            }

            $stmt->close();
        } else {
        ?>
            <div class="form">
                <h1>Log In</h1>
                <form action="" method="post" name="login">
                    <input type="text" name="username" placeholder="Username" required /><br>
                    <input type="password" name="password" placeholder="Password" required /><br>
                    <input name="submit" type="submit" value="Login" />
                </form>
                <p>Not registered yet? <a href='registration.php'>Register Here</a></p>
            </div>
        <?php } ?>
    </div>
</body>
</html>
