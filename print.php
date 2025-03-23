<?php
require_once('Classes.php');
require_once('config.php');
require_once('fpdf.php');
session_start();
class PDF extends FPDF {

    function LoadData(){
        $conn=getConnection();
        if($conn){
            $sql="SELECT * FROM etudiants";
            $result=$conn->query($sql);
            $data=[];
            if($result->rowCount()>0){
                while($row=$result->fetch(PDO::FETCH_ASSOC)){
                    $data[]=new Etudiants($row['Nom'],$row['Maths'],$row['Informatique']);
                }
            }
            closeConnection($conn);
            return $data;
        }
    }

    function Table($header, $data){
        $this->SetFillColor(255,0,0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128,0,0);
        $this->SetLineWidth(.3);
        $this->SetFont('','B');
        $w = array(40, 35, 40, 45);
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = false;
        foreach($data as $row)
        {
            $this->Cell($w[0],6,$row[1],'LR',0,'L',$fill);
            $this->Cell($w[1],6,number_format($row[2]),'LR',0,'L',$fill);
            $this->Cell($w[2],6,number_format($row[3]),'LR',0,'R',$fill);
            $this->Cell($w[3],6,number_format(($row[2]+$row[3])/2),'LR',0,'R',$fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Closing line
        $this->Cell(array_sum($w),0,'','T');
    }
    function Header(){
        $this->Image('./assets/logo.png',10,6,30);
        $this->SetFont('Arial','B',12);
        $this->Cell(0,10,'Liste des etudiants',0,1,'C');
        $this->Ln(10);
    }

    function Footer(){
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,''.$this->PageNo().'/{nb}',0,0,'C');
    }
}

$pdf = new PDF();
$header = array('Nom', 'Maths', 'Informatique', 'Moyenne');
$data = $pdf->LoadData();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Table($header, $data);
$pdf->Output();

?>