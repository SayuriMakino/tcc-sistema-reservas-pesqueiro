<?php

include '../config/conexao.php';

echo "<h1>Teste Unitário - Disponibilidade</h1>";

$sql = "SELECT * FROM disponibilidade";

$stmt = $conn->query($sql);

$disponibilidades = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<pre>";
print_r($disponibilidades);
echo "</pre>";

?>