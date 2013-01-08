<?php
class base_desk
{
	protected $h;
	protected $w;
	protected $t;
	protected $l;

	function __construct($w, $h, $fnt = 35)
	{
		$this->t = 0;
		$this->l = 0;
		$this->h = $h;
		$this->w = $w;
	}

	function drawDesk(&$img, &$pColor, &$sColor)
	{
//		$perim_color = imageColorAllocate($img, 0, 0, 0);
//		$s_color = imageColorAllocate($img, 250, 250, 250);
		imageFilledRectangle($img, $this->l, $this->t, $this->w + $this->l, $this->h + $this->t, $sColor);
		imageRectangle($img, $this->l, $this->t, $this->w + $this->l, $this->h + $this->t, $pColor);
		imageRectangle($img, $this->l + 1, $this->t + 1, $this->w + $this->l - 1, $this->h + $this->t - 1, $pColor);
//		imageRectangle($img, $this->l + 2, $this->t + 2, $this->w + $this->l - 2, $this->h + $this->t - 2, $perim_color);
	}
}
//-----------------------------------------------------------------------

class slice_desk extends base_desk
{
	protected $pColor;
	protected $sColor;

	function __construct($l, $t, $w, $h,  &$pColor, &$sColor)
	{
		$this->sColor = $sColor;
		$this->pColor = $pColor;

		$this->t = $t;
		$this->l = $l;
		$this->h = $h;
		$this->w = $w;
	}

	function drawDesk(&$img) //, &$pColor, &$sColor, &$fColor
	{
		parent::drawDesk($img, $this->pColor, $this->sColor);
//		$perim_color = imageColorAllocate($img, 0, 0, 0);
		$font_size = 35;
//		imageline($img, $this->l, $this->t, $this->w + $this->l, $this->t + $this->h, $color);
//		imagestring($img, 4, $this->l +10, $this->t + 10, $this->w . "x" . $this->h, $perim_color);
		imagettftext($img, $font_size, 0, $this->l - $font_size + $this->w/2, $this->t + 10 + $font_size, $this->pColor, dirname(__FILE__) . "/arial.ttf", $this->w);
		imagettftext($img, $font_size, 90, $this->l + 10 + $font_size, $this->h/2 + $this->t  + $font_size, $this->pColor, dirname(__FILE__) . "/arial.ttf", $this->h);
	}
}

class cut_desk extends slice_desk
{
	function drawDesk(&$img)
	{
//		$s_color = imageColorAllocate($img, 250, 0, 0);
		imageFilledRectangle($img, $this->l, $this->t, $this->w + $this->l, $this->h + $this->t, $this->pColor);
		$font_size = 15;
//		$fcolor = imageColorAllocate($img, 0, 0, 200);
		imagettftext($img, $font_size, 0, $this->l, $this->t + 20, $this->sColor, dirname(__FILE__) . "/arial.ttf", $this->l .", ". $this->t);
	}
}

class canv_desk extends base_desk
{
	protected $desks;
	protected $DeskPColor;
	protected $DeskSColor;
	protected $CutBodyColor;
	protected $CutFontColor;

	function __construct($w, $h, &$img)
	{
		parent::__construct($w, $h);
		$this->desks = array();
		$this->DeskPColor = imageColorAllocate($img, 0, 0, 0);
		$this->DeskSColor = imageColorAllocate($img, 255, 255, 255);
		$this->CutBodyColor = imageColorAllocate($img, 250, 0, 0);
		$this->CutFontColor = imageColorAllocate($img, 0, 0, 200);
	}

	function addDesk($l, $t, $w, $h)
	{
		$this->desks[] = new slice_desk($l, $t, $w, $h, $this->DeskPColor, $this->DeskSColor);
	}

	function addLine($x0, $y0, $x, $y)
	{

		$this->desks[] = new cut_desk($x0, $y0, $x - $x0, $y - $y0, $this->CutBodyColor, $this->CutFontColor);
	}

	function drawDesk(&$img, $iswite=0 /* без штриховки */)
	{
		parent::drawDesk($img, imageColorAllocate($img, 0, 0, 0), imageColorAllocate($img, 250, 250, 250));

		// Штриховка
		if(!$iswite)
		{
			$shtrich_color = imageColorAllocate($img, 0, 0, 0);
			$coeft = 1; $step = sqrt($this->h*$this->w)/25; // 30;
			while( ($coeft * $step) < $this->h )
			{
		//		imageline($image, $x1, $y1, $x2, $y2, $color);
				imageline($img, $coeft*$step, 0, 0, $coeft*$step, $shtrich_color);
				imageline($img, ($coeft*$step)+1, 0, 0, ($coeft*$step)+1, $shtrich_color);
				imageline($img, ($coeft*$step)+2, 0, 0, ($coeft*$step)+2, $shtrich_color);
				++$coeft;
			}
			while( ($coeft * $step) < $this->w )
			{
				imageline($img, $coeft*$step, 0, ($coeft*$step) - $this->h, $this->h, $shtrich_color);
				imageline($img, ($coeft*$step)+1, 0, ($coeft*$step) - $this->h +1, $this->h, $shtrich_color);
				imageline($img, ($coeft*$step)+2, 0, ($coeft*$step) - $this->h +2, $this->h, $shtrich_color);
				++$coeft;
			}
			while( ($coeft * $step) < ($this->w + $this->h) )
			{
				imageline($img, $this->w, ($coeft*$step) - $this->w, ($coeft*$step) - $this->h, $this->h, $shtrich_color);
				imageline($img, $this->w, ($coeft*$step) - $this->w + 1, ($coeft*$step) - $this->h +1, $this->h, $shtrich_color);
				imageline($img, $this->w, ($coeft*$step) - $this->w + 2, ($coeft*$step) - $this->h +2, $this->h, $shtrich_color);
				++$coeft;
			}
		}
		// END: Штриховка

		$cDesk = count($this->desks);
		for($i = 0; $i < $cDesk; ++$i)
		{
			$this->desks[$i]->drawDesk($img);
		}
	}
}
?>
