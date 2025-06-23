<?php
require_once("cabecalho.php");
require("conexao.php");

$mesa_id = isset($_GET['mesa_id']) ? (int) $_GET['mesa_id'] : null;

// Buscar os pratos com categoria
$stmt = $pdo->query("
    SELECT p.*, c.nome AS nome_categoria
    FROM produto p
    INNER JOIN categoria c ON p.categoria_id = c.id
    ORDER BY p.nome
");

$pratos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Lista de Pratos <?= $mesa_id ? " - Mesa #$mesa_id" : "" ?></h2>

<?php if (isset($_GET['adicionado'])): ?>
    <div class="alert alert-success">Prato adicionado à mesa com sucesso!</div>
<?php endif; ?>

<div class="row">
    <?php foreach ($pratos as $prato): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <?php if ($prato['imagem']): ?>
                    <img src="imagens/<?= $prato['imagem'] ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                <?php else: ?>
                    <img src="imagens/sem-imagem.jpg" class="card-img-top" style="height: 200px; object-fit: cover;">
                <?php endif; ?>
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($prato['nome']) ?></h5>
                    <p class="card-text"><?= htmlspecialchars($prato['descricao']) ?></p>
                    <p><strong>R$ <?= number_format($prato['preco'], 2, ',', '.') ?></strong></p>
                    <p class="text-muted"><?= $prato['nome_categoria'] ?></p>

                    <?php if ($mesa_id): ?>
                        <form method="post" action="adicionar_item.php">
                            <input type="hidden" name="mesa_id" value="<?= $mesa_id ?>">
                            <input type="hidden" name="produto_id" value="<?= $prato['id'] ?>">
                            <input type="number" name="quantidade" value="1" min="1" class="form-control mb-2" required>
                            <button type="submit" class="btn btn-primary btn-sm">Adicionar à Mesa <?= $mesa_id ?></button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once("rodape.php"); ?>