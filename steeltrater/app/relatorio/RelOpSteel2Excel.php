<?php

/* 
 * Autor: Cleverton Hoffmann
 */

require '../../biblioteca/phpexcel/Classes/PHPExcel.php'; 
include("../../includes/Config.php"); 

//Cabeçalho
if(isset($_REQUEST["userRel"])){
    $usu = $_REQUEST["userRel"];
}
date_default_timezone_set('America/Sao_Paulo');
$dataEmis      = date("d/m/y");                     //função para pegar a data local
$hora      = date("H:i");                       //para pegar a hora com a função date

//Datas escolhidas pelo usuário
if(isset($_REQUEST["dataini"])){
    $dtinicial = $_REQUEST["dataini"];
}

if(isset($_REQUEST["datafinal"])){
    $dtfinal = $_REQUEST["datafinal"];
}

// Instanciamos a classe
$objPHPExcel = new PHPExcel();
      
// Definimos o estilo da fonte
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D5')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('E5')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('F5')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('G5')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('H5')->getFont()->setBold(true);

// Criamos as colunas
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'RELATÓRIO DAS ORDENS DE PRODUÇÃO');

     //Situação e produto escolhido
     $sRetrabalho = $_REQUEST['retrabalho'];
     $sSituacao=$_REQUEST['situa'];
     $iEmpCodigo=$_REQUEST['emp_codigo'];
     $iTratCod = $_REQUEST['tratcod'];
     //busca os dados do banco
     $PDO = new PDO("sqlsrv:server=".Config::HOST_BD.",".Config::PORTA_BD."; Database=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
     $sSqli = "select op,prod,prodes,prodesfinal,quant,
              peso,opcliente,convert(varchar,data,103) as data,convert(varchar,dataprev,103) as dataprev,
              situacao 
              from STEEL_PCP_OrdensFab left outer join STEEL_PCP_receitasItens
              on STEEL_PCP_OrdensFab.receita = STEEL_PCP_receitasItens.cod 
              and seq = ( select top 1 seq from STEEL_PCP_receitasItens where cod = STEEL_PCP_OrdensFab.receita order by seq )
              where data between '".$dtinicial."' and '".$dtfinal."'";
              if($sSituacao!=='Todas'){
              $sSqli.=" and situacao='".$sSituacao."' ";
                }else{
                    $sSqli.=" and situacao not in ('Cancelada','Retornado') ";
                }
                if($iEmpCodigo!==''){
                    $sSqli.=" and emp_codigo='".$iEmpCodigo."' ";
                }
                if($sRetrabalho!='Incluir'){
                    $sSqli.=" and retrabalho='".$sRetrabalho."' ";
                }else{
                    $sSqli.=" and retrabalho<>'Retorno não Ind.' and retrabalho <> 'OP origem retrabalho' "; 
                }
                if($iTratCod!==''){
                    $sSqli.=" and tratcod ='".$iTratCod."'  ";
                }
   if($_REQUEST['tratdes']!==''){
        $sTratDes = $_REQUEST['tratdes'];
   }else{
        $sTratDes = 'Todos';
   }
   if($iEmpCodigo==null){
       $iEmpCodigo = 'Todas';
   }
          
   $dadosRela = $PDO->query($sSqli);
   
//Títulos da planhilha e filtros
$objPHPExcel->setActiveSheetIndex(0)
        //Filtros
            ->setCellValue('A2', 'Usuário:' )
            ->setCellValue('B2', "$usu" )
            ->setCellValue('A3','Data:')
            ->setCellValue('B3',"$dataEmis")
            ->setCellValue('A4','Hora:')
            ->setCellValue('B4',"$hora")
            ->setCellValue('C1', 'Filtros escolhidos' )
            ->setCellValue('C2', 'Situação' )
            ->setCellValue('D2', "$sSituacao" )
            ->setCellValue('C3', 'Data Inicial' )
            ->setCellValue('D3', "$dtinicial" )
            ->setCellValue('C4', 'Data Final' )
            ->setCellValue('D4', "$dtfinal" )
            ->setCellValue('E3', 'Empresa' )
            ->setCellValue('F3', "$iEmpCodigo" )
            ->setCellValue('E4', 'Retrabalho' )
            ->setCellValue('F4', "$sRetrabalho" )
            ->setCellValue('G4', 'Tratamento' )
            ->setCellValue('H4', "$sTratDes" )
        
        //titulos
            ->setCellValue('A5', 'OP' )
            ->setCellValue('B5', 'Prod' )
            ->setCellValue('C5', 'Descrição' )
            ->setCellValue('D5','Descrição Final')
         //   ->setCellValue('D5', 'Quant' )
            ->setCellValue('E5', 'Peso' )
        //    ->setCellValue('E5', 'OpCliente' )
            ->setCellValue('F5', 'Data' )
            ->setCellValue('G5', 'Data Prev' )
            ->setCellValue('H5', 'Situação' )        
        ;
  $ik=6;
  $iPesototal=0;
  $iQuantidadetotal=0;
while($row = $dadosRela->fetch(PDO::FETCH_ASSOC)){  
    $op=$row['op'];
    $prod=$row['prod'];
    $prodes=$row['prodes'];
    $prodesFinal =$row['prodesfinal'];
    $iQuant=number_format($row['quant'], 2, ',', '.');
    $iPeso=number_format($row['peso'], 2, ',', '.');
    $iPeso2=$row['peso'];
    $opcliente=$row['opcliente'];
    $dataop=$row['data'];
    $dataprev=$row['dataprev'];
    $situac=$row['situacao'];
    $iPesototal=$iPesototal+$iPeso2;
    $iQuantidadetotal=$iQuantidadetotal+$iQuant;
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.($ik), "$op" ) //concatenação de variável indice/ Pulando Linha
        ->setCellValue('B'.($ik), "$prod" )
        ->setCellValue('C'.($ik), "$prodes" )
        ->setCellValue('D'.($ik), "$prodesFinal" )
      //  ->setCellValue('D'.($ik), "$iQuant" )
        ->setCellValue('E'.($ik), "$iPeso" )
       // ->setCellValue('E'.($ik), "$opcliente" )
        ->setCellValue('F'.($ik), "$dataop" )
        ->setCellValue('G'.($ik), "$dataprev" )
        ->setCellValue('H'.($ik), "$situac" )
               
    ;
$ik++;
}
//pesos
$iPesototal = number_format($iPesototal, 2, ',', '.');
 $objPHPExcel->setActiveSheetIndex(0)
       // ->setCellValue('A'.($ik), 'Quant.Total' ) 
       // ->setCellValue('B'.($ik), "$iQuantidadetotal" )
        ->setCellValue('A'.($ik), 'Peso Total' )
        ->setCellValue('B'.($ik), "$iPesototal" );
// Podemos configurar diferentes larguras paras as colunas como padrão
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(60);
// $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);

// Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas
$objPHPExcel->getActiveSheet()->setTitle('Relatório OP');

// Cabeçalho do arquivo para ele baixar
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Relatório Ordens de Produção.xls"');
header('Cache-Control: max-age=0');
// Se for o IE9, isso talvez seja necessário
header('Cache-Control: max-age=1');

// Acessamos o 'Writer' para poder salvar o arquivo
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

// Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
$objWriter->save('php://output'); 

exit;

 