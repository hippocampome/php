<?php
session_start();

$perm = $_SESSION['perm'];
if ($perm == NULL)
	header("Location:error1.html");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php include ("function/icon.html"); ?>
<title>Other Useful Links</title>
<script type="text/javascript" src="style/resolution.js"></script>
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:Wingdings;
	panose-1:5 0 0 0 0 0 0 0 0 0;}
@font-face
	{font-family:Wingdings;
	panose-1:5 0 0 0 0 0 0 0 0 0;}
@font-face
	{font-family:Calibri;
	panose-1:2 15 5 2 2 2 4 3 2 4;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:10.0pt;
	margin-left:0.15in;
	line-height:115%;
	font-size:11.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoListParagraph, li.MsoListParagraph, div.MsoListParagraph
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:10.0pt;
	margin-left:.5in;
	line-height:115%;
	font-size:11.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoListParagraphCxSpFirst, li.MsoListParagraphCxSpFirst, div.MsoListParagraphCxSpFirst
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:.5in;
	margin-bottom:.0001pt;
	line-height:115%;
	font-size:11.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoListParagraphCxSpMiddle, li.MsoListParagraphCxSpMiddle, div.MsoListParagraphCxSpMiddle
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:.5in;
	margin-bottom:.0001pt;
	line-height:115%;
	font-size:11.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoListParagraphCxSpLast, li.MsoListParagraphCxSpLast, div.MsoListParagraphCxSpLast
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:10.0pt;
	margin-left:.5in;
	line-height:115%;
	font-size:11.0pt;
	font-family:"Calibri","sans-serif";}
.MsoChpDefault
	{font-family:"Calibri","sans-serif";}
.MsoPapDefault
	{margin-bottom:10.0pt;
	line-height:115%;}
@page WordSection1
	{size:8.5in 11.0in;
	margin:.5in .5in .5in .5in;}
div.WordSection1
	{page:WordSection1;}
 /* List Definitions */
 ol
	{margin-bottom:0in;}
ul
	{margin-bottom:0in;}
-->
</style>
</head>

<body>

<!-- COPY IN ALL PAGES -->
<?php include ("function/title.php"); ?>

	<div id="menu_main_button_new">

  	<form action="index.php" method="post" style='display:inline' target="_blank">
  		<input type="submit" name='index' value='Home' class="main_button"/> 
  	</form>
  	<form action="morphology.php" method="post" style='display:inline' target="_blank">
  		<input type="submit" name='browsing' value='Browse' class="main_button"/>
  	</form>
  	<form action="search.php" method="post" style='display:inline' target="_blank">
  		<input type="submit" name='searching' value='Search' class="main_button" />
  	</form>
  	<form action="help.php" method="post" style='display:inline'>
  		<input type="submit" name='help' value='Help' class="main_button"/>
  	</form>

	</div>
		
			  <BR><BR><BR><BR><BR><BR><BR>
	
<div class=WordSection1>
		
<p class=MsoNormal><b><u><span style='font-size:16.0pt;line-height:115%;
font-family:"Arial","sans-serif"'>Other Useful Links</span></u></b></p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-size:14.0pt;line-height:115%;font-family:Symbol'>�<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span style='font-size:14.0pt;line-height:115%;font-family:"Arial","sans-serif"'><a href="http://www.temporal-lobe.com">Temporal-lobe.com</a></span></p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-size:14.0pt;line-height:115%;font-family:Symbol'>�<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span style='font-size:14.0pt;line-height:115%;font-family:"Arial","sans-serif"'><a href="http://cmbn-approd01.uio.no/zoomgen/hippocampus/home.do">The Rat Hippocampus Atlas</a></span></p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-size:14.0pt;line-height:115%;font-family:Symbol'>�<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span style='font-size:14.0pt;line-height:115%;font-family:"Arial","sans-serif"'><a href="http://www.neuromorpho.org">NeuroMorpho.Org</a></span></p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-size:14.0pt;line-height:115%;font-family:Symbol'>�<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span style='font-size:14.0pt;line-height:115%;font-family:"Arial","sans-serif"'><a href="http://www.neuroelectro.org">NeuroElectro</a></span></p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-size:14.0pt;line-height:115%;font-family:Symbol'>�<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span style='font-size:14.0pt;line-height:115%;font-family:"Arial","sans-serif"'><a href="http://www.incf.org/programs/pons/neuron-registry">Neuron Registry</a></span></p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-size:14.0pt;line-height:115%;font-family:Symbol'>�<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span style='font-size:14.0pt;line-height:115%;font-family:"Arial","sans-serif"'><a href="http://krasnow1.gmu.edu/cn3/hippocampus3d/">Hippocampus 3D Model</a></span></p>

</div>
<!-- ------------------------ -->

</body>

</html>