<?php

require_once '../config/conexao.php';

if (!isset($_GET['id'])) {
    die("Cliente não informado.");
}

$id = $_GET['id'];

$sql = "DELETE FROM cliente WHERE id = :id";

$stmt = $conn->prepare($sql);

$stmt->execute([
    ':id' => $id
]);

header("Location: listar.php");
exit;

?>