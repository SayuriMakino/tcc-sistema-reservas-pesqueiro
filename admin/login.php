<?php

session_start();

require_once '../config/conexao.php';

$mensagem = '';
$tipoMensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $login = trim($_POST['login'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (empty($login) || empty($senha)) {

        $mensagem = "Preencha o login e a senha.";
        $tipoMensagem = "erro";

    } else {

        $sql = "SELECT *
                FROM administrador
                WHERE login = :login";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':login' => $login
        ]);

        $administrador = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($administrador && password_verify($senha, $administrador['senha'])) {

            $_SESSION['admin_id'] = $administrador['id'];
            $_SESSION['admin_nome'] = $administrador['nome'];

            header("Location: dashboard.php");
            exit;

        } else {

            $mensagem = "Login ou senha incorretos.";
            $tipoMensagem = "erro";

        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login do Administrador - SRP</title>

    <link rel="stylesheet" href="../css/style.css">

</head>

<body>

<div class="auth-page">

    <section class="auth-left">

        <div class="auth-left-content">

            <div class="auth-logo">

                <div class="auth-logo-icon">
                    🎣
                </div>

                <h1>Pesqueiro Recanto Verde</h1>

                <p>
                    Área administrativa do sistema
                    de reservas.
                </p>

            </div>


            <div class="auth-benefits">

                <div class="benefit-card">

                    <div class="benefit-icon">
                        📅
                    </div>

                    <h3>Reservas</h3>

                    <p>
                        Gerencie as reservas realizadas
                        pelos clientes.
                    </p>

                </div>


                <div class="benefit-card">

                    <div class="benefit-icon">
                        👥
                    </div>

                    <h3>Clientes</h3>

                    <p>
                        Consulte e gerencie os clientes
                        cadastrados.
                    </p>

                </div>

            </div>

        </div>

    </section>


    <section class="auth-right">

        <div class="auth-form-container">

            <a href="../index.php" class="auth-back">
                ← Voltar ao site
            </a>


            <h2>Área administrativa</h2>

            <p class="auth-subtitle">
                Entre com suas credenciais para continuar.
            </p>


            <?php if (!empty($mensagem)): ?>

                <div class="auth-message <?= $tipoMensagem ?>">

                    <?= htmlspecialchars($mensagem) ?>

                </div>

            <?php endif; ?>


            <form method="POST" class="auth-form">

                <div class="auth-group">

                    <label for="login">
                        Login
                    </label>

                    <input
                        type="text"
                        id="login"
                        name="login"
                        placeholder="Digite seu login"
                        required
                    >

                </div>


                <div class="auth-group">

                    <label for="senha">
                        Senha
                    </label>

                    <div class="password-container">

                        <input
                            type="password"
                            id="senha"
                            name="senha"
                            placeholder="Digite sua senha"
                            required
                        >

                    </div>

                </div>


                <button type="submit" class="auth-button">
                    Entrar
                </button>

            </form>

        </div>

    </section>

</div>

</body>

</html>