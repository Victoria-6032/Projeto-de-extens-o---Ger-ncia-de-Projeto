<?php
include_once('config.php');

if (isset($_POST['pagamento'])) {
   
    $consultaId = $_POST['consulta_id'];
    $formaPagamento = $_POST['forma-pagamento'];
    
    if ($formaPagamento === 'cartao') {
        
        $cartaoNumero = $_POST['cartao-numero'];
        $nomeTitular = $_POST['nome-titular'];
        $dataValidade = $_POST['data-validade'];
        $codigoSeguranca = $_POST['codigo-seguranca'];
    }

    
    $pagamentoSucesso = true;

    if ($pagamentoSucesso) {
        
        $updatePagamento = $conexao->query("UPDATE consultas SET pagamento_confirmado = 1 WHERE id = $consultaId");

        echo "<script>
            alert('Pagamento realizado com sucesso! Sua consulta está confirmada.');
            window.location.href = 'tabelaConsultas.php';
        </script>";
    } else {
        echo "<script>
            alert('Erro no processamento do pagamento. Tente novamente.');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento - Petshop</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .form-group button:hover {
            background-color: #45a049;
        }

        .cartao-info {
            display: none;
        }

        .confirmacao-pix-boleto {
            display: none;
            color: red;
            font-weight: bold;
            text-align: center;
        }
    </style>

    <script>
        function mostrarCamposPagamento(selecionado) {
            var camposCartao = document.querySelector('.cartao-info');
            var confirmacaoPixBoleto = document.querySelector('.confirmacao-pix-boleto');
            
            if (selecionado.value === 'cartao') {
                camposCartao.style.display = 'block';
                confirmacaoPixBoleto.style.display = 'none';
            } else if (selecionado.value === 'pix' || selecionado.value === 'Espécie') {
                camposCartao.style.display = 'none';
                confirmacaoPixBoleto.style.display = 'block';
            } else {
                camposCartao.style.display = 'none';
                confirmacaoPixBoleto.style.display = 'none';
            }
        }

        function validarPagamento(event) {
            var formaPagamento = document.getElementById('forma-pagamento').value;
            if (formaPagamento === 'pix' || formaPagamento === 'Espécie') {
                var confirmacao = confirm("o pagamento via " + (formaPagamento === 'pix' ? "Pix" : "Espécie") + " foi efetuado?");
                if (!confirmacao) {
                    event.preventDefault(); 
                }
            }
        }
    </script>
</head>

<body>
    <div class="container">
        <h1>Confirmação de Pagamento</h1>
        <form action="pagamento.php" method="POST" onsubmit="validarPagamento(event)">
            <input type="hidden" name="consulta_id" value="<?php echo $_GET['id']; ?>">
            
            <div class="form-group">
                <label for="forma-pagamento">Forma de Pagamento:</label>
                <select id="forma-pagamento" name="forma-pagamento" onchange="mostrarCamposPagamento(this)" required>
                    <option value="">Selecione uma opção</option>
                    <option value="cartao">Cartão de Crédito</option>
                    <option value="pix">Pix</option>
                    <option value="Espécie">Espécie</option>
                </select>
            </div>

           
            <div class="cartao-info">
                <div class="form-group">
                    <label for="cartao-numero">Número do Cartão:</label>
                    <input type="text" id="cartao-numero" name="cartao-numero">
                </div>

                <div class="form-group">
                    <label for="nome-titular">Nome do Titular:</label>
                    <input type="text" id="nome-titular" name="nome-titular">
                </div>

                <div class="form-group">
                    <label for="data-validade">Data de Validade:</label>
                    <input type="text" id="data-validade" name="data-validade" placeholder="MM/AA">
                </div>

                <div class="form-group">
                    <label for="codigo-seguranca">Código de Segurança:</label>
                    <input type="text" id="codigo-seguranca" name="codigo-seguranca">
                </div>
            </div>

           
            <div class="confirmacao-pix-boleto">
                <p>Por favor, confirme se o pagamento foi efetuado.</p>
            </div>

            <div class="form-group">
                <button type="submit" name="pagamento">Confirmar Pagamento</button>
            </div>
        </form>
    </div>
</body>

</html>
