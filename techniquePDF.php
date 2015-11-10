<?php
 
 // function to get the becreative database
 function get_db() { 
	$db = '';
	$user = '';
	$pass = '';

	if(!$db)
	  $db = new PDO('', $user, $pass);
	  return $db;
	}

 // function to get the details from the database
 function get_details () { 
	//$id = 15;

 	if (isset($_POST['idNo'])){
      	  $id = $_POST['idNo'];
   	}


	$file_db = get_db();
	$sql = 'SELECT technique_name,description,people,method,problem_solving,creative_phases,location,equipment
       	FROM tech
         WHERE technique_id = :id';

    		$sth = $file_db->prepare($sql);
    		$sth->execute(array(':id' => $id));
    		return $sth;
  	}

	$result = get_details();
	
	// Populate the contents variables
	foreach ($result as $m) {
		$techName = $m['technique_name'];
		$description = en_dash_ellipsis($m['description']);
		$method = en_dash_ellipsis($m['method']);
		$people = en_dash_ellipsis($m['people']);
		$problem = en_dash_ellipsis($m['problem_solving']);
		$creative = en_dash_ellipsis($m['creative_phases']);
		$location = en_dash_ellipsis($m['location']);
		$equipment = en_dash_ellipsis($m['equipment']);

		//Remove unwanted tags from description and method
		$description = strip_tags($description,'<body><p><ol><ul><li>');
		$method = strip_tags($method,'<body><p><ol><ul><li>');

 }

 // function to deal with the en dashes
 function en_dash_ellipsis($text) {

	$text = str_replace('&#8211;', "chr(150)", $text);
 	$text = str_replace('&#133;', "chr(133)", $text);

 	return $text;
 }


 // function to deal with the characters: en dash, apostrophe, quote and ellipsis
 function chr_fix($text) {

 	$text = str_replace('chr(150)', chr(150), $text);
 	$text = str_replace('&#39;', chr(39), $text);
 	$text = str_replace('&#34;', chr(34), $text);
 	$text = str_replace('chr(133)', chr(133), $text);

	return $text;
 }


 // Build the PDF
 // require('fpdf17/fpdf.php');
 require('MultiCellBlt2.php');

 //create a FPDF object
 $pdf=new PDF();

 //set document properties
 $pdf->SetAuthor('Anon');
 $pdf->SetTitle($techName);

 //set font for the entire document
 $pdf->SetFont('Arial','B',10);
 $pdf->SetTextColor(0,0,0);

 //set up a page
 $pdf->AddPage('P'); 
 //$pdf->SetDisplayMode(real,'default');

//**Insert an image**
 $pdf->Image('images/be_creative.png',10,10,40,0);

//**Display the title without a border around it**
 $pdf->SetFontSize(16); 
 
 // Check width of title and deal with titles that are more than one line
 $w = $pdf->GetStringWidth($techName);
 if ($w > 162) {
   $pdf->SetXY(15,25);
   $pdf->MultiCell(170,7,$techName,0,'C',0);
   $pdf->Ln(10);
 } else {
   $pdf->SetXY(50,25);
   $pdf->Cell(100,10,$techName,0,0,'C',0);
   $pdf->Ln(15);
 }

//**Display "What is" heading**
 $pdf->SetFontSize(14);
 $pdf->Cell(100,10,"What is " . $techName . "?",0,0,'L',0);
 // Line break
 $pdf->Ln(10);
 $pdf->SetFont('Arial','',10);


// Add the xhtml components to the description string
$xhtmlDescription = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\"><html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\"><head></head><body>" . $description . "</body></html>";

$xmlD=simplexml_load_string($xhtmlDescription) or die("Error: Cannot create object");


foreach ($xmlD->body->children() as $item) {

 	if ($item->getName() == "p"){
    		$pdf->Write(5,chr_fix($item));
		$pdf->Ln(10);	
	} elseif ($item->getName() == "ol"){
		// For numbered list - width and numbered list array variables
		$column_width = $pdf->w-15;
		$descNumbered = array();
 		$descNumbered['bullet'] = 1;
 		$descNumbered['margin'] = ' ';
 		$descNumbered['indent'] = 3;
 		$descNumbered['spacer'] = 2;
 		$descNumbered['text'] = array();
		$i=0;
		foreach ($item->li as $list) {
			$descNumbered['text'][$i] = chr_fix($list);
			$i++;
		}
		$pdf->SetX(10);
 		$pdf->MultiCellBltArray($column_width-$pdf->x,5,$descNumbered);
 		$pdf->Ln(5);
	
	} elseif ($item->getName() == "ul"){
		// For bullet list - width and bullet array variables
		$column_width = $pdf->w-15;
		$descBullet = array();
 		$descBullet['bullet'] = chr(149);
 		$descBullet['margin'] = ' ';
 		$descBullet['indent'] = 3;
 		$descBullet['spacer'] = 2;
 		$descBullet['text'] = array();
		$i=0;
		foreach ($item->li as $list) {
			$descBullet['text'][$i] = chr_fix($list);
			$i++;
		}
		$pdf->SetX(10);
 		$pdf->MultiCellBltArray($column_width-$pdf->x,5,$descBullet);
 		$pdf->Ln(5);
	}
}

