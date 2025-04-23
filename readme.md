# Sistema de Feedback de Produtos - Casas Luiza

Este projeto foi desenvolvido como parte da disciplina de Aplicações para Internet na Universidade de Uberaba (UNIUBE), com o objetivo de criar um sistema web utilizando PHP e o padrão de arquitetura MVC (Model-View-Controller), junto com outros padrões de projeto como DAO (Data Access Object) e Service.

## 📋 Descrição do Projeto

O Sistema de Feedback de Produtos permite que usuários cadastrados façam avaliações e deixem comentários sobre produtos. O sistema possibilita o gerenciamento completo de usuários, produtos e seus respectivos feedbacks, implementando todas as operações CRUD (Create, Read, Update, Delete).

## 🛠️ Tecnologias Utilizadas

- **PHP 8.4.3**: Linguagem de programação principal
- **MySQL**: Sistema de gerenciamento de banco de dados
- **HTML/CSS**: Para estruturação e estilização das páginas
- **Padrões de Projeto**: MVC, DAO, Singleton, Factory, Service

## 🗂️ Estrutura do Projeto

O projeto segue uma arquitetura em camadas bem definida:

```
feedbackProdutos/
├── controller/             # Controladores que gerenciam as requisições
├── dao/                    # Camada de acesso a dados
│   ├── mysql/              # Implementações específicas para MySQL
│   └── interfaces          # Interfaces que definem os contratos
├── service/                # Camada de serviços para regras de negócio
├── generic/                # Classes genéricas e utilitárias
│   ├── Acao.php            # Classe para execução de ações nos controladores
│   ├── Autoloader.php      # Carregador automático de classes
│   ├── Controller.php      # Controlador genérico para roteamento
│   ├── DotEnv.php          # Carrega variáveis de ambiente
│   ├── MysqlFactory.php    # Fábrica para criação de objetos de banco de dados
│   └── MysqlSingleton.php  # Implementação de Singleton para conexão com o MySQL
├── public/                 # Recursos públicos (CSS, imagens, templates)
│   ├── common/             # Componentes comuns (header, footer)
│   ├── css/                # Arquivos de estilo
│   ├── img/                # Imagens do sistema
│   │   └── produtos/       # Imagens dos produtos
│   ├── feedback/           # Templates para feedback
│   ├── produto/            # Templates para produtos
│   └── usuario/            # Templates para usuários
├── template/               # Classes de template
├── create_feedbackProdutos.sql  # Script SQL para criação do banco (estrutura inicial)
├── backup_feedbackProdutos.sql  # Script SQL para restauração completa do banco
├── backup_feedbackProdutos_xampp.sql # Script SQL adaptado para ambiente XAMPP
├── index.php               # Ponto de entrada da aplicação
└── README.md               # Documentação do projeto
```

## 🏗️ Padrões de Projeto Implementados

1. **MVC (Model-View-Controller)**:
   - **Model**: Representado pelas classes DAO e Services
   - **View**: Templates PHP que geram a interface do usuário
   - **Controller**: Classes que processam as requisições e coordenam o fluxo

2. **DAO (Data Access Object)**:
   - Interfaces definem contratos para acesso a dados
   - Implementações específicas para MySQL encapsulam detalhes do banco

3. **Factory**:
   - MysqlFactory fornece uma forma unificada de criar objetos relacionados ao banco

4. **Singleton**:
   - MysqlSingleton garante uma única instância de conexão com o banco

5. **Service**:
   - Camada que encapsula regras de negócio e coordena operações entre DAOs

## 📊 Banco de Dados

O sistema utiliza um banco de dados MySQL com três tabelas principais:

1. **usuarios**: Armazena informações dos usuários (id, nome, email, senha, admin, deleted)
2. **produtos**: Contém dados dos produtos (id, nome, descricao, preco, imagem)
3. **feedbacks**: Registra avaliações dos usuários sobre produtos (id, produto_id, usuario_id, nota, comentario)

### 🔄 Opções para Criação do Banco de Dados

O projeto disponibiliza dois arquivos SQL para configuração do banco de dados:

#### Opção 1: Criação de Banco Novo (apenas estrutura e usuário admin)

Use o arquivo `create_feedbackProdutos.sql` para criar um banco de dados limpo com apenas a estrutura e o usuário administrador padrão.

**Passo a passo:**

1. Abra o MySQL Workbench e conecte-se ao seu servidor
2. Selecione: **Server > Data Import**
3. Escolha **Import from Self-Contained File** e localize o arquivo `create_feedbackProdutos.sql`
4. Selecione **New** para criar um novo esquema chamado `feedback_produtos` (ou use um existente)
5. Clique em **Start Import**

