
<?php

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: ../admin/login.php");
    exit;
}

require_once '../config/conexao.php';
require_once '../models/Reserva.php';

$reserva = new Reserva($conn);

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: listar.php");
    exit;
}

$dados = $reserva->buscarPorId($id);

if (!$dados) {
    header("Location: listar.php");
    exit;
}

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $dataReserva = $_POST["data_reserva"] ?? "";
    $status = $_POST["status"] ?? "";
    $clienteId = $_POST["cliente_id"] ?? "";

    if (
        empty($dataReserva) ||
        empty($clienteId) ||
        !in_array($status, ["Pendente", "Confirmada", "Cancelada"], true)
    ) {

        $mensagem = "Preencha todos os campos corretamente.";

    } else {

        try {

            $reserva->editar(
                $id,
                $dataReserva,
                $status,
                $clienteId
            );

            header("Location: listar.php");
            exit;

        } catch (PDOException $e) {

            $mensagem = "Erro ao atualizar reserva.";

        }

    }

}

$sql = "SELECT id, nome FROM cliente ORDER BY nome";
$stmt = $conn->query($sql);
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Reserva - Vale Verde</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="../css/style.css">

</head>

<body>

<div class="layout">

    <aside class="sidebar">

        <div class="logo">

            <div class="logo-icon">
                <i class="bi bi-water"></i>
            </div>

            <div>
                <strong>Vale Verde</strong>
                <span>Painel Admin</span>
            </div>

        </div>

        <nav class="menu">

            <a href="../admin/dashboard.php" class="menu-item">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>

            <a href="listar.php" class="menu-item active">
                <i class="bi bi-calendar-check"></i>
                <span>Reservas</span>
            </a>

            <a href="../cliente/listar.php" class="menu-item">
                <i class="bi bi-people"></i>
                <span>Clientes</span>
            </a>

            <a href="#" class="menu-item">
                <i class="bi bi-currency-dollar"></i>
                <span>Valores</span>
            </a>

            <a href="../admin/alterar_senha.php" class="menu-item">
                <i class="bi bi-gear"></i>
                <span>Configurações</span>
            </a>

        </nav>

    </aside>

    <main class="content">

        <div class="page-header">

            <div>
                <h1>Editar Reserva</h1>
                <p>Atualize os dados da reserva.</p>
            </div>

        </div>

        <?php if (!empty($mensagem)): ?>

            <div class="auth-message erro">
                <?= htmlspecialchars($mensagem) ?>
            </div>

        <?php endif; ?>

        <div class="settings-card">

            <form method="POST" class="settings-form">

                <div class="form-group">

                    <label for="cliente_id">
                        Cliente
                    </label>

                    <select name="cliente_id" id="cliente_id" required>

                        <option value="">
                            Selecione um cliente
                        </option>

                        <?php foreach ($clientes as $cliente): ?>

                            <option
                                value="<?= $cliente['id'] ?>"
                                <?= $dados['cliente_id'] == $cliente['id'] ? 'selected' : '' ?>
                            >

                                <?= htmlspecialchars($cliente['nome']) ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

                <div class="form-group">

                    <label for="data_reserva">
                        Data da reserva
                    </label>

                    <input
                        type="date"
                        name="data_reserva"
                        id="data_reserva"
                        value="<?= htmlspecialchars($dados['data_reserva']) ?>"
                        required
                    >

                </div>

                <div class="form-group">

                    <label for="status">
                        Status
                    </label>

                    <select name="status" id="status" required>

                        <?php foreach (["Pendente", "Confirmada", "Cancelada"] as $status): ?>

                            <option
                                value="<?= $status ?>"
                                <?= $dados['status'] === $status ? 'selected' : '' ?>
                            >

                                <?= $status ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

                <div class="settings-actions">

                    <button type="submit" class="btn-primary">
                        Salvar alterações
                    </button>

                    <a href="listar.php" class="btn-secondary">
                        Cancelar
                    </a>

                </div>

            </form>

        </div>

    </main>

</div>

</body>
</html>