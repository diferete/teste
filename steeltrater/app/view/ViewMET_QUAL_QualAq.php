<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_QUAL_QualAq extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->getTela()->setIAltura(450);
        $this->getTela()->setBGridResponsivo(false);

        $oTitulo = new CampoConsulta('Título', 'titulo', CampoConsulta::TIPO_LARGURA, 300);

        $oFilcgc = new CampoConsulta('Cnpj', 'DELX_FIL_Empresa.fil_codigo');

        $oNr = new CampoConsulta('AQ', 'nr');
        $oNr->setSOperacao('personalizado');

        $oDataFim = new CampoConsulta('DataFinal', 'datafim', CampoConsulta::TIPO_DATA);

        $oSit = new CampoConsulta('Situação', 'sit', CampoConsulta::TIPO_DESTAQUE2);
        $oSit->addComparacao('Aberta', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA);
        $oSit->addComparacao('Iniciada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_LINHA);

        $oOrigem = new CampoConsulta('Origem', 'origem', CampoConsulta::TIPO_LARGURA);

        $oTipoAcao = new CampoConsulta('Tipo da ação', 'tipoacao', CampoConsulta::TIPO_LARGURA);

        $oTipoMel = new CampoConsulta('Tipo Melhoria', 'tipmelhoria', CampoConsulta::TIPO_LARGURA);


        $oFilNr = new Filtro($oNr, Filtro::CAMPO_TEXTO_IGUAL, 1, 1, 12, 12);

        $oFilTit = new Filtro($oTitulo, Filtro::CAMPO_TEXTO, 10, 10, 12, 12);


        $oFilEmp = new Filtro($oFilcgc, Filtro::CAMPO_SELECT, 2, 2, 12, 12);
        $oFilEmp->setSClasseBusca('DELX_FIL_Empresa');
        $oFilEmp->setSCampoRetorno('fil_codigo', $this->getTela()->getSId());
        $oFilEmp->setSIdTela($this->getTela()->getSId());
        $oFilEmp->addItemSelect('75483040000211', 'Metalbo Filial');
        $oFilEmp->addItemSelect('75483040000130', 'Metalbo Matriz');
        $oFilEmp->addItemSelect('8993358000174', 'Steeltrater');
        $oFilEmp->addItemSelect('83781641000158', 'Poliamidos');
        $oFilEmp->addItemSelect('Todos', 'Todos');
        $oFilEmp->setSLabel('Empresa');


        $oTipoAcaoFiltro = new Filtro($oTipoAcao, Filtro::CAMPO_SELECT, 2, 2, 12, 12);
        $oTipoAcaoFiltro->addItemSelect('Todos', 'Todos');
        $oTipoAcaoFiltro->addItemSelect('Ação Corretiva', 'Ação Corretiva');
        $oTipoAcaoFiltro->addItemSelect('Ação Preventiva', 'Ação Preventiva');
        $oTipoAcaoFiltro->setSLabel('Ação');

        $oOrigemFiltro = new Filtro($oOrigem, Filtro::CAMPO_SELECT, 2, 2, 12, 12);
        $oOrigemFiltro->addItemSelect('Todos', 'Todos');
        $oOrigemFiltro->addItemSelect('Sugestão de funcionário', 'Sugestão de funcionário');
        $oOrigemFiltro->addItemSelect('Análise crítica do SGQ', 'Análise crítica do SGQ');
        $oOrigemFiltro->addItemSelect('Análise dos Indicadores', 'Análise dos Indicadores');
        $oOrigemFiltro->addItemSelect('Reclamação de Cliente', 'Reclamação de Cliente');
        $oOrigemFiltro->addItemSelect('Auditoria Interna', 'Auditoria Interna');
        $oOrigemFiltro->addItemSelect('Auditoria Externa', 'Auditoria Externa');
        $oOrigemFiltro->addItemSelect('Produto não conforme', 'Produto não conforme');
        $oOrigemFiltro->setSLabel('Origem');

        $oTipoMelFiltro = new Filtro($oTipoMel, Filtro::CAMPO_SELECT, 2, 2, 12, 12);
        $oTipoMelFiltro->addItemSelect('Todos', 'Todos');
        $oTipoMelFiltro->addItemSelect('Produto', 'Produto');
        $oTipoMelFiltro->addItemSelect('Processo', 'Processo');
        $oTipoMelFiltro->addItemSelect('Ambiente', 'Ambiente');
        $oTipoMelFiltro->setSLabel('Tipo');

        $oSitFiltro = new Filtro($oSit, Filtro::CAMPO_SELECT, 2, 2, 12, 12);
        $oSitFiltro->addItemSelect('Todos', 'Todos');
        $oSitFiltro->addItemSelect('Aberta', 'Aberta');
        $oSitFiltro->addItemSelect('Iniciada', 'Iniciada');
        $oSitFiltro->addItemSelect('Finalizada', 'Finalizada');


        $this->addFiltro($oFilNr, $oFilTit, $oTipoAcaoFiltro, $oOrigemFiltro, $oTipoMelFiltro, $oSitFiltro, $oFilEmp);


        $this->setUsaAcaoExcluir(false);

        $this->setUsaDropdown(true);
        $oDrop1 = new Dropdown('Ação e Eficácia', Dropdown::TIPO_SUCESSO, 2);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_CALENDARIO) . 'Finalizar plano de ação', 'MET_QUAL_AqPlanApont', 'acaoMostraTelaApontdiv', '', true, '');
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_EDITAR) . 'Inserir avaliação da eficácia', 'MET_QUAL_AcaoEficaz', 'acaoMostraTelaApontdiv', '', true, '');
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_CALENDARIO) . 'Apontar avaliação da eficácia', 'MET_QUAL_AcaoEficazApont', 'acaoMostraTelaApontdiv', '', true, '');


        $oDrop3 = new Dropdown('Movimentação', Dropdown::TIPO_DARK, 2);
        $oDrop3->addItemDropdown($this->addIcone(Base::ICON_LAPIS) . 'Iniciar ação da qualidade', 'MET_QUAL_QualAq', 'startAq', '', false, '');
        $oDrop3->addItemDropdown($this->addIcone(Base::ICON_MARTELO) . 'Finalizar ação da qualidade', 'MET_QUAL_QualAq', 'msgFechaAq', '', false, ''); //msgAbreAq
        $oDrop3->addItemDropdown($this->addIcone(Base::ICON_DESBLOQUEADO) . 'Reabrir ação da qualidade', 'MET_QUAL_QualAq', 'msgAbreAq', '', false, '');
        $oDrop3->addItemDropdown($this->addIcone(Base::ICON_FILE) . 'Ata de reunião', 'MET_QUAL_Ata', 'acaoMostraTelaApontdiv', '', true, '');

        $oDrop4 = new Dropdown('Impressão e Emails', Dropdown::TIPO_PRIMARY, 2);
        $oDrop4->addItemDropdown($this->addIcone(Base::ICON_IMPRESSORA) . 'Vizualizar ação da qualidade', 'MET_QUAL_QualAq', 'acaoMostraRelConsulta', '', false, 'AqImp');
        $oDrop4->addItemDropdown($this->addIcone(Base::ICON_EMAIL) . 'Enviar para meu email', 'MET_QUAL_QualAq', 'envMailGrid2', '', false, 'AqImp,email,MET_QUAL_QualAq,envMailQual');
        $oDrop4->addItemDropdown($this->addIcone(Base::ICON_EMAIL) . 'Enviar para todos envolvidos', 'MET_QUAL_QualAq', 'envMailGrid', '', false, 'AqImp,email,MET_QUAL_QualAq,envMailAll');
        
        $this->addDropdown($oDrop1, $oDrop3, $oDrop4);

        $this->addCampos($oNr, $oSit, $oTitulo, $oDataFim, $oTipoAcao, $oOrigem, $oTipoMel, $oFilcgc);

        // $this->setBScrollInf(true);
    }

    public function criaTela() {
        parent::criaTela();

        $oTitulo = new Campo('Título da ação da qualidade', 'titulo', Campo::TIPO_TEXTO, 3, 6, 12, 12);
        $oLinha1 = new Campo('', '', Campo::TIPO_LINHA, 12);
        $oLinha1->setApenasTela(true);
        $oTitulo->setSCorFundo(Campo::FUNDO_AMARELO);
        $oTitulo->setBFocus(true);

        $oSit = new Campo('Situação', 'sit', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSit->setSValor('Aberta');
        $oSit->setBCampoBloqueado(true);


        $oFilcgc = new Campo('Empresa', 'DELX_FIL_Empresa.fil_codigo', Campo::TIPO_BUSCADOBANCOPK, 3, 3, 12, 12);
        $oFilcgc->setSValor('75483040000211');

        $oFilDes = new campo('Empresa', 'DELX_FIL_Empresa.fil_fantasia', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oFilDes->setSIdPk($oFilcgc->getId());
        $oFilDes->setClasseBusca('DELX_FIL_Empresa');
        $oFilDes->addValidacao(false, Validacao::TIPO_STRING, '', '2');
        $oFilDes->addCampoBusca('fil_codigo', '', '');
        $oFilDes->addCampoBusca('fil_fantasia', '', '');
        $oFilDes->setSIdTela($this->getTela()->getid());
        $oFilDes->setSValor('METALBO INDUSTRIA DE FIXADORES METÁLICOS LTDA');

        $oFilcgc->setClasseBusca('DELX_FIL_Empresa');
        $oFilcgc->setSCampoRetorno('fil_codigo', $this->getTela()->getId());
        $oFilcgc->addCampoBusca('fil_fantasia', $oFilDes->getId(), $this->getTela()->getId());


        $oDataImp = new campo('Implantação', 'dtimp', Campo::TIPO_TEXTO, 2, 6, 6, 6);
        $oDataImp->setSValor(date('d/m/Y'));
        $oDataImp->setBCampoBloqueado(true);

        $oHora = new Campo('Hora', 'horimp', Campo::TIPO_TEXTO, 2, 3, 3, 3);
        $oHora->setITamanho(Campo::TAMANHO_PEQUENO);
        date_default_timezone_set('America/Sao_Paulo');
        $oHora->setSValor(date('H:i'));
        $oHora->setBCampoBloqueado(true);

        $oUserImplant = new campo('Usuário Implantação', 'userimp', Campo::TIPO_TEXTO, 2, 9, 9, 9);
        $oUserImplant->setSValor($_SESSION['nome']);
        $oUserImplant->setBCampoBloqueado(true);



        $oResp = new campo('Cód.', 'usucodigo', Campo::TIPO_BUSCADOBANCOPK, 2, 4, 4, 4);
        $oResp->addValidacao(false, Validacao::TIPO_STRING, '', '1');

        $oRespNome = new Campo('Responsável', 'usunome', Campo::TIPO_BUSCADOBANCO, 3, 8, 8, 8);
        $oRespNome->setSIdPk($oResp->getId());
        $oRespNome->setClasseBusca('MET_TEC_usuario');
        $oRespNome->addCampoBusca('usucodigo', '', '');
        $oRespNome->addCampoBusca('usunome', '', '');
        $oRespNome->setSIdTela($this->getTela()->getid());


        $oResp->setClasseBusca('MET_TEC_usuario');
        $oResp->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oResp->addCampoBusca('usunome', $oRespNome->getId(), $this->getTela()->getId());



        $oEquipe = new campo('Equipe envolvida', 'equipe', Campo::TIPO_TEXTAREA, 4, 12, 12, 12);
        $oEquipe->setICaracter(500);
        $oEquipe->setILinhasTextArea(5);

        $oDataIni = new campo('Data Inicial', 'dataini', Campo::TIPO_DATA, 2, 6, 6, 6);
        $oDataIni->setSValor(date('d/m/Y'));
        $oDataFinal = new campo('Data Final', 'datafim', Campo::TIPO_DATA, 2, 6, 6, 6);
        $oDataFinal->setSValor(date('d/m/Y'));

        $oTipoAcao = new campo('Tipo da ação', 'tipoacao', Campo::TIPO_SELECT, 4, 12, 12, 12);
        $oTipoAcao->addItemSelect('Ação Corretiva', 'Ação Corretiva');
        $oTipoAcao->addItemSelect('Ação Preventiva', 'Ação Preventiva');

        $oOrigem = new campo('Origem da ação', 'origem', Campo::TIPO_SELECT, 4, 12, 12, 12);
        $oOrigem->addItemSelect('Sugestão de funcionário', 'Sugestão de funcionário');
        $oOrigem->addItemSelect('Análise crítica do SGQ', 'Análise crítica do SGQ');
        $oOrigem->addItemSelect('Análise dos Indicadores', 'Análise dos Indicadores');
        $oOrigem->addItemSelect('Reclamação de Cliente', 'Reclamação de Cliente');
        $oOrigem->addItemSelect('Auditoria Interna', 'Auditoria Interna');
        $oOrigem->addItemSelect('Auditoria Externa', 'Auditoria Externa');
        $oOrigem->addItemSelect('Produto não conforme', 'Produto não conforme');

        $oTipmel = new campo('Tipo de melhoria', 'tipmelhoria', Campo::TIPO_SELECT, 4, 12, 12, 12);
        $oTipmel->addItemSelect('Produto', 'Produto');
        $oTipmel->addItemSelect('Processo', 'Processo');
        $oTipmel->addItemSelect('Ambiente', 'Ambiente');

        $oAssunto = new Campo('Assunto / Problema', 'problema', Campo::TIPO_TEXTAREA, 5, 6, 12, 12);
        $oAssunto->setILinhasTextArea(5);
        $oAssunto->setICaracter(400);

        $oObjetivo = new Campo('Objetivo', 'objetivo', Campo::TIPO_TEXTAREA, 5, 6, 12, 12);
        $oObjetivo->setILinhasTextArea(5);
        $oObjetivo->setICaracter(400);



        $oNr = new campo('', 'nr', Campo::TIPO_TEXTO, 1);
        $oNr->setBOculto(true);

        $oEtapas = new FormEtapa(2, 2, 2, 2);
        $oEtapas->addItemEtapas('Inserir Ação da qualidade', true, $this->addIcone(Base::ICON_CALENDARIO));
        $oEtapas->addItemEtapas('Causa raiz do problema', false, $this->addIcone(Base::ICON_INFO));
        $oEtapas->addItemEtapas('Plano de ação', false, $this->addIcone(Base::ICON_CONFIRMAR));

        $this->addEtapa($oEtapas);

        $oClassificacao = new Campo('Classificação', 'classificacao', Campo::TIPO_SELECT, 4, 12, 12, 12);
        $oClassificacao->addItemSelect('Cliente, processos e produto', 'Cliente, processos e produto');
        $oClassificacao->addItemSelect('Segurança e saúde ocupacional', 'Segurança e saúde ocupacional');
        $oClassificacao->addItemSelect('Meio ambiente', 'Meio ambiente');

        $oAnexo1 = new Campo('Anexo 1', 'anexo1', Campo::TIPO_UPLOAD, 4);

        //monta campo de controle para inserir ou alterar
        $oAcao = new campo('', 'acao', Campo::TIPO_CONTROLE, 2);
        $oAcao->setApenasTela(true);
        if ($this->getSRotina() == View::ACAO_INCLUIR) {
            $oAcao->setSValor('incluir');
        } else {
            $oAcao->setSValor('alterar');
        }
        $this->setSIdControleUpAlt($oAcao->getId());





        $this->addCampos(array($oTitulo, $oSit, $oDataImp, $oHora, $oUserImplant), $oClassificacao, $oLinha1, array($oFilcgc, $oFilDes, $oResp, $oRespNome), $oEquipe, array($oDataIni, $oDataFinal), array($oTipoAcao, $oOrigem, $oTipmel), $oAnexo1, array($oAssunto, $oObjetivo), $oNr, $oAcao);
    }

}