<?php

$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '123456';
$dbName = 'petshop';


$conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);


// if ($conexao->connect_error) {
//     echo "Erro de conexão";
// } else {
//     echo "conexao otima ";
// }