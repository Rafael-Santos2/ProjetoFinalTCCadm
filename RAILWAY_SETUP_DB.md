# Configuração do Banco de Dados no Railway

## ⚠️ IMPORTANTE: Seu projeto precisa de um banco de dados MySQL

O erro que você está vendo acontece porque o Railway ainda não tem um banco de dados MySQL configurado.

## 📋 Passos para Configurar:

### 1. Adicionar MySQL ao Projeto no Railway

1. Acesse seu projeto no Railway: https://railway.app/
2. Clique no botão **"+ New"** dentro do seu projeto
3. Selecione **"Database"**
4. Escolha **"MySQL"**
5. O Railway vai criar automaticamente o banco MySQL

### 2. Conectar o Banco ao Seu Aplicativo

O Railway vai criar automaticamente essas variáveis de ambiente:
- `MYSQLHOST`
- `MYSQLUSER`
- `MYSQLPASSWORD`
- `MYSQLDATABASE`
- `MYSQLPORT`

O seu código já está configurado para usar essas variáveis automaticamente!

### 3. Importar o Esquema do Banco

Você precisa importar o arquivo `bd/voz_infantil.sql` para o banco de dados.

**Opção A - Via Railway Dashboard:**
1. No Railway, clique no serviço MySQL
2. Vá em **"Data"** ou **"Connect"**
3. Use um cliente MySQL (como MySQL Workbench, DBeaver ou phpMyAdmin)
4. Conecte usando as credenciais mostradas
5. Execute o arquivo `bd/voz_infantil.sql`

**Opção B - Via Terminal (se habilitado):**
```bash
mysql -h $MYSQLHOST -u $MYSQLUSER -p$MYSQLPASSWORD $MYSQLDATABASE < bd/voz_infantil.sql
```

### 4. Criar o Primeiro Usuário Administrativo

Após importar o banco, acesse:
```
https://projetofinaltccadm-production.up.railway.app/admin/criar_primeiro_usuario.php
```

Preencha o formulário para criar seu primeiro usuário policial/admin.

### 5. Acessar o Sistema

Depois de criar o usuário, acesse:
```
https://projetofinaltccadm-production.up.railway.app/admin/index.php
```

## 🔍 Verificar Configuração

Acesse o arquivo de diagnóstico para verificar se tudo está OK:
```
https://projetofinaltccadm-production.up.railway.app/diagnostico.php
```

Este arquivo mostra:
- ✅ Variáveis de ambiente configuradas
- ✅ Conexão com o banco funcionando
- ✅ Tabelas existentes
- ✅ Arquivos do projeto

## 📝 Variáveis Adicionais (Opcionais)

Você pode adicionar estas variáveis no Railway:

- `BASE_URL` - URL do seu site (exemplo: https://projetofinaltccadm-production.up.railway.app)
- `ENVIRONMENT` - Definir como `production` para esconder erros detalhados

## ❓ Problemas Comuns

### Erro: "Erro ao conectar ao banco de dados"
- Verifique se o MySQL foi adicionado ao projeto
- Verifique se as variáveis de ambiente estão definidas
- Use o arquivo `diagnostico.php` para ver detalhes

### Erro: "Tabela 'usuarios' não existe"
- Você precisa importar o arquivo `bd/voz_infantil.sql`

### Erro 500
- Acesse `diagnostico.php` para ver o problema específico
- Verifique os logs do Railway

## 🆘 Suporte

Se precisar de ajuda, verifique:
1. Logs do Railway (clique no serviço → aba "Deployments")
2. Arquivo `diagnostico.php`
3. Documentação do Railway: https://docs.railway.app/
