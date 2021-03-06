<?php
session_start();
$perm = $_SESSION['perm'];
if ($perm == NULL)
	header("Location:error1.html");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
include ("access_db.php");
?>

<head>
<title>Help</title>
<script type="text/javascript" src="style/resolution.js"></script>
</head>

<body>

<!-- COPY IN ALL PAGES -->
<?php 
	include ("function/title.php");
	include ("function/menu_main.php");
?>	

<div class='title_area'>
	<font class="font1">Help topics</font>
</div>
		

<div>	
	<table width="40%" border="0" cellspacing="0" cellpadding="0" style="position:absolute; top:180px; left:80px;">
	<tr>
		<td width="100%" align="left">
			<font class='font1a'>Morphology:</font> &nbsp; &nbsp;
			<ul> 
			<li><a href='Help_Morphological_Abbreviations.php'><font class="font7"> Abbreviations</font></a></li>
  			<li><a href='Help_Morphological_Bibliographic_Protocols.php'><font class="font7"> Bibliographic Protocols</font></a></li>
  			<li><a href='Help_Morphological_Interpretations_Brief.php'><font class="font7"> Interpretations (Brief)</font></a>
  			<li><a href='Help_Morphological_Interpretations_Full.php'><font class="font7"> Interpretations (Full)</font></a></li>
			</ul>
			
			<font class='font1a'>Molecular markers:</font> &nbsp; &nbsp;
			<ul>
			<li><a href='Help_Marker_Abbreviations.php'><font class="font7"> Abbreviations</font></a></li>
			</ul>
			
			<font class='font1a'>Electrophysiology:</font> &nbsp; &nbsp;
			<ul>
  			<li><a href='Help_Electrophysiological_Abbreviations_and_Definitions.php'><font class="font7"> Abbreviations and Definitions</font></a></li>
			</ul>
			
			<font class='font1a'>Connectivity:</font> &nbsp; &nbsp;			
			<ul>
			<li><a href='Help_Connectivity.php'><font class="font7"> Definitions and Protocols</font></a></li>  			
			</ul>
			
			<font class='font1a'>Miscellaneous:</font> &nbsp; &nbsp;			
			<ul>
  			<li><a href='Help_In_Progress.php'><font class="font7"> In Progress ...</font></a></li>
  			<li><a href='Help_Release_Notes.php'><font class="font7"> Release Notes</font></a></li>
  			<li><a href='Hippocampome_Video_Overview/Hippocampome_Video_Overview_player.html' target="_blank"><font class="font7"> Hippocampome Video Overview</font></a></li>
  			<li><a href='Help_Other_Useful_Links.php'><font class="font7"> Other Useful Links</font></a></li>
  			<li><a href='Help_Acknowledgements.php'><font class="font7"> Acknowledgements</font></a></li>
			</ul>
						
		</td>
	</tr>
	</table>
	<br />
</div>
</body>

</html>
