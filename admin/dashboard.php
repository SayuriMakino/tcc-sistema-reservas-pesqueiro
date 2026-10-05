<?php

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

$nomeAdmin = $_SESSION["admin_nome"];

require_once '../config/conexao.php';

$totalReservas = (int) $conn->query("SELECT COUNT(*) FROM reserva")->fetchColumn();
$totalClientes = (int) $conn->query("SELECT COUNT(*) FROM cliente")->fetchColumn();

$stmt = $conn->prepare("SELECT COUNT(*) FROM reserva WHERE LOWER(TRIM(status)) = 'pendente'");
$stmt->execute();
$reservasPendentes = (int) $stmt->fetchColumn();

$stmt = $conn->prepare("SELECT COUNT(*) FROM reserva WHERE LOWER(TRIM(status)) = 'confirmada'");
$stmt->execute();
$reservasConfirmadas = (int) $stmt->fetchColumn();

$stmt = $conn->prepare("SELECT COUNT(*) FROM reserva WHERE LOWER(TRIM(status)) = 'confirmada' AND EXTRACT(MONTH FROM data_reserva) = EXTRACT(MONTH FROM CURRENT_DATE) AND EXTRACT(YEAR FROM data_reserva) = EXTRACT(YEAR FROM CURRENT_DATE)");
$stmt->execute();
$confirmadasMes = (int) $stmt->fetchColumn();

$baseStatus = $reservasConfirmadas + $reservasPendentes;
$percentConfirmadas = $baseStatus > 0 ? round(($reservasConfirmadas / $baseStatus) * 100) : 0;
$percentPendentes = $baseStatus > 0 ? round(($reservasPendentes / $baseStatus) * 100) : 0;

// Relatório exibido no próprio dashboard
$dataInicial = $_GET['data_inicial'] ?? '';
$dataFinal = $_GET['data_final'] ?? '';
$statusFiltro = $_GET['status'] ?? '';
$where = [];
$params = [];

if ($dataInicial !== '') {
    $where[] = 'r.data_reserva >= :data_inicial';
    $params[':data_inicial'] = $dataInicial;
}
if ($dataFinal !== '') {
    $where[] = 'r.data_reserva <= :data_final';
    $params[':data_final'] = $dataFinal;
}
if ($statusFiltro !== '') {
    $where[] = 'r.status = :status';
    $params[':status'] = $statusFiltro;
}

$whereSQL = empty($where) ? '' : 'WHERE ' . implode(' AND ', $where);

$sqlRelatorio = "SELECT r.id, r.data_reserva, r.status, c.nome, c.telefone FROM reserva r INNER JOIN cliente c ON c.id = r.cliente_id $whereSQL ORDER BY r.data_reserva DESC";
$stmtRelatorio = $conn->prepare($sqlRelatorio);
$stmtRelatorio->execute($params);
$reservasRelatorio = $stmtRelatorio->fetchAll(PDO::FETCH_ASSOC);

$totalRelatorio = count($reservasRelatorio);
$pendentesRelatorio = 0;
$confirmadasRelatorio = 0;
$canceladasRelatorio = 0;

