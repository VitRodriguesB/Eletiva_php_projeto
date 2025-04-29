<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercício 1</title>
</head>
<body>
    <form action="" method="POST">
        <?php for($i=0;$i<5;$i++): ?> 
            <input type="text" name="nome[]" placeholder="Nome"/>
            <input type="number" name="tel[]" placeholder="Telefone"/>
            <br/>
        <?php endfor; ?>
        <button type="submit">Enviar</button>
    </form>

    <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST"){
            try{
                $a = array();
                $nome = $_POST['nome'];
                $tel = $_POST['tel'];
                for($i=0;$i<5;$i++){
                    $posicao = $nome[$i];
                    $a[$posicao] = $tel[$i];
                }
            } catch (Exception $e){
                echo $e->getMessage();
            }
        }
    ?>
</body>
</html>