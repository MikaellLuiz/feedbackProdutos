<?php

namespace CasasLuiza\generic;

/**
 * Classe Controller
 * 
 * Implementa o sistema de roteamento principal da aplicação
 * Mapeia as rotas para as ações correspondentes nos controladores
 */
class Controller{
    /**
     * @var array Mapeamento das rotas para as respectivas ações
     */
    private $arrChamadas=[];
    
    /**
     * Construtor da classe Controller
     * 
     * Inicializa o mapeamento de rotas da aplicação
     */
    public function __construct()
    {
        $this->arrChamadas = [
            // Rota padrão
            "" => new Acao("ProdutoController", "listar"),
            
            // Rotas de usuário mantidas (login, autenticação e perfil)
            "usuario/perfil" => new Acao("UsuarioController", "perfil"),
            "usuario/editar_ajax" => new Acao("UsuarioController", "editarAjax"),
            "usuario/alterar_senha_ajax" => new Acao("UsuarioController", "alterarSenhaAjax"),
            "usuario/login" => new Acao("UsuarioController", "login"),
            "usuario/autenticar" => new Acao("UsuarioController", "autenticar"),
            "usuario/registrar" => new Acao("UsuarioController", "registrar"),
            "usuario/completar_registro" => new Acao("UsuarioController", "completarRegistro"),
            "usuario/logout" => new Acao("UsuarioController", "logout"),
            
            // Painel de administração agora com todas as funcionalidades de gerenciamento de usuários
            "usuario/admin" => new Acao("UsuarioController", "admin"),
            "usuario/excluir" => new Acao("UsuarioController", "excluir"),
            
            // Redirecionamentos da antiga aba de usuários para o painel admin
            "usuario/listar" => new Acao("UsuarioController", "admin"),
            "usuario/novo" => new Acao("UsuarioController", "admin"),
            "usuario/editar" => new Acao("UsuarioController", "admin"),
            
            // Rotas para Produto
            "produto/listar" => new Acao("ProdutoController", "listar"),
            "produto/novo" => new Acao("ProdutoController", "novo"),
            "produto/editar" => new Acao("ProdutoController", "editar"),
            "produto/excluir" => new Acao("ProdutoController", "excluir"),
            "produto/detalhes" => new Acao("ProdutoController", "detalhes"),
            
            // Rotas para Feedback
            "feedback/listar" => new Acao("FeedbackController", "listar"),
            "feedback/novo" => new Acao("FeedbackController", "novo"),
            "feedback/editar" => new Acao("FeedbackController", "editar"),
            "feedback/excluir" => new Acao("FeedbackController", "excluir"),
            "feedback/adicionar_ajax" => new Acao("FeedbackController", "adicionar_ajax"),
            "feedback/editar_ajax" => new Acao("FeedbackController", "editar_ajax"),
            "feedback/excluir_ajax" => new Acao("FeedbackController", "excluir_ajax"),
        ];
    }

    /**
     * Verifica e executa a ação correspondente à rota solicitada
     * 
     * @param string $rota A rota solicitada pelo usuário
     * @return void
     */
    public function verificarChamadas($rota){
       
        if(isset($this->arrChamadas[$rota])){
            $acao = $this->arrChamadas[$rota];
            $acao->executar();
            return;
        }

        echo "Rota não existe!";
    }
}