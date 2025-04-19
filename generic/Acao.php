<?php
namespace CasasLuiza\generic;

/**
 * Classe Acao
 * 
 * Responsável por instanciar um controlador e executar um método específico
 * Utilizada para o roteamento de ações no sistema
 */
class Acao{
    /**
     * @var string Nome da classe do controlador a ser instanciado
     */
    private $classe;
    
    /**
     * @var string Nome do método a ser executado
     */
    private $metodo;

    /**
     * Construtor da classe Acao
     * 
     * @param string $classe Nome da classe do controlador
     * @param string $metodo Nome do método a ser executado
     */
    public function __construct($classe, $metodo)
    {
        $this->classe = "CasasLuiza\\controller\\".$classe;
        $this->metodo = $metodo;
        
    }

    /**
     * Executa a ação solicitada
     * 
     * Instancia a classe do controlador e executa o método definido
     * 
     * @return mixed Resultado da execução do método
     */
    public function executar(){
        $obj = new $this->classe();
        $obj->{$this->metodo}();
    }
}