# 📋 Instruções de Deploy - Voz Infantil

## Pré-requisitos

- Servidor web com PHP 7.4+ e MySQL 5.7+
- Apache com mod_rewrite habilitado
- Permissões de escrita na pasta `uploads/`

## Passos para Deploy

### 1. Clonar o Repositório

```bash
git clone [URL_DO_REPOSITORIO]
cd pf
```

### 2. Verificar Permissões da Pasta Uploads

A pasta `uploads/` deve ter permissões de escrita:

```bash
chmod 755 uploads/
```

### 3. Configurar Banco de Dados

1. Importe o arquivo SQL:
   ```bash
   mysql -u root -p < bd/voz_infantil.sql
   ```

2. Configure a conexão em `admin/inc/conexao.php` e `usuario/denuncia/inc/conexao.php`:
   ```php
   $host = "localhost";
   $usuario = "seu_usuario";
   $senha = "sua_senha";
   $banco = "voz_infantil";
   ```

### 4. Verificar Arquivos de Segurança

Certifique-se de que os seguintes arquivos existem na pasta uploads:
- ✅ `.htaccess` - Proteção de segurança
- ✅ `index.php` - Impede listagem de diretório
- ✅ `.gitkeep` - Mantém a pasta no Git

### 5. Testar o Sistema

1. Acesse: `http://seu-dominio/pf/usuario/index.php`
2. Teste uma denúncia com arquivo anexo
3. Faça login na área administrativa: `http://seu-dominio/pf/admin/login.php`
4. Verifique se o arquivo foi salvo corretamente

## Segurança em Produção

### Permissões Recomendadas

```bash
# Arquivos PHP
find . -type f -name "*.php" -exec chmod 644 {} \;

# Pastas
find . -type d -exec chmod 755 {} \;

# Pasta uploads (precisa de escrita)
chmod 755 uploads/
```

### Configurações Apache

Certifique-se de que o arquivo `.htaccess` está ativo na pasta uploads:

```apache
Options -Indexes
```

### Variáveis de Ambiente (Recomendado)

Para maior segurança, use variáveis de ambiente para credenciais do banco:

```php
$host = getenv('DB_HOST') ?: 'localhost';
$usuario = getenv('DB_USER') ?: 'root';
$senha = getenv('DB_PASS') ?: '';
$banco = getenv('DB_NAME') ?: 'voz_infantil';
```

### Backup

### Banco de Dados

```bash
mysqldump -u root -p voz_infantil > backup_$(date +%Y%m%d).sql
```

### Arquivos de Upload

```bash
tar -czf uploads_backup_$(date +%Y%m%d).tar.gz uploads/
```

## Troubleshooting

### Erro: "Pasta uploads não encontrada"

```bash
mkdir -p uploads
chmod 755 uploads
```

### Erro: "Permissão negada ao salvar arquivo"

```bash
chown -R www-data:www-data uploads/
chmod 755 uploads/
```

### Erro: "Arquivo não pode ser visualizado"

Verifique se o `.htaccess` permite o tipo de arquivo:
```apache
<FilesMatch "\.(jpg|jpeg|png|gif|pdf|doc|docx)$">
    Allow from all
</FilesMatch>
```

## Suporte

Para questões técnicas, consulte a documentação completa no README.md principal do projeto.
