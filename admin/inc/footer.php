<?php
// Calcula o caminho base relativo a partir da pasta do projeto
$baseUrl = dirname(dirname($_SERVER['PHP_SELF']));
?>
<footer class="footer">
        <div class="container-footer">
            <!-- LOGOS NO TOPO -->
            <div class="header-footer">
                <img src="<?= htmlspecialchars($baseUrl) ?>../../../../assets/Logo%20infantil.png" alt="Logo Voz Infantil">
                <img src="<?= htmlspecialchars($baseUrl) ?>../../../../assets/Logo%20instituto.png" alt="Logo Instituto Amparo Digital">
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
                        <li><a href="<?= htmlspecialchars($baseUrl) ?>/assets/Politica_de_Privacidade.pdf" target="_blank" rel="noopener noreferrer">Política de Privacidade</a></li>
                        <li><a href="<?= htmlspecialchars($baseUrl) ?>/assets/Termos_de_Uso.pdf" target="_blank" rel="noopener noreferrer">Termos de Uso</a></li>
                        <li><a href="<?= htmlspecialchars($baseUrl) ?>/usuario/contato.php">Contato</a></li>
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