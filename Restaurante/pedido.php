<?php
require_once("cabecalho.php");
require("conexao.php");

// Verifica se a mesa foi informada
if (!isset($_GET['mesa_id'])) {
    die("Mesa não informada.");
}

$mesa_id = (int) $_GET['mesa_id'];

// ✅ ADICIONAR ITEM AO PEDIDO
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['produto_id'])) {
    $produto_id = (int) $_POST['produto_id'];
    $quantidade = (int) $_POST['quantidade'];

    // Verifica se já existe um pedido
    $stmt = $pdo->prepare("SELECT id FROM pedidos WHERE mesa_id = ? ORDER BY id DESC LIMIT 1");
    $stmt->execute([$mesa_id]);
    $pedido = $stmt->fetch();

    if ($pedido) {
        $pedido_id = $pedido['id'];
    } else {
        $stmt = $pdo->prepare("INSERT INTO pedidos (mesa_id) VALUES (?)");
        $stmt->execute([$mesa_id]);
        $pedido_id = $pdo->lastInsertId();
    }

    // Insere item no pedido
    $stmt = $pdo->prepare("INSERT INTO itens_pedido (pedido_id, produto_id, quantidade) VALUES (?, ?, ?)");
    $stmt->execute([$pedido_id, $produto_id, $quantidade]);

    header("Location: pedido.php?mesa_id=$mesa_id");
    exit;
}

// ✅ REMOVER ITEM DO PEDIDO
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id'])) {
    $item_id = (int) $_POST['item_id'];
    $stmt = $pdo->prepare("DELETE FROM itens_pedido WHERE id = ?");
    $stmt->execute([$item_id]);
    echo '<div class="alert alert-success">Item removido com sucesso!</div>';
}

// Buscar mesa
$stmt = $pdo->prepare("SELECT * FROM mesas WHERE id = ?");
$stmt->execute([$mesa_id]);
$mesa = $stmt->fetch();

if (!$mesa) {
    die("Mesa não encontrada.");
}

// Buscar pedido
$stmt = $pdo->prepare("SELECT * FROM pedidos WHERE mesa_id = ? ORDER BY id DESC LIMIT 1");
$stmt->execute([$mesa_id]);
$pedido = $stmt->fetch();

echo "<h2>Pedido da Mesa #{$mesa['numero']}</h2>";

if ($pedido) {
    $pedido_id = $pedido['id'];

    // Buscar itens do pedido
    $stmt = $pdo->prepare("
        SELECT ip.*, p.nome, p.preco
        FROM itens_pedido ip
        INNER JOIN produto p ON ip.produto_id = p.id
        WHERE ip.pedido_id = ?
    ");
    $stmt->execute([$pedido_id]);
    $itens = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $itens = [];
}
?>

<!-- Exibir itens -->
<?php if (count($itens) > 0): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Prato</th>
                <th>Valor Unitário</th>
                <th>Quantidade</th>
                <th>Subtotal</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php $total = 0; ?>
            <?php foreach ($itens as $item): ?>
                <?php $subtotal = $item['preco'] * $item['quantidade']; ?>
                <?php $total += $subtotal; ?>
                <tr>
                    <td><?= htmlspecialchars($item['nome']) ?></td>
                    <td>R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
                    <td><?= $item['quantidade'] ?></td>
                    <td>R$ <?= number_format($subtotal, 2, ',', '.') ?></td>
                    <td>
                        <form method="post" style="display:inline" onsubmit="return confirm('Remover este item?')">
                            <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Remover</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total</th>
                <th colspan="2">R$ <?= number_format($total, 2, ',', '.') ?></th>
            </tr>
        </tfoot>
    </table>
<?php else: ?>
    <p>Nenhum item adicionado ainda.</p>
<?php endif; ?>

<hr>
<h3>Adicionar mais pratos à mesa</h3>

<?php
// Buscar todos os pratos
$stmt = $pdo->query("
    SELECT p.*, c.nome AS nome_categoria
    FROM produto p
    INNER JOIN categoria c ON c.id = p.categoria_id
    ORDER BY p.nome
");
$pratos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

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
                    <p class="text-muted"><?= $prato['nome_categoria'] ?></p>
                    <p><strong>R$ <?= number_format($prato['preco'], 2, ',', '.') ?></strong></p>
                    <form method="post">
                        <input type="hidden" name="produto_id" value="<?= $prato['id'] ?>">
                        <input type="number" name="quantidade" value="1" min="1" class="form-control mb-2" required>
                        <button type="submit" class="btn btn-success btn-sm">Adicionar à Mesa</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<a href="mesa.php" class="btn btn-secondary mt-4">Voltar às Mesas</a>

<?php require_once("rodape.php"); ?>