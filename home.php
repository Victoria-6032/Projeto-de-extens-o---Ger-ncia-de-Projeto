<?php
session_start();


if ((!isset($_SESSION['nome']) == true) and (!isset($_SESSION['senha']) == true)) {
    unset($_SESSION['nome']);
    unset($_SESSION['senha']);
    header('Location: login.php');
} else {
    $logado = $_SESSION['nome'];
}
?>


<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetShop</title>
    <link rel="stylesheet" href="CSS/2tela.css">
</head>
</head>

<body>
    <div class="container">
        <?php
        echo "<h1>Bem vindo(a)! : $logado</h1>"
            ?>
        <nav>
            <a href="tabelaConsultas.php">Consultas</a>
            <a href="cadastro.php">Cadastrar novo Pet</a>
            <a href="tabelaAnimais.php">Pets</a>
        </nav>
       <a href="sair.php">Sair</a>
      
    </div>
</body>

</html>