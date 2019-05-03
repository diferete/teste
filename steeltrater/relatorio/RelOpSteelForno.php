<?php

// Diretórios
require '../../biblioteca/fpdf/fpdf.php'; 
include("../../includes/Config.php"); 

class PDF extends FPDF {
    function Footer(){ // Cria rodapé
        $this->SetXY(15,278);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial','',7); // seta fonte no rodape
        $this->Cell(190,7,'Página '.$this->PageNo().' de {nb}',0,1,'C'); // paginação
        }
}

$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE

$pdf->SetXY(5,5); // DEFINE O X E O Y NA PAGINA

//Caminho da logo
$sLogo ='../../biblioteca/assets/images/steelrel.png'; 
$pdf->SetMargins(5,5,5);

//Caminho do usuário, data e hora
date_default_timezone_set('America/Sao_Paulo');
$data      = date("d/m/y");                     //função para pegar a data local
$hora      = date("H:i");                       //para pegar a hora com a função date
$useRel= $_REQUEST['userRel'];


//Inserção do cabeçalho
$pdf->Cell(37,15,$pdf->Image($sLogo, $pdf->GetX(), $pdf->GetY(), 45),0,0,'J');

$pdf->SetFont('Arial','',15);
$pdf->Cell(110,15,'Relatório Ordem de Produção', '',0, 'C',0); 

$pdf->SetFont('Arial','',9);
$pdf->MultiCell(52,7,'Data: '.$data
        .'        Hora:'.$hora
        .' Usuário:'.$useRel 
        .' ','','L',0); //'B,R,T'
$pdf->Cell(0,5,'','',1,'L');
$pdf->Cell(0,5,'','T',1,'L');


