<?php

include '../config/conexao.php';

echo "<h1>Teste de Conexão</h1>";

if($conn){
    echo "Conexão realizada com sucesso!";
}else{
    echo "Erro na conexão!";
}

?>