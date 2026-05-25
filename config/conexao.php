<?php

$host = "localhost";
$port = "5432";
$dbname = "srp";
$user = "postgres";
$password = "1234";

try {

    $conn = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbname",
        $user,
        $password
    );

    echo "Conexão realizada com sucesso!";

} catch (PDOException $e) {

    echo "Erro: " . $e->getMessage();
}

?>