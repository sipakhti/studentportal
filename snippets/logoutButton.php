<!-- this a simple html  button that i can add to any page to logout. it will handle all the server side logic for the logging out process -->


<?php

// this is the logout.php file
// it will handle the server side logic for the logout process
// it will destroy the session and unset the cookies
// it will also redirect the user to the login page

require_once('Database/database.php');
if (isset($_POST['logout'])) {
    session_destroy();
    setcookie('PHPSESSID', '', time() - 3600, '/');
    header("Location: login.php");
    $DATABASE->logoutUser($_SESSION['roll_num']);
}

$logoutButton = `<button type="button" onclick="logout()" id="logout-btn">Logout</button>
<style>
    #logout-btn {
        position: absolute;
        top: 0;
        right: 0;
        margin: 1rem;
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 0.5rem;
        background-color: #ff0000;
        color: #fff;
        font-size: 1rem;
        cursor: pointer;
    }
</style>
<script>
    function logout() {
        fetch('logout.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                logout: true
            })
        }).then((response) => {
            if (response.status == 200) {
                window.location.href = "login.php";
            }
        })
    }
</script>`;

?>

