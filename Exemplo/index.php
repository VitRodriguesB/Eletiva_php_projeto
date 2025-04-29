<?php

    $idade = 20;
    if ($idade >= 18)
        echo "Você é maior de idade!";
    else {
        echo "Você é menor de idade!";
    }

    echo $idade >= 18 ? "Maior de idade!" : "Menor de idade";

    $nota = 6;
    if ($nota > 6)
        echo "Acima da média!";
    elseif ($nota == 6)
        echo "Na média!";
    else 
        echo "Abaixo da média!";

    $mes = 1;
    switch ($mes){
        case 1:
            echo "Janeiro";
            break;
        case 2:
            echo "Fevereiro";
            break;
        default:
            echo "Nenhuma das opções!";
    }

    $i = 1;
    while($i<=10){
        echo "$i<br/>";
        $valor = 10 + $i++;
    }

    $i = 1;
    do {
        echo "$i<br/>";
        $i++;
    } while ($i<=10);

    for ($i=0; $i<10; $i++){
        echo "$i<br/>";
    }
    