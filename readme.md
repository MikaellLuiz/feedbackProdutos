# Sistema de Feedback de Produtos

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
│   ├── FeedbackController.php
│   ├── ProdutoController.php
│   └── UsuarioController.php
├── dao/                    # Camada de acesso a dados
│   ├── mysql/              # Implementações específicas para MySQL
│   │   ├── FeedbackDAO.php
│   │   ├── ProdutoDAO.php
│   │   └── UsuarioDAO.PHP
│   ├── IFeedbackDAO.php    # Interfaces que definem os contratos
│   ├── IProdutoDAO.php
│   └── IUsuarioDAO.php
├── service/                # Camada de serviços para regras de negócio
│   ├── FeedbackService.php
│   ├── ProdutoService.php
│   └── UsuarioService.php
├── genetic/                # Classes genéricas e utilitárias
│   ├── Acao.php            # Classe para execução de ações nos controladores
│   ├── Autoloader.php      # Carregador automático de classes
│   ├── Controller.php      # Controlador genérico para roteamento
│   ├── MysqlFactory.php    # Fábrica para criação de objetos de banco de dados
│   └── MysqlSingleton.php  # Implementação de Singleton para conexão com o MySQL
├── database_feedbackProdutos.sql  # Script SQL para criação do banco de dados
├── index.php               # Ponto de entrada da aplicação
└── README.md               # Documentação do projeto
```

## 🏗️ Padrões de Projeto Implementados

1. **MVC (Model-View-Controller)**:
   - **Model**: Representado pelas classes DAO e Services
   - **View**: Templates a serem implementados (HTML/CSS)
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

1. **usuarios**: Armazena informações dos usuários (id, nome, email, senha, admin)
2. **produtos**: Contém dados dos produtos (id, descricao, preco, imagem)
3. **feedbacks**: Registra avaliações dos usuários sobre produtos (id, produto_id, usuario_id, nota, comentario)

O script para criação do banco está disponível no arquivo `database_feedbackProdutos.sql`.

## 🚀 Como Executar o Projeto

1. **Configuração do Ambiente**:
   - Instale um servidor web local (XAMPP, WAMP, etc.)
   - Configure um servidor MySQL
   - PHP 7.4 ou superior

2. **Configuração do Banco de Dados**:
   - Crie um banco de dados MySQL chamado `feedback_produtos`
   - Importe o arquivo `database_feedbackProdutos.sql`

3. **Configuração do Projeto**:
   - Clone este repositório na pasta do seu servidor web
   - Verifique as configurações de conexão em `genetic/MysqlSingleton.php`

4. **Execução**:
   - Acesse o projeto através do navegador: `http://localhost/feedbackProdutos`

## 👥 Autores

Este projeto foi desenvolvido como trabalho acadêmico para a disciplina de Aplicações para Internet na Universidade de Uberaba (UNIUBE), pelos alunos:

- Carlos Alberto Rocha Neto
- Mikael Luiz de Lima Fernandes

---

Desenvolvido em abril de 2025 como parte da avaliação da disciplina de Aplicações para Internet.