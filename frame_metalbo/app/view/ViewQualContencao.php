<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewQualContencao extends View {

    public function __construct() {
        parent::__construct();
    }

    function criaGridDetalhe() {
        parent::criaGridDetalhe();

        $this->getOGridDetalhe()->setIAltura(200);

        $sAcaoRotina = $this->getSRotina();

        $oBotaoModal = new CampoConsulta('', 'apontar', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_EDIT);
        $oBotaoModal->setBHideTelaAcao(true);
        $oBotaoModal->setILargura(15);
        $oBotaoModal->setSTitleAcao('Apontar Contenção/Abrangência');
        $oBotaoModal->addAcao('QualContencao', 'criaTelaModalApontaContencao', 'modalApontaContencao');
        $this->addModaisDetalhe($oBotaoModal);

        $oNr = new CampoConsulta('Nr.', 'nr');
        $oNr->setILargura(30);

        $oSeq = new CampoConsulta('Seq.', 'seq');
        $oSeq->setILargura(30);

        $oPlan = new CampoConsulta('Ação', 'plano');
        $oPlan->setILargura(500);

        $oDataPrev = new CampoConsulta('Previsão', 'dataprev', CampoConsulta::TIPO_DATA);

        $oUsunome = new CampoConsulta('Quem', 'usunome');

        $oSituacao = new CampoConsulta('Situação', 'situaca');
        $oSituacao->addComparacao('Aberta', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA);

        $oAnexo = new CampoConsulta('Anexo', 'anexoplan1', CampoConsulta::TIPO_DOWNLOAD);

        $this->addCamposDetalhe($oBotaoModal, $oNr, $oSeq, $oSituacao, $oPlan, $oDataPrev, $oUsunome, $oAnexo);
        $this->addGriTela($this->getOGridDetalhe());
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $sAcaoRotina = $this->getSRotina();

        $oBotaoModal = new CampoConsulta('', 'apontar', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_EDIT);
        $oBotaoModal->setBHideTelaAcao(true);
        $oBotaoModal->setILargura(15);
        $oBotaoModal->setSTitleAcao('Apontar Contenção/Abrangência');
        $oBotaoModal->addAcao('QualContencao', 'criaTelaModalApontaContencao', 'modalApontaContencao');
        $this->addModais($oBotaoModal);

        $oNr = new CampoConsulta('Nr.', 'nr');
        $oNr->setILargura(30);

        $oSeq = new CampoConsulta('Seq.', 'seq');
        $oSeq->setILargura(30);

        $oPlan = new CampoConsulta('Ação', 'plano');
        $oPlan->setILargura(500);

        $oDataPrev = new CampoConsulta('Previsão', 'dataprev', CampoConsulta::TIPO_DATA);

        $oUsunome = new CampoConsulta('Responsável', 'usunome');

        $oSituacao = new CampoConsulta('Situação', 'situaca');
        $oSituacao->addComparacao('Finalizado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA);

        $oAnexo = new CampoConsulta('Anexo', 'anexoplan1', CampoConsulta::TIPO_DOWNLOAD);


        $this->addCampos($oBotaoModal, $oNr, $oSeq, $oSituacao, $oPlan, $oDataPrev, $oUsunome, $oAnexo);
    }

    public function criaTela() {
        parent::criaTela();

        $sAcaoRotina = $this->getSRotina();
        $this->criaGridDetalhe();

        if ($sAcaoRotina == 'acaoVisualizar') {
            $this->getTela()->setBUsaAltGrid(false);
            $this->getTela()->setBUsaDelGrid(false);
        }

        $aValor = $this->getAParametrosExtras();


        $oFilcgc = new Campo('Empresa', 'filcgc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilcgc->setSValor($aValor[0]);
        $oFilcgc->setBCampoBloqueado(true);

        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNr->setSValor($aValor[1]);
        $oNr->setBCampoBloqueado(true);

        $oSeq = new Campo('Sequência', 'seq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSeq->setBCampoBloqueado(true);

        $oPlano = new Campo('Ação', 'plano', Campo::TIPO_TEXTAREA, 12);
        $oPlano->setILinhasTextArea(5);
        $oPlano->setICaracter(500);

        $oAnexo = new Campo('Anexo', 'anexoplan1', Campo::TIPO_UPLOAD, 2, 2, 12, 12);
        $oAnexo->setIMarginTop(3);

        $oResp = new campo('Cód.', 'usucodigo', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oResp->setBFocus(true);
        $oResp->setSIdHideEtapa($this->getSIdHideEtapa());
        $oResp->addValidacao(false, Validacao::TIPO_STRING, '', '1');

        $oRespNome = new Campo('Responsável', 'usunome', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oRespNome->setSIdPk($oResp->getId());
        $oRespNome->setClasseBusca('User');
        $oRespNome->addCampoBusca('usucodigo', '', '');
        $oRespNome->addCampoBusca('usunome', '', '');
        $oRespNome->setSIdTela($this->getTela()->getid());

        $oResp->setClasseBusca('User');
        $oResp->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oResp->addCampoBusca('usunome', $oRespNome->getId(), $this->getTela()->getId());

        $oTipo = new Campo('Tipo ação', 'tipo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oTipo->setSValor($aValor[3]);
        $oTipo->setBCampoBloqueado(true);
        if ($aValor[3] == 'Ação Preventiva') {
            $oTipo->setSCorFundo(Campo::FUNDO_VERDE);
            $oDivisor = new Campo('Tela com preenchimento OPCIONAL, Ação Preventiva não necessita preenchimento.', 'divisor1', Campo::DIVISOR_SUCCESS, 12, 12, 12, 12);
        } else {
            $oTipo->setSCorFundo(Campo::FUNDO_VERMELHO);
            $oDivisor = new Campo('Tela com preenchimento OPCIONAL, Ação Preventiva não necessita preenchimento.', 'divisor1', Campo::DIVISOR_WARNING, 12, 12, 12, 12);
        }

        $oDivisor->setApenasTela(true);

        $oDataPrev = new Campo('Previsão', 'dataprev', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDataPrev->addValidacao(false, Validacao::TIPO_STRING, '', '2');

        $oBotConf = new Campo('Inserir', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $oBotConf->setIMarginTop(6);


        $sGrid = $this->getOGridDetalhe()->getSId();
        //id form,id incremento,id do grid, id focus,    
        $sAcao = $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","acaoDetalheIten","' . $this->getTela()->getId() . '-form,' . $oSeq->getId() . ',' . $sGrid . ',' . $oPlano->getId() . ',' . $oAnexo->getId() . '","' . $oFilcgc->getSValor() . ',' . $oNr->getSValor() . '");';
        //$oBotConf->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBotConf->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        if ($sAcaoRotina == 'acaoVisualizar') {

            $this->addCampos($oDivisor, array($oFilcgc, $oNr, $oSeq, $oTipo), array($oResp, $oRespNome), $oPlano, array($oDataPrev, $oAnexo));
        } else {

            $this->addCampos($oDivisor, array($oFilcgc, $oNr, $oSeq, $oTipo), array($oResp, $oRespNome), $oPlano, array($oDataPrev, $oAnexo, $oBotConf));
        }

        $this->addCamposFiltroIni($oFilcgc, $oNr);
    }

    public function criaModalApontaContencao() {
        parent::criaModal();

        $this->setBTela(true);
        $oDados = $this->getAParametrosExtras();

        $oEmpresa = new Campo('Empresa', 'filcgc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oEmpresa->setSValor($oDados->getFilcgc());
        $oEmpresa->setBCampoBloqueado(true);

        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 1, 1, 1, 12, 12);
        $oNr->setSValor($oDados->getNr());
        $oNr->setBCampoBloqueado(true);

        $oSeqEnv = new Campo('Sequencia', 'seq', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSeqEnv->setSValor($oDados->getSeq());
        $oSeqEnv->setBCampoBloqueado(true);
        $oSeqEnv->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oSeqEnv->setApenasTela(true);

        $oDataFim = new Campo('Data Finalização', 'dtaponta', Campo::TIPO_DATA, 2, 2, 2, 2);
        if ($oDados->getDtaponta() != null) {
            $oDataFim->setSValor(Util::converteData($oDados->getDtaponta()));
        }
        $oDataFim->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oDataFim->setSCorFundo(Campo::FUNDO_AMARELO);

        $oApontamento = new Campo('Observação final', 'apontamento', Campo::TIPO_TEXTAREA, 8, 8, 8, 8);
        $oApontamento->setICaracter(1000);
        if ($oDados->getApontamento() != null) {
            $oApontamento->setSValor(Util::limpaString($oDados->getApontamento()));
        }
        $oApontamento->setSCorFundo(Campo::FUNDO_AMARELO);
        $oApontamento->setILinhasTextArea(3);

        $oLinha = new Campo('', '', Campo::TIPO_LINHABRANCO);

        //botão inserir os dados
        $oBtnInserir = new Campo('Gravar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $sAcaoAponta = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","apontaContencao","' . $this->getTela()->getId() . '-form","");';
        $oBtnInserir->getOBotao()->addAcao($sAcaoAponta);

        $oBtnNormal = new Campo('Ret. Aberta', 'btnNormal', Campo::TIPO_BOTAOSMALL, 2);
        $sAcaoRet = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","apontaRetAberto","' . $this->getTela()->getId() . '-form","");';
        $oBtnNormal->getOBotao()->addAcao($sAcaoRet);
        $oBtnNormal->getOBotao()->setSStyleBotao(Botao::TIPO_DEFAULT);

        $this->addCampos(array($oEmpresa, $oNr, $oSeqEnv), array($oDataFim), $oLinha, array($oApontamento, $oBtnInserir, $oBtnNormal));
    }

}
