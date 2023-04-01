<?php
require_once('logoutButton.php')
?>

<header>
    <div class="header">
        <div class="logo">
            <img src="images\logo.png" alt="logo">
        </div>
        <div class="title">
            <h1>Student Portal</h1>
        </div>
        <div class="logout">
            <?php
            if (isset($_SESSION['authorized'])) {
                if ($_SESSION['authorized'] == true) {
                    echo $logoutButton;
                }
            }
            ?>
        </div>
    </div>
</header>
<style>
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background-color: #fff;
        box-shadow: 0 0 0.5rem rgba(0, 0, 0, 0.5);
        min-width: 100%;
    }
</style>