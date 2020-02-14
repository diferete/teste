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

//Pega data que o usuário digitou
$dtinicial= $_REQUEST['dataini'];
$dtfinal= $_REQUEST['datafinal'];

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
     
     $sSituacao=$_REQUEST['situa'];
     $iEmpCodigo=$_REQUEST['emp_codigo'];
     //busca os dados do banco
     $PDO = new PDO("sqlsrv:server=".Config::HOST_BD.",".Config::PORTA_BD."; Database=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
     $sSqli = "select op,prod,prodes,quant,
              peso,opcliente,convert(varchar,data,103) as data,convert(varchar,dataprev,103) as dataprev,
              situacao 
              from STEEL_PCP_OrdensFab 
              where data between '".$dtinicial."' and '".$dtfinal."'";
          if($sSituacao!=='Todas'){
              $sSqli.=" and situacao='".$sSituacao."' ";
          }else{
              $sSqli.=" and situacao<>'Cancelada' ";
          }
          if($iEmpCodigo!==''){
              $sSqli.=" and emp_codigo='".$iEmpCodigo."' ";
          }
          
   $dadosRela = $PDO->query($sSqli);
   
   //Filtros escolhidos
   $pdf->SetFont('Arial','B',12);
   $pdf->Cell(50,10,'Filtros escolhidos:', '',0, 'L',0);
   
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(30,10,'Data inicial: '.$dtinicial.
           '         Data final: '.$dtfinal.
           '         Situação: '.$sSituacao, '',1, 'L',0);
   
   
   //$pdf->SetFont('Arial','',9);
   //$pdf->Cell(30,10,'Data inicial: '.$dtfinal, '',1, 'L',0);
   $pdf->Cell(0,3,'','',1,'L');
  
   
   
   
   
   
   //Títulos do relatório
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(8,5,'OP', 'B,R,L,T',0, 'C',0);
   
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(17,5,'Prod.', 'B,R,T',0, 'C',0);
   
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(69,5,'Descrição', 'B,R,T',0, 'C',0);
   
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(17,5,'Quant.', 'B,R,T',0, 'C',0);
   
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(17,5,'Peso', 'B,R,T',0, 'C',0);
   
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(17,5,'OpCliente', 'B,R,T',0, 'C',0);
   
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(19,5,'Data', 'B,R,T',0, 'C',0);
   
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(19,5,'Data Prev.', 'B,R,T',0, 'C',0);
   
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(16,5,'Situação', 'B,R,T',1, 'C',0);
   
   $Pesototal=0;
   $Quanttotal=0;
   
   while($row = $dadosRela->fetch(PDO::FETCH_ASSOC)){
   
  
   $pdf->SetFont('Arial','',8);
   $pdf->Cell(8, 6, $row['op'],'L,B',0,'C');
       
   $pdf->SetFont('Arial','',9);
   $pdf->Cell(17, 6, $row['prod'],'L,B',0,'R');
       
   $pdf->SetFont('Arial','',7);
   $pdf->Cell(69, 6, $row['prodes'],'L,B',0,'L');
   
   $pdf->SetFont('Arial','',9);
   $pdf->Cell(17, 6, number_format($row['quant'], 2, ',', '.'),'L,B',0,'R');
   
   $pdf->SetFont('Arial','',9);
   $pdf->Cell(17, 6, number_format($row['peso'], 2, ',', '.'),'L,B',0,'R');
   
   $pdf->SetFont('Arial','',9);
   $pdf->Cell(17, 6, $row['opcliente'],'L,B',0,'R');
       
   $pdf->SetFont('Arial','',9);
   $pdf->Cell(19, 6, $row['data'],'L,B',0,'C');
   
   $pdf->SetFont('Arial','',9);
   $pdf->Cell(19, 6, $row['dataprev'],'L,B',0,'C');
   
   $pdf->SetFont('Arial','',8);
   $pdf->Cell(16, 6, $row['situacao'],'L,B,R',1,'C');
  
   
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





$pdf->Output('I','RelOpSteel2.pdf');
 Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE 