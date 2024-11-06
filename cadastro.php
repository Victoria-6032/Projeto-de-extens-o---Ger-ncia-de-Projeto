<?php


if (isset($_POST['submit'])) {
  

    include_once('config.php');

    $nomeAnimal = $_POST['nome-animal'];
    $nomeDono = $_POST['nome-dono'];
    $idade = $_POST['idade'];
    $peso = $_POST['peso'];
    $idEspecie = $_POST['especie'];

    
    $result = mysqli_query($conexao, "INSERT INTO animais (nome_animal, nome_dono, idade, peso, id_especie) VALUES ('$nomeAnimal','$nomeDono','$idade','$peso', '$idEspecie')");

    if ($result) {
        echo "<script>
            alert('Novo Pet Cadastrado com Sucesso!');
            window.location.href = 'tabelaAnimais.php';
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/cadastro-animais.css">
    <title>Cadastro de Animais - Petshop</title>
</head>

<body>

    <div class="container">
        <h1>Cadastro de Animais</h1>
        <form action="cadastro.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nome-animal">Nome do Animal:</label>
                <input type="text" id="nome-animal" name="nome-animal" required>
            </div>
            <div class="form-group">
                <label for="nome-dono">Nome do Dono:</label>
                <input type="text" id="nome-dono" name="nome-dono" required>
            </div>
            <div class="form-group">
                <label for="idade">Idade:</label>
                <input type="number" id="idade" name="idade" required>
            </div>
            <div class="form-group">
                <label for="peso">Peso (kg):</label>
                <input type="number" step="0.1" id="peso" name="peso" required>
            </div>

            <div class="form-group">
                <label for="especie">Espécie:</label>
                <select id="especie" name="especie" required>
                    <?php
                    include_once('config.php'); 
                    $result = mysqli_query($conexao, "SELECT id, nome_especie FROM especies");

                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<option value="' . $row['id'] . '">' . $row['nome_especie'] . '</option>';
                        }
                    } else {
                        echo '<option value="">Nenhuma espécie encontrada</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <button type="submit" name="submit" id="submit">Cadastrar Animal</button>
            </div>
        </form>
    </div>


</body>

</html>