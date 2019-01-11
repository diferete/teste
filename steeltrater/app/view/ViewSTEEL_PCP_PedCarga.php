<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 20/11/2018
 */

class ViewSTEEL_PCP_PedCarga extends View {

    public function criaConsulta() {
        parent::criaConsulta();
        
       
        $oCarga= new CampoConsulta('Nº Carga', 'PDV_PedidoCodigo') ;
        $oEmp = new CampoConsulta('Empresa', 'PDV_PedidoEmpCodigo');
        $oEmDes = new CampoConsulta('Razão','DELX_CAD_Pessoa.emp_razaosocial');
        $oDtEmis = new CampoConsulta('Emissao', 'PDV_PedidoDataEmissao',CampoConsulta::TIPO_DATA);
        $oSit = new CampoConsulta('Situacao', 'PDV_PedidoSituacao');
        $oApr = new CampoConsulta('Aprovacao', 'PDV_PedidoAprovacao');
        
        $oCodfiltro = new Filtro($oCarga, Filtro::CAMPO_TEXTO_IGUAL, 5);
        

        $this->setUsaAcaoExcluir(true);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oCodfiltro);

        $this->setBScrollInf(false);
        $this->addCampos($oCarga,$oEmp,$oEmDes,$oDtEmis,$oSit,$oApr);
    }

    public function criaTela() {
        parent::criaTela();
        $oLabel = new campo('','linha1', Campo::TIPO_LINHA,12,12,12,12);
        $oLabel->setApenasTela(true);
        
        $oDiv = new campo('Dados da carga','div1', Campo::DIVISOR_DARK,12,12,12,12);
        $oDiv->setApenasTela(true);
        //----------------------------------------------------------------------------------------
        $oFilial = new Campo('Filial', 'pdv_pedidofilial', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilial->setSValor('8993358000174');
        $oFilial->setBCampoBloqueado(true);
        //----------------------------------------------------------------------------------------
        $oDataEmiss = new Campo('DataEmissão','PDV_PedidoDataEmissao', Campo::TIPO_DATA,2,2,2,2);
        $oDataEmiss->setSValor(date('d/m/Y'));
        $oDataEmiss->setBCampoBloqueado(true);
        //----------------------------------------------------------------------------------------
        $oDataDig = new Campo('DataDig','PDV_PedidoDataDigitacao', Campo::TIPO_DATA,2,2,2,2);
        $oDataDig->setSValor(date('d/m/Y'));
        $oDataDig->setBCampoBloqueado(true);
        //----------------------------------------------------------------------------------------
        $oUseEmiss = new Campo('UserEmiss','PDV_PedidoUsuario', Campo::TIPO_TEXTO,2, 2, 2, 2);
        $oUseEmiss->setBCampoBloqueado(true);
        $oUseEmiss->setSValor($_SESSION['nomedelsoft']);
        //----------------------------------------------------------------------------------------
        $oNrCarga = new Campo('CargaNº','pdv_pedidocodigo', Campo::TIPO_TEXTO,1,1,1,1);
        $oNrCarga->setBCampoBloqueado(true);
        //----------------------------------------------------------------------------------------
        $oPedSit = new Campo('SitPed','PDV_PedidoSituacao', Campo::TIPO_TEXTO,1,1,1);
        $oPedSit->setSValor('A');
        $oPedSit->setBCampoBloqueado(true);
        //----------------------------------------------------------------------------------------
        
        $oPedAprov = new Campo('SitPed','PDV_PedidoAprovacao', Campo::TIPO_TEXTO,1,1,1);
        $oPedAprov->setSValor('A');
        $oPedAprov->setBCampoBloqueado(true);
        
        //----------------------------------------------------------------------------------------
        //CAMPO OP BASE PARA PUXAR DADOS AUTOMÁTICOS DA ORDEM DE PRODUÇÃO PADRÃO
        $oOpBase = new Campo('OP_base','op_base', Campo::TIPO_TEXTO,1,1,1,1);
        $oOpBase->setApenasTela(true);
        $oOpBase->setSCorFundo(Campo::FUNDO_AMARELO);
        $oOpBase->setBFocus(true);
        //----------------------------------------------------------------------------------------
        $oEmp_codigo = new Campo('Cliente','PDV_PedidoEmpCodigo',Campo::TIPO_BUSCADOBANCOPK,2);
        $oEmp_codigo->setSValor('75483040000211');
        $oEmp_codigo->addValidacao(false, Validacao::TIPO_STRING);
        
         //campo descrição do produto adicionando o campo de busca
        $oEmp_des = new Campo('Razão Social','DELX_CAD_Pessoa.emp_razaosocial',Campo::TIPO_BUSCADOBANCO, 5);
        $oEmp_des->setSIdPk($oEmp_codigo->getId());
        $oEmp_des->setClasseBusca('DELX_CAD_Pessoa');
        $oEmp_des->addCampoBusca('emp_codigo', '','');
        $oEmp_des->addCampoBusca('emp_razaosocial', '','');
        $oEmp_des->setSIdTela($this->getTela()->getId());
        $oEmp_des->setSValor('METALBO INDUSTRIA DE FIXADORES METALICOS LTDA');  //METALBO INDUSTRIA DE FIXADORES METALICOS LTDA
      
        
        $oEmp_codigo->setClasseBusca('DELX_CAD_Pessoa');
        $oEmp_codigo->setSCampoRetorno('emp_codigo',$this->getTela()->getId());
        $oEmp_codigo->addCampoBusca('emp_razaosocial',$oEmp_des->getId(),  $this->getTela()->getId());
        
        //----------------------------------------------------------------------------------------
        $oMovCod = new Campo('Movimento','PDV_PedidoTipoMovimentoCodigo',Campo::TIPO_BUSCADOBANCOPK,2);
        $oMovCod->setSValor('302');
        $oMovCod->addValidacao(false, Validacao::TIPO_STRING);
        
        $oMov_des = new Campo('MovDescrição','movdes',Campo::TIPO_BUSCADOBANCO, 5);
        $oMov_des->setSIdPk($oMovCod->getId());
        $oMov_des->setClasseBusca('DELX_NFS_TipoMovimento');
        $oMov_des->addCampoBusca('nfs_tipomovimentocodigo', '','');
        $oMov_des->addCampoBusca('nfs_tipomovimentodescricao', '','');
        $oMov_des->setSIdTela($this->getTela()->getId());
        $oMov_des->setApenasTela(true);
        
        $oMovCod->setClasseBusca('DELX_NFS_TipoMovimento');
        $oMovCod->setSCampoRetorno('nfs_tipomovimentocodigo',$this->getTela()->getId());
        $oMovCod->addCampoBusca('nfs_tipomovimentodescricao',$oMov_des->getId(),  $this->getTela()->getId());
        //------------------------------------------------------------------------------------------
        
        $oTabPreco = new Campo('Tab_Preço','PDV_PedidoTabelaPreco', Campo::TIPO_TEXTO,1,1,1);
        $oTabPreco->setSValor('1');
        $oTabPreco->setBCampoBloqueado(true);
       
       
        //------------------------------------------------------------------------------------------
        $oDataEnt = new Campo('DataEntrega','PDV_PedidoDataEntrega', Campo::TIPO_DATA,2,2,2,2);
        $oDataEnt->setSValor(date('d/m/Y'));
       //-------------------------------------------------------------------------------------------
        $oCondPag = new Campo('CondiçãoPag','PDV_PedidoCondicaoPgtoCodigo',Campo::TIPO_TEXTO,1);
        $oCondPag->setSValor('32');
        $oCondPag->setBCampoBloqueado(true);
        
        //adiciona os evento ao sair do campo op_base
        $sEventoOp = 'var OpSteel =  $("#'.$oOpBase->getId().'").val();if(OpSteel !==""){requestAjax("'.$this->getTela()->getId().'-form","STEEL_PCP_PedCarga","consultaOpDados",'
                 . '"'.$oEmp_codigo->getId().','.$oEmp_des->getId().'");}';
        $oOpBase->addEvento(Campo::EVENTO_SAIR,$sEventoOp);
        //-----------------------------------
        $oEtapas = new FormEtapa(2, 2, 12, 12);
        $oEtapas->addItemEtapas('Monta Carga', true, $this->addIcone(Base::ICON_EDITAR));
        $oEtapas->addItemEtapas('Itens da Carga', false, $this->addIcone(Base::ICON_CONFIRMAR));
        $this->addEtapa($oEtapas);
        
        
        //adiciona campo de controle
        //monta campo de controle para inserir ou alterar
        $oAcao = new campo('', 'acao', Campo::TIPO_CONTROLE, 2, 2, 12, 12);
        $oAcao->setApenasTela(true);
        if ($this->getSRotina() == View::ACAO_INCLUIR) {
            $oAcao->setSValor('incluir');
        } else {
            $oAcao->setSValor('alterar');
        }
        $this->setSIdControleUpAlt($oAcao->getId());
      
                
        $this->addCampos(
                array($oFilial,$oUseEmiss,$oDataEmiss,$oDataDig,$oNrCarga,$oPedSit,$oPedAprov),
                $oDiv,
                $oLabel,
                array($oOpBase,$oEmp_codigo,$oEmp_des),
                $oLabel,
                array($oMovCod,$oTabPreco,$oCondPag,$oDataEnt),$oAcao
               );
    }

}