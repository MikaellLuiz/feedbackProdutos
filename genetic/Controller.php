<?php

namespace CasasLuiza\generic;

class Controller{
    private $arrChamadas=[];
    public function __construct()
    {
        $this->arrChamadas = [
            // Rotas para Usuário
            "usuario/lista" => new Acao("UsuarioController", "listar"),
            "usuario/novo" => new Acao("UsuarioController", "novo"),
            "usuario/editar" => new Acao("UsuarioController", "editar"),
            "usuario/excluir" => new Acao("UsuarioController", "excluir"),
            
            // Rotas para Produto
            "produto/lista" => new Acao("ProdutoController", "listar"),
            "produto/novo" => new Acao("ProdutoController", "novo"),
            "produto/editar" => new Acao("ProdutoController", "editar"),
            "produto/excluir" => new Acao("ProdutoController", "excluir"),
            
            // Rotas para Feedback
            "feedback/lista" => new Acao("FeedbackController", "listar"),
            "feedback/novo" => new Acao("FeedbackController", "novo"),
            "feedback/editar" => new Acao("FeedbackController", "editar"),
            "feedback/excluir" => new Acao("FeedbackController", "excluir"),
        ];
    }

    public function verificarChamadas($rota){
       
        if(isset($this->arrChamadas[$rota])){
            $acao = $this->arrChamadas[$rota];
            $acao->executar();
            return ;
        }

        echo "Rota não existe!";
    }
}