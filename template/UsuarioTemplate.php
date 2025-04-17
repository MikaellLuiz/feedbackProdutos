<?php

namespace CasasLuiza\template;

class UsuarioTemplate implements ITemplate {
    public function cabecalho() {
        include $_SERVER["DOCUMENT_ROOT"] . "/feedbackProdutos/public/common/header.php";
    }

    public function rodape() {
        include $_SERVER["DOCUMENT_ROOT"] . "/feedbackProdutos/public/common/footer.php";
    }

    public function layout($caminho, $parametro = null) {
        $this->cabecalho();
        include $_SERVER["DOCUMENT_ROOT"] . "/feedbackProdutos/public" . $caminho;
        $this->rodape();
    }
}