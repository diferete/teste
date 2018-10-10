<?php

/* 
 * Classe que implementa as ordens de fabricação steel
 * 
 * @author Cleverton Hoffmann
 * @since 31/07/2018
 */

class ViewSTEEL_PCP_OrdensFabApontLista extends View{
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oBotaoModal = new CampoConsulta('','apontar', CampoConsulta::TIPO_MODAL);
        $oBotaoModal->setBHideTelaAcao(true);
        $oBotaoModal->setILargura(15);
        $oBotaoModal->setSTitleAcao('Coloca item na lista!');
        $oBotaoModal->addAcao('STEEL_PCP_ordensFabApontLista','criaTelaModalProposta','modalLista');
        $this->addModais($oBotaoModal);
       
        
        
        
        $oOp = new CampoConsulta('Op','op');
        $oTempRev = new CampoConsulta('Temp.Rev','temprev', CampoConsulta::TIPO_DECIMAL);
        $oTempRev->setBOrderBy(true);
        $oData = new CampoConsulta('Data','data', CampoConsulta::TIPO_DATA);
        $oCodigo = new CampoConsulta('Codigo','prod');
        $oProdes = new CampoConsulta('Descrição','prodes');
  
        $oPeso = new CampoConsulta('Peso','peso', CampoConsulta::TIPO_DECIMAL);
        $oSituacao = new CampoConsulta('Sit.Op', 'situacao');
       
        
        $oSitLista = new CampoConsulta('Sit.Lista', 'STEEL_PCP_ordensFabLista.situacao');
       // $oSitLista->addComparacao('Aberta', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE,CampoConsulta::MODO_COLUNA);
        $oSitLista->addComparacao('Espera', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL,CampoConsulta::MODO_COLUNA);
        $oSitLista->addComparacao('Liberado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE,CampoConsulta::MODO_COLUNA);
        $oSitLista->addComparacao('Processo', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_ROXO,CampoConsulta::MODO_COLUNA);
        
        $oCliente = new CampoConsulta('Cliente','emp_razaosocial');
        
        $oOpFiltro = new Filtro($oOp, Filtro::CAMPO_TEXTO_IGUAL,1);
        $oCodigoFiltro = new Filtro($oCodigo, Filtro::CAMPO_TEXTO_IGUAL,2);
        $oDescricaoFiltro = new Filtro($oProdes, Filtro::CAMPO_TEXTO,3);
        $oClienteFiltro = new Filtro($oCliente, Filtro::CAMPO_TEXTO,5);
        
        
        
         //filtro de situacao
        $oSitFiltro = new Filtro($oSituacao, Filtro::CAMPO_SELECT, 2,2,2,2);
        $oSitFiltro->addItemSelect('Aberta', 'Aberta');
        $oSitFiltro->addItemSelect('Todos', 'Todos');
        $oSitFiltro->addItemSelect('Processo', 'Processo');
        $oSitFiltro->addItemSelect('Finalizado', 'Finalizado');
        $oSitFiltro->setBInline(true);
        
        //situação da lista
        $oSitListaFiltro = new Filtro($oSitLista, Filtro::CAMPO_SELECT,3,3,3,3);
        $oSitListaFiltro->addItemSelect('slista', 'Sem lista');
        $oSitListaFiltro->addItemSelect('Todos', 'Todos');
        $oSitListaFiltro->addItemSelect('Espera', 'Espera');
        $oSitListaFiltro->addItemSelect('Liberado', 'Liberado');
        $oSitListaFiltro->setBInline(true);
        
        $oDataFiltro = new Filtro($oData, Filtro::CAMPO_DATA_ENTRE,2,2,2,2);
        
        $this->addFiltro($oOpFiltro,$oCodigoFiltro,$oDescricaoFiltro,$oDataFiltro,$oClienteFiltro,$oSitFiltro,$oSitListaFiltro);
        
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(false);
        
        $aInicial[0]='situacao,Aberta';
        
        $this->getTela()->setAParametros($aInicial);
        $this->getTela()->setSWhereInicial(" and coalesce(STEEL_PCP_ordensFabLista.situacao,'') =''");
        
        
       // $this->setBScrollInf(TRUE);
       // $this->getTela()->setBUsaCarrGrid(true);
        
        $this->setUsaDropdown(true);
        $oDrop1 = new Dropdown('Movimentações',Dropdown::TIPO_SUCESSO);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_EDITAR) . 'Excluir da lista', 'STEEL_PCP_OrdensFabApontLista', 'msgExcluirLista', '', false, '');
        
        $oDrop2 = new Dropdown('Lista de prioridades',Dropdown::TIPO_DARK, Dropdown::ICON_POSITIVO);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_BOX) . 'Lista de prioridades', 'STEEL_PCP_OrdensFabLista', 'mostraconsulta', '', false, '',true,'',false,'Lista de prioridades',false,true);
       //$oDrop2->addItemDropdown($this->addIcone(Base::ICON_INFO) . 'Estoque', 'ConsultaEstoque', 'acaoMostraTelaEstoque', '', false, $_SESSION['officecabsoliten'], true, '',false,'Estoques');
        //addItemDropdown($sLabelAcao, $sClasse, $sMetodo, $sParametro, $bHiden, $sParamAdicional, $bNewAba, $sNomeModal, $bModal, $sTitulo, $bMultiSelect,$bSel)
        $this->addDropdown($oDrop1,$oDrop2);
        
        $this->addCampos($oBotaoModal,$oOp,$oSitLista,$oTempRev,$oSituacao,$oData,$oCodigo,$oProdes,$oPeso,$oCliente);
        $this->getTela()->setiAltura(700);
    }
    
    public function criaModalOp(){
        parent::criaModal();
        
        $this->setBTela(true);
        $oDados = $this->getAParametrosExtras();
        $aFornoLista = $this->getAModelDados();
        
        $oOp = new Campo('Op','op', Campo::TIPO_TEXTO,1);
        $oOp->setSCorFundo(Campo::FUNDO_AMARELO);
        $oOp->setSValor($oDados->getOp());
        $oOp->setBCampoBloqueado(true);
        
        $oProcod = new campo('Produto','prodes', Campo::TIPO_TEXTO,2);
        $oProcod->setSValor($oDados->getProd());
        $oProcod->setBCampoBloqueado(true);
        
        $oProdes = new Campo('Descrição','prodes', Campo::TIPO_TEXTO,5);
        $oProdes->setSValor($oDados->getProdes());
        $oProdes->setBCampoBloqueado(true);
        
        $oForno = new Campo('Forno','fornocod', Campo::TIPO_SELECTMULTI,2);
        $oForno->addItemSelect('Todos', 'Todos');
        //coloca os fornos nos valores
        foreach ($aFornoLista as $key => $oFornoObj) {
          $oForno->addItemSelect($oFornoObj->getFornocod(), $oFornoObj->getFornodes());  
          }
        $oForno->setSValor('Todos');
      
        $oSitLista = new campo('Situação','situacao', Campo::TIPO_SELECTMULTI,2);
        $oSitLista->addItemSelect('Espera', 'Espera');
        $oSitLista->addItemSelect('Liberado', 'Liberado');
        $oSitLista->setSValor('Espera');
        
        $oPrioridade = new Campo('Prioridadades','prioridade', Campo::CAMPO_SELECTSIMPLE,2);
        $i=1;
        while ($i<=100){
           $oPrioridade->addItemSelect($i, $i);
           $i++;
        }
        
        
        
        $oTemp = new Campo('Temperatura','tempForno', Campo::TIPO_TEXTO,2);
        $oTemp->setIMarginTop(8);
        $oTemp->setSValor(number_format($oDados->getTemprev(), 2, ',', '.'));
        
        //botao inserir da tela
        
        $oBtnInserir = new Campo('Inserir', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        $oBtnInserir->setIMarginTop(7);
        //id do grid

       $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_ordensFabLista","insereLista","' . $this->getTela()->getId() . '-form","");';

        $oBtnInserir->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        
        
        $this->addCampos(array($oOp,$oProcod,$oProdes),array($oForno,$oSitLista,$oPrioridade,$oTemp),$oBtnInserir);
        
        
    }
    
}