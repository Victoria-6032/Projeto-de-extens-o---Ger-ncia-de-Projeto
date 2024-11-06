<?php
include_once('config.php');


$animal_query = '';
$donor_query = '';

if (isset($_POST['search_animal']) && isset($_POST['search_donor'])) {
    $animal_query = $_POST['search_animal'];
    $donor_query = $_POST['search_donor'];
    $sql = "SELECT a.*, e.nome_especie 
            FROM animais a
            JOIN especies e ON a.id_especie = e.id 
            WHERE a.nome_animal LIKE '%$animal_query%' 
              AND a.nome_dono LIKE '%$donor_query%' 
            ORDER BY e.nome_especie, a.id DESC";
} else {
    $sql = "SELECT a.*, e.nome_especie 
            FROM animais a
            JOIN especies e ON a.id_especie = e.id 
            ORDER BY e.nome_especie, a.id DESC";
}
$result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Tabela de Animais - Petshop</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f7f7f7;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        h1 {
            color: #333;
            margin: 0;
        }

        .btn-cadastrar {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }

        .btn-cadastrar:hover {
            background-color: #45a049;
        }

        .search-container {
            margin-bottom: 20px;
            display: flex;
            gap: 10px; 
        }

        .search-input {
            padding: 10px;
            width: 100%;
            max-width: 250px; 
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            flex: 1 1 calc(33.333% - 20px);
            display: flex;
            flex-direction: column;
            transition: transform 0.2s;
            cursor: pointer; 
        }

        .card:hover {
            transform: translateY(-5px); 
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15); 
        }

        .card h2 {
            font-size: 20px;
            margin: 10px 0;
            color: #333;
        }

        .card p {
            margin: 5px 0;
            color: #666;
        }

        .actions {
            margin-top: auto;
            text-align: right;
        }

        .btn-delete {
            padding: 5px 10px; 
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-delete:hover {
            background-color: #d32f2f;
        }

        .btn-back {
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s;
            margin-left: 10px;

        .btn-back:hover {
            background-color: #0056b3;
        }}
    </style>
</head>

<body>
    <div class="header">
        <h1>Tabela de Animais</h1>
        <div>
            <a href="cadastro.php" class="btn-cadastrar">Cadastrar Novo Pet</a>
            <a href="home.php" class="btn-back">Voltar para Home</a>
        </div>
    </div>

    <div class="search-container">
        <form action="" method="POST" style="display: flex; gap: 10px;">
            <input type="text" name="search_animal" class="search-input" placeholder="Buscar pelo nome do pet..." value="<?php echo htmlspecialchars($animal_query); ?>">
            <input type="text" name="search_donor" class="search-input" placeholder="Buscar pelo nome do dono..." value="<?php echo htmlspecialchars($donor_query); ?>">
            <button type="submit" class="btn-cadastrar">Buscar</button>
        </form>
    </div>

    <div class="card-container">
        <?php
        $current_species = null; 
        while ($user_data = mysqli_fetch_assoc($result)) {
            if ($current_species !== $user_data['nome_especie']) {
                if ($current_species !== null) {
                    echo "</div>"; 
                }
                $current_species = $user_data['nome_especie'];
                echo "<h2>" . htmlspecialchars($current_species) . "</h2>"; 
                echo "<div class='card-container'>"; 
            }

            echo "<div class='card' onclick=\"window.location.href='detalhes.php?id=" . $user_data['id'] . "'\">";
            echo "<h2>" . htmlspecialchars($user_data['nome_animal']) . "</h2>";
            echo "<p><strong>Dono:</strong> " . htmlspecialchars($user_data['nome_dono']) . "</p>";
            echo "<p><strong>Idade:</strong> " . htmlspecialchars($user_data['idade']) . "</p>";
            echo "<p><strong>Peso:</strong> " . htmlspecialchars($user_data['peso']) . " kg</p>";
            echo "<div class='actions'>
                    <a class='btn-delete' href='deleteAnimais.php?id=" . $user_data['id'] . "' onclick=\"return confirm('Você realmente deseja excluir o animal?');\">
                        <i class='bi bi-trash3-fill'></i> Deletar
                    </a>
                </div>";
            echo "</div>";
        }
        ?>
    </div>

    <?php if ($animal_query || $donor_query): ?>
    <div style="margin-top: 20px;">
        <a href="tabelaAnimais.php" class="btn-back">Voltar</a>
    </div>
    <?php endif; ?>
</body>

</html>
