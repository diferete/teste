<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelMET_ISO_Treinamentos {

    private $nr;
    private $filcgc;
    private $cracha;
    private $situacao;
    private $nome;
    private $codsetor;
    private $descsetor;
    private $funcao;
    private $data_cad;
    private $usuario;
    private $updates;
    
    function getNr() {
        return $this->nr;
    }

    function getFilcgc() {
        return $this->filcgc;
    }

    function getCracha() {
        return $this->cracha;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function getNome() {
        return $this->nome;
    }

    function getCodsetor() {
        return $this->codsetor;
    }

    function getDescsetor() {
        return $this->descsetor;
    }

    function getFuncao() {
        return $this->funcao;
    }

    function getData_cad() {
        return $this->data_cad;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getUpdates() {
        return $this->updates;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setCracha($cracha) {
        $this->cracha = $cracha;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setCodsetor($codsetor) {
        $this->codsetor = $codsetor;
    }

    function setDescsetor($descsetor) {
        $this->descsetor = $descsetor;
    }

    function setFuncao($funcao) {
        $this->funcao = $funcao;
    }

    function setData_cad($data_cad) {
        $this->data_cad = $data_cad;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setUpdates($updates) {
        $this->updates = $updates;
    }

}