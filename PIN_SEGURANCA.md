# 🔐 PIN de Segurança para Cadastro

## Sistema de Proteção

Para evitar cadastros não autorizados, o sistema utiliza um **PIN de segurança**.

### 📌 PIN Atual

```
PIN: 2025
```

### 🔒 Como funciona:

1. **Primeiro usuário (sem PIN):**
   - Se não existe nenhum usuário no sistema
   - O cadastro é livre (não pede PIN)
   - O primeiro usuário é automaticamente **Administrador**

2. **Demais usuários (COM PIN):**
   - Se já existem usuários cadastrados
   - **Exige PIN de segurança** para cadastrar
   - Apenas quem tiver o PIN pode criar novas contas

3. **Admin logado (sem PIN):**
   - Se um admin já está logado no sistema
   - Não precisa de PIN
   - Pode cadastrar usuários direto do dashboard

### 🎯 Casos de uso:

#### Caso 1: Primeiro acesso ao sistema
```
- Acessa /admin/cadastrar.php
- Preenche: Nome, Email, Senha
- NÃO pede PIN
- Cria primeiro admin ✅
```

#### Caso 2: Cadastro com PIN (sem estar logado)
```
- Acessa /admin/cadastrar.php
- Preenche: Nome, Email, Senha
- PEDE PIN: 2025 🔑
- Só cadastra se o PIN estiver correto ✅
```

#### Caso 3: Admin cadastrando via dashboard
```
- Admin já logado
- Clica "+ Novo Usuário"
- NÃO pede PIN
- Cadastra diretamente ✅
```

### ⚙️ Como alterar o PIN:

Edite o arquivo `admin/cadastrar.php` e altere a linha:

```php
define('PIN_CADASTRO', '2025'); // Altere '2025' para seu PIN
```

**Exemplos de PINs seguros:**
- `PCSP2025`
- `DEL3G4C1A`
- `V0Z1NF4NT1L`
- Qualquer combinação de números e letras

### 🛡️ Segurança:

- ✅ PIN armazenado no código (não no banco)
- ✅ Impede cadastros não autorizados
- ✅ Primeiro usuário sempre livre (bootstrap)
- ✅ Admins logados não precisam de PIN
- ⚠️ **Compartilhe o PIN apenas com pessoas autorizadas**

### 📋 Distribuindo o PIN:

Compartilhe este PIN com:
- ✅ Delegados
- ✅ Chefes de equipe
- ✅ Responsáveis pela gestão do sistema
- ❌ Não compartilhe publicamente

---

**Sistema Voz Infantil** - Proteção à Infância e Adolescência
