<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- link css -->
  <link rel="stylesheet" href="../css/style.css">

  <!-- link js -->
  <script src="../js/script.js"></script>

  <style>
    .bloco-vermelho {
    background-color: #FD9F9F !important;
    font-size: 1.5rem !important;
}

.bloco-azul {
    background-color: #9FC5FD !important;
    font-size: 1.5rem !important;
}

.bloco-amarelo{
    background-color: #FFF9C4 !important;
    font-size: 1.5rem !important;
}

.bloco-verde {
    background-color: #9FFDB2 !important;
    font-size: 1.5rem !important;
}

.bloco-verde p{
    border-bottom: solid 4px #71CE83;
}

.bloco-azul, .bloco-verde, .bloco-amarelo, .bloco-vermelho {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}


.bloco-azul:hover, .bloco-amarelo:hover, .bloco-vermelho:hover, .bloco-verde:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    z-index: 2;
}
  </style>

  <!-- link do bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

  <title>Página dos Responsáveis</title>
</head>

<body>
  <?php include __DIR__ . '/inc/header.php'; ?>

  <div class="aviso">
    <p class="aviso-texto"></p>
  </div>

  <main class="container">
    <div class="banner">
      <img src="../assets/banner2.png" alt="Banner do site" class="img-banner">
    </div>

    <div class="main-card mt-5 p-3 text-center">
      <h1>Aprenda a identificar, agir e proteger</h1>
    </div>

    <div class="denunciar-revelar mt-3 p-3 text-center">
      <a href="#" class="btn btn-denunciar-reverso">Denuncie agora</a>
    </div>
  </main>

  <section class="container mb-5">
    <div class="row g-4 mt-3">
      <!-- COMO IDENTIFICAR -->
      <div class="col-md-7">
        <div class="card p-3 shadow bloco-azul">
          <div class="row g-3 align-items-center">
            <div class="col-auto">
              <img src="../assets/resp_(2).png" class="img-fluid rounded" alt="criança no parque" style="max-width:200px;">
            </div>
            <div class="col">
              <h5><strong>COMO IDENTIFICAR?</strong></h5>
              <ul class="mb-0">
                <li>Mudanças de comportamento</li>
                <li>Marcas no corpo</li>
                <li>Queda no rendimento escolar</li>
                <li>Isolamento social</li>
              </ul>
            </div>
          </div>
        </div>

        <!-- O QUE OBSERVAR -->
        <div class="card p-3 mt-5 shadow bloco-verde text-center">
          <h5><strong>O QUE OBSERVAR NO DIA-A-DIA?</strong></h5>
          <div class="container-fluid">
            <div class="row align-items-center mb-3">
              <div class="col-md-8 col-sm-7 order-md-2">
                <p class="mb-0">Resistência em voltar para certos lugares ou encontrar certas pessoas</p>
              </div>
              <div class="col-md-4 col-sm-5 text-center order-md-1">
                <img src="../assets/resp_(1).png" class="img-fluid rounded" alt="criança preocupada">
              </div>
            </div>
            <div class="row align-items-center mb-3">
              <div class="col-md-8 col-sm-7 order-md-1">
                <p class="mb-0">Alterações na rotina de sono/alimentação</p>
              </div>
              <div class="col-md-4 col-sm-5 text-center order-md-2">
                <img src="../assets/resp_(3).png" class="img-fluid rounded" alt="criança triste">
              </div>
            </div>
            <div class="row align-items-center">
              <div class="col-md-8 col-sm-7 order-md-2">
                <p class="mb-0">Desenhos ou brincadeiras com conteúdo violento ou sexual</p>
              </div>
              <div class="col-md-4 col-sm-5 text-center order-md-1">
                <img src="../assets/resp_(4).png" class="img-fluid rounded" alt="crianças desenhando">
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- COMO AGIR e COMO NÃO AGIR -->
      <div class="col-md-5">
        <div class="card p-3 shadow bloco-amarelo text-center">
          <h5><strong>COMO AGIR?</strong></h5>
          <ul>
            <li>Apoiar a criança sem julgamento</li>
            <li>Procurar ajuda profissional</li>
            <li>Denunciar imediatamente</li>
          </ul>
          <img src="../assets/resp_(5).png" class="img-fluid rounded mb-3 mx-auto d-block" alt="apoio emocional" style="max-width:900px;">
        </div>

        <div class="card p-3 mt-5 shadow bloco-vermelho text-center text-white">
          <div class="text-center fs-1">🚫</div>
          <h5><strong>COMO NÃO AGIR?</strong></h5>
          <ul>
            <li>Desacreditar ou minimizar (“isso é coisa da sua cabeça”)</li>
            <li>Culpar a criança</li>
            <li>Confrontar diretamente o suspeito sem apoio especializado</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <?php include __DIR__ . '/inc/footer.php'; ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>