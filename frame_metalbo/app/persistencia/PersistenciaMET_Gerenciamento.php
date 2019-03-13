<?php

/* 
 * Implementa a classe persistência
 * 
 * @author Cleverton Hoffmann
 * @since 24/08/2018
 */

class PersistenciaMET_Gerenciamento extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbmanutmp');
        $this->adicionaRelacionamento('filcgc','filcgc',true, true);
        $this->adicionaRelacionamento('nr', 'nr', true, true, true);
        $this->adicionaRelacionamento('codmaq', 'codmaq');
        $this->adicionaRelacionamento('codmaq','MET_Maquinas.cod',false,false,false);
        $this->adicionaRelacionamento('maquina','MET_Maquinas.maquina',false,false,false);
        $this->adicionaRelacionamento('codsetor','codsetor');
        $this->adicionaRelacionamento('descsetor','descsetor',false,false,false);
        $this->adicionaRelacionamento('sitmp','sitmp');
        $this->adicionaRelacionamento('databert','databert');
        $this->adicionaRelacionamento('userabert','userabert');
        $this->adicionaRelacionamento('userfecho','userfecho');
        $this->adicionaRelacionamento('datafech','datafech');
        
        $this->adicionaOrderBy('nr',1);
        
        $this->adicionaJoin('MET_Maquinas',null,1,'codmaq','cod');
        $this->adicionaJoin('MET_Setores');
       
    }
      
    public function consultaCodSetor($iCodMaq){
        
        $sSql = "select codsetor from metmaq where cod ='".$iCodMaq."'";       
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        return $oRow;
        
    }
    
    
}