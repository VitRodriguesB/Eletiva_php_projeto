<?php
  require_once("cabecalho.php");

  echo "<h2> Usuário: ".$_SESSION['usuario']." </h2>";
?>
  <p><a href="sair.php">Sair</a></p>
<?php
  require_once("rodape.php");
?>