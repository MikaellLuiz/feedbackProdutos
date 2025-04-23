<?php

namespace CasasLuiza\template;

/**
 * Classe UsuarioTemplate
 * 
 * Implementa a interface ITemplate para renderização das views relacionadas a usuários
 * 
 * @package CasasLuiza\template
 */
class UsuarioTemplate implements ITemplate {
    /**
     * {@inheritdoc}
     */
    public function cabecalho() {
        include dirname(dirname(__FILE__)) . "/public/common/header.php";
    }

    /**
     * {@inheritdoc}
     */
    public function rodape() {
        include dirname(dirname(__FILE__)) . "/public/common/footer.php";
    }

    /**
     * {@inheritdoc}
     */
    public function layout($caminho, $parametro = null) {
        // Define a base URL para o XAMPP
        global $baseUrl;
        
        $this->cabecalho();
        include dirname(dirname(__FILE__)) . "/public" . $caminho;
        $this->rodape();
    }
}