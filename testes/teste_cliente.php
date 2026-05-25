<?php

include '../config/conexao.php';

echo "<h1>Teste Unitário - Cliente</h1>";

$sql = "SELECT * FROM cliente";

$stmt = $conn->query($sql);

$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<pre>";
print_r($clientes);
echo "</pre>";

?>