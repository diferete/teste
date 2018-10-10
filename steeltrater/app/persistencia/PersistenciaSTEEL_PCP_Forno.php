<?php

/*
 * Classe que implementa a persistencia de Forno
 * 
 * @author Cleverton Hoffmann
 * @since 05/07/2018
 */

class PersistenciaSTEEL_PCP_Forno extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('STEEL_PCP_FORNO');

        $this->adicionaRelacionamento('fornocod', 'fornocod', true, true,true);
        $this->adicionaRelacionamento('fornodes', 'fornodes');
        $this->adicionaRelacionamento('fornosigla', 'fornosigla');

        $this->setSTop('40');
        $this->adicionaOrderBy('fornocod', 1);
    }

}