**Alternativa via linha de comando:**

```bash
mysql -u [seu_usuario] -p < create_feedbackProdutos.sql
```

#### Opção 2: Restauração de Backup (com dados de demonstração)

Use o arquivo `backup_feedbackProdutos.sql` para restaurar o banco de dados com produtos de demonstração.

**Passo a passo:**

1. Abra o MySQL Workbench e conecte-se ao seu servidor
2. Selecione: **Server > Data Import**
3. Escolha **Import from Self-Contained File** e localize o arquivo `backup_feedbackProdutos.sql`
4. Selecione **New** para criar um novo esquema chamado `feedback_produtos` (ou use um existente)
5. Clique em **Start Import**

**Alternativa via linha de comando:**

```bash
mysql -u [seu_usuario] -p < backup_feedbackProdutos.sql
```

## ⚙️ Configuração do Ambiente

1. **Requisitos**:
   - Servidor web (Apache, Nginx)
   - PHP 8.x
   - MySQL 8.x

2. **Configuração do arquivo .env**:
   Crie um arquivo `.env` na raiz do projeto com as seguintes configurações:

   ```
   DB_HOST=localhost
   DB_NAME=feedback_produtos
   DB_USER=seu_usuario
   DB_PASSWORD=sua_senha
   ```

3. **Permissões**:
   - Certifique-se de que a pasta `public/img/produtos` tenha permissão de escrita para upload de imagens

## 🚀 Como Executar o Projeto

1. **Configuração do Servidor Web**:
   - Clone este repositório na pasta do seu servidor web
   - Configure o servidor para apontar para a pasta do projeto

2. **Inicialização**:
   - Acesse o projeto através do navegador: `http://localhost/feedbackProdutos`
   - Faça login com as credenciais do administrador:
     - Email: `admin@casasluiza.com`
     - Senha: `admin123`

## 📦 Instalação no XAMPP

Se você estiver utilizando o XAMPP como ambiente de desenvolvimento, siga estas instruções específicas:

### Passo 1: Copiar os arquivos para o XAMPP

1. Clone ou copie todos os arquivos do projeto para a pasta `htdocs/feedbackProdutos` do seu XAMPP:
   ```
   C:\xampp\htdocs\feedbackProdutos\
   ```

### Passo 2: Configurar o banco de dados no XAMPP

1. Inicie o XAMPP Control Panel e ative os serviços Apache e MySQL
2. Abra o phpMyAdmin no navegador: http://localhost/phpmyadmin
3. Crie um novo banco de dados chamado `feedback_produtos` (Collation: utf8mb4_general_ci)
4. Selecione o banco de dados criado e clique na aba "SQL"
5. Copie e cole o conteúdo do arquivo `backup_feedbackProdutos_xampp.sql` e execute-o

### Passo 3: Configurar o arquivo .env para XAMPP

1. Crie um arquivo `.env` na raiz do projeto com as seguintes configurações:
   ```
   DB_HOST=localhost
   DB_NAME=feedback_produtos
   DB_USER=root
   DB_PASSWORD=
   ```
   **Observação**: Ajuste o usuário e senha conforme sua instalação do XAMPP

### Passo 4: Acessar o sistema

1. Acesse o sistema através do navegador:
   ```
   http://localhost/feedbackProdutos/
   ```

### ⚠️ Observações importantes para XAMPP

- O sistema está configurado para funcionar no subdiretório `/feedbackProdutos`. Todos os links já foram adaptados para este caminho.
- As imagens de produtos serão salvas como `/feedbackProdutos/public/img/produtos/[nome_arquivo]`.
- Caso tenha um erro 404, verifique se o mod_rewrite está ativado no Apache do XAMPP:
  - Edite o arquivo `httpd.conf` do XAMPP e descomente a linha `LoadModule rewrite_module modules/mod_rewrite.so`
  - Reinicie o servidor Apache

## 🔐 Funcionalidades Disponíveis

### Para Administradores:
- Gerenciar usuários (criar, editar, desativar)
- Gerenciar produtos (adicionar, editar, remover)
- Visualizar todos os feedbacks

### Para Usuários Comuns:
- Visualizar produtos
- Deixar avaliações e comentários
- Gerenciar seu próprio perfil

## 👥 Autores

Este projeto foi desenvolvido como trabalho acadêmico para a disciplina de Aplicações para Internet na Universidade de Uberaba (UNIUBE), pelos alunos:

- Carlos Alberto Rocha Neto
- Mikael Luiz de Lima Fernandes

---

Desenvolvido em abril de 2025 como parte da avaliação da disciplina de Aplicações para Internet.