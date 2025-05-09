<?php
  require_once("cabecalho.php");

  function retornaProdutos(){
    require("conexao.php");
    try{
        $sql = "SELECT p.*, c.nome as nome_categoria 
                FROM produto p
                INNER JOIN categoria c ON c.id = p.categoria_id";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    } catch (Exception $e){
        die("Erro ao consultar produtos: " . $e->getMessage());
    }
  }

  $produtos = retornaProdutos();
?>
  
<h2>Produtos</h2>
<a href="novo_produto.php" class="btn btn-success mb-3">Novo Registro</a>
<table class="table table-hover table-striped" id="tabela">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Valor</th>
            <th>Categoria</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($produtos as $p):
        ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= $p['nome'] ?></td>
                <td><?= $p['descricao'] ?></td>
                <td><?= $p['preco'] ?></td>
                <td><?= $p['nome_categoria'] ?></td>
                <td>
                    <a href="editar_produto.php?id=<?= $p['id'] ?>" class="btn btn-warning">Editar</a>
                    <a href="consultar_produto.php?id=<?= $p['id'] ?>" class="btn btn-info">Consultar</a>
                </td>
            </tr>
        <?php
            endforeach;
        ?>
    </tbody>
</table>


<?php
  require_once("rodape.php");
?>