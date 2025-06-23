<?php
require_once("cabecalho.php");
$usuario = $_SESSION['usuario'] ?? 'Usuário';
?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Bem-vindo, <?= htmlspecialchars($usuario) ?>!</h1>

    <div class="row g-4 justify-content-center">

        <div class="col-md-4 col-lg-3">
            <a href="novo_prato.php" class="text-decoration-none">
                <div class="card text-center shadow h-100">
                    <div class="card-body">
                        <i class="fas fa-plus fa-2x text-primary"></i>
                        <h5 class="mt-3">Novo Prato</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4 col-lg-3">
            <a href="nova_categoria.php" class="text-decoration-none">
                <div class="card text-center shadow h-100">
                    <div class="card-body">
                        <i class="fas fa-folder-open fa-2x text-warning"></i>
                        <h5 class="mt-3">Nova Categoria</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4 col-lg-3">
            <a href="novo_usuario.php" class="text-decoration-none">
                <div class="card text-center shadow h-100">
                    <div class="card-body">
                        <i class="fas fa-user-plus fa-2x text-dark"></i>
                        <h5 class="mt-3">Novo Cliente</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4 col-lg-3">
            <a href="nova_mesa.php" class="text-decoration-none">
                <div class="card text-center shadow h-100">
                    <div class="card-body">
                        <i class="fas fa-chair fa-2x text-danger"></i>
                        <h5 class="mt-3">Nova Mesa</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4 col-lg-3">
            <a href="mesa.php" class="text-decoration-none">
                <div class="card text-center shadow h-100">
                    <div class="card-body">
                        <i class="fas fa-receipt fa-2x text-info"></i>
                        <h5 class="mt-3">Novo Pedido</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4 col-lg-3">
            <a href="relatorio.php" class="text-decoration-none">
                <div class="card text-center shadow h-100">
                    <div class="card-body">
                        <i class="fas fa-chart-bar fa-2x text-success"></i>
                        <h5 class="mt-3">Relatório de Pedidos</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-12 text-center mt-4">
            <a href="logout.php" class="btn btn-outline-danger">
                <i class="fas fa-sign-out-alt me-1"></i> Sair
            </a>
        </div>
    </div>
</div>

<?php require_once("rodape.php"); ?>
