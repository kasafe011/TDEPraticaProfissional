<?php
// Iniciando o array de produtos (seria equivalente ao banco de dados)
$produto = [];

    //Função para cadastrar novo produto

    function inserirProduto($nome, $preco, $quantidade) {
        global $produto;
        $novo_id = count($produto) + 1;
        $produto[] = ['id' => $novo_id, 'nome' => $nome, 'preco' => $preco, 'quantidade' => $quantidade];
}

function atualizarProduto($id, $nome, $preco, $quantidade) {
    global $produto;
    foreach ($produto as &$produtos) {
        if ($produtos['id'] == $id) {
            $produtos['nome'] = $nome;
            $produtos['preco'] = $preco;
            $produtos['quantidade'] = $quantidade;
            break;
        }
    }
}

function excluirProduto($id) {
    global $produto;
    foreach ($produto as $key => $produtos) {
        if ($produtos['id'] == $id) {
            unset($produto[$key]);
            break;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao'])) {
    $acao = $_POST['acao'];

    //PHP recebe os dados via metodo POST
    
    if($acao == 'inserir') {
        $nome = $_POST['nome'];
        $preco = $_POST['preco'];
        $quantidade = $_POST['quantidade'];
        inserirProduto($nome, $preco, $quantidade);

    } elseif($acao == 'atualizar') {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $preco = $_POST['preco'];
        $quantidade = $_POST['quantidade'];
        atualizarProduto($id, $nome, $preco, $quantidade);

    } elseif ($acao == 'deletar') {
        $id = $_POST['id'];
        excluirProduto($id);
    }   
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Churrascaria</title>
    <link href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center"> Cadastro de Produtos </h2>

        <form method="POST">
            <input type="hidden" name="acao" value="inserir">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome do Produto</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="preco" class="form-label">Preço do Produto</label>
                <input type="number" step="0.01" class="form-control" id="preco" name="preco" required>
            </div>
            <div class="mb-3">
                <label for="quantidade" class="form-label">Quantidade do Produto</label>
                <input type="number" class="form-control" id="quantidade" name="quantidade" required>
            </div>

            <button type="submit" class="btn-primary"> adicionar Produto</button>
        </form>

    <h3 class="mt-5">Cardapio</h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID do Produto</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produto as $produtos): ?>
                <tr>
                    <td><?= $produtos['id'] ?></td>
                    <td><?= $produtos['nome'] ?></td>
                    <td><?= number_format($produtos['preco'], 2, ',', '.') ?></td>
                    <td><?= $produtos['quantidade'] ?></td>
                    <td>

                    <form method="post" class="d-inline">
                        <input type="hidden" name="acao" value="atualizar">
                        <input type="hidden" name="id" value="<?= $produtos['id'] ?>">
                        <input type="text" class="form-control mb-2" name="nome" value="<?= $produtos['nome'] ?>" required>
                        <input type="number" class="form-control mb-2" name="preco" value="<?= $produtos['preco'] ?>" step="0.01" required>
                        <input type="number" class="form-control mb-2" name="quantidade" value="<?= $produtos['quantidade'] ?>" required>

                        <button type="submit" class="btn btn-warning btn-sw">Atualizar lista</button>
                    </form>

                    <form method="post" class="d-inline">
                        <input type="hidden" name="acao" value="deletar">
                        <input type="hidden" name="id" value="<?= $produtos['id']?>">
                        <button type="submit" class="btn btn-danger btn-sm">deletar</button>
                    </form>
                    </td>
                </tr>
                <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</body>
</html>