<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllerEquipamentoTiTipo
 *
 * @author Carlos
 */
class ControllerTiEquipamentoTipo extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('TiEquipamentoTipo');
    }
}