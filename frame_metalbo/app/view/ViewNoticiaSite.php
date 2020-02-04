<?php

class ViewNoticiaSite extends View {

    function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->getTela()->setBGridResponsivo(true);

        $this->setUsaDropdown(true);
        $oFeed = new Dropdown('Feed', Dropdown::TIPO_PRIMARY);
        $oFeed->addItemDropdown($this->addIcone(Base::ICON_CONFIRMAR) . 'Publicar', 'NoticiaSite', 'getFeed', '', false, '', false, '', false, '', false, false);

        $oNr = new CampoConsulta('Nr', 'nr');

        $oData = new CampoConsulta('Data', 'data', CampoConsulta::TIPO_DATA);

        $oTitulo = new CampoConsulta('Titulo', 'titulo');

        $oSite = new CampoConsulta('Site', 'filcgc');
        $oSite->addComparacao('75483040000211', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA, false, null);
        $oSite->addComparacao('83781641000158', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_LINHA, false, null);

        $oFilData = new Filtro($oData, Filtro::CAMPO_DATA_ENTRE, 2, 2, 12, 12, false);

        $oFilTitulo = new Filtro($oTitulo, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, false);

        $this->addFiltro($oFilData, $oFilTitulo);

        $this->addDropdown($oFeed);

        $this->addCampos($oNr, $oSite, $oData, $oTitulo);

        $oLinhaWhite = new Campo('', '', Campo::TIPO_LINHABRANCO);

        $oTexto = new Campo('Problema apresentando', '', Campo::TIPO_TEXTAREA, 12);
        $oTexto->setILinhasTextArea(6);
        $oTexto->setSCorFundo(Campo::FUNDO_AMARELO);
        $oTexto->setBCampoBloqueado(true);

        $this->addCamposGrid($oTexto, $oLinhaWhite);
        $this->getTela()->setIAltura(240);

        $this->getTela()->setSEventoClick('var chave=""; $("#' . $this->getTela()->getSId() . ' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                . 'requestAjax("","NoticiaSite","carregaTexto","' . $this->getTela()->getSId() . '"+","+chave+","+"' . $oTexto->getId() . '"+","+"");');
    }

    public function criaTela() {
        parent::criaTela();

        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 1, 1, 2, 2);
        $oNr->setBCampoBloqueado(true);

        $oData = new Campo('Data', 'data', Campo::TIPO_DATA, 2, 2, 12, 12);

        $oTitulo = new Campo('Titulo', 'titulo', Campo::TIPO_TEXTO, 4, 4, 12, 12);

        $oTexto = new Campo('Texto', 'texto', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oTexto->setILinhasTextArea(6);

        $oSite = new Campo('Site', 'filcgc', Campo::TIPO_RADIO, 4, 4, 12, 12);
        $oSite->addItenRadio('75483040000211', 'METALBO');
        $oSite->addItenRadio('83781641000158', 'POLIAMIDOS');


        $this->addCampos($oNr, $oData, $oTitulo, $oTexto, $oSite);
    }

}
