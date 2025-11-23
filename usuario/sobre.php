<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- link css -->
    <link rel="stylesheet" href="../css/style.css" />

    <!-- link js -->
    <script src="../js/script.js"></script>

    <!-- link do bootstrap -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />

    <title>Sobre nós</title>

    <style>
      /* ====== BLOCO "SOBRE NÓS" ====== */
      .section-pink {
        background-color: #ffe4ea;
        border-radius: 16px;
        padding: 50px 40px;
      }

      /* título centralizado em uma caixa branca */
      .pill {
        display: inline-block;
        background-color: #fff;
        color: #000;
        font-weight: 700;
        padding: 10px 28px;
        border-radius: 999px;
        font-size: 1.3rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 20px;
        margin-top: 30px;
      }

      /* imagens com moldura rosa atrás */
      .img-frame,
      .img-frame-sm {
        position: relative;
        display: inline-block;
      }
      .img-frame::before,
      .img-frame-sm::before {
        content: "";
        position: absolute;
        inset: -14px;
        background-color: #fdd7e0;
        border-radius: 20px;
        z-index: 0;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
      }
      .img-frame img,
      .img-frame-sm img {
        position: relative;
        z-index: 2;
        border-radius: 12px;
        width: 100%;
        height: auto;
      }

      /* GRADIENTE NA MARCA (fallback de cor + background-clip padrão) */
      .brand-name {
        color: #f03a5f; /* fallback para navegadores sem suporte a clip/text-fill */
        background: linear-gradient(
          90deg,
          #ff4d6d,
          #ff9a76,
          #ffd166,
          #06d6a0,
          #118ab2,
          #9b5de5
        );
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 800;
      }

      /* ====== CARTÕES DE ESTATÍSTICAS ====== */
      .stat-row {
        row-gap: 20px;
      }
      .stat-card {
        background-color: #fff;
        border-radius: 16px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
        padding: 24px 10px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
      }
      .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.1);
      }
      .stat-card small {
        color: #555;
        font-weight: 600;
      }
      .stat-card .display-6 {
        color: #f03a5f;
        font-weight: 900;
        font-size: 2.2rem;
        margin-top: 4px;
      }

      /* divisores verticais leves */
      @media (min-width: 768px) {
        .stat-row .col-md-3:not(:last-child) {
          border-right: 2px solid rgba(240, 58, 95, 0.15);
        }
      }

      /* ====== PARÁGRAFOS (ajuste de espaçamento e padding) ====== */
      .section-pink p {
        margin-bottom: 13px;
        padding: 0 100px;
        line-height: 2;
        font-size: 1.1rem;
      }

      /* mobile: espaçamento mais compacto */
      @media (max-width: 767.98px) {
        .section-pink p {
          margin-bottom: 10px;
          padding: 0 4px;
        }
      }

      /* ====== AJUSTE DE ESPAÇAMENTO GLOBAL ====== */
      main {
        margin-top: 60px;
        margin-bottom: 60px;
      }

      /* ====== RESPONSIVIDADE ====== */

      @media (max-width: 991.98px) {
        .section-pink {
          padding: 40px 25px;
          text-align: center;
        }
        .section-pink .col-md-4,
        .section-pink .col-md-8 {
          text-align: center;
        }
        .section-pink img {
          max-width: 80%;
        }
        .pill {
          font-size: 1rem;
          padding: 8px 22px;
        }
        .stat-card .display-6 {
          font-size: 1.8rem;
        }
        .stat-card small {
          font-size: 0.85rem;
        }
      }

      /* --- Smartphones grandes (≤ 767px) --- */
      @media (max-width: 767.98px) {
        .section-pink {
          padding: 35px 20px;
        }
        .section-pink img {
          max-width: 90%;
          margin-bottom: 20px;
        }
        .img-frame::before,
        .img-frame-sm::before {
          inset: -10px;
        }
        .stat-row {
          margin-top: 20px;
        }
        .stat-card {
          padding: 18px;
          min-height: auto;
        }
        .stat-card .display-6 {
          font-size: 1.6rem;
        }
      }

      /* --- Smartphones pequenos (≤ 480px) --- */
      @media (max-width: 480px) {
        .pill {
          font-size: 0.95rem;
          padding: 6px 18px;
        }
        .section-pink {
          border-radius: 12px;
          padding: 30px 16px;
        }
        .stat-card .display-6 {
          font-size: 1.4rem;
        }
        .stat-card small {
          font-size: 0.8rem;
        }
      }
    </style>
  </head>
  <body>
   <?php include __DIR__ . '/inc/header.php'; ?>

    <main class="container my-5">
      <!-- bloco superior: imagem + texto (com pílula e moldura atrás da imagem) -->
      <section class="row align-items-center mb-4 px-3 py-4 section-pink rounded-3 position-relative">
        <div class="col-md-4 text-center">
          <div class="img-frame mx-auto">
            <img src="../assets/sobre.png" alt="Criança sorridente" class="img-fluid rounded-2"/>
          </div>
        </div>

        <div class="col-md-8">
          <div class="col-12 text-center mb-4 mt-4">
            <span class="pill">Sobre Nós</span>
          </div>
          <p>
            O <strong class="brand-name">Voz Infantil</strong> nasceu com a
            missão de proteger crianças e adolescentes contra qualquer forma de
            violência, abuso ou negligência. Sabemos que, muitas vezes, os mais
            jovens não conseguem se expressar ou não têm coragem de pedir ajuda.
            Por isso, criamos um espaço seguro, anônimo e acessível, onde
            qualquer pessoa pode denunciar situações de risco.
          </p>
          <p>
            Nosso objetivo é dar voz à infância, garantindo que cada criança
            tenha o direito de crescer em um ambiente saudável, cheio de
            cuidado, respeito e proteção.
          </p>
        </div>
      </section>

      <!-- estatísticas -->
      <section class="row text-center mb-4 stat-row">
        <div class="col-6 col-md-3 mb-3">
          <div class="stat-card p-3 rounded">
            <small class="d-block">Denúncias recebidas e encaminhadas</small>
            <div class="display-6 fw-bold text-danger">12,000</div>
          </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
          <div class="stat-card p-3 rounded">
            <small class="d-block"
              >Cidades alcançadas com nossa rede de apoio</small
            >
            <div class="display-6 fw-bold text-danger">350</div>
          </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
          <div class="stat-card p-3 rounded">
            <small class="d-block"
              >Profissionais, educadores e voluntários mobilizados</small
            >
            <div class="display-6 fw-bold text-danger">1,500</div>
          </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
          <div class="stat-card p-3 rounded">
            <small class="d-block"
              >Compromisso com o sigilo e proteção das vítimas</small
            >
            <div class="display-6 fw-bold text-danger">100%</div>
          </div>
        </div>
      </section>

      <!-- bloco inferior: texto + imagem -->
      <section class="row align-items-center section-pink rounded-3 px-3 py-4">
        <div class="col-md-8">
          <p>
            Aqui, toda denúncia é tratada com seriedade e sigilo, sendo
            encaminhada para os canais oficiais de proteção, como o
            <strong style="color: red">Disque 100</strong>, Conselhos Tutelares
            e autoridades competentes.
          </p>
          <p>
            Além disso, o
            <strong class="brand-name">Voz Infantil</strong> também busca
            conscientizar a sociedade através de informações, materiais
            educativos e orientações para pais, professores e responsáveis,
            ajudando a identificar sinais de violência e agir da forma correta.
          </p>
          <p>
            Porque toda criança merece viver a infância com segurança, dignidade
            e felicidade. Somos a voz que ecoa em defesa delas.
          </p>
        </div>
        <div class="col-md-4 text-center">
          <div class="img-frame-sm mx-auto">
            <img src="../assets/sobre2.png" alt="Criança feliz" class="img-fluid rounded-2"/>
          </div>
        </div>
      </section>
    </main>

    <?php include __DIR__ . '/inc/footer.php'; ?>

    <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>