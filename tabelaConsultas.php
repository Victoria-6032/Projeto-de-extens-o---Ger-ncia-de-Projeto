<?php 
include_once('config.php');


$results_per_page = 5; 


$sql = "SELECT COUNT(*) AS total FROM consultas";
$result = $conexao->query($sql);
$row = $result->fetch_assoc();
$total_results = $row['total'];


$total_pages = ceil($total_results / $results_per_page);


if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $current_page = (int)$_GET['page'];
} else {
    $current_page = 1; 
}


$start_from = ($current_page - 1) * $results_per_page;


$sql = "SELECT * FROM consultas ORDER BY id DESC LIMIT $start_from, $results_per_page";
$result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Tabela de Consultas - Petshop</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: white;
        }
        
        .header {
            display: flex;
            justify-content: center;
            gap: 10px;
            align-items: center;
        }

        h1 {
            color: #333;
        }

        .btn-cadastrar, .btn-voltar {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
        }

        .btn-voltar {
            background-color: #008000;
        }

        .btn-cadastrar:hover, .btn-voltar:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .pagination {
            margin: 20px 0;
            display: flex;
            justify-content: center;
        }

        .pagination a {
            padding: 8px 12px;
            margin: 0 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-decoration: none;
            color: #4CAF50;
        }

        .pagination a.active {
            background-color: #4CAF50;
            color: white;
        }

        .pagination a:hover {
            background-color: #45a049;
            color: white;
        }
    </style>
</head>

<body>
    <a href="home.php" class="btn-voltar">Voltar</a>
    <div class="header">
        <h1>Tabela de Consultas</h1>
        <a href="consulta.php" class="btn-cadastrar">Cadastrar Nova Consulta</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Observações</th>
                <th>Nome do Animal</th>
                <th>Nome do Veterinário</th>
                <th>Pagamento Confirmado</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($user_data = mysqli_fetch_assoc($result)) {
              
                $animal_id = $user_data['id_animal'];
                $animal_result = $conexao->query("SELECT nome_animal FROM animais WHERE id = $animal_id");
                $animal_data = mysqli_fetch_assoc($animal_result);
                $nome_animal = $animal_data['nome_animal'] ?? 'Desconhecido';

                
                $veterinario_id = $user_data['id_veterinario'];
                $veterinario_result = $conexao->query("SELECT nome FROM veterinarios WHERE id = $veterinario_id");
                $veterinario_data = mysqli_fetch_assoc($veterinario_result);
                $nome_veterinario = $veterinario_data['nome'] ?? 'Desconhecido';

                
                $pagamento_confirmado = $user_data['pagamento_confirmado'] ? 'Sim' : 'Não';

                echo "<tr>";
                echo "<td>" . htmlspecialchars($user_data['data_hora']) . "</td>";
                echo "<td>" . htmlspecialchars($user_data['observacoes']) . "</td>";
                echo "<td>" . htmlspecialchars($nome_animal) . "</td>";
                echo "<td>" . htmlspecialchars($nome_veterinario) . "</td>";
                echo "<td>" . htmlspecialchars($pagamento_confirmado) . "</td>";
                echo "<td>
                        <a class='btn btn-danger' href='delete.php?id=" . $user_data['id'] . "'>
                            <i class='bi bi-trash3-fill'></i>
                        </a>
                    </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="pagination">
        <?php
      
        for ($page = 1; $page <= $total_pages; $page++) {
            if ($page == $current_page) {
                echo "<a class='active' href='?page=$page'>$page</a>";
            } else {
                echo "<a href='?page=$page'>$page</a>";
            }
        }
        ?>
    </div>
</body>

</html>
