<?php

namespace CasasLuiza\generic;

class Controller{
    private $arrChamadas=[];
    public function __construct()
    {
        $this->arrChamadas = [
            // Rota padrão
            "" => new Acao("ProdutoController", "listar"),
            
            // Rotas para Usuário
            "usuario/listar" => new Acao("UsuarioController", "listar"),
            "usuario/novo" => new Acao("UsuarioController", "novo"),
            "usuario/editar" => new Acao("UsuarioController", "editar"),
            "usuario/excluir" => new Acao("UsuarioController", "excluir"),
            
            // Rotas para autenticação
            "usuario/login" => new Acao("UsuarioController", "login"),
            "usuario/autenticar" => new Acao("UsuarioController", "autenticar"),
            "usuario/registrar" => new Acao("UsuarioController", "registrar"),
            "usuario/completar_registro" => new Acao("UsuarioController", "completarRegistro"),
            "usuario/logout" => new Acao("UsuarioController", "logout"),
            
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
        ];
    }

    public function verificarChamadas($rota){
       
        if(isset($this->arrChamadas[$rota])){
            $acao = $this->arrChamadas[$rota];
            $acao->executar();
            return;
        }

        echo "Rota não existe!";
    }
}