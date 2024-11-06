<?php
include_once('config.php');


if (isset($_GET['id'])) {
    $id = $_GET['id'];

   
    $sqlAnimal = "SELECT a.*, e.nome_especie 
                  FROM animais a 
                  JOIN especies e ON a.id_especie = e.id 
                  WHERE a.id = '$id'";
    $resultAnimal = $conexao->query($sqlAnimal);
    $animal = $resultAnimal->fetch_assoc();

    
    $sqlConsultas = "SELECT c.*, v.nome AS nome_veterinario
                     FROM consultas c
                     JOIN veterinarios v ON c.id_veterinario = v.id
                     WHERE c.id_animal = '$id'
                     ORDER BY c.data_hora DESC";
    $resultConsultas = $conexao->query($sqlConsultas);
} else {
   
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Animal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f7f7f7;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        .btn-back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-back:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Detalhes do Animal</h1>
    <p><strong>Nome:</strong> <?php echo htmlspecialchars($animal['nome_animal']); ?></p>
    <p><strong>Dono:</strong> <?php echo htmlspecialchars($animal['nome_dono']); ?></p>
    <p><strong>Idade:</strong> <?php echo htmlspecialchars($animal['idade']); ?> anos</p>
    <p><strong>Peso:</strong> <?php echo htmlspecialchars($animal['peso']); ?> kg</p>
    <p><strong>Espécie:</strong> <?php echo htmlspecialchars($animal['nome_especie']); ?></p>

    <h2>Histórico de Consultas</h2>
    <?php if ($resultConsultas->num_rows > 0): ?>
        <table>
            <tr>
                <th>Data e Hora</th>
                <th>Veterinário</th>
                <th>Observações</th>
            </tr>
            <?php while ($consulta = $resultConsultas->fetch_assoc()): ?>
            <tr>
                <td><?php echo date('d/m/Y H:i', strtotime($consulta['data_hora'])); ?></td>
                <td><?php echo htmlspecialchars($consulta['nome_veterinario']); ?></td>
                <td><?php echo htmlspecialchars($consulta['observacoes']); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Este animal ainda não possui consultas registradas.</p>
    <?php endif; ?>

    <a href="tabelaAnimais.php" class="btn-back">Voltar</a>
</div>

</body>
</html>
