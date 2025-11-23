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

    <title>Contato</title>

    <style>
    /* Fundo geral */
    .contato-bg {
        background: #fde7ea;
        min-height: 100vh;
    }

    /* Cartões */
    .contato-card {
        border-radius: 6px;
        min-height: 320px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: flex-start;
        max-width: 340px;
    }
    .contato-email { background: #fa7ca7; color: #222; }
    .contato-tel   { background: #aee8ed; color: #222; }
    .contato-correio { background: #ffe1a8; color: #222; }

    /* Ícones circulares */
    .icon-bg {
        width: 60px; height: 60px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        background: rgba(255,255,255,0.18);
    }
    .icon-email { background: #c75c6f; }
    .icon-tel   { background: #7fd8de; }
    .icon-correio { background: #e7b95b; }

    /* Títulos */
    .contato-card h5 {
        letter-spacing: 1px;
        font-size: 1.15rem;
    }

    /* Responsivo */
    @media (max-width: 991.98px) {
        .contato-card { min-height: 260px; max-width: 100%; }
    }
    @media (max-width: 767.98px) {
        .contato-card { min-height: 220px; margin-bottom: 18px; }
        .icon-bg { width: 48px; height: 48px; }
    }

    h2 {
        color: #111;
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 2.5rem;
        margin-top: 7.2rem;
        text-align: center;
    }
    
    </style>
</head>
<body>
    <?php include __DIR__ . '/inc/header.php'; ?>

    <main class="container-fluid contato-bg py-4">
        <h2 class="text-center fw-bold mb-5" style="font-size:2rem;">Entre em contato conosco</h2>
        <div class="row justify-content-center g-4">
            <div class="col-12 col-md-4 d-flex justify-content-center">
                <div class="contato-card contato-email p-4 w-100">
                    <div class="icon-bg icon-email mb-3">
                        <svg width="38" height="38" fill="none" viewBox="0 0 38 38">
                            <circle cx="19" cy="19" r="19" fill="#c75c6f"/>
                            <rect x="9" y="13" width="20" height="12" rx="3" stroke="#fff" stroke-width="2"/>
                            <path d="M9 13l10 8 10-8" stroke="#fff" stroke-width="2"/>
                        </svg>
                    </div>
                    <h5 class="fw-bold mb-3">EMAIL</h5>
                    <div>
                        <span class="fw-bold">Voz-Infantil</span><br>
                        <span>email1@gmail.com</span>
                    </div>
                    <div class="mt-3">
                        <span class="fw-bold">Instituto Amparo Digital</span><br>
                        <span>email2@gmail.com</span>
                    </div>
                </div>
            </div>
            <!-- TELEFONE -->
            <div class="col-12 col-md-4 d-flex justify-content-center">
                <div class="contato-card contato-tel p-4 w-100">
                    <div class="icon-bg icon-tel mb-3">
                        <!-- Ícone de telefone moderno -->
                        <svg width="38" height="38" fill="none" viewBox="0 0 38 38">
                            <circle cx="19" cy="19" r="19" fill="#7fd8de"/>
                            <path d="M26.5 23.5l-3.2-1.1a2 2 0 0 0-2.1.5l-1.1 1.1a13.5 13.5 0 0 1-6.5-6.5l1.1-1.1a2 2 0 0 0 .5-2.1l-1.1-3.2A2 2 0 0 0 12 10.5h-2A2 2 0 0 0 8 12.5c0 9.4 7.6 17 17 17a2 2 0 0 0 2-2v-2a2 2 0 0 0-1.5-1.9z" stroke="#fff" stroke-width="2"/>
                        </svg>
                    </div>
                    <h5 class="fw-bold mb-3">TELEFONE</h5>
                    <div>
                        <span class="fw-bold">Voz-Infantil</span><br>
                        <span>1234-5678</span>
                    </div>
                    <div class="mt-3">
                        <span class="fw-bold">Instituto Amparo Digital</span><br>
                        <span>8765-4321</span>
                    </div>
                </div>
            </div>
            <!-- CORREIO -->
            <div class="col-12 col-md-4 d-flex justify-content-center">
                <div class="contato-card contato-correio p-4 w-100">
                    <div class="icon-bg icon-correio mb-3">
                        <!-- Ícone de correio (carta) -->
                        <svg width="38" height="38" fill="none" viewBox="0 0 38 38">
                            <circle cx="19" cy="19" r="19" fill="#e7b95b"/>
                            <rect x="10" y="14" width="18" height="10" rx="2" stroke="#fff" stroke-width="2"/>
                            <path d="M10 14l9 7 9-7" stroke="#fff" stroke-width="2"/>
                        </svg>
                    </div>
                    <h5 class="fw-bold mb-3">CORREIO</h5>
                    <div>
                        <span class="fw-bold">Instituto Amparo Digital</span><br>
                        <span>Número tal, Rua Tal, Cidade tal,<br>Estado tal</span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/inc/footer.php'; ?>
    
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</html>