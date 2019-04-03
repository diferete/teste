<?php

/*
 * Classe que implementa a persistencia de NotaFiscalItem de entrada
 * 
 * @author Cleverton Hoffmann
 * @since 20/06/2018
 */

class PersistenciaDELX_NFS_NotaFiscalItem extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('NFS_NOTAFISCALITEM');

        $this->adicionaRelacionamento('nfs_notafiscalfilial', 'nfs_notafiscalfilial', true, true);
        $this->adicionaRelacionamento('nfs_notafiscalseq', 'nfs_notafiscalseq', true, true);
        $this->adicionaRelacionamento('nfs_notafiscalitemseq', 'nfs_notafiscalitemseq', true, true);
        $this->adicionaRelacionamento('nfs_notafiscalitemproduto', 'nfs_notafiscalitemproduto');
        $this->adicionaRelacionamento('nfs_notafiscalitemprodutonomem', 'nfs_notafiscalitemprodutonomem');
        $this->adicionaRelacionamento('nfs_notafiscalitemprodutounman', 'nfs_notafiscalitemprodutounman');
        $this->adicionaRelacionamento('nfs_notafiscalitemquantidade', 'nfs_notafiscalitemquantidade');
        $this->adicionaRelacionamento('nfs_notafiscalitemvalorunitari', 'nfs_notafiscalitemvalorunitari');
        $this->adicionaRelacionamento('nfs_notafiscalitemvalortotal', 'nfs_notafiscalitemvalortotal');
        $this->adicionaRelacionamento('nfs_notafiscalitempesoliquido', 'nfs_notafiscalitempesoliquido');
        $this->adicionaRelacionamento('nfs_notafiscalitempesobruto', 'nfs_notafiscalitempesobruto');

        $this->setSTop('1000');
        $this->adicionaOrderBy('nfs_notafiscalfilial', 0);
    }

}
