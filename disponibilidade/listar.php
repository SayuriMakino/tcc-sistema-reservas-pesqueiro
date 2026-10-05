<?php

session_start();

/*
|--------------------------------------------------------------------------
| Verifica login
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['cliente_id']) && !isset($_SESSION['admin_id'])) {
    header("Location: ../cliente/login.php");
    exit;
}

require_once '../config/conexao.php';

$ehCliente = isset($_SESSION['cliente_id']);
$ehAdmin = isset($_SESSION['admin_id']);


/*
|--------------------------------------------------------------------------
| Mês exibido no calendário
|--------------------------------------------------------------------------
*/

$mesAtual = isset($_GET['mes']) ? (int) $_GET['mes'] : (int) date('m');
$anoAtual = isset($_GET['ano']) ? (int) $_GET['ano'] : (int) date('Y');


/*
|--------------------------------------------------------------------------
| Corrige mês/ano caso necessário
|--------------------------------------------------------------------------
*/

if ($mesAtual < 1) {
    $mesAtual = 12;
    $anoAtual--;
}

if ($mesAtual > 12) {
    $mesAtual = 1;
    $anoAtual++;
}


/*
|--------------------------------------------------------------------------
| Primeiro e último dia do mês
|--------------------------------------------------------------------------
*/

$primeiroDia = new DateTime(
    sprintf('%04d-%02d-01', $anoAtual, $mesAtual)
);

$ultimoDia = clone $primeiroDia;
$ultimoDia->modify('last day of this month');


/*
|--------------------------------------------------------------------------
| Busca reservas do mês
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT data_reserva, COUNT(*) AS total
    FROM reserva
    WHERE data_reserva BETWEEN :inicio AND :fim
    GROUP BY data_reserva
    ORDER BY data_reserva
";

$stmt = $conn->prepare($sql);

$stmt->execute([
    ':inicio' => $primeiroDia->format('Y-m-d'),
    ':fim' => $ultimoDia->format('Y-m-d')
]);

$reservas = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $reservas[$row['data_reserva']] = (int) $row['total'];
};


/*
|--------------------------------------------------------------------------
| Busca disponibilidade do mês
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT data, status
    FROM disponibilidade
    WHERE data BETWEEN :inicio AND :fim
";

$stmt = $conn->prepare($sql);

$stmt->execute([
    ':inicio' => $primeiroDia->format('Y-m-d'),
    ':fim' => $ultimoDia->format('Y-m-d')
]);

$disponibilidades = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $disponibilidades[$row['data']] = (bool) $row['status'];
}


/*
|--------------------------------------------------------------------------
| Nome dos meses
|--------------------------------------------------------------------------
*/

$meses = [
    1 => 'Janeiro',
    2 => 'Fevereiro',
    3 => 'Março',
    4 => 'Abril',
    5 => 'Maio',
    6 => 'Junho',
    7 => 'Julho',
    8 => 'Agosto',
    9 => 'Setembro',
    10 => 'Outubro',
    11 => 'Novembro',
    12 => 'Dezembro'
];


/*
|--------------------------------------------------------------------------
| Dias da semana
|--------------------------------------------------------------------------
*/

$diasSemana = [
    1 => 'SEG',
    2 => 'TER',
    3 => 'QUA',
    4 => 'QUI',
    5 => 'SEX',
    6 => 'SÁB',
    7 => 'DOM'
];


/*
|--------------------------------------------------------------------------
| Descobre o dia da semana do primeiro dia do mês
|--------------------------------------------------------------------------
|
| ISO-8601:
| 1 = Segunda
| 7 = Domingo
|
*/

$diaSemanaInicio = (int) $primeiroDia->format('N');

$quantidadeDias = (int) $ultimoDia->format('d');


/*
|--------------------------------------------------------------------------
| Mês anterior
|--------------------------------------------------------------------------
*/

$mesAnterior = $mesAtual - 1;
$anoAnterior = $anoAtual;

if ($mesAnterior < 1) {
    $mesAnterior = 12;
    $anoAnterior--;
}


/*
|--------------------------------------------------------------------------
| Próximo mês
|--------------------------------------------------------------------------
*/

