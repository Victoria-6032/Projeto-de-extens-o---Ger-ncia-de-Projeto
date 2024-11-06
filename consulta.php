<?php
include_once('config.php');


if (isset($_POST['submit'])) {
    $dataHora = $_POST['data-hora'];
    $veterinario = $_POST['veterinario'];
    $nomeAnimal = $_POST['nome-animal'];
    $observacoes = $_POST['observacoes'];

 
    $result = mysqli_query($conexao, "INSERT INTO consultas (data_hora, observacoes, id_animal, id_veterinario) VALUES ('$dataHora','$observacoes','$nomeAnimal','$veterinario')");

    if ($result) {
        
        $consultaId = mysqli_insert_id($conexao); 
        header("Location: pagamento.php?id=$consultaId");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/consulta.css">
    <title>Marcar Consulta - Petshop</title>
</head>

<body>
    <div class="container">
        <h1>Marcar Nova Consulta</h1>
        <form action="consulta.php" method="POST">
            <div class="form-group">
                <label for="data-hora">Data e Hora:</label>
                <input type="datetime-local" id="data-hora" name="data-hora" required>
            </div>

            <div class="form-group">
                <label for="veterinario">Veterinário:</label>
                <select id="veterinario" name="veterinario" required>
                    <?php
                    
                    $result = mysqli_query($conexao, "SELECT id, nome FROM veterinarios");
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<option value="' . $row['id'] . '">' . $row['nome'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="nome-animal">Nome do Animal:</label>
                <select id="nome-animal" name="nome-animal" required>
                    <?php
                    
                    $result = mysqli_query($conexao, "SELECT id, nome_animal FROM animais WHERE id_especie IS NOT NULL");
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<option value="' . $row['id'] . '">' . $row['nome_animal'] . '</option>';
                        }
                    } else {
                        echo '<option value="">Nenhum animal encontrado</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="observacoes">Observações:</label>
                <textarea id="observacoes" name="observacoes" rows="4" placeholder="Observações adicionais, se houver..."></textarea>
            </div>

            <div class="form-group">
                <button type="submit" name="submit" id="submit">Confirmar Consulta</button>
            </div>
        </form>
    </div>
    
    <script>
        
        document.getElementById('data-hora').addEventListener('change', function () {
            const selectedDate = new Date(this.value);
            const currentDate = new Date();
            if (selectedDate < currentDate) {
                alert('A data e hora selecionadas já passaram. Por favor, escolha uma data futura.');
                this.value = '';
            }
        });
    </script>
</body>

</html>
