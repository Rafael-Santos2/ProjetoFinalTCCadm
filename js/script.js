(function () {
  "use strict";

  function updateHeaderHeight() {
    var header = document.querySelector("header");
    if (!header) return;
    var height = header.offsetHeight;
    // Define a variavel CSS no :root
    document.documentElement.style.setProperty(
      "--header-height",
      height + "px"
    );
  }

  // Atualiza quando DOM pronto
  document.addEventListener("DOMContentLoaded", function () {
    updateHeaderHeight();
    // Também observa mudanças no header (por exemplo: quando o menu colapsa/abre)
    var header = document.querySelector("header");
    if (header && window.ResizeObserver) {
      var ro = new ResizeObserver(function () {
        updateHeaderHeight();
      });
      ro.observe(header);
    }
  });

  // Atualiza em resize da janela (fallback)
  window.addEventListener("resize", function () {
    updateHeaderHeight();
  });
})();

// Script para suportar toque (mobile): ao tocar, alterna a classe "expandido".
(function () {
  const botao = document.getElementById("botaoAjuda");
  let touchTimer = null;

  if (!botao) return; // segurança caso o botão não exista

  botao.addEventListener("click", (e) => {
    // Se for dispositivo sem hover (mobile)
    if (window.matchMedia("(hover: none)").matches) {
      // Mostra o texto primeiro
      if (!botao.classList.contains("expandido")) {
        e.preventDefault();
        botao.classList.add("expandido");

        // Remove automaticamente depois de 4 segundos
        clearTimeout(touchTimer);
        touchTimer = setTimeout(() => botao.classList.remove("expandido"), 4000);
        return;
      }
    }

    // 👉 Redireciona ao clicar (para desktops ou 2º toque no mobile)
    // Permite sobrescrever o destino via data-href no botão; caso contrário usa um caminho absoluto seguro
    const target = botao.dataset.href || "/ProjetoFinal_Instituto/usuario/denuncia/denuncia.php";
    window.location.href = target;
  });

  // Se tocar fora do botão, recolhe
  window.addEventListener(
    "touchstart",
    (ev) => {
      if (!botao.contains(ev.target)) {
        botao.classList.remove("expandido");
      }
    },
    { passive: true }
  );

  // Ao rolar a página, recolhe
  window.addEventListener("scroll", () => botao.classList.remove("expandido"), {
    passive: true,
  });
})();