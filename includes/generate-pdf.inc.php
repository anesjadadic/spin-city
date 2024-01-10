<?php
	include("./connect.inc.php");
	require('./FPDF/fpdf.php');
?>
<?php
	class PDF extends FPDF
	{
		var $widths;
		var $aligns;
		
		// PRE-EXISTING METHODS
		function SetWidths($w)
		{
		    //Set the array of column widths
		    $this->widths=$w;
		}

		function SetAligns($a)
		{
		    //Set the array of column alignments
		    $this->aligns=$a;
		}

		function Row($data, $r, $g, $b)
		{			
		   	//Calculate the height of the row
		    $nb=0;
		    for($i=0;$i<count($data);$i++)
		        $nb=max($nb, $this->NbLines($this->widths[$i], $data[$i]));
		    $h=5*$nb;
		    //Issue a page break first if needed
		    $this->CheckPageBreak($h);
		    //Draw the cells of the row
		    for($i=0;$i<count($data);$i++)
		    {
		        $w=$this->widths[$i];
		        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
		        //Save the current position
		        $x=$this->GetX();
		        $y=$this->GetY();
		        //Draw the border
				$this->SetFillColor($r, $g, $b);
				$this->SetDrawColor(0,0,0);
				$this->SetLineWidth(.05);
		        $this->Rect($x, $y, $w-.01, $h+1, 'DF');
					
				//	$this->SetFont('','B');
		        //Print the text
		        $this->MultiCell($w, 5, $data[$i], "LTR", $a, true);
		        //Put the position to the right of the cell
		        $this->SetXY($x+$w, $y);
		    }
		    //Go to the next line
		    $this->Ln($h);
		}
		
		function CheckPageBreak($h)
		{
		    //If the height h would cause an overflow, add a new page immediately
		    if($this->GetY()+$h>$this->PageBreakTrigger)
		        $this->AddPage($this->CurOrientation);
		}

		function NbLines($w, $txt)
		{
		    //Computes the number of lines a MultiCell of width w will take
		    $cw=&$this->CurrentFont['cw'];
		    if($w==0)
		        $w=$this->w-$this->rMargin-$this->x;
		    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		    $s=str_replace("\r", '', $txt);
		    $nb=strlen($s);
		    if($nb>0 and $s[$nb-1]=="\n")
		        $nb--;
		    $sep=-1;
		    $i=0;
		    $j=0;
		    $l=0;
		    $nl=1;
		    while($i<$nb)
		    {
		        $c=$s[$i];
		        if($c=="\n")
		        {
		            $i++;
		            $sep=-1;
		            $j=$i;
		            $l=0;
		            $nl++;
		            continue;
		        }
		        if($c==' ')
		            $sep=$i;
		        $l+=$cw[$c];
		        if($l>$wmax)
		        {
		            if($sep==-1)
		            {
		                if($i==$j)
		                    $i++;
		            }
		            else
		                $i=$sep+1;
		            $sep=-1;
		            $j=$i;
		            $l=0;
		            $nl++;
		        }
		        else
		            $i++;
		    }
		    return $nl;
		}


		// HEADER and FOOTER - automatically executed
		function Header()
		{
		    // Arial bold 18
		    $this->SetFont('Arial','B',18);
		    $this->Cell(0,10,' Spin City Record Report',0,0,'C');
		    // Line break
		    $this->Ln(20);
		}


		function Footer()
		{
		    $this->SetY(-15);
		    $this->SetFont('Arial','I',8);
		    $this->Cell(0, 10, 'Page '.$this->PageNo().' of {nb}', 0, 0, 'L');
			$this->Cell(0, 10, date('m/d/Y H:i:s'), 0, 0, 'R');		    
		}



		// ---------- My Custom Table(s) ---------
		function RecordInterestsTable($header, $data, $widths)
		{
			// Color R/G/B parameters between 0 and 255 each
			$this->SetFillColor(112, 163, 202);
			$this->SetTextColor(255); // If only one argument, it's assumed to be gray scale level. Otherwise use 3 parameters for red/green/blue values (0-255 each)
			$this->SetDrawColor(0,0,0);
			$this->SetLineWidth(.1); 
			$this->SetFont('','B');// '' means "keep current font family". 'B' is "bold"

			$w = $widths;
			for($i=0;$i<count($header);$i++)
				$this->Cell($widths[$i],7,$header[$i],1,0,'C',true);
			$this->Ln();

			$this->SetFillColor(225,234,224);
			$this->SetTextColor(0);
			$this->SetDrawColor(0,0,0);
			$this->SetFont('Arial', '', 9);
			$this->SetWidths($widths);
			
			foreach($data as $row)
			{
				$this->Row(array($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8]), 255, 255, 255);				  
			}

		}		
	}


	//==========================    MAIN CODE   =============================


	/* ------------ Get the POST variables and access the database  ------------- */
	
	$date = date("m/d/Y");	
	$query = "SELECT * from Record";
	$result = $conn->query($query);	
	$numrows = $result->num_rows;	

	$recordsArray = array();
	for ($i=0; $i<$numrows ; $i++)
	{
		$row = $result->fetch_assoc();
		$id = $row["rID"];
		$name = $row['rName'];
		$artist = $row['rArtist'];
		$genre = $row['rGenre'];
		$year = $row['rYearReleased'];
		$vinyls = $row['rVinylQuantity'];
		$CDs = $row['rCDquantity'];
		$vinylPrice = '$'.$row['rVinylPrice'];
		$cdPrice = '$'.$row['rCDprice'];
		array_push($recordsArray, array($id, $name, $artist, $genre, $year, $vinyls, $CDs, $vinylPrice, $cdPrice));		
	}	

	/* ------------ START THE PDF GENERATION ------------- */
	$pdf = new PDF();

	// Set alias for number of pages. Will be calculated and substituted at the end.
	$pdf->AliasNbPages();	
	
	// Create new page	(Header() and Footer() functions executed automatically
	$pdf->AddPage();
	
	// Default font and draw color
	$pdf->SetFont('Arial', '', 9);
	$pdf->SetDrawColor(0,0,0);
	
	// Now prepare and draw the events table.
	$RecordsTableHeader = array('ID','Name', 'Artist', 'Genre', 'Year', 'Vinyl', 'CDs', 'Vinyl Price', 'CDs Price',);
	$RecordWidths = array(10, 40, 30, 18, 15, 15, 15, 23, 23);
	$pdf->Ln(10);
	$pdf->RecordInterestsTable($RecordsTableHeader, $recordsArray, $RecordWidths);
	
	// With all the tables created, generate the actual file...
	$pdf->Output('I');
	
	echo "Document generated with name ".$tempFileName." in the PDFs folder.";
	
	echo "<p><button type='button' onclick='window.location =\"mainpage.html\"'>Return</button></p>\n";
		
	$conn->close();
	
?>
