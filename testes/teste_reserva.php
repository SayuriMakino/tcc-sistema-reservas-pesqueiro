<?php

include '../config/conexao.php';

echo "<h1>Teste Unitário - Reserva</h1>";

$sql = "SELECT * FROM reserva";

$stmt = $conn->query($sql);

$reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<pre>";
print_r($reservas);
echo "</pre>";

?>