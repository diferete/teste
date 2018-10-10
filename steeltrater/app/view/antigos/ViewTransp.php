<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewTransp extends View {
      public function criaConsulta() {
        parent::criaConsulta();
        
        $oEmpoCod = new CampoConsulta('Código','empcod');
        $oEmpDes = new CampoConsulta('Empresa', 'empdes');
        $oEmpSit = new CampoConsulta('Situação','empativo');
        $oEmpSit->addComparacao('B', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_LINHA);
        
        $oCidade = new CampoConsulta('Cidade','Cidcep.cidnome');
        
        
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        $FiltroEmpcod = new Filtro($oEmpoCod, Filtro::CAMPO_TEXTO_IGUAL,2);
        $FiltroEmpdes = new Filtro($oEmpDes, Filtro::CAMPO_TEXTO,3);
        $this->addCampos($oEmpoCod,$oEmpDes,$oEmpSit,$oCidade);
        $this->addFiltro($FiltroEmpcod,$FiltroEmpdes);
        $this->setBScrollInf(TRUE);
    }
    
    public function criaTela() {
        parent::criaTela();
        $this->setTituloTela('Cadastro de Clientes e Fornecedores');
        $oEmpCod = new Campo('Código','empcod', Campo::TIPO_TEXTO,2);
        $oEmpdes = new Campo('Empresa','empdes', Campo::TIPO_TEXTO,4);
        $oEmpCnpj = new Campo('Cnpj/Cpf','empcnpj', Campo::TIPO_TEXTO,2);
        $oEmpCnpj->setSCorFundo(Campo::FUNDO_AMARELO);
        $oEmpSit = new Campo('Situação','empativo', Campo::TIPO_SELECT,2);
        $oEmpSit->addItemSelect('S', 'Ativo');
        $oEmpSit->addItemSelect('N','Inativo');
        
        $oEmpfant = new Campo('Fantasia','empfant', Campo::TIPO_TEXTO,3);
     
        $oEmpFone = new Campo('Telefone','empfone', Campo::TIPO_TEXTO,2);
        $oEmpFone->setBFone(true);
        
        $oEmailGeral = new Campo('E-mail','empinterne', Campo::TIPO_TEXTO,2);
        
        $oEmpEnd = new Campo('Endereço','empend', Campo::TIPO_TEXTO,3);
        
        $oEmpBair = new Campo('Bairro','empendbair', Campo::TIPO_TEXTO,2);
        
        $oEmpEstCod = new Campo('Estado','Cidcep.estcod', Campo::TIPO_TEXTO,1);
        
        $oCep = new Campo('CEP','Cidcep.cidcep', Campo::TIPO_TEXTO,2);
        $oCep->setBCEP(true);
        
        $oEmpIns = new Campo('Inscrição Estadual','empins', Campo::TIPO_TEXTO,2);
        
        $oCidade = new Campo('Cidade','Cidcep.cidnome', Campo::TIPO_TEXTO,2);
        
        $oObs = new Campo('Observações','empobs', Campo::TIPO_TEXTAREA,6);
        $oObs->setILinhasTextArea(7);
        $oObs->setSCorFundo(Campo::FUNDO_AMARELO);
        
        $oEmpUser = new Campo('Usuário de cadastro','empausucad', Campo::TIPO_TEXTO,2);
        $oDataca = new Campo('Data cadastro','empadtcad', Campo::TIPO_DATA,2);
        
        $oRepcod = new Campo('Representante','repcod', Campo::TIPO_TEXTO,1);
        
        $oTab = new TabPanel();
        $oTabGeral = new AbaTabPanel('Dados Gerais');
        $this->addLayoutPadrao('Aba');
        $oTabGeral->setBActive(true);
       
        $oTabGeral->addCampos(array($oEmpCod,$oEmpdes,$oEmpCnpj),array($oEmpfant,$oEmpSit),
                $oEmpFone,array(/*$oEmailGeral,*/$oEmpEnd, $oEmpBair,$oCidade,$oEmpEstCod),array($oCep,$oEmpIns),$oObs,
                array($oEmpUser,$oDataca),$oRepcod);
        $oTab->addItems($oTabGeral);
        
        $this->addCampos($oTab);
    }
}