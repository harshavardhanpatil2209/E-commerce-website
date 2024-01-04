<?php
// sign up validation

if (empty($_POST['name'])) {
    die("Name is required!");
}
// validate email
if(! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
    die("Please Enter a valid email");
}

// validate password
if (strlen($_POST['password']) < 6) {
    die("Password Length should be greater than 6");
}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}
// passwords should match
if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

// generate a hashed password

$password_hash  = password_hash($_POST['password'], PASSWORD_DEFAULT);

// require connection to the database
$mysqli = require __DIR__."/db.php";

// create a query

$sql = "INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)";

// create a statement
$stmt = $mysqli->stmt_init();

// error check
if (! $stmt->prepare($sql)) {
    die("SQL Error " . $mysqli->error);
}

// bind values to the stmt
$stmt->bind_param('sss',
                $_POST['name'],
                $_POST['email'],
                $password_hash);

if ( $stmt->execute()) {
    header("Location: success.html");
    exit;
} else {
    if ($mysqli->errno == 1062) {
        die("Email already taken.");
    } else {
        die($mysqli->error . "" . $mysqli->errno);
    }
}
