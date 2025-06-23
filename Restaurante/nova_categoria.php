<?php
require_once("cabecalho.php");
require_once("conexao.php");

// Função para inserir categoria
function inserirCategoria($nome, $descricao) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("INSERT INTO categoria (nome, descricao) VALUES (?, ?)");
        return $stmt->execute([$nome, $descricao]);
    } catch (Exception $e) {
        echo "<div class='alert alert-danger'>Erro: " . $e->getMessage() . "</div>";
        return false;
    }
}

// Verifica envio do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $descricao = trim($_POST['descricao']);

    if (empty($nome) || empty($descricao)) {
        echo "<div class='alert alert-danger'>Preencha todos os campos.</div>";
    } else {
        if (inserirCategoria($nome, $descricao)) {
            echo "<div class='alert alert-success'>Categoria cadastrada com sucesso!</div>";
        } else {
            echo "<div class='alert alert-danger'>Erro ao cadastrar.</div>";
        }
    }
}
?>

<h2>Nova Categoria</h2>

<form method="post">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome da Categoria</label>
        <input type="text" id="nome" name="nome" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="descricao" class="form-label">Descrição</label>
        <textarea id="descricao" name="descricao" class="form-control" rows="3" required></textarea>
    </div>

    <button type="submit" class="btn btn-success">Cadastrar</button>
    <a href="principal.php" class="btn btn-secondary">Voltar</a>
</form>

<?php require_once("rodape.php"); ?>
