<?php
    require_once("cabecalho.php");
    require_once("conexao.php");

    if (!isset($_GET['id'])) {
        die("Reserva não informada.");
    }

    $id = $_GET['id'];

    // Consulta os dados da mesa
    $stmt = $pdo->prepare("SELECT * FROM mesas WHERE id = ?");
    $stmt->execute([$id]);
    $reserva = $stmt->fetch();

    if (!$reserva) {
        die("Reserva não encontrada.");
    }

    // Atualizar dados se formulário for enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $numero = (int) $_POST['numero'];
        $nome_reserva = trim($_POST['nome_reserva']);

        // Validações
        if ($numero < 1 || $numero > 10) {
            echo "<div class='alert alert-danger'>Número da mesa deve ser entre 1 e 10.</div>";
        } elseif (empty($nome_reserva)) {
            echo "<div class='alert alert-danger'>O nome da reserva é obrigatório.</div>";
        } else {
            // Verifica se já existe outra mesa com esse número
            $verifica = $pdo->prepare("SELECT * FROM mesas WHERE numero = ? AND id != ?");
            $verifica->execute([$numero, $id]);

            if ($verifica->rowCount() > 0) {
                echo "<div class='alert alert-warning'>Já existe uma reserva com esse número.</div>";
            } else {
                $sql = "UPDATE mesas SET numero = ?, nome_reserva = ? WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                if ($stmt->execute([$numero, $nome_reserva, $id])) {
                    header("Location: mesa.php?atualizado=true");
                    exit;
                } else {
                    echo "<div class='alert alert-danger'>Erro ao atualizar reserva.</div>";
                }
            }
        }
    }
?>

<h2>Editar Reserva da Mesa <?= htmlspecialchars($reserva['numero']) ?></h2>

<form method="post">
    <div class="mb-3">
        <label for="numero" class="form-label">Número da Mesa</label>
        <input type="number" id="numero" name="numero" class="form-control" value="<?= htmlspecialchars($reserva['numero']) ?>" min="1" max="10" required>
    </div>

    <div class="mb-3">
        <label for="nome_reserva" class="form-label">Nome da Reserva</label>
        <input type="text" id="nome_reserva" name="nome_reserva" class="form-control" value="<?= htmlspecialchars($reserva['nome_reserva']) ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Salvar</button>
    <a href="reservas.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php require_once("rodape.php"); ?>