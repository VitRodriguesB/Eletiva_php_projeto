<?php
    require_once("cabecalho.php");
?>

    <h2> Consultar Produto </h2>

    <div class="mb-2">
        <p>Nome do Produto: <strong>Produto 1</strong></p>
    </div>

    <div class="mb-2">
        <p>Descrição do Produto: <strong>Produto 1</strong></p>
    </div>

    <div class="mb-2">
        <p>Valor do Produto: <strong>Produto 1</strong></p>
    </div>

    <div class="mb-2">
        <button type="submit" class="btn btn-danger">Excluir</button>
        <button type="button" class="btn btn-secondary"
                onclick="history.back()">Voltar</button>
    </div>

<?php
    require_once("rodape.php");