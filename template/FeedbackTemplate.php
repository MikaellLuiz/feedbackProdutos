<?php

namespace CasasLuiza\template;

/**
 * Classe FeedbackTemplate
 * 
 * Implementa a interface ITemplate para renderização das views relacionadas a feedbacks
 * 
 * @package CasasLuiza\template
 */
class FeedbackTemplate implements ITemplate {
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
        $this->cabecalho();
        include dirname(dirname(__FILE__)) . "/public" . $caminho;
        $this->rodape();
    }
}