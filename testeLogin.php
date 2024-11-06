<?php

session_start();


if (isset($_POST['submit']) && !empty($_POST['username']) && !empty($_POST['password'])) {
   
    include_once('config.php');
    $username = $_POST['username'];
    $password = $_POST['password'];


    $sql = "SELECT * FROM usuarios WHERE nome = '$username' and senha = '$password'";
    $result = $conexao->query($sql);

   
    if (mysqli_num_rows($result) < 1) {

        unset($_SESSION['nome']);
        unset($_SESSION['senha']);

        echo "<script>
            alert('Não existe nenhum registro encontrado, verifique sua senha ou usuario.');
            window.location.href = 'login.php';
          </script>";

    } else {
        $_SESSION['nome'] = $username;
        $_SESSION['senha'] = $password;

        header('Location: home.php');

    }
} else {
   
    header('Location: login.php');
}

