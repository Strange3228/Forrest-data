<?php include('functions.php');?>
<?php

session_start();
$db_connection = new General;

if (isset($_POST['username']) && isset($_POST['password'])) {
    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }
    $uname = validate($_POST['username']);
    $pass = validate($_POST['password']);
    if (empty($uname)) {
        echo "Поле логіну є обов'язковим";
        exit();
    }else if(empty($pass)){
        echo "Поле паролю є обов'язковим";
        exit();
    } else {
        $sql = "SELECT * FROM logs_users WHERE user_name='$uname' AND password='$pass'";
        $sth = $db_connection->dbs->prepare($sql);
        $sth->execute();
        $result = $db_connection->dbs->prepare("SELECT FOUND_ROWS()");
        $result->execute();
        if ($result->fetchColumn() > 0) {
            $_SESSION['user_name'] = $_POST['username'];
            echo 'redirect';
            return true;
            exit();
        } else {
            echo 'Невірний логін або пароль';
        }
    }
}