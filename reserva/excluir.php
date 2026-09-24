
<?php

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: ../admin/login.php");
    exit;
}

require_once '../config/conexao.php';
require_once '../models/Reserva.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: listar.php");
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: listar.php");
    exit;
}

$reserva = new Reserva($conn);

try {

    $reserva->excluir($id);

} catch (PDOException $e) {


}

header("Location: listar.php");
exit;

?>