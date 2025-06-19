<?php
require_once("cabecalho.php");
require("conexao.php");

// TRATAR EXCLUSÃO DIRETA POR POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir_id'])) {
    $id = (int) $_POST['excluir_id'];

    // Excluir ou marcar como disponível
    $stmt = $pdo->prepare("DELETE FROM mesas WHERE id = ?");
    if ($stmt->execute([$id])) {
        echo '<div class="alert alert-success">Reserva excluída com sucesso!</div>';
    } else {
        echo '<div class="alert alert-danger">Erro ao excluir.</div>';
    }
}

// Buscar reservas ativas
try {
    $stmt = $pdo->query("SELECT * FROM mesas WHERE status = 0 ORDER BY numero ASC");
    $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Erro ao buscar reservas: " . $e->getMessage());
}
?>

<h2>Reservas Ativas</h2>

<?php if (count($reservas) > 0): ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Número</th>
                <th>Nome da Reserva</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservas as $mesa): ?>
                <tr>
                    <td><?= $mesa['id'] ?></td>
                    <td><?= $mesa['numero'] ?></td>
                    <td><?= htmlspecialchars($mesa['nome_reserva']) ?></td>
                    <td>
                        <a href="editar_reserva.php?id=<?= $mesa['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="produtos.php?mesa_id=<?= $mesa['id'] ?>" class="btn btn-primary btn-sm">Adicionar Produtos</a>

                        <!-- Formulário de exclusão direta -->
                        <form method="post" style="display:inline" onsubmit="return confirm('Deseja excluir esta reserva?');">
                            <input type="hidden" name="excluir_id" value="<?= $mesa['id'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                        </form>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Nenhuma reserva encontrada.</p>
<?php endif; ?>

<?php require_once("rodape.php"); ?>