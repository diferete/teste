<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelMET_PORT_Pessoas {

    private $filcgc;
    private $nr;
    private $situaca;
    private $datachegou;
    private $horachegou;
    private $dataentrou;
    private $horaentrou;
    private $horasaiu;
    private $datasaiu;
    private $usucod;
    private $usunome;
    private $cracha;
    private $tipopessoa;
    private $pessoa;
    private $fone;
    private $codsetor;
    private $descsetor;
    private $motivo;
    private $descmotivo;
    private $cor;
    private $tipo;
    private $empcod;
    private $empdes;
    private $respcracha;
    private $respnome;

    function getRespcracha() {
        return $this->respcracha;
    }

    function getRespnome() {
        return $this->respnome;
    }

    function setRespcracha($respcracha) {
        $this->respcracha = $respcracha;
    }

    function setRespnome($respnome) {
        $this->respnome = $respnome;
    }

    function getEmpcod() {
        return $this->empcod;
    }

    function getEmpdes() {
        return $this->empdes;
    }

    function setEmpcod($empcod) {
        $this->empcod = $empcod;
    }

    function setEmpdes($empdes) {
        $this->empdes = $empdes;
    }

    function getTipopessoa() {
        return $this->tipopessoa;
    }

    function setTipopessoa($tipopessoa) {
        $this->tipopessoa = $tipopessoa;
    }

    function getDatachegou() {
        return $this->datachegou;
    }

    function getHorachegou() {
        return $this->horachegou;
    }

    function setDatachegou($datachegou) {
        $this->datachegou = $datachegou;
    }

    function setHorachegou($horachegou) {
        $this->horachegou = $horachegou;
    }

    function getCodsetor() {
        return $this->codsetor;
    }

    function getDescsetor() {
        return $this->descsetor;
    }

    function setCodsetor($codsetor) {
        $this->codsetor = $codsetor;
    }

    function setDescsetor($descsetor) {
        $this->descsetor = $descsetor;
    }

    function getPessoa() {
        return $this->pessoa;
    }

    function setPessoa($pessoa) {
        $this->pessoa = $pessoa;
    }

    function getTipo() {
        return $this->tipo;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function getCracha() {
        return $this->cracha;
    }

    function setCracha($cracha) {
        $this->cracha = $cracha;
    }

    function getDataentrou() {
        return $this->dataentrou;
    }

    function getHoraentrou() {
        return $this->horaentrou;
    }

    function getHorasaiu() {
        return $this->horasaiu;
    }

    function getDatasaiu() {
        return $this->datasaiu;
    }

    function setDataentrou($dataentrou) {
        $this->dataentrou = $dataentrou;
    }

    function setHoraentrou($horaentrou) {
        $this->horaentrou = $horaentrou;
    }

    function setHorasaiu($horasaiu) {
        $this->horasaiu = $horasaiu;
    }

    function setDatasaiu($datasaiu) {
        $this->datasaiu = $datasaiu;
    }

    function getSituaca() {
        return $this->situaca;
    }

    function setSituaca($situaca) {
        $this->situaca = $situaca;
    }

    function getDescmotivo() {
        return $this->descmotivo;
    }

    function setDescmotivo($descmotivo) {
        $this->descmotivo = $descmotivo;
    }

    function setCor($cor) {
        $this->cor = $cor;
    }

    function getFilcgc() {
        return $this->filcgc;
    }

    function getNr() {
        return $this->nr;
    }

    function getUsucod() {
        return $this->usucod;
    }

    function getUsunome() {
        return $this->usunome;
    }

    function getFone() {
        return $this->fone;
    }

    function getMotivo() {
        return $this->motivo;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setUsucod($usucod) {
        $this->usucod = $usucod;
    }

    function setUsunome($usunome) {
        $this->usunome = $usunome;
    }

    function setFone($fone) {
        $this->fone = $fone;
    }

    function setMotivo($motivo) {
        $this->motivo = $motivo;
    }

}