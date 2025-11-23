<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Formulário seguro e anônimo para denúncias de violência contra crianças e adolescentes">
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet" href="../../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --backcard: #fde4e4;
            --principal: #ffe4e4;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            background: var(--principal);
            font-family: 'Poppins', Arial, sans-serif;
            height: 100%;
        }

        .navbar.img{
            max-width: 90px;
            height: auto;
        }

        .denuncia-page {
            /* espaço garantindo visibilidade sob header (usa --header-height quando definido) */
            padding-top: calc(var(--header-height, 120px) + 20px);
            padding-bottom: 0;
            margin-bottom: 0;
        }

        .denuncia-container {
            width: 100%;
            display: grid;
            grid-template-columns: 40% 60%;
            align-items: stretch;
            /* stretch so both columns match height */
            gap: 18px;
            margin-top: -40px;
            margin-bottom: 0;
        }

        /* left image column: keep image inside the 40% column and show whole image */
        .denuncia-image {
            width: 100%;
            height: 110%;
            margin-left: -15px;
        }

        .denuncia-image img {
            width: 100%;
            height: auto;
        }

        /* right form column */
        .denuncia-form-card {
            background: var(--backcard);
            border-radius: 0 6px 6px 0;
            padding: 30px 50px 30px 40px;
            box-sizing: border-box;
        }

        .denuncia-form-card h2 {
            text-align: left;
            margin: 0 0 18px 0;
            font-weight: 700;
            font-size: 30px;
            color: #111;
            text-align: center;
        }

        .inner-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px 22px;
        }

        .left-fields>div,
        .right-fields>div {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            width: 100%;
        }

        label.field-label {
            font-size: 0.85rem;
            font-weight: 700;
            color: #3b3b3b;
            margin-top: 6px;
            text-transform: uppercase;
        }

        /* inputs and selects: make larger and aligned */
        .denuncia-form-card input[type="text"],
        .denuncia-form-card select {
            width: 100%;
            max-width: 300px;
            box-sizing: border-box;
            height: 44px;
            padding: 10px 14px;
            border-radius: 6px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            background: #fff;
            font-size: 0.98rem;
            color: #333;
        }

        .denuncia-form-card input::placeholder {
            color: #c9c9c9;
        }

        .denuncia-form-card select {
            appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="%23999"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h.001l3.85 3.85a1 1 0 0 0 1.415-1.415l-3.85-3.85zm-5.242 1.656a5 5 0 1 1 0-10 5 5 0 0 1 0 10z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
        }

        /* upload area */
        .upload-box {
            width: 300px;
            height: 300px;
            border-radius: 6px;
            border: 2px dashed rgba(0, 0, 0, 0.08);
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #666;
            position: relative;
            margin-top: 8px
        }

        .upload-inner {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px
        }

        .upload-field {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-top: 6px
        }

        .upload-icon {
            width: 64px;
            height: 64px;
            display: inline-grid;
            place-items: center;
            font-size: 44px;
            color: #222
        }

        .upload-infos {
            font-size: 0.72rem;
            color: #9b9b9b
        }

        .upload-box input[type="file"] {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer
        }

        .preview-container {
            width: 100%;
            height: 100%;
            padding: 16px;
        }

        .preview-content {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        #previewArea {
            max-width: 100%;
            max-height: 70%;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #previewArea img {
            max-width: 100%;
            max-height: 200px;
            object-fit: contain;
        }

        #previewArea video {
            max-width: 100%;
            max-height: 200px;
        }

        #previewArea audio {
            width: 100%;
        }

        .preview-container {
            transition: opacity 0.3s ease;
        }

        .upload-inner {
            transition: opacity 0.3s ease;
        }

        .file-info {
            text-align: center;
            font-size: 0.9rem;
            color: #333;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        #fileName {
            font-weight: 600;
            word-break: break-all;
        }

        #fileSize {
            color: #666;
            font-size: 0.8rem;
        }

        .remove-file {
            position: absolute;
            top: -8px;
            right: -8px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #ff4444;
            color: white;
            border: none;
            font-size: 18px;
            line-height: 1;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .remove-file:hover {
            background: #ff0000;
        }

        .submit-wrap {
            display: flex;
            justify-content: flex-end;
            margin-top: 18px;
        }

        .btn-submit {
            background: #11b85a;
            color: #fff;
            width: 140px;
            height: 48px;
            border-radius: 8px;
            border: none;
            font-weight: 800;
            box-shadow: 0 12px 30px rgba(17, 184, 90, 0.18)
        }

        @media (max-width:1100px) {
            .denuncia-container {
                grid-template-columns: 1fr;
                padding: 0 18px
            }

            .inner-grid {
                grid-template-columns: 1fr
            }

            .upload-box {
                width: 100%;
                height: 260px
            }

            .submit-wrap {
                justify-content: center
            }

            .denuncia-image {
                left: 0;
                min-height: 260px;
                border-radius: 6px
            }

            .denuncia-image img {
                width: 100%;
                height: 100%;
            }

            .denuncia-form-card input[type="text"],
            .denuncia-form-card select {
                max-width: 100%
            }
        }
        /* ajustes para telas menores que 768px */
    /* ajustes para telas menores que 768px */
        @media (max-width:768px) {
            .denuncia-page { 
                padding-top: calc(var(--header-height, 100px) + 12px); 
                padding-bottom: 0;
                min-height: auto;
            }
            .denuncia-form-card { padding: 20px; }
            .denuncia-form-card h2 { font-size: 22px; }
            .upload-box { height: 220px; }
            .preview-content img, #previewArea img { max-height: 160px; }
        }

        @media (max-width:420px) {
            .denuncia-page { 
                padding-top: calc(var(--header-height, 80px) + 8px); 
                padding-bottom: 0;
            }
            .denuncia-form-card { padding: 14px; }
            .denuncia-form-card h2 { font-size: 18px; }
            .upload-box { height: 180px; }
            .denuncia-form-card input[type="text"], .denuncia-form-card select { height: 44px; }
            .submit-wrap { justify-content: center; }
            .btn-submit { width: 100%; }
        }
    </style>
    <title>Denúncia Anônima - Voz Infantil | Proteção de Crianças e Adolescentes</title>
</head>

<body>
    <header class="d-flex flex-wrap">
        <nav class="navbar navbar-expand-lg navbar-dark" role="navigation" aria-label="Menu principal">
            <a class="navbar-brand" href="../index.php" aria-label="Página inicial Voz Infantil"><img src="../../assets/Logo infantil.png" alt="Logo Voz Infantil" height="auto"></a>

            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav" aria-controls="menuNav" aria-expanded="false" aria-label="Alternar menu de navegação">
                <span class="toggler-icon top-bar"></span>
                <span class="toggler-icon middle-bar"></span>
                <span class="toggler-icon bottom-bar"></span>
            </button>

            <div class="collapse navbar-collapse" id="menuNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="../index.php" aria-label="Ir para página principal"><span class="rainbow1">Página Principal</span></a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="../sobre.php" aria-label="Conhecer mais sobre nós"><span class="rainbow2">Sobre nós</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="../responsavel.php" aria-label="Acessar área do responsável"><span class="rainbow3">Área do Responsável</span></a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="../educativa.php" aria-label="Acessar página educativa"><span class="rainbow4">Página Educativa</span></a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="../contato.php" aria-label="Página de contato"><span class="rainbow5">Contato</span></a></li>
                </ul>
            </div>

            <div class="denunciar">
                <button onclick="window.history.back()" class="btn btn-denunciar" aria-label="Voltar para página anterior">Voltar</button>
            </div>
        </nav>
    </header>
    <main class="denuncia-page container-fluid" role="main">
        <div class="denuncia-container">
            <div class="denuncia-image" role="img" aria-label="Ilustração representando segurança e proteção">
                <img src="../../assets/seguranca.png" alt="Ilustração de segurança e proteção infantil" loading="lazy">
            </div>

            <div class="denuncia-form-card">
                <h2>Complete sua denúncia</h2>
                <form action="processa_denuncia.php" method="post" enctype="multipart/form-data" id="denunciaForm" novalidate>
                    <!-- Campo CSRF Token (adicionar no processa_denuncia.php a validação) -->
                    <input type="hidden" name="csrf_token" value="<?php 
                        if (session_status() === PHP_SESSION_NONE) {
                            session_start();
                        }
                        if (empty($_SESSION['csrf_token'])) {
                            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                        }
                        echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8');
                    ?>">
                    
                    <div class="inner-grid">
                        <div class="left-fields">
                            <div>
                                <label class="field-label" for="cep">Digite seu CEP:*</label>
                                <input 
                                    id="cep" 
                                    name="cep" 
                                    type="text" 
                                    placeholder="00000-000" 
                                    maxlength="9" 
                                    pattern="\d{5}-?\d{3}"
                                    required
                                    autocomplete="postal-code"
                                    aria-required="true"
                                    aria-describedby="cep-help">
                                <small id="cep-help" class="form-text" style="display:none; color:#666; font-size:0.75rem;">Digite o CEP para preenchimento automático do endereço</small>
                            </div>

                            <div>
                                <label class="field-label" for="estado">Estado:*</label>
                                <input 
                                    id="estado" 
                                    name="estado" 
                                    type="text" 
                                    placeholder="Ex: SP" 
                                    readonly 
                                    required
                                    autocomplete="address-level1"
                                    aria-required="true"
                                    aria-readonly="true">
                            </div>

                            <div>
                                <label class="field-label" for="cidade">Cidade:*</label>
                                <input 
                                    id="cidade" 
                                    name="cidade" 
                                    type="text" 
                                    placeholder="Ex: São Paulo" 
                                    readonly 
                                    required
                                    autocomplete="address-level2"
                                    aria-required="true"
                                    aria-readonly="true">
                            </div>

                            <div>
                                <label class="field-label" for="bairro">Bairro:*</label>
                                <input 
                                    id="bairro" 
                                    name="bairro" 
                                    type="text" 
                                    placeholder="Ex: Centro" 
                                    readonly 
                                    required
                                    autocomplete="address-level3"
                                    aria-required="true"
                                    aria-readonly="true">
                            </div>

                            <div>
                                <label class="field-label" for="rua">Rua:*</label>
                                <input 
                                    id="rua" 
                                    name="rua" 
                                    type="text" 
                                    placeholder="Ex: Rua das Flores" 
                                    readonly 
                                    required
                                    autocomplete="street-address"
                                    aria-required="true"
                                    aria-readonly="true">
                            </div>

                            <div>
                                <label class="field-label" for="numero">Número:*</label>
                                <input 
                                    id="numero" 
                                    name="numero" 
                                    type="text" 
                                    placeholder="Ex: 123" 
                                    required
                                    maxlength="10"
                                    pattern="[0-9A-Za-z\s\-\/]+"
                                    autocomplete="off"
                                    required>
                            </div>
                            <div class="submit-wrap">
                                <button type="submit" class="btn-submit" aria-label="Enviar denúncia">Enviar</button>
                            </div>
                        </div>

                        <div class="right-fields">
                            <div>
                                <label class="field-label" for="complemento">Complemento:*</label>
                                <input 
                                    id="complemento" 
                                    name="complemento" 
                                    type="text" 
                                    placeholder="Ex: Apt 101, Bloco B" 
                                    required
                                    maxlength="100"
                                    autocomplete="off"
                                    aria-required="true">
                            </div>

                            <div>
                                <label class="field-label" for="tipo_crime">Tipo de crime:*</label>
                                <select 
                                    id="tipo_crime" 
                                    name="tipo_crime" 
                                    required
                                    aria-required="true">
                                    <option value="" disabled selected>Selecione:</option>
                                    <option value="Abuso">Abuso</option>
                                    <option value="Negligência">Negligência</option>
                                    <option value="Exploração">Exploração</option>
                                    <option value="Outro">Outro</option>
                                </select>
                            </div>

                            <div class="upload-field">
                                <label class="field-label" for="arquivo">Fotos, vídeos ou áudios do ocorrido:</label>
                                <div class="upload-box" id="uploadBox" role="button" tabindex="0" aria-label="Área para upload de arquivo">
                                    <div class="upload-inner" id="defaultUpload">
                                        <div class="upload-icon" aria-hidden="true">⬇️</div>
                                        <div>Arraste ou clique para anexar</div>
                                        <div class="upload-infos">Imagem: 10MB | Vídeo: 50MB | Áudio: 20MB</div>
                                    </div>
                                    <div class="preview-container" id="previewContainer" style="display: none;">
                                        <div class="preview-content">
                                            <div id="previewArea" role="img" aria-label="Pré-visualização do arquivo"></div>
                                            <div class="file-info">
                                                <span id="fileName"></span>
                                                <span id="fileSize"></span>
                                            </div>
                                            <button type="button" id="removeFile" class="remove-file" aria-label="Remover arquivo selecionado">×</button>
                                        </div>
                                    </div>
                                    <input 
                                        type="file" 
                                        id="arquivo" 
                                        name="arquivo" 
                                        accept="image/jpeg,image/png,image/gif,image/webp,audio/mpeg,audio/wav,audio/ogg,video/mp4,video/mpeg,video/quicktime,video/webm"
                                        aria-label="Selecionar arquivo para upload">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <footer class="footer" style="margin-top: 0;" role="contentinfo">
        <div class="container-footer">
            <!-- LOGOS NO TOPO -->
            <div class="header-footer">
                <img src="../../assets/Logo infantil.png" alt="Logo Voz Infantil" width="120" height="auto" loading="lazy">
                <img src="../../assets/Logo instituto.png" alt="Logo Instituto Amparo Digital" width="120" height="auto" loading="lazy">
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
                        <li><a href="../../assets/Politica_de_Privacidade.pdf" target="_blank" rel="noopener noreferrer" aria-label="Abrir Política de Privacidade em nova aba">Política de Privacidade</a></li>
                        <li><a href="../../assets/Termos_de_Uso.pdf" target="_blank" rel="noopener noreferrer" aria-label="Abrir Termos de Uso em nova aba">Termos de Uso</a></li>
                        <li><a href="../contato.php" aria-label="Ir para página de contato">Contato</a></li>
                    </ul>
                </div>

                <div class="acoes-footer">
                    <h5>Juntos pela proteção das crianças!</h5>
                    <p>Toda criança merece proteção.</p>
                    <a href="denuncia.php" class="btn-denunciar" aria-label="Fazer uma denúncia agora">Denuncie agora</a>
                </div>
            </div>
        </div>

        <div class="footer-copy">
            <p>&copy; <?php echo date('Y'); ?> Voz Infantil – Instituto Amparo Digital</p>
            <span>Toda criança merece proteção.</span>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="../../js/cep.js"></script>
    <script src="../../js/upload.js"></script>
    <noscript>
        <div style="padding: 20px; background: #fff3cd; border: 2px solid #ffc107; margin: 20px; text-align: center; border-radius: 8px;">
            <strong>⚠️ JavaScript desabilitado</strong><br>
            Para uma melhor experiência, por favor habilite o JavaScript no seu navegador.<br>
            Algumas funcionalidades como busca automática de CEP e preview de arquivos podem não funcionar corretamente.
        </div>
    </noscript>
</body>

</html>