<?php
namespace CasasLuiza\template;

/**
 * Interface ITemplate
 * 
 * Define os métodos obrigatórios para implementação de templates no sistema
 * 
 * @package CasasLuiza\template
 */
interface ITemplate {
    /**
     * Renderiza o cabeçalho da página
     * 
     * @return void
     */
    public function cabecalho();
    
    /**
     * Renderiza o rodapé da página
     * 
     * @return void
     */
    public function rodape();
    
    /**
     * Renderiza o layout principal da página
     * 
     * @param string $caminho Caminho para o arquivo de view
     * @param mixed $parametro Parâmetros a serem passados para a view
     * @return void
     */
    public function layout($caminho, $parametro = null);
}