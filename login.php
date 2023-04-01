<!-- require files -->
<?php 
session_start();
require_once('Database/database.php');
require_once('snippets/header.php');
?>

<?php

// if (!isset($_SESSION['authorized'])) {
//     $savedSessionID = $_COOKIE['PHPSESSID'];

// }
?>

<?php

if (isset($_SESSION['authorized'])) {
    if ($_SESSION['authorized'] == true) {
        header("Location: portal.php");
    }
}
/**
 * Explaination of the code
 * check if the roll number and password is set in POST request indicating that the form has been submitted
 * if the form has been submitted then check if the student exists in the database
 * 
 */
if (isset($_POST['roll-num']) && isset($_POST['password'])) {
    $roll_num = $_POST['roll-num'];
    $password = $_POST['password'];
    if ($DATABASE->checkStudentCredentials($roll_num, $password)) {
        $_SESSION['authorized'] = true;
        $_SESSION['roll_num'] = $roll_num;
        $DATABASE->bindSession($roll_num);
        header("Location: portal.php");
        echo "Student found";
    } else {
        echo "Student not found";
    }
}



?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style\login.css">
    <title>Login Page</title>
</head>
<body>
    <form action="login.php" method="post">

        <h2>LOGIN</h2>

        <label>Roll Number</label>

        <input type="text" name="roll-num" placeholder="Roll Number"><br>

        <label>Password</label>

        <input type="password" name="password" placeholder="Password"><br> 

        <button type="submit">Login</button>

     </form>
</body>
</html>