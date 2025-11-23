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
            <a class="navbar-brand" href="/index.php"><img src="../../assets/Logo%20infantil.png" alt="Logo do site"></a>
            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav">
                <span class="toggler-icon top-bar"></span>
                <span class="toggler-icon middle-bar"></span>
                <span class="toggler-icon bottom-bar"></span>
            </button>

            <div class="collapse navbar-collapse" id="menuNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="/usuario/index.php"><span class="rainbow1">Página Principal</span></a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="/usuario/sobre.php"><span class="rainbow2">Sobre nós</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="/usuario/responsavel.php"><span class="rainbow3">Área do Responsável</span></a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="/usuario/educativa.php"><span class="rainbow4">Página Educativa</span></a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="/usuario/contato.php"><span class="rainbow5">Contato</span></a></li>
                </ul>
            </div>

            <div class="denunciar">
                <a href="/usuario/denuncia/denuncia.php" class="btn btn-denunciar">Denuncie</a>
            </div>
        </nav>
    </header>