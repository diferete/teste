<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewFamSub extends View {

    public function criaConsulta() {
        parent::criaConsulta();


        $oFamsub = new CampoConsulta('SubFamília', 'famsub', CampoConsulta::TIPO_LARGURA, 20);
        $oFamSubDes = new CampoConsulta('Descrição', 'famsdes', CampoConsulta::TIPO_LARGURA, 20);

        $oFamcodF = new Filtro($oFamsub, Filtro::CAMPO_TEXTO, 1, 1, 12, 12, false);
        $oFamDesF = new Filtro($oFamSubDes, Filtro::CAMPO_TEXTO, 3, 3, 12, 12, false);
        $this->addFiltro($oFamcodF, $oFamDesF);

        $this->addCampos($oFamsub, $oFamSubDes);

        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);
    }

    public function criaTela() {
        parent::criaTela();
    }

}
