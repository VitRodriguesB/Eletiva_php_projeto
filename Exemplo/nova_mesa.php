<?php
require_once("cabecalho.php");

function inserirMesa($numero, $nome_reserva) {
    require("conexao.php");
    try {
        $sql = "INSERT INTO mesas (numero, status, nome_reserva) VALUES (?, 0, ?)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$numero, $nome_reserva])) {
            header('location: mesa.php?cadastro=true');
            exit;
        } else {
            header('location: mesa.php?cadastro=false');
            exit;
        }
    } catch (Exception $e) {
        die("Erro ao inserir a mesa: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    require("conexao.php");
    $numero = (int) $_POST['numero'];
    $nome_reserva = trim($_POST['nome_reserva']);

    if ($numero < 1 || $numero > 10) {
    echo '<div class="alert alert-danger">Número da mesa deve ser entre 1 e 10.</div>';
} elseif (empty($nome_reserva)) {
    echo '<div class="alert alert-danger">O nome da reserva é obrigatório.</div>';
} else {
    require("conexao.php");
    // Verificar se já existe reserva ativa para essa mesa
    $stmt = $pdo->prepare("SELECT * FROM mesas WHERE numero = ? AND status = 0");
    $stmt->execute([$numero]);
    if ($stmt->rowCount() > 0) {
        echo '<div class="alert alert-warning">Esta mesa já está reservada.</div>';
    } else {
        inserirMesa($numero, $nome_reserva);
    }
}
}

// Buscar apenas mesas disponíveis
require("conexao.php");
$mesas = [];
try {
    $stmt = $pdo->query("SELECT * FROM mesas WHERE status = 1 ORDER BY numero ASC");
    $mesas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "Erro ao buscar mesas: " . $e->getMessage();
}
?>

<h2>Reserva de Mesa</h2>

<form method="post">
    <div class="mb-3">
        <label for="numero" class="form-label">Número da Mesa (1 a 10)</label>
        <input type="number" id="numero" name="numero" min="1" max="10" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="nome_reserva" class="form-label">Nome da Reserva</label>
        <input type="text" id="nome_reserva" name="nome_reserva" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Reservar</button>
</form>

<hr>

<h3>Mesas Disponíveis</h3>
<?php
require("conexao.php");

// 1. Busque todas as mesas ocupadas (ativas na tabela)
$stmt = $pdo->query("SELECT numero FROM mesas WHERE status = 0");
$ocupadas = $stmt->fetchAll(PDO::FETCH_COLUMN);

// 2. Monte lista de todas as mesas possíveis (1 a 10)
$disponiveis = [];

for ($i = 1; $i <= 10; $i++) {
    if (!in_array($i, $ocupadas)) {
        $disponiveis[] = $i;
    }
}

?>
<?php if (count($disponiveis) > 0): ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Número</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($disponiveis as $numero): ?>
                <tr>
                    <td><?= $numero ?></td>
                    <td><span class="text-success">Disponível</span></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Nenhuma mesa disponível.</p>
<?php endif; ?>

<?php require_once("rodape.php"); ?>
