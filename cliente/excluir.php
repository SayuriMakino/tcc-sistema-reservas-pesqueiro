<?php

require_once '../config/conexao.php';

if (!isset($_GET['id'])) {
    die("Cliente não informado.");
}

$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

if (!$id) {
    die("Cliente inválido.");
}

try {

    $conn->beginTransaction();

    $stmt = $conn->prepare("DELETE FROM reserva WHERE cliente_id = :id");
    $stmt->execute([':id' => $id]);

    $stmt = $conn->prepare("DELETE FROM cliente WHERE id = :id");
    $stmt->execute([':id' => $id]);

    $conn->commit();

} catch (PDOException $e) {

    if ($conn->inTransaction()) {
        $conn->rollBack();
    }

    die("Erro ao excluir cliente.");
}

header("Location: listar.php");
exit;

?>