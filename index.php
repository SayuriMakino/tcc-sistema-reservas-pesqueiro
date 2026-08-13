<?php

$imagemPesqueiro = 'arquivos/img.jpg';

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pesqueiro Recanto Verde</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>


    <!-- =========================
     NAVBAR
========================= -->

    <header class="site-header">

        <div class="site-logo">

            <div class="logo-icon">
                🎣
            </div>

            <div>
                <strong>Pesqueiro Recanto Verde</strong>
                <span>Pesque, relaxe e aproveite</span>
            </div>

        </div>


        <nav class="site-nav">

            <a href="#inicio">Início</a>

            <a href="#sobre">Sobre</a>

            <a href="#servicos">Serviços</a>

            <a href="#precos">Preços</a>

            <a href="#contato">Contato</a>

        </nav>


        <div class="nav-actions">

            <a href="cliente/login.php" class="nav-login">
                Entrar
            </a>

            <a href="cliente/cadastrar.php" class="nav-register">
                Criar conta
            </a>

        </div>

    </header>


    <!-- =========================
     HERO
========================= -->

    <section
        class="hero-section"
        id="inicio"
        style="
        background-image:
        linear-gradient(
            rgba(8, 48, 35, 0.55),
            rgba(8, 48, 35, 0.65)
        ),
        url('<?= $imagemPesqueiro ?>');
    ">

        <div class="hero-content">

            <span class="hero-label">
                ✦ PESQUEIRO • NATUREZA • LAZER
            </span>

            <h1>
                Pesque, relaxe e
                <span>aproveite a natureza.</span>
            </h1>

            <p>
                Um lugar especial para você descansar,
                pescar e aproveitar momentos inesquecíveis
                com quem você ama.
            </p>


            <div class="hero-actions">

                <a href="cliente/login.php" class="button-primary">
                    Reservar agora
                    <span>→</span>
                </a>

                <a href="#sobre" class="button-outline">
                    Conheça o pesqueiro
                </a>

            </div>

        </div>


        <div class="hero-info">

            <div>
                <strong>500+</strong>
                <span>Clientes</span>
            </div>

            <div>
                <strong>12</strong>
                <span>Anos de experiência</span>
            </div>

            <div>
                <strong>4.9 ★</strong>
                <span>Avaliação</span>
            </div>

        </div>

    </section>


    <!-- =========================
     SOBRE
========================= -->

    <section class="about-section" id="sobre">

        <div class="section-tag">
            SOBRE NÓS
        </div>

        <h2>
            Um refúgio verde para
            <span>viver bons momentos.</span>
        </h2>

        <p class="section-description">

            No Pesqueiro Recanto Verde você encontra
            tranquilidade, natureza e diversão em um
            só lugar. Nosso espaço foi pensado para
            proporcionar uma experiência agradável
            para toda a família.

        </p>


        <div class="about-features">

            <div class="about-feature">

                <div class="feature-icon">
                    🎣
                </div>

                <div>

                    <strong>Pesca</strong>

                    <p>
                        Espaços preparados para
                        uma ótima experiência.
                    </p>

                </div>

            </div>


            <div class="about-feature">

                <div class="feature-icon">
                    🌿
                </div>

                <div>

                    <strong>Natureza</strong>

                    <p>
                        Um ambiente tranquilo
                        cercado pela natureza.
                    </p>

                </div>

            </div>


            <div class="about-feature">

                <div class="feature-icon">
                    👨‍👩‍👧
                </div>

                <div>

                    <strong>Família</strong>

                    <p>
                        Um espaço para aproveitar
                        com toda a família.
                    </p>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================
     SERVIÇOS
========================= -->

    <section class="services-section" id="servicos">

        <div class="section-heading">

            <div class="section-tag">
                NOSSOS SERVIÇOS
            </div>

            <h2>
                Tudo para um dia perfeito
            </h2>

            <p>
                Estrutura completa para você aproveitar
                sua experiência.
            </p>

        </div>


        <div class="service-grid">

            <div class="service-card">

                <div class="service-card-icon">
                    🎣
                </div>

                <h3>
                    Dia de Pesca
                </h3>

                <p>
                    Aproveite um dia tranquilo
                    pescando em contato com a natureza.
                </p>

            </div>


            <div class="service-card">

                <div class="service-card-icon">
                    🐟
                </div>

                <h3>
                    Pesque & Pague
                </h3>

                <p>
                    Pesque e leve seu peixe para
                    casa após sua experiência.
                </p>

            </div>


            <div class="service-card">

                <div class="service-card-icon">
                    🌿
                </div>

                <h3>
                    Aluguel de Vara
                </h3>

                <p>
                    Equipamentos disponíveis para
                    facilitar sua experiência.
                </p>

            </div>


            <div class="service-card">

                <div class="service-card-icon">
                    ⭐
                </div>

                <h3>
                    Estrutura Completa
                </h3>

                <p>
                    Ambiente confortável para
                    aproveitar seu dia.
                </p>

            </div>

        </div>

    </section>


    <!-- =========================
     PREÇOS
