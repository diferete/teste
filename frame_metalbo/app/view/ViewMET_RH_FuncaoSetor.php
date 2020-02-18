<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_RH_FuncaoSetor extends View{
    public function __construct() {
        parent::__construct();
    }
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oNr = new CampoConsulta('Nr', 'nr');
        $oFilcgc = new CampoConsulta('Emp.', 'filcgc');
        $oSetor = new CampoConsulta('Setor', 'codsetor');
        $oCodFunc = new CampoConsulta('Cod.Setor', 'descsetor');
        $oCodcFunc = new CampoConsulta('Cod.Func.', 'codfuncao');
        $oDescFunc = new CampoConsulta('Desc.Func.', 'descfuncao');
        
        $this->addCampos($oNr,$oFilcgc,$oSetor,$oCodFunc,$oCodcFunc,$oDescFunc);
        
    }
    
    public function criaTela() {
        parent::criaTela();
    }
}