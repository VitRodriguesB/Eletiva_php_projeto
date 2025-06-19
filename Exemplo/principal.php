<?php
  require_once("cabecalho.php");
?>

<h2>Bem-vindo, <?php echo $_SESSION['usuario']; ?>!</h2>

<div style="display: flex; flex-wrap: wrap; gap: 20px; margin-top: 30px;">
  <a href="nova_mesa.php" style="padding: 20px; background: #f2f2f2; border: 1px solid #ccc;">➕ Novo Prato</a>
  <a href="nova_categoria.php" style="padding: 20px; background: #f2f2f2; border: 1px solid #ccc;">📂 Nova Categoria</a>
  <a href="novo_cliente.php" style="padding: 20px; background: #f2f2f2; border: 1px solid #ccc;">👤 Novo Cliente</a>
  <a href="nova_mesa.php" style="padding: 20px; background: #f2f2f2; border: 1px solid #ccc;">🪑 Nova Mesa</a>
  <a href="novo_pedido.php" style="padding: 20px; background: #f2f2f2; border: 1px solid #ccc;">🧾 Novo Pedido</a>
  <a href="relatorio_pedidos.php" style="padding: 20px; background: #f2f2f2; border: 1px solid #ccc;">📊 Relatório de Pedidos</a>
</div>

<p style="margin-top: 30px;"><a href="sair.php">🚪 Sair</a></p>

<?php
  require_once("rodape.php");
?>