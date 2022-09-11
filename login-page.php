<?php include('parts/head.php');?>
<?php include('functions.php');?>
<?php
    if (isset($_SESSION['user_name'])) {
        header("Location: front-page.php");
    }
?>
<?php $db_connection = new General;?>


<section class="login_form_section">
    <div class="container login_form_container">
        <form action="login_function.php" method="post" id="login_form">
            <div class="form_error_wrapp"></div>
            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            <label>Ім'я користовача</label>
            <input type="text" name="uname" placeholder="Впишіть ім'я"><br>
            <label>Пароль</label>
            <input type="password" name="upassword" placeholder="Впишіть Пароль"><br> 
            <button type="submit">Підтвердити</button>
        </form>
    </div>
</section>


<?php include('parts/foot.php');?>