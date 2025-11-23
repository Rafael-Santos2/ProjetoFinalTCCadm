<?php
// 1. Tenta obter o valor da variável de ambiente 'BASE_URL' do Railway.
$base_url = getenv('BASE_URL'); 

// 2. Fallback: Coloque o seu domínio público real do Railway aqui.
if (!$base_url) {
    $base_url = 'https://projetofinaltcc-production.up.railway.app'; 
}
?>
<header class="d-flex flex-wrap">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="<?= htmlspecialchars($baseUrl) ?>/usuario/index.php"><img src="<?= htmlspecialchars($baseUrl) ?>/assets/Logo%20infantil.png" alt="Logo do site"></a>

        <div class="collapse navbar-collapse" id="menuNav">
        </div>

        <?php if (isset($_SESSION['usuario_nome'])): ?>
        <div class="usuario-logado">
            <span>Logado como: <strong><?= htmlspecialchars($_SESSION['usuario_nome']) ?></strong></span>
        </div>
        <?php endif; ?>

        <div class="denunciar">
            <button onclick="window.history.back()" class="btn btn-denunciar">Voltar</button>
        </div>
    </nav>
</header>