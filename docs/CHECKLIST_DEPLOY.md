# ✅ Checklist de Deploy - Voz Infantil

## 📦 Arquivos Preparados para Deploy

### ✅ Configuração
- [x] `config.php` - Configuração centralizada com suporte a variáveis de ambiente
- [x] `.env.example` - Exemplo de variáveis de ambiente
- [x] `.gitignore` - Atualizado para ignorar arquivos sensíveis
- [x] `railway.json` - Configuração para Railway

### ✅ Segurança
- [x] `admin/.htaccess` - Proteção da área administrativa
- [x] `uploads/.htaccess` - Proteção de uploads
- [x] `uploads/index.php` - Bloqueio de listagem
- [x] Todos os `conexao.php` atualizados para usar `config.php`
- [x] Headers de segurança configurados
- [x] Prepared statements em todas as queries

### ✅ Documentação
- [x] `RAILWAY_DEPLOY.md` - Guia completo de deploy no Railway
- [x] `DEPLOY.md` - Guia de deploy tradicional
- [x] `uploads/README.md` - Explicação da pasta uploads

### ✅ Estrutura
- [x] Pasta `uploads/` criada com `.gitkeep`
- [x] Includes centralizados (`inc/header.php` e `inc/footer.php`)
- [x] Caminhos de assets corrigidos (URL encoding para espaços)

---

## 🚀 Pronto para Deploy no Railway!

### Você Pode Fazer Agora:

1. **Commit e Push**
   ```bash
   git add .
   git commit -m "Preparado para deploy no Railway"
   git push origin main
   ```

2. **Seguir o Guia**
   - Abra o arquivo `RAILWAY_DEPLOY.md`
   - Siga os passos para criar 2 aplicações
   - Configure as variáveis de ambiente

---

## 🎯 Estrutura das 2 Aplicações

### Aplicação 1: Site Público
- **Nome**: `voz-infantil-publico`
- **Root Directory**: `/usuario` (opcional)
- **URL**: `https://voz-infantil-publico.up.railway.app`
- **Acesso**: Público
- **Conteúdo**: 
  - Página inicial
  - Sobre nós
  - Contato
  - Área educativa
  - Formulário de denúncia
  - Consulta de protocolo

### Aplicação 2: Painel Admin
- **Nome**: `voz-infantil-admin`
- **Root Directory**: `/admin`
- **URL**: `https://voz-infantil-admin.up.railway.app`
- **Acesso**: Restrito (⚠️ MANTENHA PRIVADO)
- **Conteúdo**:
  - Login
  - Dashboard
  - Visualização de denúncias
  - Alteração de status
  - Logs

---

## 📋 Próximos Passos

### No Railway:

1. ✅ Criar projeto no Railway
2. ✅ Provisionar MySQL
3. ✅ Importar SQL (`bd/voz_infantil.sql`)
4. ✅ Criar serviço público (usuário)
5. ✅ Configurar variáveis de ambiente
6. ✅ Gerar domínio público
7. ✅ Criar serviço admin
8. ✅ Configurar root directory: `/admin`
9. ✅ Configurar variáveis de ambiente
10. ✅ Gerar domínio admin (privado)
11. ✅ Testar ambas aplicações
12. ✅ Criar primeiro usuário admin
13. ✅ Remover `criar_primeiro_usuario.php`

### Configurações de Banco no Railway:

```env
DB_HOST=${{MYSQLHOST}}
DB_PORT=${{MYSQLPORT}}
DB_USER=${{MYSQLUSER}}
DB_PASS=${{MYSQLPASSWORD}}
DB_NAME=${{MYSQLDATABASE}}
ENVIRONMENT=production
```

---

## ⚠️ IMPORTANTE - Segurança do Admin

### Opção 1: Domínio Não Listado
- Não compartilhe a URL admin publicamente
- Use apenas internamente
- Considere adicionar ao `/etc/hosts` local

### Opção 2: Cloudflare Access
- Configure Cloudflare na frente
- Use Cloudflare Access para restringir por IP
- Requeira autenticação adicional

### Opção 3: VPN/Tailscale
- Configure Tailscale
- Acesse admin apenas via VPN

### Opção 4: HTTP Basic Auth
Adicione ao `.htaccess`:
```apache
AuthType Basic
AuthName "Restrito"
AuthUserFile /app/.htpasswd
Require valid-user
```

Crie senha:
```bash
htpasswd -c .htpasswd admin
```

---

## 🧪 Testes Após Deploy

### Teste 1: Conexão com Banco
```bash
railway run php -r "require 'config.php'; echo 'OK: ' . DB_NAME;"
```

### Teste 2: Enviar Denúncia
1. Acesse o site público
2. Vá em "Denuncie"
3. Preencha o formulário
4. Anexe um arquivo de teste
5. Anote o protocolo

### Teste 3: Login Admin
1. Acesse o painel admin
2. Faça login
3. Veja a denúncia enviada
4. Altere o status
5. Verifique os logs

### Teste 4: Upload de Arquivo
1. Clique em "Ver Arquivo" na denúncia
2. Verifique se abre corretamente
3. Teste com diferentes tipos (imagem, PDF)

---

## 📊 Monitoramento

### No Railway Dashboard:

- **Logs**: Monitore erros em tempo real
- **Métricas**: CPU, memória, requisições
- **Deploys**: Histórico de deploys
- **Variáveis**: Verifique se estão corretas

### Comandos Úteis:

```bash
# Ver logs ao vivo
railway logs

# Rodar comando no container
railway run php -v

# Restart do serviço
railway restart

# SSH no container (debug)
railway shell
```

---

## 🎉 Deploy Completo!

Quando tudo estiver funcionando:

✅ Site público online e acessível  
✅ Admin protegido e funcional  
✅ Banco de dados conectado  
✅ Uploads funcionando  
✅ Denúncias sendo recebidas  
✅ Logs sendo gravados  

**Parabéns! Seu sistema está no ar! 🚀**

---

## 📞 Suporte

Caso encontre problemas:

1. Verifique os logs: `railway logs`
2. Confira variáveis de ambiente
3. Teste conexão local primeiro
4. Consulte `RAILWAY_DEPLOY.md`
5. Community Railway: https://discord.gg/railway

---

**💚 Sucesso no seu deploy!**