//Inicio
     //Pega data que o usuário digitou
        $dtinicial= $_REQUEST['dataini'];
        $dtfinal= $_REQUEST['datafinal'];
        
     //Pega dados que passados pelo usuário na tela de relatório
     
     $sSituacao=$_REQUEST['situa'];
     $iEmpCodigo=$_REQUEST['emp_codigo'];
     $sEmpDescricao=$_REQUEST['emp_razaosocial'];
     $sFornodes=$_REQUEST['fornodes'];
     $iFornoCod=$_REQUEST['fornocod'];
     
     //busca os dados do banco
     $PDO = new PDO("sqlsrv:server=".Config::HOST_BD.",".Config::PORTA_BD."; Database=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
     $sSqli = "select STEEL_PCP_ordensFabApont.op,fornodes,
               STEEL_PCP_ordensFabApont.prodes,convert(varchar,dataent_forno,103)as dataent_forno,
               convert(varchar,horaent_forno,8)as horaent_forno,
               convert(varchar,datasaida_forno,103)as datasaida_forno,
               convert(varchar,horasaida_forno,8)as horasaida_forno,STEEL_PCP_ordensFab.peso,quant,documento,
               STEEL_PCP_ordensFab.situacao,emp_razaosocial,convert(varchar,data,103)as data,
               dataent_forno as dataent_forno2
               from STEEL_PCP_ordensFabApont left outer join STEEL_PCP_ordensFab
               on STEEL_PCP_ordensFabApont.op = STEEL_PCP_ordensFab.op
               where dataent_forno between '".$dtinicial."' and '".$dtfinal."'";
               if($iEmpCodigo!==''){     
               $sSqli.= " and emp_codigo ='".$iEmpCodigo."'";
    
               } 
               if($iFornoCod!==''){
                   $sSqli.=" and STEEL_PCP_ordensFabApont.fornocod ='".$iFornoCod."'";
               }
               if($sSituacao!=='Todas'){
               if ($sSituacao=='Processo'){
                 $sSqli.=" and STEEL_PCP_ordensFab.situacao='Processo' ";
                 } else {
                 $sSqli.=" and STEEL_PCP_ordensFab.situacao='Finalizado' ";
                 }
               }
               if($iEmpCodigo!==''){
                  $sSqli.=" and emp_codigo='".$iEmpCodigo."' ";
               }
        $sSqli.="order by dataent_forno2";
          
   $dadosRela = $PDO->query($sSqli);
   
   //Filtros escolhidos
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(35,10,'Filtros escolhidos:', '',0, 'L',0);
   
   
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(30,10,'Data de entrada: '.$dtinicial.
           '         Data saída: '.$dtfinal.
           '         Forno: '.$sFornodes.
           '         Situação: '.$sSituacao, '',1, 'L',0);
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(30,10,'Cliente: '.$iEmpCodigo.
           '         Razão Social: '.$sEmpDescricao, '',1, 'L',0);
   
   //$pdf->SetFont('Arial','',9);
   //$pdf->Cell(30,10,'Data inicial: '.$dtfinal, '',1, 'L',0);
   $pdf->Cell(0,3,'','',1,'L');
   
   $Pesototal=0;
   $Quanttotal=0;
   
   while($row = $dadosRela->fetch(PDO::FETCH_ASSOC)){
   
   //Títulos do relatório
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell(8,5,'OP', 'B,R,L,T',0, 'C',0);
   
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell(14,5,'FORNO', 'B,R,T',0, 'C',0);
   
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell(72,5,'PRODUTO', 'B,R,T',0, 'C',0);
   
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell(19,5,'DATA ENT', 'B,R,T',0, 'C',0);
   
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell(19,5,'HORA ENT', 'B,R,T',0, 'C',0);
   
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell(21,5,'DATA SAIDA', 'B,R,T',0, 'C',0);
   
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell(24,5,'HORA SAIDA', 'B,R,T',0, 'C',0);
   
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell(22,5,'SITUAÇÃO', 'B,R,T',1, 'C',0);
       
   $pdf->SetFont('Arial','',8);
   $pdf->Cell(8, 6, $row['op'],'L,B',0,'C');
       
   $pdf->SetFont('Arial','',8);
   $pdf->Cell(14, 6, $row['fornodes'],'L,B',0,'C');
       
   $pdf->SetFont('Arial','',7);
   $pdf->Cell(72, 6, $row['prodes'],'L,B',0,'L');
   
   $pdf->SetFont('Arial','',9);
   $pdf->Cell(19, 6, $row['dataent_forno'],'L,B',0,'C');
   
   $pdf->SetFont('Arial','',9);
   $pdf->Cell(19, 6, $row['horaent_forno'],'L,B',0,'C');
   
   $pdf->SetFont('Arial','',9);
   $pdf->Cell(21, 6, $row['datasaida_forno'],'L,B',0,'C');
       
   $pdf->SetFont('Arial','',9);
   $pdf->Cell(24, 6, $row['horasaida_forno'],'L,B',0,'C');
   
   $pdf->SetFont('Arial','',8);
   $pdf->Cell(22, 6, $row['situacao'],'L,B,R',1,'C');
   
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell(16,6,'CLIENTE:', 'B,L',0, 'L',0);
   $pdf->SetFont('Arial','',7);
   $pdf->Cell(78, 6, $row['emp_razaosocial'],'B,R',0,'L');
   
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell(18,6,'DATA OP:', 'B',0, 'L',0);
   $pdf->SetFont('Arial','',8);
   $pdf->Cell(20, 6, $row['data'],'B,R',0,'L');
   
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell(10,6,'NOTA:', 'B',0, 'L',0);
   $pdf->SetFont('Arial','',8);
   $pdf->Cell(11, 6, $row['documento'],'B,R',0,'L');
   
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell(10,6,'PESO:', 'B',0, 'L',0);
   $pdf->SetFont('Arial','',8);
   $pdf->Cell(14, 6, number_format($row['peso'], 2, ',', '.'),'B,R',0,'L');
   
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell(6,6,'QT:', 'B',0, 'L',0);
   $pdf->SetFont('Arial','',8);
   $pdf->Cell(16, 6, number_format($row['quant'], 2, ',', '.'),'B,R',1,'L');
   
   $pdf->Cell(100,5,'', '',1, '',0);

   $Pesototal=($row['peso']+$Pesototal);
   $Quanttotal=($row['quant']+$Quanttotal);
   
   }
   
   $pdf->Cell(50,5,'','B',1,'L');
   
   $pdf->SetFont('Arial','',9);
   $pdf->Cell(100, 2, '','',1,'C');
   
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(100, 8, 'Quant. Total: '.number_format($Quanttotal, 2, ',', '.'),'',1,'J');
   
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(99, 8, 'Peso Total: '.number_format($Pesototal, 2, ',', '.'),'',0,'J');
 
//Fim  
   


$pdf->Output('I','RelOpSteelForno.pdf');
 Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE 