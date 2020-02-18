<?php

/*
 * Implementa a classe model MET_ItensManPrevConsulta
 * 
 * @author Cleverton Hoffmann
 * @since 18/02/2019
 */

class ModelMET_ItensManPrevConsulta {
    
    private $MET_ServicoMaquina;
    private $MET_Maquinas;
    private $filcgc;
    private $nr;
    private $seq;
    private $codmaq;
    private $codsit;
    private $servico;
    private $sitmp;
    private $dias;
    private $databert;
    private $userinicial;
    private $datafech;
    private $userfinal;
    private $obs;
    private $oqfazer;
    
    function getMET_Maquinas() {
        if (!isset($this->MET_Maquinas)) {
            $this->MET_Maquinas = Fabrica::FabricarModel('MET_Maquinas');
        }
        return $this->MET_Maquinas;
    }

    function setMET_Maquinas($MET_Maquinas) {
        $this->MET_Maquinas = $MET_Maquinas;
    }
        
    function getServico() {
        return $this->servico;
    }

    function setServico($servico) {
        $this->servico = $servico;
    }
    
    function getOqfazer() {
        return $this->oqfazer;
    }

    function setOqfazer($oqfazer) {
        $this->oqfazer = $oqfazer;
    }
  
    function getMET_ServicoMaquina() {
        if (!isset($this->MET_ServicoMaquina)) {
            $this->MET_ServicoMaquina = Fabrica::FabricarModel('MET_ServicoMaquina');
        }
        return $this->MET_ServicoMaquina;
    }

    function setMET_ServicoMaquina($MET_ServicoMaquina) {
        $this->MET_ServicoMaquina = $MET_ServicoMaquina;
    }
   
    function getFilcgc() {
        return $this->filcgc;
    }

    function getNr() {
        return $this->nr;
    }

    function getSeq() {
        return $this->seq;
    }

    function getCodmaq() {
        return $this->codmaq;
    }

    function getCodsit() {
        return $this->codsit;
    }

    function getSitmp() {
        return $this->sitmp;
    }

    function getDias() {
        return $this->dias;
    }

    function getDatabert() {
        return $this->databert;
    }

    function getUserinicial() {
        return $this->userinicial;
    }

    function getDatafech() {
        return $this->datafech;
    }

    function getUserfinal() {
        return $this->userfinal;
    }

    function getObs() {
        return $this->obs;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setSeq($seq) {
        $this->seq = $seq;
    }

    function setCodmaq($codmaq) {
        $this->codmaq = $codmaq;
    }

    function setCodsit($codsit) {
        $this->codsit = $codsit;
    }

    function setSitmp($sitmp) {
        $this->sitmp = $sitmp;
    }

    function setDias($dias) {
        $this->dias = $dias;
    }

    function setDatabert($databert) {
        $this->databert = $databert;
    }

    function setUserinicial($userinicial) {
        $this->userinicial = $userinicial;
    }

    function setDatafech($datafech) {
        $this->datafech = $datafech;
    }

    function setUserfinal($userfinal) {
        $this->userfinal = $userfinal;
    }

    function setObs($obs) {
        $this->obs = $obs;
    }
    
}
