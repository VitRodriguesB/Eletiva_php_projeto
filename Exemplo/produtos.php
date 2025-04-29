<?php
  require_once("cabecalho.php");
?>
  
<h2>Produtos</h2>
<a href="novo_produto.php" class="btn btn-success mb-3">Novo Registro</a>
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th><th>Descrição</th><th>Valor</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
      <tr>
          <td>1</td>
          <td>Exemplo</td><td>Exemplo</td><td>Exemplo</td>
          <td>
              <a href="editar_produto.php" class="btn btn-warning">Editar</a>
              <a href="consultar_produto.php" class="btn btn-info">Consultar</a>
          </td>
      </tr>
      <tr>
          <td>2</td>
          <td>Exemplo</td><td>Exemplo</td><td>Exemplo</td>
          <td>
              <a href="#" class="btn btn-warning">Editar</a>
              <a href="#" class="btn btn-info">Consultar</a>
          </td>
      </tr>
      <tr>
          <td>3</td>
          <td>Exemplo</td><td>Exemplo</td><td>Exemplo</td>
          <td>
              <a href="#" class="btn btn-warning">Editar</a>
              <a href="#" class="btn btn-info">Consultar</a>
          </td>
      </tr>
      <tr>
          <td>4</td>
          <td>Exemplo</td><td>Exemplo</td><td>Exemplo</td>
          <td>
              <a href="#" class="btn btn-warning">Editar</a>
              <a href="#" class="btn btn-info">Consultar</a>
          </td>
      </tr>  
      <tr>
          <td>5</td>
          <td>Exemplo</td><td>Exemplo</td><td>Exemplo</td>
          <td>
              <a href="#" class="btn btn-warning">Editar</a>
              <a href="#" class="btn btn-info">Consultar</a>
          </td>
      </tr>
    </tbody>
</table>


<?php
  require_once("rodape.php");
?>