//**Display "What to do" heading**
 $pdf->SetFont('Arial','B',14);
 $pdf->SetFontSize(14);
 $pdf->Write(14,"What to Do");
 $pdf->Ln(12);
 $pdf->SetFont('Arial','',10);

// Add the xhtml components to the method string
$xhtmlMethod = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\"><html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\"><head></head><body>" . $method . "</body></html>";

$xmlM=simplexml_load_string($xhtmlMethod) or die("Error: Cannot create object");


foreach ($xmlM->body->children() as $item) {

 	if ($item->getName() == "p"){
    		$pdf->Write(5,chr_fix($item));
		$pdf->Ln(10);	
	} elseif ($item->getName() == "ol"){
		// For numbered list - width and numbered list array variables
		$column_width = $pdf->w-15;
		$descNumbered = array();
 		$descNumbered['bullet'] = 1;
 		$descNumbered['margin'] = ' ';
 		$descNumbered['indent'] = 3;
 		$descNumbered['spacer'] = 2;
 		$descNumbered['text'] = array();
		$i=0;
		foreach ($item->li as $list) {
			$descNumbered['text'][$i] = chr_fix($list);
			$i++;
		}
		$pdf->SetX(10);
 		$pdf->MultiCellBltArray($column_width-$pdf->x,5,$descNumbered);
 		$pdf->Ln(5);
	
	} elseif ($item->getName() == "ul"){
		// For bullet list - width and bullet array variables
		$column_width = $pdf->w-15;
		$descBullet = array();
 		$descBullet['bullet'] = chr(149);
 		$descBullet['margin'] = ' ';
 		$descBullet['indent'] = 3;
 		$descBullet['spacer'] = 2;
 		$descBullet['text'] = array();
		$i=0;
		foreach ($item->li as $list) {
			$descBullet['text'][$i] = chr_fix($list);
			$i++;
		}
		$pdf->SetX(10);
 		$pdf->MultiCellBltArray($column_width-$pdf->x,5,$descBullet);
 		$pdf->Ln(5);
	}
}


//**Display "Basics" heading**
 //$pdf->SetFont('Arial','B',14);
 //$pdf->Cell(100,10,"Basics",0,0,'L',0);
 //$pdf->Ln(8);

 $pdf->SetFont('Arial','B',14);
 $pdf->SetFontSize(14);
 $pdf->Write(14,"Basics");
 $pdf->Ln(11);

//**Display the people heading**
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(100,10,"People",0,0,'L',0);
 $pdf->Ln(8);

//**Write the people text**
 $pdf->SetFont('Arial','',10);
 $pdf->Write(5,chr_fix(strip_tags($people)));
 $pdf->Ln(7);

//**Display the problem solving characteristics heading**
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(100,10,"Problem solving characteristics",0,0,'L',0);
 $pdf->Ln(8);

//**Write the problem solving characteristics text**
 $pdf->SetFont('Arial','',10);
 $pdf->Write(5,chr_fix(strip_tags($problem)));
 $pdf->Ln(7);

//**Display the creative phases heading**
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(100,10,"Creative phases",0,0,'L',0);
 $pdf->Ln(8);

//**Write the creative phases text**
 $pdf->SetFont('Arial','',10);
 $pdf->Write(5,chr_fix(strip_tags($creative)));
 $pdf->Ln(7);

//**Display the location heading**
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(100,10,"Location",0,0,'L',0);
 $pdf->Ln(8);

//**Write the location text**
 $pdf->SetFont('Arial','',10);
 $pdf->Write(5,chr_fix(strip_tags($location)));
 $pdf->Ln(7);

//**Display the equipment heading**
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(100,10,"Equipment",0,0,'L',0);
 $pdf->Ln(8);

//**Write the equipment text**
 $pdf->SetFont('Arial','',10);
 $pdf->Write(5, chr_fix(strip_tags($equipment)));
 $pdf->Ln(7);

//**Output the PDF**
 $pdf->Output();

?>