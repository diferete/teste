<?php

/*
 *
 */

class ModelSTEEL_PCP_ordensFabApontEtapasGeren {

    private $op;
    private $seq;
    private $fornocod;
    private $dataent_forno;
    private $horaent_forno;
    private $datasaida_forno;
    private $horasaida_forno;
    private $fornodes;
    private $procod;
    private $prodes;
    private $situacao;
    private $coduser;
    private $usernome;
    private $codusersaida;
    private $usernomesaida;
    private $turnoSteel;
    private $turnoSteelSaida;
    
    function getTurnoSteelSaida() {
        return $this->turnoSteelSaida;
    }

    function setTurnoSteelSaida($turnoSteelSaida) {
        $this->turnoSteelSaida = $turnoSteelSaida;
    }

        
    function getTurnoSteel() {
        return $this->turnoSteel;
    }

    function setTurnoSteel($turnoSteel) {
        $this->turnoSteel = $turnoSteel;
    }

        
     function getCodusersaida() {
         return $this->codusersaida;
     }

     function getUsernomesaida() {
         return $this->usernomesaida;
     }

     function setCodusersaida($codusersaida) {
         $this->codusersaida = $codusersaida;
     }

     function setUsernomesaida($usernomesaida) {
         $this->usernomesaida = $usernomesaida;
     }

         
    function getUsernome() {
        return $this->usernome;
    }

    function setUsernome($usernome) {
        $this->usernome = $usernome;
    }

        
    function getCoduser() {
        return $this->coduser;
    }

   
    function setCoduser($coduser) {
        $this->coduser = $coduser;
    }

  
    function getSituacao() {
        return $this->situacao;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    
    function getFornodes() {
        return $this->fornodes;
    }

    function getProcod() {
        return $this->procod;
    }

    function getProdes() {
        return $this->prodes;
    }

    function setFornodes($fornodes) {
        $this->fornodes = $fornodes;
    }

    function setProcod($procod) {
        $this->procod = $procod;
    }

    function setProdes($prodes) {
        $this->prodes = $prodes;
    }

    
    function getOp() {
        return $this->op;
    }

    function getSeq() {
        return $this->seq;
    }

    function getFornocod() {
        return $this->fornocod;
    }

    function getDataent_forno() {
        return $this->dataent_forno;
    }

    function getHoraent_forno() {
        return $this->horaent_forno;
    }

    function getDatasaida_forno() {
        return $this->datasaida_forno;
    }

    function getHorasaida_forno() {
        return $this->horasaida_forno;
    }

    function setOp($op) {
        $this->op = $op;
    }

    function setSeq($seq) {
        $this->seq = $seq;
    }

    function setFornocod($fornocod) {
        $this->fornocod = $fornocod;
    }

    function setDataent_forno($dataent_forno) {
        $this->dataent_forno = $dataent_forno;
    }

    function setHoraent_forno($horaent_forno) {
        $this->horaent_forno = $horaent_forno;
    }

    function setDatasaida_forno($datasaida_forno) {
        $this->datasaida_forno = $datasaida_forno;
    }

    function setHorasaida_forno($horasaida_forno) {
        $this->horasaida_forno = $horasaida_forno;
    }

}
