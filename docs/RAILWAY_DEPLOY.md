# 🚀 Deploy no Railway - Voz Infantil

## Estratégia de Deploy: 2 Aplicações Separadas

### Por que 2 aplicações?
- ✅ **Segurança**: Admin isolado do site público
- ✅ **Controle de Acesso**: Diferentes URLs e configurações
- ✅ **Performance**: Cada aplicação pode escalar independentemente

---

## 📋 Pré-requisitos

1. Conta no [Railway.app](https://railway.app)
2. Repositório Git com o código
3. Acesso ao GitHub/GitLab

---

## 🗄️ Passo 1: Criar Banco de Dados MySQL

### 1.1 Criar o Serviço MySQL no Railway

1. Acesse [Railway Dashboard](https://railway.app/dashboard)
2. Clique em **"New Project"**
3. Selecione **"Provision MySQL"**
4. Aguarde a criação do banco

### 1.2 Anotar Credenciais do Banco

No Railway, clique no serviço MySQL criado e vá em **"Variables"**:

```
MYSQLHOST=xxx.railway.app
MYSQLPORT=xxxx
MYSQLUSER=root
MYSQLPASSWORD=xxxxxxxx
MYSQLDATABASE=railway
```

### 1.3 Importar o SQL

**Opção A: Via Railway CLI**
```bash
railway login
railway link [seu-projeto]
railway run mysql -h $MYSQLHOST -P $MYSQLPORT -u $MYSQLUSER -p$MYSQLPASSWORD $MYSQLDATABASE < bd/voz_infantil.sql
```

**Opção B: Via MySQL Workbench / phpMyAdmin**
1. Use as credenciais do Railway
2. Importe o arquivo `bd/voz_infantil.sql`

---

## 🌐 Passo 2: Deploy da Aplicação Pública (Usuários)

### 2.1 Criar Novo Serviço no Railway

1. No mesmo projeto, clique em **"New"** → **"GitHub Repo"**
2. Selecione seu repositório
3. Nome sugerido: **`voz-infantil-publico`**

### 2.2 Configurar Variáveis de Ambiente

No serviço criado, vá em **"Variables"** e adicione:

```env
# Banco de Dados (copie do serviço MySQL)
DB_HOST=${{MYSQLHOST}}
DB_PORT=${{MYSQLPORT}}
DB_USER=${{MYSQLUSER}}
DB_PASS=${{MYSQLPASSWORD}}
DB_NAME=${{MYSQLDATABASE}}

# Configurações do Sistema
ENVIRONMENT=production
BASE_URL=${{RAILWAY_PUBLIC_DOMAIN}}
```

### 2.3 Configurar Domínio Público

1. Vá em **"Settings"** → **"Networking"**
2. Clique em **"Generate Domain"**
3. Anote a URL: `https://voz-infantil-publico.up.railway.app`

### 2.4 Configurar Root Directory (Opcional)

Se quiser que apenas a pasta `usuario` seja pública:

1. Vá em **"Settings"** → **"Root Directory"**
2. Configure: `/usuario`

---

## 🔐 Passo 3: Deploy da Aplicação Admin (Restrita)

### 3.1 Criar Segundo Serviço

1. No mesmo projeto, clique em **"New"** → **"GitHub Repo"**
2. Selecione o **MESMO** repositório
3. Nome sugerido: **`voz-infantil-admin`**

### 3.2 Configurar Variáveis de Ambiente

No serviço admin, vá em **"Variables"** e adicione:

```env
# Banco de Dados (MESMO banco do serviço público)
DB_HOST=${{MYSQLHOST}}
DB_PORT=${{MYSQLPORT}}
DB_USER=${{MYSQLUSER}}
DB_PASS=${{MYSQLPASSWORD}}
DB_NAME=${{MYSQLDATABASE}}

# Configurações do Sistema
ENVIRONMENT=production
BASE_URL=${{RAILWAY_PUBLIC_DOMAIN}}
```

### 3.3 Configurar Root Directory

1. Vá em **"Settings"** → **"Root Directory"**
2. Configure: `/admin`

### 3.4 Configurar Domínio Admin

1. Vá em **"Settings"** → **"Networking"**
2. Clique em **"Generate Domain"**
3. Anote a URL: `https://voz-infantil-admin.up.railway.app`

### 3.5 Proteção Extra (IMPORTANTE!)

**Opção 1: Usar Domínio Customizado Privado**
- Configure um subdomínio não listado publicamente
- Exemplo: `admin-interno-xyz.seudominio.com`

**Opção 2: Restrição por IP (via Cloudflare)**
- Use Cloudflare Access
- Permita apenas IPs específicos

**Opção 3: Autenticação HTTP Básica**
Adicione no `.htaccess` do admin:
```apache
AuthType Basic
AuthName "Área Administrativa Restrita"
AuthUserFile /app/.htpasswd
Require valid-user
```

---

## 🔧 Passo 4: Configurações Finais

### 4.1 Verificar Permissões da Pasta Uploads

No Railway, a pasta `uploads` será criada automaticamente, mas verifique:

```bash
railway run chmod 755 uploads/
```

### 4.2 Testar Conexão com Banco

Acesse: `https://voz-infantil-publico.up.railway.app/test_connection.php`

Crie temporariamente:
```php
<?php
require_once 'config.php';
echo "Conexão OK! Banco: " . DB_NAME;
phpinfo();
?>
```

⚠️ **REMOVA ESTE ARQUIVO APÓS O TESTE!**

### 4.3 Criar Usuário Admin

Execute via Railway CLI:
```bash
railway run php admin/criar_primeiro_usuario.php
```

Ou acesse direto: `https://voz-infantil-admin.up.railway.app/criar_primeiro_usuario.php`

---

## 📊 Estrutura Final no Railway

```
Projeto: Voz Infantil
│
├── 🗄️ MySQL Database
│   └── voz_infantil (compartilhado)
│
├── 🌐 voz-infantil-publico
│   ├── URL: https://voz-infantil-publico.up.railway.app
│   ├── Root: /usuario
│   └── Variáveis: DB_*, ENVIRONMENT, BASE_URL
│
└── 🔐 voz-infantil-admin
    ├── URL: https://voz-infantil-admin.up.railway.app (PRIVADO)
    ├── Root: /admin
    └── Variáveis: DB_*, ENVIRONMENT, BASE_URL
```

---

## ✅ Checklist de Deploy

### Antes do Deploy
- [ ] Commit e push de todo código
- [ ] `.env.example` criado
- [ ] `config.php` configurado
- [ ] `.gitignore` atualizado
- [ ] Pasta `uploads/` com `.gitkeep`
- [ ] SQL do banco pronto

### Durante o Deploy
- [ ] MySQL criado no Railway
- [ ] SQL importado com sucesso
- [ ] Serviço público criado e configurado
- [ ] Serviço admin criado e configurado
- [ ] Variáveis de ambiente definidas
- [ ] Domínios gerados

### Após o Deploy
- [ ] Teste de conexão com banco
- [ ] Teste de envio de denúncia
- [ ] Teste de upload de arquivo
- [ ] Login admin funcionando
- [ ] Visualização de denúncias OK
- [ ] URLs protegidas (admin)

---

## 🐛 Troubleshooting

### Erro: "Connection refused"
- Verifique se as variáveis `DB_*` estão corretas
- Certifique-se de usar `${{MYSQLHOST}}` (referência Railway)

### Erro: "Table doesn't exist"
- Reimporte o SQL: `railway run mysql ... < bd/voz_infantil.sql`

### Erro: "Permission denied" em uploads
```bash
railway run chmod 755 uploads/
```

### Admin acessível publicamente
- Configure proteção por IP (Cloudflare)
- Use autenticação HTTP básica
- Considere VPN ou Tailscale

---

## 🔄 Atualizações

Para atualizar o código em produção:

```bash
git add .
git commit -m "Sua mensagem"
git push origin main
```

O Railway fará deploy automático! 🎉

---

## 💡 Dicas de Segurança

1. **Nunca** commite senhas no Git
2. Use senhas fortes para usuários admin
3. Mantenha a URL do admin privada
4. Configure HTTPS (Railway faz automático)
5. Monitore logs regularmente
6. Faça backup do banco semanalmente

---

## 📞 Suporte

- Railway Docs: https://docs.railway.app
- Community: https://discord.gg/railway

---

## 🎯 URLs Finais

Após o deploy, você terá:

- **Site Público**: `https://voz-infantil-publico.up.railway.app`
- **Painel Admin**: `https://voz-infantil-admin.up.railway.app` (⚠️ PRIVADO)
- **Banco MySQL**: Compartilhado entre ambos

✅ **Pronto para produção!**
