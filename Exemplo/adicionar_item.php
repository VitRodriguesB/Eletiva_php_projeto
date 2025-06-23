<?php
require("conexao.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mesa_id = (int) $_POST['mesa_id'];
    $produto_id = (int) $_POST['produto_id'];
    $quantidade = (int) $_POST['quantidade'];

    // Verifica se há pedido já criado para a mesa
    $stmt = $pdo->prepare("SELECT id FROM pedidos WHERE mesa_id = ? ORDER BY id DESC LIMIT 1");
    $stmt->execute([$mesa_id]);
    $pedido = $stmt->fetch();

    if ($pedido) {
        $pedido_id = $pedido['id'];
    } else {
        // Cria novo pedido
        $stmt = $pdo->prepare("INSERT INTO pedidos (mesa_id) VALUES (?)");
        $stmt->execute([$mesa_id]);
        $pedido_id = $pdo->lastInsertId();
    }

    // Insere item no pedido
    $stmt = $pdo->prepare("INSERT INTO itens_pedido (pedido_id, produto_id, quantidade) VALUES (?, ?, ?)");
    $stmt->execute([$pedido_id, $produto_id, $quantidade]);

    header("Location: prato.php?mesa_id=$mesa_id&adicionado=true");
    exit;
}