========================= -->

    <section class="prices-section" id="precos">

        <div class="section-heading">

            <div class="section-tag">
                PREÇOS
            </div>

            <h2>
                Escolha sua experiência
            </h2>

            <p>
                Preços simples e transparentes.
            </p>

        </div>


        <div class="price-grid">


            <div class="price-card">

                <span class="price-type">
                    EXPERIÊNCIA
                </span>

                <h3>
                    Dia de Pesca
                </h3>

                <div class="price-value">
                    R$ 80
                    <small>/dia</small>
                </div>

                <ul>

                    <li>✓ Acesso ao pesqueiro</li>

                    <li>✓ Área de pesca</li>

                    <li>✓ Ambiente familiar</li>

                    <li>✓ Estacionamento</li>

                </ul>

                <a href="cliente/login.php">
                    Reservar agora
                </a>

            </div>


            <div class="price-card featured">

                <div class="popular-label">
                    MAIS POPULAR
                </div>

                <span class="price-type">
                    EXPERIÊNCIA
                </span>

                <h3>
                    Pesque & Pague
                </h3>

                <div class="price-value">
                    R$ 25
                    <small>/kg</small>
                </div>

                <ul>

                    <li>✓ Acesso ao pesqueiro</li>

                    <li>✓ Pesca livre</li>

                    <li>✓ Ambiente familiar</li>

                    <li>✓ Área de descanso</li>

                </ul>

                <a href="cliente/login.php">
                    Reservar agora
                </a>

            </div>


            <div class="price-card">

                <span class="price-type">
                    EQUIPAMENTO
                </span>

                <h3>
                    Aluguel de Vara
                </h3>

                <div class="price-value">
                    R$ 30
                    <small>/dia</small>
                </div>

                <ul>

                    <li>✓ Vara de pesca</li>

                    <li>✓ Equipamento</li>

                    <li>✓ Uso durante a visita</li>

                    <li>✓ Orientação</li>

                </ul>

                <a href="cliente/login.php">
                    Reservar agora
                </a>

            </div>

        </div>

    </section>


    <!-- =========================
     CTA
========================= -->

    <section class="cta-section">

        <div>

            <span>
                PRONTO PARA VIVER ESSA EXPERIÊNCIA?
            </span>

            <h2>
                Reserve seu dia no Recanto Verde.
            </h2>

            <p>
                Faça sua reserva de forma rápida,
                simples e online.
            </p>

            <a href="cliente/login.php">
                Fazer minha reserva →
            </a>

        </div>

    </section>


    <!-- =========================
     RODAPÉ
========================= -->

    <footer class="site-footer" id="contato">

        <div class="footer-grid">


            <div>

                <div class="footer-logo">
                    🎣 Pesqueiro Recanto Verde
                </div>

                <p>
                    Pesque, relaxe e aproveite
                    a natureza.
                </p>

            </div>


            <div>

                <h4>
                    Navegação
                </h4>

                <a href="#inicio">Início</a>

                <a href="#sobre">Sobre</a>

                <a href="#servicos">Serviços</a>

                <a href="#precos">Preços</a>

            </div>


            <div>

                <h4>
                    Contato
                </h4>

                <p>
                    📍 Deodápolis - MS
                </p>

                <p>
                    📞 (67) 99999-9999
                </p>

            </div>


            <div>

                <h4>
                    Horário
                </h4>

                <p>
                    Segunda a Domingo
                </p>

                <p>
                    08h às 18h
                </p>

            </div>

        </div>


        <div class="footer-bottom">

            © 2026 Pesqueiro Recanto Verde.
            Todos os direitos reservados.

        </div>

    </footer>


</body>

</html>