<?php
require_once("cabecalho.php");
require_once("conexao.php");

$data_inicial = $_GET['data_inicial'] ?? '';
$data_final = $_GET['data_final'] ?? '';
$pedidos = [];

if (!empty($data_inicial) && !empty($data_final)) {
    try {
        $stmt = $pdo->prepare("
    SELECT 
        p.id AS pedido_id,
        p.data_pedido,
        m.numero AS numero_mesa,
        (SELECT SUM(ip.quantidade) FROM itens_pedido ip WHERE ip.pedido_id = p.id) AS total_itens,
        (SELECT SUM(ip.quantidade * pr.preco)
            FROM itens_pedido ip
            JOIN produto pr ON pr.id = ip.produto_id
            WHERE ip.pedido_id = p.id) AS total_valor
    FROM pedidos p
    INNER JOIN mesas m ON m.id = p.mesa_id
    WHERE DATE(p.data_pedido) BETWEEN ? AND ?
    ORDER BY p.data_pedido DESC
");
        $stmt->execute([$data_inicial, $data_final]);
        $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo "<div class='alert alert-danger'>Erro ao consultar: {$e->getMessage()}</div>";
    }
}
?>

<h2>Relatório de Pedidos por Período</h2>

<form method="get" class="row g-3 mb-4">
    <div class="col-md-4">
        <label for="data_inicial" class="form-label">Data Inicial</label>
        <input type="date" id="data_inicial" name="data_inicial" class="form-control" value="<?= htmlspecialchars($data_inicial) ?>" required>
    </div>
    <div class="col-md-4">
        <label for="data_final" class="form-label">Data Final</label>
        <input type="date" id="data_final" name="data_final" class="form-control" value="<?= htmlspecialchars($data_final) ?>" required>
    </div>
    <div class="col-md-4 d-flex align-items-end">
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </div>
</form>

<?php if (!empty($data_inicial) && !empty($data_final)): ?>
    <h5>Período: <?= date('d/m/Y', strtotime($data_inicial)) ?> até <?= date('d/m/Y', strtotime($data_final)) ?></h5>

    <?php if (count($pedidos) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mesa</th>
                    <th>Data</th>
                    <th>Total de Itens</th>
                    <th>Total (R$)</th>
                </tr>
            </thead>
            <tbody>
                <?php $total_geral = 0; ?>
                <?php foreach ($pedidos as $pedido): ?>
                    <?php $total_geral += $pedido['total_valor']; ?>
                    <tr>
                        <td>Mesa <?= $pedido['numero_mesa'] ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($pedido['data_pedido'])) ?></td>
                        <td><?= $pedido['total_itens'] ?? 0 ?></td>
                        <td>R$ <?= number_format($pedido['total_valor'], 2, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Geral</th>
                    <th>R$ <?= number_format($total_geral, 2, ',', '.') ?></th>
                </tr>
            </tfoot>
        </table>
    <?php else: ?>
        <p>Nenhum pedido encontrado no período selecionado.</p>
    <?php endif; ?>
<?php endif; ?>

<?php require_once("rodape.php"); ?>
