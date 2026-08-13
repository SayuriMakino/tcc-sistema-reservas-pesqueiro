<?php

require_once '../config/conexao.php';

$mensagem = '';
$tipoMensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $login = trim($_POST['login'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (empty($login) || empty($senha)) {

        $mensagem = "Preencha o e-mail e a senha.";
        $tipoMensagem = "erro";
    } else {

        $sql = "SELECT * FROM cliente
                WHERE login = :login
                AND senha = :senha";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':login' => $login,
            ':senha' => $senha
        ]);

        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cliente) {

            session_start();

            $_SESSION['cliente_id'] = $cliente['id'];
            $_SESSION['cliente_nome'] = $cliente['nome'];

            header("Location: area_cliente.php");
            exit;

        } else {

            $mensagem = "E-mail ou senha incorretos.";
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

    <title>Login - SRP</title>

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
                        Reserve sua experiência de pesca online,
                        gerencie suas visitas e aproveite ao máximo
                        nosso pesqueiro.
                    </p>

                </div>


                <div class="auth-benefits">

                    <div class="benefit-card">

                        <div class="benefit-icon">📅</div>

                        <h3>Reservas Online</h3>

                        <p>
                            Reserve sua visita de forma rápida
                            e prática.
                        </p>

                    </div>


                    <div class="benefit-card">

                        <div class="benefit-icon">📋</div>

                        <h3>Histórico</h3>

                        <p>
                            Consulte suas reservas anteriores
                            facilmente.
                        </p>

                    </div>


                    <div class="benefit-card">

                        <div class="benefit-icon">💬</div>

                        <h3>Suporte</h3>

                        <p>
                            Tenha acesso às informações
                            do pesqueiro.
                        </p>

                    </div>


                    <div class="benefit-card">

                        <div class="benefit-icon">⭐</div>

                        <h3>Benefícios</h3>

                        <p>
                            Aproveite todos os recursos
                            disponíveis.
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


                <h2>Bem-vindo de volta!</h2>

                <p class="auth-subtitle">
                    Entre com sua conta para continuar.
                </p>


                <?php if (!empty($mensagem)): ?>

                    <div class="auth-message <?= $tipoMensagem ?>">

                        <?= htmlspecialchars($mensagem) ?>

                    </div>

                <?php endif; ?>


                <form method="POST" class="auth-form">

                    <div class="auth-group">

                        <label for="login">
                            E-mail
                        </label>

                        <input
                            type="email"
                            id="login"
                            name="login"
                            placeholder="seu@email.com"
                            required>

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
                                placeholder="••••••••"
                                required>

                            <span class="password-icon">
                                ◉
                            </span>

                        </div>

                    </div>


                    <a href="#" class="forgot-password">
                        Esqueceu a senha?
                    </a>


                    <button type="submit" class="auth-button">
                        Entrar
                    </button>

                </form>


                <div class="auth-footer">

                    Não tem uma conta?

                    <a href="cadastrar.php">
                        Cadastre-se
                    </a>

                </div>

            </div>

        </section>

    </div>

</body>

</html>