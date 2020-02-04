<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerFamProd extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('FamProd');
    }

    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);

        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        if (count($aCampos) > 0) {
            if (isset($aCampos['param'])) {
                return;
            } else {
                $this->Persistencia->adicionaFiltro('grucod', $aCampos['grucod']);
                $this->Persistencia->adicionaFiltro('subcod', $aCampos['subcod']);
            }
        }
    }

    public function antesValorBuscaPk() {
        parent::antesValorBuscaPk();

        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        if (count($aCampos) > 0) {
            if (isset($aCampos['param'])) {
                return;
            } else {
                $this->Persistencia->adicionaFiltro('grucod', $aCampos['grucod']);
                $this->Persistencia->adicionaFiltro('subcod', $aCampos['subcod']);
            }
        }
    }

}
