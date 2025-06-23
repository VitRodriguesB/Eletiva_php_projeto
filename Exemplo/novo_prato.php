<?php
require_once("cabecalho.php");

function inserirPrato($nome, $descricao, $preco, $categoria_id, $nomeImagem) {
    require("conexao.php");
    try {
        $sql = "INSERT INTO produto (nome, descricao, preco, categoria_id, imagem) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$nome, $descricao, $preco, $categoria_id, $nomeImagem])) {
            header('location: prato.php?cadastro=true');
            exit;
        } else {
            header('location: prato.php?cadastro=false');
            exit;
        }
    } catch (Exception $e) {
        die("Erro ao inserir o prato: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $descricao = trim($_POST['descricao']);
    $preco = (float) $_POST['preco'];
    $categoria_id = (int) $_POST['categoria_id'];
    $imagem = $_FILES['imagem'];

    $nomeImagem = null;

    // Upload de imagem
    if ($imagem['error'] === UPLOAD_ERR_OK) {
        $extensao = pathinfo($imagem['name'], PATHINFO_EXTENSION);
        $nomeImagem = uniqid('prato_') . '.' . $extensao;
        move_uploaded_file($imagem['tmp_name'], 'imagens/' . $nomeImagem);
    }

    if (empty($nome) || empty($descricao) || $preco <= 0 || $categoria_id <= 0) {
        echo '<div class="alert alert-danger">Preencha todos os campos corretamente.</div>';
    } else {
        inserirPrato($nome, $descricao, $preco, $categoria_id, $nomeImagem);
    }
}

require("conexao.php");
$stmt = $pdo->query("SELECT * FROM categoria ORDER BY nome ASC");
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Novo Prato</h2>

<form method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome do Prato</label>
        <input type="text" id="nome" name="nome" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="descricao" class="form-label">Descrição</label>
        <textarea id="descricao" name="descricao" class="form-control" required></textarea>
    </div>

    <div class="mb-3">
        <label for="preco" class="form-label">Preço</label>
        <input type="number" step="0.01" id="preco" name="preco" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="categoria_id" class="form-label">Categoria</label>
        <select id="categoria_id" name="categoria_id" class="form-control" required>
            <option value="">Selecione...</option>
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?= $categoria['id'] ?>"><?= htmlspecialchars($categoria['nome']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="imagem" class="form-label">Imagem do Prato</label>
        <input type="file" id="imagem" name="imagem" class="form-control" accept="image/*">
    </div>

    <button type="submit" class="btn btn-success">Cadastrar</button>
</form>

<?php require_once("rodape.php"); ?>
