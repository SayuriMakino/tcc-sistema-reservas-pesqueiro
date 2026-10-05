<?php

session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/login.php");
    exit;
}

require_once '../config/conexao.php';

$data = $_GET['data'] ?? '';

if (empty($data)) {
    header("Location: listar.php");
    exit;
}

// Não permite alterar datas passadas
if ($data < date('Y-m-d')) {
    header("Location: listar.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| Verifica se a data já possui configuração
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT
        id,
        CASE
            WHEN status = TRUE THEN 1
            ELSE 0
        END AS status
    FROM disponibilidade
    WHERE data = :data
";

$stmt = $conn->prepare($sql);

$stmt->execute([
    ':data' => $data
]);

$configuracao = $stmt->fetch(PDO::FETCH_ASSOC);


/*
|--------------------------------------------------------------------------
| Se a data já existe, inverte o status
|--------------------------------------------------------------------------
*/

if ($configuracao) {

    $novoStatus = ((int) $configuracao['status'] === 1)
        ? false
        : true;

    $sql = "
        UPDATE disponibilidade
        SET status = :status
        WHERE id = :id
    ";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':status' => $novoStatus,
        ':id' => $configuracao['id']
    ]);

} else {

    /*
    |--------------------------------------------------------------------------
    | Se a data ainda não existe, cria como indisponível
    |--------------------------------------------------------------------------
    */

    $sql = "
        INSERT INTO disponibilidade (data, status)
        VALUES (:data, FALSE)
    ";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':data' => $data
    ]);
}


/*
|--------------------------------------------------------------------------
| Volta para o mês da data alterada
|--------------------------------------------------------------------------
*/

$mes = date('m', strtotime($data));
$ano = date('Y', strtotime($data));

header("Location: listar.php?mes={$mes}&ano={$ano}");
exit;