foreach ($reservasRelatorio as $item) {
    $status = strtolower(trim($item['status']));
    if ($status === 'pendente') $pendentesRelatorio++;
    elseif ($status === 'confirmada') $confirmadasRelatorio++;
    elseif ($status === 'cancelada') $canceladasRelatorio++;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - Pesqueiro Recanto Verde</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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

                <a href="dashboard.php" class="menu-item active">

                    <i class="bi bi-grid"></i>

                    <span>Dashboard</span>

                </a>


                <a href="../reserva/listar.php" class="menu-item">

                    <i class="bi bi-calendar-check"></i>

                    <span>Reservas</span>

                </a>


                <a href="../disponibilidade/listar.php" class="sidebar-link">
                    <i class="bi bi-calendar3"></i>
                    <span>Disponibilidade</span>
                </a>


                <a href="../cliente/listar.php" class="menu-item">

                    <i class="bi bi-people"></i>

                    <span>Clientes</span>

                </a>

                <a href="#relatorios" class="menu-item">

                    <i class="bi bi-bar-chart"></i>

                    <span>Relatórios</span>

                </a>


                <a href="#" class="menu-item">

                    <i class="bi bi-currency-dollar"></i>

                    <span>Valores</span>

                </a>


                <a href="alterar_senha.php" class="menu-item">

                    <i class="bi bi-gear"></i>

                    <span>Configurações</span>

                </a>

            </nav>


            <div class="admin-area">

                <div class="admin-avatar">

                    <i class="bi bi-person"></i>

                </div>


                <div class="admin-info">

                    <strong>
                        <?= htmlspecialchars($nomeAdmin) ?>
                    </strong>

                    <span>Administrador</span>

                </div>


                <a href="logout.php" class="logout">

                    <i class="bi bi-box-arrow-right"></i>

                </a>

            </div>

        </aside>

        <main class="content">


            <div class="page-header">

                <div>

                    <h1>Dashboard</h1>

                    <p>
                        Visão geral do Pesqueiro Recanto Verde
                    </p>

                </div>

            </div>

            <div class="cards">


                <div class="card-dashboard">

                    <div class="card-icon">

                        <i class="bi bi-calendar-check"></i>

                    </div>

                    <div>

                        <span>Total de Reservas</span>

                        <h2><?= $totalReservas ?></h2>

                        <small class="positive">

                            <i class="bi bi-arrow-up"></i>

                            <?= $confirmadasMes ?> confirmadas este mês

                        </small>

                    </div>

                </div>



                <div class="card-dashboard">

                    <div class="card-icon">

                        <i class="bi bi-people"></i>

                    </div>

                    <div>

                        <span>Clientes</span>

                        <h2><?= $totalClientes ?></h2>

                        <small>

                            Clientes cadastrados

                        </small>

                    </div>

                </div>



                <div class="card-dashboard">

                    <div class="card-icon">

                        <i class="bi bi-calendar-event"></i>

                    </div>

                    <div>

                        <span>Reservas Pendentes</span>

                        <h2><?= $reservasPendentes ?></h2>

                        <small>

                            Aguardando confirmação

                        </small>

                    </div>

                </div>



                <div class="card-dashboard">

                    <div class="card-icon">

                        <i class="bi bi-calendar2-check"></i>

                    </div>

                    <div>

                        <span>Reservas Confirmadas</span>

                        <h2><?= $reservasConfirmadas ?></h2>

                        <small>

                            Este mês

                        </small>

                    </div>

                </div>


            </div>


            <div class="dashboard-grid">

                <div class="panel">


                    <div class="panel-header">

                        <div>

                            <h3>Reservas Recentes</h3>

                            <span>
                                Últimas reservas realizadas
                            </span>

                        </div>

                    </div>


                    <div class="table-responsive">

                        <table class="table">

                            <thead>

                                <tr>

                                    <th>Cliente</th>

                                    <th>Data</th>

                                    <th>Status</th>

                                </tr>

                            </thead>


                            <tbody>

                                <?php if (empty($reservasRelatorio)): ?>
                                    <tr>
                                        <td colspan="3" style="text-align:center; padding:30px; color:var(--muted);">Nenhuma reserva encontrada.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach (array_slice($reservasRelatorio, 0, 5) as $reserva): ?>
                                        <?php $status = strtolower(trim($reserva['status'])); ?>
                                        <tr>
                                            <td><?= htmlspecialchars($reserva['nome']) ?></td>
                                            <td><?= date('d/m/Y', strtotime($reserva['data_reserva'])) ?></td>
                                            <td>
                                                <?php if ($status === 'confirmada'): ?>
                                                    <span class="status confirmed">Confirmada</span>
                                                <?php elseif ($status === 'cancelada'): ?>
                                                    <span class="status cancelada">Cancelada</span>
                                                <?php else: ?>
                                                    <span class="status pending">Pendente</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </tbody>

                        </table>

                    </div>


                </div>


                <div class="panel">


                    <div class="panel-header">

                        <div>

                            <h3>Resumo</h3>

                            <span>
                                Informações do sistema
                            </span>

                        </div>

                    </div>


                    <div class="distribution">


                        <div class="distribution-item">

                            <div class="distribution-title">

                                <span>Reservas confirmadas</span>

                                <strong><?= $percentConfirmadas ?>%</strong>

                            </div>


                            <div class="progress">

                                <div
                                    class="progress-bar"
                                    style="width: <?= $percentConfirmadas ?>%"></div>

                            </div>

                        </div>



                        <div class="distribution-item">

                            <div class="distribution-title">

                                <span>Reservas pendentes</span>

                                <strong><?= $percentPendentes ?>%</strong>

                            </div>


                            <div class="progress">

                                <div
                                    class="progress-bar"
                                    style="width: <?= $percentPendentes ?>%"></div>

                            </div>

                        </div>


                    </div>


                    <div class="mini-cards">


                        <div>

                            <span>Clientes</span>

                            <strong><?= $totalClientes ?></strong>

                        </div>


                        <div>

                            <span>Reservas</span>

                            <strong><?= $totalReservas ?></strong>

                        </div>


                    </div>


                </div>


            </div>


            <section id="relatorios" class="relatorio-dashboard">

                <div class="panel">

                    <div class="panel-header">
                        <div>
                            <h3>Relatório de Reservas</h3>
                            <span>Consulte as reservas realizadas no pesqueiro</span>
                        </div>
                        <span><?= $totalRelatorio ?> registro(s)</span>
                    </div>

                    <form method="GET" class="relatorio-dashboard-filtros">
                        <div>
                            <label for="data_inicial">Data inicial</label>
                            <input type="date" name="data_inicial" id="data_inicial" value="<?= htmlspecialchars($dataInicial) ?>">
                        </div>
                        <div>
                            <label for="data_final">Data final</label>
                            <input type="date" name="data_final" id="data_final" value="<?= htmlspecialchars($dataFinal) ?>">
                        </div>
                        <div>
                            <label for="status">Status</label>
                            <select name="status" id="status">
                                <option value="">Todos</option>
                                <option value="Pendente" <?= $statusFiltro === 'Pendente' ? 'selected' : '' ?>>Pendente</option>
                                <option value="Confirmada" <?= $statusFiltro === 'Confirmada' ? 'selected' : '' ?>>Confirmada</option>
                                <option value="Cancelada" <?= $statusFiltro === 'Cancelada' ? 'selected' : '' ?>>Cancelada</option>
                            </select>
                        </div>
                        <div class="relatorio-dashboard-botoes">
                            <button type="submit" class="btn-primary"><i class="bi bi-bar-chart"></i> Gerar relatório</button>
                            <a href="dashboard.php#relatorios" class="btn-secondary"><i class="bi bi-arrow-counterclockwise"></i> Limpar</a>
                        </div>
                    </form>

                    <div class="relatorio-resumo">
                        <div><span>Total</span><strong><?= $totalRelatorio ?></strong></div>
                        <div><span>Pendentes</span><strong><?= $pendentesRelatorio ?></strong></div>
                        <div><span>Confirmadas</span><strong><?= $confirmadasRelatorio ?></strong></div>
                        <div><span>Canceladas</span><strong><?= $canceladasRelatorio ?></strong></div>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Cliente</th>
                                    <th>Telefone</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($reservasRelatorio)): ?>
                                    <tr>
                                        <td colspan="4" class="relatorio-vazio-dashboard"><i class="bi bi-inbox"></i> Nenhuma reserva encontrada.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($reservasRelatorio as $reserva): ?>
                                        <?php $status = strtolower(trim($reserva['status'])); ?>
                                        <tr>
                                            <td><?= date('d/m/Y', strtotime($reserva['data_reserva'])) ?></td>
                                            <td><strong><?= htmlspecialchars($reserva['nome']) ?></strong></td>
                                            <td><?= htmlspecialchars($reserva['telefone']) ?></td>
                                            <td>
                                                <?php if ($status === 'confirmada'): ?>
                                                    <span class="status confirmed">Confirmada</span>
                                                <?php elseif ($status === 'cancelada'): ?>
                                                    <span class="status cancelada">Cancelada</span>
                                                <?php else: ?>
                                                    <span class="status pending">Pendente</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>

            </section>

        </main>

    </div>

</body>

</html>