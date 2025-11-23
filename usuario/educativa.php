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

  <title>Página Educativa</title>

  <style>
    /* Fundo geral */
    .educa-bg {
      background: #F5DADA;
      min-height: 50vh;
    }

    /* Cartões */
    .card-custom {
      border-radius: 6px;
      min-height: 320px;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-start;
      padding: 1.5rem;
      color: #111;
    }

    .card-pink{
    background-color: #FFB6C1 !important;
    font-size: 1.5rem !important;
}

.card-pink h5{
    color: #D53078 !important;
    font-size: 1.5rem !important;
}

.card-green{
    background-color: #59D7AD !important;
    font-size: 1.5rem !important;
}

.card-green h5{
    color: #29905D !important;
    font-size: 1.5rem !important;
}

.card-purple{
    background-color: #D8BFD8 !important;
    font-size: 1.5rem !important;
}

.card-purple h5{
    color: #89458C !important;
    font-size: 1.5rem !important;
}

.card-green,.card-purple,.card-pink {
    padding-top: 3vh;
    border-radius: 20px;
    padding-top: 4vh;
    padding-left: 2vw;
    padding-right: 2vw;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card-green:hover, .card-purple:hover, .card-pink:hover {
    transform: scale(1.1);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    z-index: 2;
}

.blob {
    background-color: #95CBDF;
    color: #3B4EAD;
    border-radius: 25px;
}



/* Garante que todos os cards personalizados tenham a mesma altura
   e que o conteúdo (imagem + texto) fique alinhado verticalmente. */
.card-custom {
    min-height: 320px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    box-shadow: 0 4px 8px rgba(0,0,0,0.06);
    border-radius: 20px;
    padding: 1.6rem 1.2rem;
    text-align: center;
}

/* Ajusta imagens usadas nos cards educativos para manter proporções e
   tamanho consistente entre os cards. */
.card-custom .image_educa,
.image_educa {
    width: 140px;
    height: 140px;
    object-fit: contain;
    margin-bottom: 1rem;
}

    h2 {
      color: #111;
      font-size: 2rem;
      font-weight: bold;
      margin-bottom: 2.5rem;
      margin-top: 7.2rem;
      text-align: center;
    }

    /* Responsivo */
    @media (max-width: 991.98px) {
      .card-custom {
        min-height: 260px;
      }
    }

    @media (max-width: 767.98px) {
      .card-custom {
        min-height: 220px;
        margin-bottom: 18px;
      }

      .image_educa {
        max-width: 90px;
      }
    }
  </style>
</head>

<body>
  <?php include __DIR__ . '/inc/header.php'; ?>

  <main class="container-fluid py-4">
    <h2 class="fw-bold mb-5">Página Educativa</h2>

    <div class="educa-bg">
      <div class="main-card container py-5 mt-4 justify-content-center">
        <div class="row g-4 justify-content-center">

          <!-- Card 1 -->
          <div class="col-md-4">
            <div class="card-custom card-green text-center">
              <img src="../assets/hist.png" class="image_educa mb-4" alt="História em quadrinhos">
              <h5><strong>Histórias em quadrinhos</strong></h5>
              <p>Exemplos de situações perigosas e como pedir ajuda.</p>
            </div>
          </div>

          <!-- Card 2 -->
          <div class="col-md-4">
            <div class="card-custom card-purple text-center">
              <img src="../assets/jogo.png" class="image_educa mb-4" alt="Joguinhos educativos">
              <h5><strong>Joguinhos educativos ou quizzes simples</strong></h5>
              <p>(Ex.: “O que fazer se um estranho falar com você online?”)</p>
            </div>
          </div>

          <!-- Card 3 -->
          <div class="col-md-4">
            <div class="card-custom card-pink text-center">
              <img src="../assets/cart.png" class="image_educa mb-4" alt="Cartilhas e vídeos">
              <h5><strong>Cartilhas e vídeos</strong></h5>
              <p>Sobre segurança, respeito e direitos.</p>
            </div>
          </div>

        </div>
      </div>
    </div>
  </main>

  <?php include __DIR__ . '/inc/footer.php'; ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>