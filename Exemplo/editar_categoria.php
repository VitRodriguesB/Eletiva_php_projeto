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

    function alterarCategoria($nome, $descricao, $id){
        require("conexao.php");
        try{
            $sql = "UPDATE categoria SET nome = ?, descricao = ? WHERE id=?";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$nome, $descricao, $id])){
                header('location: categorias.php?edicao=true');
            } else {
                header('location: categorias.php?edicao=false');
            }
        } catch (Exception $e){
            die("Erro ao alterar a categoria: ".$e->getMessage());
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $id = $_POST['id'];
        alterarCategoria($nome, $descricao, $id);
    } else {
        $categoria = consultaCategoria($_GET['id']);
    }

?>

<h2>Alterar Categoria</h2>

<form method="post">

    <input type="hidden" name="id" value="<?= $categoria['id'] ?>" >
                        
    <div class="mb-3">
        <label for="nome" class="form-label">Informe o Nome</label>
        <input value="<?= $categoria['nome'] ?>" type="text" id="nome" name="nome" class="form-control" required="">
    </div>

    <div class="mb-3">
        <label for="descricao" class="form-label">Informe a descrição</label>
        <textarea id="descricao" name="descricao" class="form-control" rows="4" required=""><?= $categoria['descricao'] ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Enviar</button>
</form>


<?php 
    require_once("rodape.php");

?>