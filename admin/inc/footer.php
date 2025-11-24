<?php
// 1. Tenta obter o valor da variável de ambiente 'BASE_URL' do Railway.
$base_url = getenv('BASE_URL'); 

// 2. Fallback: Coloque o seu domínio público real do Railway aqui.
if (!$base_url) {
    $base_url = 'https://projetofinaltccadm-production.up.railway.app'; 
}
?>
<footer class="footer">
        <div class="container-footer">
            <!-- LOGOS NO TOPO -->
            <div class="header-footer">
                <img src="/assets/Logo infantil.png" alt="Logo Voz Infantil">
                <img src="/assets/logo instituto.png" alt="Logo Instituto Amparo Digital">
            </div>

            <!-- CONTEÚDO PRINCIPAL -->
            <div class="main-footer">
                <div class="text-footer">
                    <p>
                        O Voz Infantil é um espaço seguro e anônimo para denunciar situações de violência contra
                        crianças e adolescentes, encaminhando tudo para os órgãos responsáveis.
                    </p>
                </div>

                <div class="links-footer">
                    <ul>
                        <li><a href="../../assets/Politica_de_Privacidade.pdf" target="_blank" rel="noopener noreferrer">Política de Privacidade</a></li>
                        <li><a href="../../assets/Termos_de_Uso.pdf" target="_blank" rel="noopener noreferrer">Termos de Uso</a></li>
                    </ul>
                </div>

                <div class="acoes-footer">
                    <h5>Juntos pela proteção das crianças!</h5>
                    <p>Toda criança merece proteção.</p>
                </div>
            </div>
        </div>

        <div class="footer-copy">
            <p>&copy; 2025 Voz Infantil – Instituto Amparo Digital</p>
            <span>Toda criança merece proteção.</span>
        </div>
    </footer>