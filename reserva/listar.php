
<?php

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: ../admin/login.php");
    exit;
}

require_once '../config/conexao.php';
require_once '../models/Reserva.php';

$reserva = new Reserva($conn);

$reservas = $reserva->listar();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reservas - Vale Verde</title>

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

                <h1>Reservas</h1>

                <p>
                    Gerencie as reservas do Pesqueiro Vale Verde.
                </p>

            </div>

            <a href="cadastrar.php" class="btn-primary">
                + Nova reserva
            </a>

        </div>

        <div class="panel recent-panel">

            <div class="panel-header">

                <div>

                    <h3>Reservas cadastradas</h3>

                    <span>
                        Lista de reservas do sistema
                    </span>

                </div>

            </div>

            <div class="table-responsive">

                <table class="table">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Data</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php if (count($reservas) > 0): ?>

                            <?php foreach ($reservas as $item): ?>

                                <tr>

                                    <td>
                                        <?= htmlspecialchars($item['id']) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($item['cliente_nome']) ?>
                                    </td>

                                    <td>
                                        <?= date(
                                            'd/m/Y',
                                            strtotime($item['data_reserva'])
                                        ) ?>
                                    </td>

                                    <td>

                                        <?php

                                        $classeStatus = strtolower(
                                            $item['status']
                                        );

                                        ?>

                                        <span class="status <?= htmlspecialchars($classeStatus) ?>">

                                            <?= htmlspecialchars($item['status']) ?>

                                        </span>

                                    </td>

                                    <td>

                                        <a
                                            href="editar.php?id=<?= $item['id'] ?>"
                                            class="btn-edit"
                                        >
                                            Editar
                                        </a>

                                        <form
                                            action="excluir.php"
                                            method="POST"
                                            style="display: inline;"
                                            onsubmit="return confirm('Tem certeza que deseja excluir esta reserva?')"
                                        >

                                            <input
                                                type="hidden"
                                                name="id"
                                                value="<?= $item['id'] ?>"
                                            >

                                            <button
                                                type="submit"
                                                class="btn-delete"
                                            >
                                                Excluir
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>

                                <td colspan="5">
                                    Nenhuma reserva cadastrada.
                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </main>

</div>

</body>
</html>