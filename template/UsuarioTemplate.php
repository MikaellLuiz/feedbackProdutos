<?php

namespace CasasLuiza\template;

class UsuarioTemplate implements ITemplate {
    public function cabecalho() {
        include dirname(dirname(__FILE__)) . "/public/common/header.php";
    }

    public function rodape() {
        include dirname(dirname(__FILE__)) . "/public/common/footer.php";
    }

    public function layout($caminho, $parametro = null) {
        $this->cabecalho();
        include dirname(dirname(__FILE__)) . "/public" . $caminho;
        $this->rodape();
    }
}