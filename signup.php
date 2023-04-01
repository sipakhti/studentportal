<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style\signup.css">
    <title>SignUp Page</title>
</head>
<body>
    <?php
    
    ?>
    <form name="signupForm" action="signup.php" method="post" onSubmit="return Forms.validateSignupForm(this)">

        <h2>SIGNUP</h2>
        <?php

        /** 
         * THIS BLOCK EXECUTEs WHEN A POST REQUEST IS MADE
         */
        if (sizeof($_POST) > 0) {
            echo print_r($_POST);
        }
        ?>
        <?php if (isset($_GET['error'])) { ?>

            <p class="error"><?php echo $_GET['error']; ?></p>

        <?php } ?>

        <label>User Name</label>

        <input type="text" name="username" placeholder="User Name" required><br>

        <label>Password</label>

        <input type="password" name="password" placeholder="Password" required><br> 

        <label>Confirm Password</label>

        <input type="password" name="confirmPassword" placeholder="Password" required><br> 

        <button type="submit">Sign Up</button>

     </form>
</body>
<script src="Scripts/Forms.js"></script>
</html>