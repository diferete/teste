<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_QUAL_AcaoEficaz extends Persistencia {

    public function __construct() {
        parent::__construct();
        $this->setTabela('MET_QUAL_acaoeficaz');

        $this->adicionaRelacionamento('filcgc', 'filcgc', true, true);
        $this->adicionaRelacionamento('nr', 'nr', true, true);
        $this->adicionaRelacionamento('seq', 'seq', true, true, true);
        $this->adicionaRelacionamento('acao', 'acao');
        $this->adicionaRelacionamento('dataprev', 'dataprev');
        $this->adicionaRelacionamento('datareal', 'datareal');
        $this->adicionaRelacionamento('usucodigo', 'usucodigo');
        $this->adicionaRelacionamento('usunome', 'usunome');
        $this->adicionaRelacionamento('eficaz', 'eficaz');
        $this->adicionaRelacionamento('obs', 'obs');
        $this->adicionaRelacionamento('sit', 'sit');

        $this->adicionaOrderBy('seq', 1);
    }

    public function apontaEfi() {

        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        $aCampos['obs'] = $this->preparaString($aCampos['obs']);

        $sSql = "update MET_QUAL_acaoeficaz set datareal = '" . $aCampos['datareal'] . "',eficaz = '" . $aCampos['eficaz'] . "',obs='" . $aCampos['obs'] . "', sit = 'Finalizado' where filcgc ='" . $aCampos['filcgc'] . "' and nr ='" . $aCampos['nr'] . "' and seq ='" . $aCampos['seq'] . "'";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    public function retEfi() {
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        $naoNull = ' ';

        $sSql = "update MET_QUAL_acaoeficaz set datareal = null ,eficaz = '" . $naoNull . "' ,obs=null,sit = null where filcgc ='" . $aCampos['filcgc'] . "' and nr ='" . $aCampos['nr'] . "' and seq ='" . $aCampos['seq'] . "'";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    public function finalizaAcao($aDados) {
        $user = $_SESSION['nome'];
        date_default_timezone_set('America/Sao_Paulo');
        $sHora = date('H:i');
        $sData = date('d/m/Y');

        $sSqlSelect = "select count(*) as total "
                . "from MET_QUAL_acaoeficaz "
                . "where filcgc ='" . $aDados['filcgc'] . "' "
                . "and nr ='" . $aDados['nr'] . "' "
                . "and sit is null";
        $oRetorno = $this->consultaSql($sSqlSelect);

        if ($oRetorno->total == 0) {
            $sSql = "update MET_QUAL_qualaq "
                    . "set sit = 'Finalizada',"
                    . "userfech = '" . $user . "',"
                    . "horafech = '" . $sHora . "',"
                    . "datafech = '" . $sData . "' "
                    . "where filcgc = '" . $aDados['filcgc'] . "' and nr ='" . $aDados['nr'] . "'  ";
            $aRetorno = $this->executaSql($sSql);
            return $aRetorno;
        } else {
            return $aRetorno[0] = false;
        }
    }

    public function reabreAq($aDados) {
        $user = $_SESSION['nome'];
        date_default_timezone_set('America/Sao_Paulo');
        $sHora = date('H:i');
        $sData = date('d/m/Y');


        $sSql = "update MET_QUAL_qualaq set sit = 'Aberta', userfech =null, horafech =null, datafech =null 
         where filcgc = '" . $aDados['filcgc'] . "' and nr ='" . $aDados['nr'] . "'  ";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

}
