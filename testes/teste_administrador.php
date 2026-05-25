<?php

include '../config/conexao.php';

echo "<h1>Teste Unitário - Administrador</h1>";

$sql = "SELECT * FROM administrador";

$stmt = $conn->query($sql);

$admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<pre>";
print_r($admins);
echo "</pre>";

?>