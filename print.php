<?php
ob_start();
require_once('Classes.php');
require_once('config.php');
require_once('fpdf.php');
session_start();

$index=intval($_GET['id']);
class PDF extends FPDF {
    function LoadData($index){
        $conn=getConnection();
        if($conn){
            $sql="SELECT Nom, Maths, Informatique, Photo FROM Notes WHERE ID=?";
            $result=$conn->prepare($sql);
            $result->execute([$index]);
            $data=$result->fetch();
            closeConnection($conn);
            return $data;
        }
    }

    function Table($header, $data){
        $this->SetLineWidth(.3);
        $w = array(150,30);
        $photo=trim($data['Photo'], "'\"");
        // Nom
        $this->SetFillColor(220);
        $this->SetFont('','B', 12);
        $this->Image($photo,150,45,40);
        $this->Ln(8);
        $this->Cell($w[0]-41,12,$header[0],0,0,'L',1);
        $this->SetFont('');
        $this->Cell($w[1],12,$data['Nom'],0,0,'R',1);
        $this->Ln(40);
        // Maths
        $this->SetFont('','B');
        $this->Cell($w[0],12,$header[1],'TBL',0,'L');
        $this->SetFont('');
        $this->Cell($w[1],12,number_format($data['Maths']),1,0,'R');
        $this->Ln();
        // Informatique
        $this->SetFont('','B');
        $this->Cell($w[0],12,$header[2],'TBL',0,'L',);
        $this->SetFont('');
        $this->Cell($w[1],12,number_format($data['Informatique']),1,0,'R');
        $this->Ln();
        // Moyenne
        $moy=number_format(($data['Maths']+$data['Informatique'])/2);

        $this->SetFont('','B');
        $this->Cell($w[0],12,$header[3],'TBL',0,'L',1);
        $this->Cell($w[1],12,$moy,1,0,'R',1);
        $this->Ln(35);
        // Observation
        $obsrv=($moy >= 10.00) ? "ADMIS" : "NON ADMIS";

        $this->Cell($w[0],12,$header[4],'TBL',0,'L',1);
        $this->Cell($w[1],12, $obsrv,1,0,'R',1);
        $this->Ln();
    }
    function Header(){
        $this->Image('./assets/logo.png',10,6,40);
        $this->SetFont('Arial','B',24);
        $this->Cell(0,30,'Rapport',0,1,'C');
        $this->Ln(10);
    }
}
$pdf = new PDF();
$header = array('Nom', 'Maths', 'Informatique', 'Moyenne', 'Observation');
$data = $pdf->LoadData($index);
$pdf->AddPage();
$pdf->Table($header, $data);
$pdf->Output();
ob_end_flush(); 
?>