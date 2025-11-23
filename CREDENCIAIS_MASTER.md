# 🔐 Credenciais de Acesso Master

## Delegado Responsável - Acesso Administrativo

Para o primeiro acesso ao sistema, utilize as credenciais abaixo:

### 📧 Credenciais Master

```
Email: delegado@policia.sp.gov.br
Senha: Delegado@2025
```

### 🎯 Como usar:

1. Acesse: `https://projetofinaltccadm-production.up.railway.app/admin/`
2. Clique em **"Entrar no Sistema"**
3. Use as credenciais master acima
4. Você terá acesso administrativo completo
5. Cadastre outros usuários através do botão **"+ Novo Usuário"** no dashboard

### ⚠️ IMPORTANTE - Segurança:

- ✅ Estas credenciais estão **hardcoded** no sistema
- ✅ Funcionam mesmo sem banco de dados configurado
- ✅ Permitem acesso administrativo completo
- ⚠️ **NUNCA compartilhe essas credenciais**
- ⚠️ Após configurar o sistema, cadastre seu próprio usuário
- 🔒 Em produção, considere alterar estas credenciais no código

### 📝 Próximos passos após primeiro login:

1. Configure o banco de dados MySQL no Railway
2. Importe o schema do banco (`bd/voz_infantil.sql`)
3. Cadastre usuários oficiais através da interface
4. Os usuários cadastrados terão suas senhas armazenadas com hash seguro

### 🗂️ Tipos de Usuários que você pode cadastrar:

- **Administrador**: Acesso completo ao sistema
- **Policial**: Pode visualizar e gerenciar denúncias
- **Operador**: Acesso limitado às funcionalidades

---

**Sistema Voz Infantil** - Proteção à Infância e Adolescência
