<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemplo arrays</title>
</head>
<body>
    
    <form action="exemplo_array.php" method="post">
        <?php for($i=0; $i<10; $i++): ?>
            <input type="number" name="valor[]" 
                placeholder="Informe o valor <?= $i ?>"/>
        <?php endfor; ?>
        <button type="submit">Enviar </button>

        <?php 
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                try {
                    $valores = $_POST['valor'];
                    echo "O primeiro valor é: ".$valores[0];
                    echo "<br/>";
                    print_r($valores);
                    $valores['texto'] = 'dados';
                    unset($valores['texto']);
                    echo "<br/>";
                    foreach ($valores as $c => $v){
                        echo "<p>Posição: $c - Valor: $v</p>";
                    }
                    $array = [10, 11, 12, 13];
                    $array2 = array("uva", "maça", "pêra");
                    $array3 = [
                        "uva" => 3,
                        "maçã" => 4,
                        "pêra" => 5
                    ];
                } catch (Exception $e){
                    echo $e->getMessage();
                }
            }
        ?>
    </form>

</body>
</html>