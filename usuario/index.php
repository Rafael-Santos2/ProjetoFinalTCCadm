<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- link css -->
    <link rel="stylesheet" href="../css/style.css">

    <!-- link js -->
    <script src="../js/script.js"></script>

    <!-- link do bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <title>Página Inicial</title>
</head>

<body>
    <?php include __DIR__ . '/inc/header.php'; ?>
    <div class="aviso">
        <p class="aviso-texto">MAIS DE X CRIANÇAS ESTÃO EM SITUAÇÃO DE RISCO. AJUDE E DENUNCIE!</p>
    </div>
    <main class="container">
        <div class="banner">
            <img src="../assets/banner.png" alt="Banner do site" class="img-banner">
        </div>
        <div class="main-card mt-5 p-3 text-center">
            <h1>Por que existimos?</h1>
            <div class="card-body">
                <div class="cards mt-3">
                    <div class="card-main">
                        <img src="../assets/care.png" alt="care" class="img-card">
                        <p>Defender os direitos</p>
                    </div>
                    <div class="card-main">
                        <img src="../assets/violence-prevention.png" alt="care" class="img-card">
                        <p>Combater a violência</p>
                    </div>
                    <div class="card-main">
                        <img src="../assets/education.png" alt="care" class="img-card">
                        <p>Promover a educação</p>
                    </div>
                    <div class="card-main">
                        <img src="../assets/home.png" alt="care" class="img-card">
                        <p>Apoiar um ambiente seguro</p>
                    </div>
                    <div class="card-main">
                        <img src="../assets/biodiversidade.png" alt="care" class="img-card">
                        <p>Defender a biodiversidade</p>
                    </div>
                    <div class="card-main">
                        <img src="../assets/hacker.png" alt="care" class="img-card">
                        <p>Garantir um anonimato</p>
                    </div>
                    <div class="card-main">
                        <img src="../assets/collaboration.png" alt="care" class="img-card">
                        <p>Articular com orgãos responsaveis</p>
                    </div>
                    <div class="card-main">
                        <img src="../assets/connected.png" alt="care" class="img-card">
                        <p>Proteger o futuro</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-cardg mt-5 p-3 text-center">
            <h1>Pilares para Denúncia</h1>
        </div>
    </main>
    <section class="container mb-5">
        <div class="card-pilar mt-3 p-3 text-center">
            <div class="cards-body">
                <div class="card-main-pilar card1">
                    <img src="../assets/trio.png" alt="confidencialidade" class="img-card-denuncia mt-4">
                    <h3>Proteção:</h3>
                    <h4>Toda criança merece estar segura.</h4>
                    <p>Primeiro passo:
                        Clique no botão de denúncia e preencha o formulário com tudo que você sabe e tem de informação
                        sobre o caso
                    </p>
                </div>
                <div class="card-main-pilar card2">
                    <img src="../assets/superheroi.png" alt="confidencialidade" class="img-card-denuncia mt-4">
                    <h3>Ação:</h3>
                    <h4>Toda criança merece estar segura.</h4>
                    <p>Segundo passo:
                        Nós encaminhamos as autoridades até o endereço que você informou. Lá eles tomam a ação
                        necessária</p>
                </div>
                <div class="card-main-pilar card3">
                    <img src="../assets/silencio.png" alt="confidencialidade" class="img-card-denuncia mt-4">
                    <h3>Sigilo:</h3>
                    <h4>Toda criança merece estar segura.</h4>
                    <p>Terceiro passo:
                        Com a ação tomada, você pode enfim se sentir mais leve e garantindo a segurança da criança e a
                        sua</p>
                </div>
            </div>
        </div>
        <!-- Botão: coloque role=button e aria para acessibilidade -->
        <button class="botao-ajuda" id="botaoAjuda" role="button" aria-label="Precisa de ajuda" data-href="/ProjetoFinal_Instituto/usuario/denuncia/denuncia.php">
            <span class="icone" aria-hidden="true">📞</span>
            <span class="texto">Precisa de Ajuda?</span>
        </button>
    </section>

    <?php include __DIR__ . '/inc/footer.php'; ?>

</body>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>



</html>