<?php

// is_valid data
$is_invalid = false;

// check if post request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // requre db connection
    $mysqli = require __DIR__ . "/db.php";
    
    $sql = sprintf("SELECT * FROM users WHERE email = '%s' ",
        $mysqli->real_escape_string($_POST['email']));
    
    $result = $mysqli->query($sql);
    // user data
    $user = $result->fetch_assoc();

// verify user
    if ($user) {
        // verify password
        if(password_verify($_POST['password'], $user['password_hash'])) {
            // start session
            session_start();
            session_regenerate_id();
            $_SESSION['user_id'] = $user['id'];

            header("Location: ../index.php");
            exit;

        }
    }
    $is_invalid = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blockbuster 3.0</title>
    <link rel="stylesheet" href="../client/src/assets/css/main.css">
</head>
<style>
    #login-btn {
    width: 80%;
    align-self: center;
    padding: 1rem 0.5rem;
    margin: 1rem 0;
    background: rgba(3, 41, 87, 0.84);
    outline: none;
    cursor: pointer;
    border: none;
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    color: #eee;
    font-size: 20px;
    font-weight: 500;
    border-radius: 5px;
}
#login-btn:hover{
    background: #eee;
    transition: 0.3s linear;
    color: black;
}
.call-to-action-link {
    text-decoration: dotted;
    font-size: x-large;
    margin: 1rem 0;
    padding: 0 1rem;
}
/* on small screens */
@media screen and (max-width: 600){
    .call-to-action-link {
        font-size: small;
    }
}
a {
    color: #f1f1f1;
}
a:hover {
    color: red;
}
.logo-container {
    width: 200px;
    height: 100%;
    display: grid;
    place-items: center;
    margin-top: 0.5rem;
}
img {
    object-fit: cover;
    max-width: 150px;
    border-radius: 60%;
    outline: 1px solid #121212;
}
</style>
<body>
<div class="sign-up-container">
<div class="logo-container">
    <a href="../index.html"><img src="https://i.pinimg.com/originals/12/d6/00/12d60046505b41fe3ca8a71e0d186c62.png" alt="" class="logo"></a>
</div>
<h1>Login</h1>
    <?php if ($is_invalid): ?>
        <span>Invalid login</span>
    <?php endif; ?>
    
    <form method="post" id="login-form">
        <label for="email">Email</label>
        <input type="email" name="email" id="email"
               value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
        
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        <button id="login-btn">Log in</button>
    </form>
    <p class="call-to-action-link">Do not have an account? <a href="signup.html"> sign up</a></p>
</div>
</body>
</html>