<?php

    require_once("cabecalho.php");

    function consultaCategoria($id){
        require("conexao.php");
        try{
            $sql = "SELECT * FROM categoria WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            $categoria = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$categoria){
                die("Erro ao consultar o registro!");
            } else{
                return $categoria;
            }
        } catch(Exception $e){
            die("Erro ao consultar categoria: " . $e->getMessage());
        }
    }

    function excluirCategoria($id){
        require("conexao.php");
        try{
            $sql = "DELETE FROM categoria WHERE id=?";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$id])){
                header('location: categorias.php?exclusao=true');
            } else {
                header('location: categorias.php?exclusao=false');
            }
        } catch (Exception $e){
            die("Erro ao excluir a categoria: ".$e->getMessage());
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $id = $_POST['id'];
        excluirCategoria($id);
    } else {
        $categoria = consultaCategoria($_GET['id']);
    }

?>

<h2>Consultar Categoria</h2>

<form method="post">

    <input type="hidden" name="id" value="<?= $categoria['id'] ?>" >
                        
    <div class="mb-3">
        <p>Nome: <b> <?= $categoria['nome'] ?> </b> </p>
    </div>

    <div class="mb-3">
        <p> Descrição: <b> <?= $categoria['descricao'] ?> </b> </p>
    </div>

    <div class="mb-3">
        <p class="text-danger">Deseja excluir esse registro</p>
        <button type="submit" class="btn btn-danger">Excluir</button>
        <a href="categorias.php" class="btn btn-secondary">Voltar</a>
    </div>
</form>


<?php 
    require_once("rodape.php");

?>