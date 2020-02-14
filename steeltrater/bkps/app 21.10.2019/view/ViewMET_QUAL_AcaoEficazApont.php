<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_QUAL_AcaoEficazApont extends View {

    public function criaTela() {
        parent::criaTela();

        $aDados = $this->getAParametrosExtras();
        $oEmpresa = new Campo('Empresa', 'filcgc', Campo::TIPO_TEXTO, 2, 2, 2, 2);
        $oEmpresa->setSValor($aDados['DELX_FIL_Empresa_fil_codigo']);
        $oEmpresa->setBCampoBloqueado(true);
        $oNr = new Campo('Nr AQ', 'nr', Campo::TIPO_TEXTO, 1, 1, 1, 1, 1);
        $oNr->setSValor($aDados['nr']);
        $oNr->setBCampoBloqueado(true);

        /* ------------grid---------------------- */
        $oGridAq = new campo('Avaliação da eficácia', 'griEf', Campo::TIPO_GRID, 12, 12, 12, 12, 150);

        $oSeq = new CampoConsulta('Seq.', 'seq');
        $oSeq->setILargura(30);
        $oAcao = new CampoConsulta('O que verificar', 'acao');
        $oAcao->setILargura(500);

        $oQuando = new CampoConsulta('Quando', 'dataprev', CampoConsulta::TIPO_DATA);
        $oDataRelGrid = new CampoConsulta('Data Realização', 'datareal', CampoConsulta::TIPO_DATA, 2);
        $oSit = new CampoConsulta('Situação', 'sit');
        $oSit->addComparacao('Finalizado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA);

        $oUsuGrid = new CampoConsulta('Quem', 'usunome');

        $oGridAq->addCampos($oSeq, $oAcao, $oQuando, $oDataRelGrid, $oSit, $oUsuGrid);
        $oGridAq->setSController('MET_QUAL_AqPlanApont');
        $oGridAq->addParam('seq', '0');
        /* ------campos que vao receber os dados do grid--------- */

        $oFieldEficaz = new FieldSet('Aponta eficácia');

        $oSeqEnv = new Campo('Sêquencia', 'seq', Campo::TIPO_TEXTO, 1);
        $oSeqEnv->setBCampoBloqueado(true);
        $oSeqEnv->addValidacao(false, Validacao::TIPO_STRING, '', '1');

        $oAcaoEnv = new Campo('O que verificar', 'acao', Campo::TIPO_TEXTAREA, 6);
        $oAcaoEnv->setBCampoBloqueado(true);

        $oDataPrev = new Campo('Quando', 'dataprev', Campo::TIPO_TEXTO, 2);
        $oDataPrev->setBCampoBloqueado(true);

        $oEficaz = new Campo('Eficaz?', 'eficaz', Campo::TIPO_SELECT, 2);
        $oEficaz->addItemSelect('Sim', 'Sim! foi eficaz.');
        $oEficaz->addItemSelect('Não', 'Não! não foi eficaz!');

        $oObs = new Campo('Observação final', 'obs', Campo::TIPO_TEXTAREA, 6);
        $oObs->setSCorFundo(Campo::FUNDO_AMARELO);

        $oDataReali = new Campo('Data realização', 'datareal', Campo::TIPO_DATA, 2);
        $oDataReali->addValidacao(false, Validacao::TIPO_STRING, '', '1');

        $sAcaoBusca = 'requestAjax("' . $this->getTela()->getId() . '-form","MET_QUAL_AcaoEficazApont","getDadosGrid","' . $oGridAq->getId() . '","criaConsultaEf"); ';
        $this->getTela()->setSAcaoShow($sAcaoBusca);


        $oGridAq->getOGrid()->setSEventoClick('var chave=""; $("#' . $oGridAq->getId() . ' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                . 'requestAjax("","MET_QUAL_AcaoEficazApont","sendaDadosCampos","' . $oGridAq->getId() . '"+","+chave+","+"' . $oSeqEnv->getId() . '"+","+""+","+"' . $oDataPrev->getId() . '"+","+"' . $oAcaoEnv->getId() . '"+","+"' . $oDataReali->getId() . '"+","+"' . $oObs->getId() . '"+","+"' . $oEficaz->getId() . '"); '); //$oObs
        //botão inserir os dados
        $oBtnInserir = new Campo('Gravar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        //id do grid
        $sGrid = $oGridAq->getId();
        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","apontaEfi","' . $this->getTela()->getId() . '-form,' . $sGrid . '","");';

        $oBtnInserir->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);
        $this->getTela()->setSAcaoShow($sAcaoBusca);

        $sAcaoRet = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","apontaRetEfi","' . $this->getTela()->getId() . '-form,' . $sGrid . '","");';
        $oBtnNormal = new Campo('Ret. Aberta', 'btnNormal', Campo::TIPO_BOTAOSMALL, 2);
        $oBtnNormal->getOBotao()->addAcao($sAcaoRet);
        $oBtnNormal->getOBotao()->setSStyleBotao(Botao::TIPO_DEFAULT);

        $oLinha = new Campo('', 'linha1', Campo::TIPO_LINHA, 12);
        $oLinha->setApenasTela(true);

        $oFieldEficaz->addCampos($oAcaoEnv, $oEficaz, $oDataReali, array($oObs, $oBtnInserir, $oBtnNormal));
        $oFieldEficaz->setOculto(true);

        $oFieldPlanAcao = new FieldSet('Inserir plano de ação para esta avaliação da eficácia.');

        $oPlano = new Campo('O que fazer', 'plano', Campo::TIPO_TEXTAREA, 7);
        $oPlano->setILinhasTextArea(2);
        $oPlano->setICaracter(500);

        $oAnexo = new Campo('Anexar plano de ação', 'anexoplan1', Campo::TIPO_UPLOAD, 2, 2, 2, 2);

        $oResp = new campo('Cód.', 'usucodigo', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 1, 1);
        $oResp->setSIdHideEtapa($this->getSIdHideEtapa());


        $oRespNome = new Campo('Responsável', 'usunome', Campo::TIPO_BUSCADOBANCO, 3, 3, 3, 3);
        $oRespNome->setSIdPk($oResp->getId());
        $oRespNome->setClasseBusca('MET_TEC_usuario');
        $oRespNome->addCampoBusca('usucodigo', '', '');
        $oRespNome->addCampoBusca('usunome', '', '');
        $oRespNome->setSIdTela($this->getTela()->getid());


        $oResp->setClasseBusca('MET_TEC_usuario');
        $oResp->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oResp->addCampoBusca('usunome', $oRespNome->getId(), $this->getTela()->getId());

        $oTipo = new Campo('Tipo ação', 'tipo', Campo::TIPO_TEXTO, 1);
        $oTipo->setSValor('Eficiência');
        $oTipo->setBCampoBloqueado(true);

        $oDataPrevPlan = new Campo('Previsão', 'dataprevplan', Campo::TIPO_DATA, 2);


        $oBotaoPlan = new Campo('Inserir plano de ação', '', Campo::TIPO_BOTAOSMALL_SUB, 2);
        $sAcaoPlan = 'requestAjax("' . $this->getTela()->getId() . '-form","MET_QUAL_QualPlan","geraPlanoEf","' . $this->getTela()->getId() . '-form");';
        $oBotaoPlan->addAcaoBotao($sAcaoPlan);



        $oFieldPlanAcao->addCampos($oPlano, $oAnexo, array($oResp, $oRespNome, $oTipo), $oDataPrevPlan, $oBotaoPlan);
        $oFieldPlanAcao->setOculto(true);




        $this->addCampos(array($oEmpresa, $oNr), $oGridAq, array($oSeqEnv, $oDataPrev), $oLinha, $oFieldEficaz, $oFieldPlanAcao);
    }

    public function criaConsultaEf() {
        $oGridAq = new Grid("");

        $oSeq = new CampoConsulta('Seq.', 'seq');
        $oSeq->setILargura(30);
        $oAcao = new CampoConsulta('O que verificar', 'acao');
        $oAcao->setILargura(550);

        $oQuando = new CampoConsulta('Quando', 'dataprev', CampoConsulta::TIPO_DATA);
        $oDataRelGrid = new CampoConsulta('Data Realização', 'datareal', CampoConsulta::TIPO_DATA);
        $oSit = new CampoConsulta('Situação', 'sit');
        $oSit->addComparacao('Finalizado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA);

        $oUsuGrid = new CampoConsulta('Quem', 'usunome');

        $oGridAq->addCampos($oSeq, $oAcao, $oQuando, $oDataRelGrid, $oSit, $oUsuGrid);
        $aCampos = $oGridAq->getArrayCampos();
        return $aCampos;
    }

}
