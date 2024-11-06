<?php

if (!empty($_GET['id'])) {

    include_once('config.php');

    $id = $_GET['id'];

    $sqlSelect = "SELECT * FROM animais WHERE id=$id";

    $result = $conexao->query($sqlSelect);

    if ($result->num_rows > 0) {
        $sqlDelete = "DELETE FROM animais WHERE id=$id";
        $resultDelete = $conexao->query($sqlDelete);
    }
}

header('Location: tabelaAnimais.php');