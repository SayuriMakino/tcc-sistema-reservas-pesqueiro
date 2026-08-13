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

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

?>