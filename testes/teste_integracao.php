<?php

include '../config/conexao.php';

echo "<h1>Teste de Integração</h1>";

$sql = "
SELECT
    cliente.nome,
    reserva.data_reserva,
    reserva.status
FROM reserva
INNER JOIN cliente
ON cliente.id = reserva.cliente_id
";

$stmt = $conn->query($sql);

$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<pre>";
print_r($dados);
echo "</pre>";

?>