$mesProximo = $mesAtual + 1;
$anoProximo = $anoAtual;

if ($mesProximo > 12) {
    $mesProximo = 1;
    $anoProximo++;
}


/*
|--------------------------------------------------------------------------
| Data de hoje
|--------------------------------------------------------------------------
*/

$hoje = date('Y-m-d');

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Disponibilidade - Vale Verde</title>

    <link
        rel="stylesheet"
        href="../css/style.css">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>

    <div class="disponibilidade-page">


        <!-- =====================================================
         CABEÇALHO
    ====================================================== -->

        <?php if ($ehCliente): ?>

            <header class="cliente-header">

                <div class="cliente-logo">

                    <span>
                        <i class="bi bi-water"></i>
                    </span>

                    <div>

                        <h1>Vale Verde</h1>

                        <p>Sistema de Reservas</p>

                    </div>

                </div>


                <a
                    href="../cliente/area_cliente.php"
                    class="cliente-sair">

                    <i class="bi bi-arrow-left"></i>

                    Voltar

                </a>

            </header>

        <?php else: ?>

            <header class="cliente-header">

                <div class="cliente-logo">

                    <span>
                        <i class="bi bi-water"></i>
                    </span>

                    <div>

                        <h1>Vale Verde</h1>

                        <p>Painel Admin</p>

                    </div>

                </div>


                <a
                    href="../admin/dashboard.php"
                    class="cliente-sair">

                    <i class="bi bi-arrow-left"></i>

                    Voltar

                </a>

            </header>

        <?php endif; ?>


        <!-- =====================================================
         CONTEÚDO
    ====================================================== -->

        <main class="disponibilidade-content">


            <div class="disponibilidade-header">

                <?php if ($ehAdmin): ?>

                    <h1>Gerenciar Disponibilidade</h1>

                    <p>
                        Defina quais datas estarão disponíveis para novas reservas.
                    </p>

                <?php else: ?>

                    <h1>Disponibilidade</h1>

                    <p>
                        Consulte as datas disponíveis para realizar sua reserva.
                    </p>

                <?php endif; ?>

            </div>


            <!-- =================================================
             INFORMAÇÃO
        ================================================== -->

            <div class="disponibilidade-info">

                <i class="bi bi-info-circle"></i>

                <?php if ($ehAdmin): ?>

                    <span>
                        Clique em uma data disponível para fechá-la
                        ou em uma data fechada para reabri-la.
                    </span>

                <?php else: ?>

                    <span>
                        As datas disponíveis estão indicadas em verde.
                        Não há limite de reservas por dia.
                    </span>

                <?php endif; ?>

            </div>


            <!-- =================================================
             CALENDÁRIO
        ================================================== -->

            <div class="calendario-container">


                <!-- CABEÇALHO DO CALENDÁRIO -->

                <div class="calendario-header">

                    <a
                        href="?mes=<?= $mesAnterior ?>&ano=<?= $anoAnterior ?>"
                        class="calendario-navegacao"
                        title="Mês anterior">

                        <i class="bi bi-chevron-left"></i>

                    </a>


                    <div class="calendario-titulo">

                        <h2>
                            <?= $meses[$mesAtual] ?>
                        </h2>

                        <span>
                            <?= $anoAtual ?>
                        </span>

                    </div>


                    <a
                        href="?mes=<?= $mesProximo ?>&ano=<?= $anoProximo ?>"
                        class="calendario-navegacao"
                        title="Próximo mês">

                        <i class="bi bi-chevron-right"></i>

                    </a>

                </div>


                <!-- DIAS DA SEMANA -->

                <div class="calendario-semana">

                    <?php foreach ($diasSemana as $dia): ?>

                        <div>
                            <?= $dia ?>
                        </div>

                    <?php endforeach; ?>

                </div>


                <!-- DIAS -->

                <div class="calendario-grid">


                    <!-- ESPAÇOS ANTES DO PRIMEIRO DIA -->

                    <?php for ($i = 1; $i < $diaSemanaInicio; $i++): ?>

                        <div class="calendario-dia vazio"></div>

                    <?php endfor; ?>


                    <!-- DIAS DO MÊS -->

                    <?php for ($dia = 1; $dia <= $quantidadeDias; $dia++): ?>

                        <?php

                        $dataAtual = sprintf(
                            '%04d-%02d-%02d',
                            $anoAtual,
                            $mesAtual,
                            $dia
                        );

                        $totalReservas = $reservas[$dataAtual] ?? 0;

                        $disponivel = $disponibilidades[$dataAtual] ?? true;

                        $timestamp = strtotime($dataAtual);

                        $diaDaSemana = (int) date('N', $timestamp);

                        $ehPassado = $dataAtual < $hoje;

                        $ehHoje = $dataAtual === $hoje;

                        ?>


                        <div
                            class="
                            calendario-dia
                            <?= $ehHoje ? 'hoje' : '' ?>
                            <?= $ehPassado ? 'passado' : '' ?>
                        ">

                            <div class="calendario-dia-numero">

                                <?= $dia ?>

                                <?php if ($ehHoje): ?>

                                    <span class="calendario-hoje">
                                        Hoje
                                    </span>

                                <?php endif; ?>

                            </div>


                            <?php if (!$ehPassado): ?>

                                <?php if ($disponivel): ?>

                                    <div class="calendario-disponivel">
                                        <i class="bi bi-check-circle"></i>
                                        Disponível
                                    </div>

                                <?php else: ?>

                                    <div class="calendario-indisponivel">
                                        <i class="bi bi-x-circle"></i>
                                        Indisponível
                                    </div>

                                <?php endif; ?>


                                <?php if ($totalReservas == 0): ?>

                                    <div class="calendario-reservas">

                                        Nenhuma reserva

                                    </div>

                                <?php elseif ($totalReservas == 1): ?>

                                    <div class="calendario-reservas">

                                        <i class="bi bi-people"></i>

                                        1 reserva

                                    </div>

                                <?php else: ?>

                                    <div class="calendario-reservas">

                                        <i class="bi bi-people"></i>

                                        <?= $totalReservas ?>

                                        reservas

                                    </div>

                                <?php endif; ?>


                                <?php if ($ehCliente): ?>

                                    <?php if ($disponivel): ?>

                                        <a
                                            href="../reserva/cadastrar.php?data=<?= $dataAtual ?>"
                                            class="calendario-botao">
                                            <i class="bi bi-calendar-plus"></i>
                                            Reservar
                                        </a>

                                    <?php else: ?>

                                        <div class="calendario-botao calendario-botao-indisponivel">
                                            <i class="bi bi-x-circle"></i>
                                            Indisponível
                                        </div>

                                    <?php endif; ?>

                                <?php else: ?>

                                    <?php if ($disponivel): ?>

                                        <a
                                            href="alterar.php?data=<?= $dataAtual ?>"
                                            class="calendario-botao calendario-botao-fechar"
                                            onclick="return confirm('Deseja fechar esta data para novas reservas?');">
                                            <i class="bi bi-lock"></i>
                                            Fechar data
                                        </a>

                                    <?php else: ?>

                                        <a
                                            href="alterar.php?data=<?= $dataAtual ?>"
                                            class="calendario-botao calendario-botao-abrir"
                                            onclick="return confirm('Deseja reabrir esta data para reservas?');">
                                            <i class="bi bi-unlock"></i>
                                            Abrir data
                                        </a>

                                    <?php endif; ?>

                                <?php endif; ?>


                            <?php else: ?>

                                <div class="calendario-passado">

                                    Data passada

                                </div>

                            <?php endif; ?>

                        </div>

                    <?php endfor; ?>


                </div>


                <!-- LEGENDA -->

                <div class="calendario-legenda">

                    <div>

                        <span class="legenda-ponto disponivel"></span>

                        Data disponível

                    </div>


                    <div>

                        <span class="legenda-ponto hoje"></span>

                        Hoje

                    </div>


                    <div>

                        <i class="bi bi-people"></i>

                        Quantidade de reservas

                    </div>

                </div>


            </div>

        </main>

    </div>

</body>

</html>