# Pasta de Uploads

Esta pasta armazena os arquivos anexados às denúncias enviadas através do sistema.

## Segurança

- ✅ Arquivos PHP são bloqueados pelo `.htaccess`
- ✅ Listagem de diretório está desabilitada
- ✅ Apenas formatos permitidos: imagens (jpg, png, gif), áudios (mp3, wav), vídeos (mp4) e documentos (pdf, doc)
- ✅ Tamanho máximo por arquivo: 50MB

## Estrutura no Git

- O arquivo `.gitkeep` mantém esta pasta no repositório
- Os arquivos enviados pelos usuários são ignorados pelo Git (segurança e privacidade)
- Ao fazer deploy, esta pasta será criada automaticamente se não existir

## Importante

⚠️ **Nunca commite arquivos reais de denúncias no repositório Git!**

Os arquivos aqui contêm informações sensíveis e devem permanecer apenas no servidor de produção.
