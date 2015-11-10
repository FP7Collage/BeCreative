<?php
require('fpdf17/fpdf.php');

class PDF extends FPDF
{
	/************************************************************
	*                                                           *
	*    MultiCell with bullet (array)                          *
	*                                                           *
	*    Requires an array with the following  keys:            *
	*                                                           *
	*        Bullet -> String or Number                         *
	*        Margin -> Number, space between bullet and text    *
	*        Indent -> Number, width from current x position    *
	*        Spacer -> Number, calls Cell(x), spacer=x          *
	*        Text -> Array, items to be bulleted                *
	*                                                           *
	*    NB Amended JAL to put fullstop after number            *		       
	*                                                           *
	************************************************************/

	function MultiCellBltArray($w, $h, $blt_array, $border=0, $align='L', $fill=false)
	{
		if (!is_array($blt_array))
		{
			die('MultiCellBltArray requires an array with the following keys: bullet,margin,text,indent,spacer');
			exit;
		}
				
		//Save x
		$bak_x = $this->x;

		if (is_numeric($blt_array['bullet'])) {

		for ($i=0; $i<sizeof($blt_array['text']); $i++)
		{
			//Get bullet width including margin
			$blt_width = $this->GetStringWidth($blt_array['bullet'] . "." . $blt_array['margin'])+$this->cMargin*2;
			
			// SetX
			$this->SetX($bak_x);
			
			//Output indent
			if ($blt_array['indent'] > 0)
				$this->Cell($blt_array['indent']);
			
			//Output bullet
			$this->Cell($blt_width,$h,$blt_array['bullet'] . "." . $blt_array['margin'],0,'',$fill);
			
			//Output text
			$this->MultiCell($w-$blt_width,$h,$blt_array['text'][$i],$border,$align,$fill);
			
			//Insert a spacer between items if not the last item
			if ($i != sizeof($blt_array['text'])-1) {
				$this->Ln($blt_array['spacer']);
			}
			
			//Increment bullet number
			$blt_array['bullet']++;
		}
	} else {

		for ($i=0; $i<sizeof($blt_array['text']); $i++)
		{
			//Get bullet width including margin
			$blt_width = $this->GetStringWidth($blt_array['bullet'] . $blt_array['margin'])+$this->cMargin*2;
			
			// SetX
			$this->SetX($bak_x);
			
			//Output indent
			if ($blt_array['indent'] > 0)
				$this->Cell($blt_array['indent']);
			
			//Output bullet
			$this->Cell($blt_width,$h,$blt_array['bullet'] . $blt_array['margin'],0,'',$fill);
			
			//Output text
			$this->MultiCell($w-$blt_width,$h,$blt_array['text'][$i],$border,$align,$fill);
			
			//Insert a spacer between items if not the last item
			if ($i != sizeof($blt_array['text'])-1) {
				$this->Ln($blt_array['spacer']);
			}
		}
	}
	
		//Restore x
		$this->x = $bak_x;
	}
}
?>
