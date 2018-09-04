<?php

/* 
 * Implementa a classe persistência
 * 
 * @author Cleverton Hoffmann
 * @since 22/08/2018
 */

class PersistenciaMET_CadastroMaquinas extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbtipmaq');
        
        $this->adicionaRelacionamento('tipcod','tipcod',true,true, true);
        $this->adicionaRelacionamento('tipdes', 'tipdes');
        
        $this->adicionaOrderBy('tipcod',0);
    }
}