<?php
session_start();
include ("access_db.php");

$perm = $_SESSION['perm'];
if ($perm == NULL)
	header("Location:error1.html");
	
require_once('class/class.temporary_author.php');
require_once('class/class.author.php');	
require_once('class/class.articleauthorrel.php');	
require_once('class/class.article.php');	
	
$temporary = new temporary_author();	
$author_1 = new author($class_author);
$articleauthorrel = new articleauthorrel($class_articleauthorrel);
$article_1 = new article($class_article);	


// Select AND / OR:
if ($_REQUEST['and_or'])
{
	$and_or = $_REQUEST['and_or'];
	$_SESSION['and_or'] = $and_or;
	
	$name_temporary_table = $_SESSION['name_temporary_table'];
	$temporary ->setName_table($name_temporary_table);
	
	$temporary_search = 1;
}

// resume searching:
if ($_REQUEST['resume_searching_tab'])
{
	$resume_searching = $_SESSION['resume_searching'];	
	$name_temporary_table = $resume_searching;
	$_SESSION['name_temporary_table'] = $name_temporary_table;
	$temporary ->setName_table($name_temporary_table);
}	
	
// Creates the temporary table for the research? -----------------------------------------------------
if ($_REQUEST['searching'])
{
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$ip_address = str_replace('.', '_', $ip_address);
	$time_t = time();
	
	$name_temporary_table ='search1_'.$ip_address."__".$time_t;
	$_SESSION['name_temporary_table'] = $name_temporary_table;
	
	$temporary ->setName_table($name_temporary_table);
	
	$temporary -> create_temp_table ($name_temporary_table);
	$temporary -> insert_temporary('A', 'Amaral DG');
	
	$temporary_search=0;
	
	$and_or = 'AND';
	$_SESSION['and_or'] = $and_or;
		
}


if($_REQUEST['new'])
{
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$ip_address = str_replace('.', '_', $ip_address);
	$time_t = time();
		
	$name_temporary_table ='search1_'.$ip_address."__".$time_t;
	$_SESSION['name_temporary_table'] = $name_temporary_table;
		
	$temporary ->setName_table($name_temporary_table);

	$temporary -> create_temp_table ($name_temporary_table);
	$temporary -> insert_temporary($_GET["first_author"], $_GET["name_author"]);
	$temporary_search=0;
		
	$and_or = 'AND';
	$_SESSION['and_or'] = $and_or;
}
	
// ------------------------------------------------------------------------------------------------------

// update tha letter in the temporary table: ------------------------------------------------------------
$letter = $_REQUEST['letter'];
if ($letter)
{
	$name_temporary_table = $_SESSION['name_temporary_table'];
	$id_update = $_REQUEST['id'];
	
	$temporary ->setName_table($name_temporary_table);
	$temporary -> update_temporary($letter, NULL, 1, $id_update);
	
	$temporary_search=0;
	
	$and_or = $_SESSION['and_or'];
}

$author5 = $_REQUEST['author'];
if ($author5)
{
	$name_temporary_table = $_SESSION['name_temporary_table'];
	$id_update = $_REQUEST['id'];
	
	$temporary ->setName_table($name_temporary_table);
	$temporary -> update_temporary(NULL, $author5, 2, $id_update);
	
	$temporary_search=1;
	$and_or = $_SESSION['and_or'];
}
// ------------------------------------------------------------------------------------------------------


// ADD a new line for a new Author: --------------------------------------------------------------------
if ($_REQUEST['plus'])
{
	$name_temporary_table = $_SESSION['name_temporary_table'];
	$temporary ->setName_table($name_temporary_table);

	$temporary -> insert_temporary('A', 'Amaral DG');

	$temporary_search=0;	
	$and_or = $_SESSION['and_or'];
}
// ------------------------------------------------------------------------------------------------------


// REMOVE line  -----------------------------------------------------------------------------------------
if ($_REQUEST['remove'])
{
	$name_temporary_table = $_SESSION['name_temporary_table'];
	$temporary ->setName_table($name_temporary_table);
	$id_temp = $_REQUEST['id'];

	$temporary -> remove($id_temp);

	$temporary_search=1;
	$and_or = $_SESSION['and_or'];
}
// ------------------------------------------------------------------------------------------------------

// Show result --------------------------------------------------------------------------------------------
if ($_REQUEST['see_result'])
{
	$name_temporary_table = $_SESSION['name_temporary_table'];
	$temporary ->setName_table($name_temporary_table);
	$temporary_search=1;
	$and_or = $_SESSION['and_or'];
}


// retrieve the number of paper found during the temporary research: -------------------------------------
if ($temporary_search == 1)
{
	$and_or = $_SESSION['and_or'];

	$temporary -> retrieve_id();
	$n_id = $temporary -> getN_id();

	
	// Name of Authors
	$n_author = 0;
	for ($i1=0; $i1<$n_id; $i1++)
	{
		$name_aut_temp[$n_author] = $temporary -> getAuthor_array($i1);
		$n_author = $n_author + 1;
	}
	
	$n_total_id_article = 0;
	for ($i1=0; $i1<$n_id; $i1++)
	{
		$aut = $temporary -> getAuthor_array($i1);	
	
		// With name of authors, I retrieve the id of the authors from Author table.
		$author_1 -> retrive_id_by_name($aut);
		$id_author = $author_1 -> getID_array(0);
		
		// With Id_author retrieve the ID_article form table ArticleAuthorRel:
		$articleauthorrel -> retrive_article_id($id_author);
		
		$n_article_id = $articleauthorrel -> getN_author_id();
		
		
		for ($i2=0; $i2<$n_article_id; $i2++)
		{
			$article_id_temp[$n_total_id_article] = $articleauthorrel -> getArticle_id_array($i2);
			$n_total_id_article = $n_total_id_article + 1;
		} // end $i2			
	} // end $i1


	// COUNT:
	if ($and_or == 'AND')
	{
		$nn = array_count_values($article_id_temp);
		
		$n_total_id_article = 0;
		
		for ($i6=0; $i6<count($article_id_temp); $i6++)
		{
			$nname = $article_id_temp[$i6];
			if ($nn[$nname] ==  $n_author )
			{
				$article_id[$n_total_id_article] = $article_id_temp[$i6];
				$n_total_id_article = $n_total_id_article + 1;		
			}
			else;
		}
	}
	if ($and_or == 'OR')	
		$article_id = $article_id_temp;

		
	if ($n_total_id_article !=0 )
	{	
		// remove the dubble id:
		$article_id=array_unique($article_id);
		$n_tot_id_results = count($article_id);
	}
	else
		$n_tot_id_results = 0;	
	
	// show the results *********************
	if ($_REQUEST['see_result'])
	{
		for ($i3=0; $i3<$n_tot_id_results; $i3++)
		{
			$article_1 -> retrive_by_id($article_id[$i3]);		
			$title[$i3] = $article_1 -> getTitle();
			$journal[$i3] = $article_1 -> getPublication();
			$year[$i3] = $article_1 -> getYear();
			$pmid[$i3] = $article_1 -> getPmid_isbn();
			$doi[$i3] = $article_1 -> getDoi();
		} // END $i3
	}	
}
// --------------------------------------------------------------------------------------------------------	



// Clear all ---------------------------------------------
if ($_REQUEST['clear_all'])
{
	$name_temporary_table = $_SESSION['name_temporary_table'];
	$query = "TRUNCATE $name_temporary_table";
	$rs = mysql_query($query);

	// Creates the temporary table:
	$temporary -> setName_table($name_temporary_table);	
	$temporary -> insert_temporary('A', 'Amaral DG');
}
// -------------------------------------------------------



?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
// Javascript function *****************************************************************************************************
function letter(link, id_1)
{
	var letter=link[link.selectedIndex].value;
	var id = id_1;
	
	var destination_page = "find_author.php";
	location.href = destination_page+"?letter="+letter+"&id="+id;
}

function author(link, id_1)
{
	var author=link[link.selectedIndex].value;
	var id = id_1;
	
	var destination_page = "find_author.php";
	location.href = destination_page+"?author="+author+"&id="+id;
}
</script>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php include ("function/icon.html"); ?>

<title>Find Author</title>

<script type="text/javascript" src="style/resolution.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<script src="DataTables-1.9.4/media/js/jquery.js" type="text/javascript"></script>
<script src="DataTables-1.9.4/media/js/jquery.dataTables.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="DataTables-1.9.4/media/css/demo_table_jui.css"/>
<link rel="stylesheet" type="text/css" href="DataTables-1.9.4/examples/examples_support/themes/smoothness/jquery-ui-1.8.4.custom.css"/>
<script type="text/javascript" charset="utf-8">
$(document).ready(function(){
	$('#tab_res').dataTable({
			"sPaginationType":"full_numbers",
			"bJQueryUI":true,
			"oLanguage": {
			      "sSearch": "Search for keywords inside the table:"
			    },
			"iDisplayLength": 25
		});
});
</script>
<style>
#tab_res_wrapper{
	top: 288px; 
	left: 60px; 
	width: 1155px; 
	right: 129px; 
	bottom: -331px;
}
</style>
</head>

<body>

<!-- COPY IN ALL PAGES -->
<?php include ("function/title.php"); ?>





	<div id="menu_main_button_new">
	<form action="index.php" method="post" style='display:inline'>
		<input type="submit" name='index' value='Home' class="main_button"/> 
	</form>
	<form action="morphology.php" method="post" style='display:inline' target="_blank">	
		<input type="submit" name='browsing' value='Browse' class="main_button"/> 
	</form>
	<form action="help.php" method="post" style='display:inline' target="_blank">
		<input type="submit" name='help' value='Help' class="main_button"/>
	</form>
	</div>
		

<div class='sub_menu'>
	<table width="90%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%" align="left">
			<font class='font1'><em>Find:</em></font> &nbsp; &nbsp; 
					
			<a href="search.php?searching=1"><font class="font7">Neuron</font></a> <font class="font7_A">|</font> 
			<font class="font7_B"> Author</font><font class="font7_A">|</font> 
			<a href="find_pmid.php?searching=1"><font class="font7"> PMID/ISBN</font> </a><font class="font7_A">|</font> 
			</font>	
		</td>
	</tr>
	</table>
</div>
<!-- ------------------------ -->

<div class="table_position_search_page">
<table width="95%" border="0" cellspacing="5" cellpadding="0" class='body_table'>
  <tr>
    <td width="80%">
		<!-- ****************  BODY **************** -->
		<font class='font1'>Find Author</font> &nbsp;
		
		<!-- clear all tab -->
		&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
		<form action="find_author.php" method="post" style='display:inline'>	
		<input type='submit' name='clear_all' value='CLEAR ALL' />
		</form>
		<!-- ---- -->
		
		
		<br /><br />
		<table border="0" cellspacing="3" cellpadding="0" class='table_search'>
		<tr>		
			<td width="100%" align="left">
			<?php

			
				if ($and_or == 'AND')
				{
					print ("<input type='radio' name='and_or' value='AND' checked='checked'/> 
						<font class='font12'>AND</font> ");
					print ("<input type='radio' name='and_or' value='OR' onClick=\"javascript:location.href='find_author.php?and_or=OR'\"/>  
						<font class='font12'>OR</font>");
				}
				if ($and_or == 'OR')
				{
					print ("<input type='radio' name='and_or' value='AND' onClick=\"javascript:location.href='find_author.php?and_or=AND'\" />  
						<font class='font12'>AND </font>");
					print ("<input type='radio' name='and_or' value='OR' checked='checked'/> 
						<font class='font12'>OR</font>");
				}			
			?>
				<br /><br /> 	
			</td>
		</tr>
		
		<table border="0" cellspacing="3" cellpadding="0" class='table_search'>
		<tr>
			<td align="center" width="10%">  </td>
			<td align="center" width="20%" class='table_neuron_page3'>Author Initial</td>
			<td align="center" width="20%" class='table_neuron_page3'>Authors</td>
			<td align="center" width="5%" class'table_neuron_page3'> </td>
			<td align="center" width="5%" class'table_neuron_page3'> </td>
			<td align="right" width="40%"> 
			
			<?php
				if ($temporary_search == 1)
				{
					if ($n_tot_id_results < 2)
						print ("<font class='font12'> $n_tot_id_results article has been found</font>");
					else
						print ("<font class='font12'> $n_tot_id_results articles have been found</font>");
				}
				else
					print ("<font class='font12'> Searching...</font>");
			?>
			
			</td>
		</tr>
		</table>


		<table border="0" cellspacing="3" cellpadding="0" class='table_search'>
			<?php
				$temporary -> retrieve_id();
				$n_search = $temporary -> getN_id();
				
				for ($i=0; $i<$n_search; $i++)
				{
					print ("<tr>
							<td align='center' width='10%'>  </td>
							<td align='center' width='20%' class='table_neuron_page1'>");
						
						$id = $temporary -> getID_array($i);
					
						print ("<select name='letter1' size='1' cols='10' class='select1' onChange=\"letter(this, $id)\">");
						
						$temporary -> retrieve_letter_from_id($id);
						$letter_t = $temporary -> getLetter();
						if ($letter_t)
						{
							if ($letter_t == 'all')
								$letter_t  = 'all';
								//$letter_t  = '--';
						
							print ("<OPTION VALUE='$letter_t'> $letter_t </OPTION>");					
							//print ("<OPTION VALUE=''> </OPTION>");
						}
						print ("
							<OPTION VALUE='A'> A </OPTION>			
							<OPTION VALUE='B'> B </OPTION>
							<OPTION VALUE='C'> C </OPTION>
							<OPTION VALUE='D'> D </OPTION>
							<OPTION VALUE='E'> E </OPTION>
							<OPTION VALUE='F'> F </OPTION>
							<OPTION VALUE='G'> G </OPTION>
							<OPTION VALUE='H'> H </OPTION>
							<OPTION VALUE='I'> I </OPTION>
							<OPTION VALUE='J'> J </OPTION>
							<OPTION VALUE='K'> K </OPTION>
							<OPTION VALUE='L'> L </OPTION>
							<OPTION VALUE='M'> M </OPTION>
							<OPTION VALUE='N'> N </OPTION>
							<OPTION VALUE='O'> O </OPTION>
							<OPTION VALUE='P'> P </OPTION>
							<OPTION VALUE='Q'> Q </OPTION>
							<OPTION VALUE='R'> R </OPTION>
							<OPTION VALUE='S'> S </OPTION>
							<OPTION VALUE='T'> T </OPTION>
							<OPTION VALUE='U'> U </OPTION>
							<OPTION VALUE='V'> V </OPTION>
							<OPTION VALUE='W'> W </OPTION>			
							<OPTION VALUE='X'> X </OPTION>
							<OPTION VALUE='Y'> Y </OPTION>
							<OPTION VALUE='Z'> Z </OPTION>		
							<OPTION VALUE='all'> all </OPTION>					
						</select>
					</td>");
					
					// retrieve ALL authors from table AUTHOR:
					$author_1 -> retrive_name();
					$n_author_total = $author_1 -> getN_author();
					
					// keep only the authors that have the first letter = $letter_t:
					$n_author = 0;
					$name_author = NULL;
					for ($i1=0; $i1<$n_author_total; $i1++)
					{
						$name_author1 = $author_1 -> getName_author_array($i1);
						
						//if ($letter_t == '--')
						if ($letter_t == 'all')
						{
							$name_author[$n_author] = $name_author1;
							$n_author = $n_author + 1;						
						}
						else
						{
						
							if ($name_author1[0] == $letter_t)
							{
								$name_author[$n_author] = $name_author1;
								$n_author = $n_author + 1;
							}
						}
										
						if ($name_author)
							sort($name_author);						
					}
						
					print ("<td align='center' width='20%' class='table_neuron_page1'>");
					print ("<select name='author1' size='1' cols='10' class='select1' onChange=\"author(this, $id)\">");
			
					$temporary -> retrieve_author_from_id($id);
					$name_author_right = $temporary -> getAuthor();		
			
					if ($name_author_right)
					{
						print ("<OPTION VALUE='$name_author_right'>$name_author_right</OPTION>");	
						print ("<OPTION VALUE=''></OPTION>");
					}	
					
					
					if ($n_author == 0)
					{
						print ("<OPTION VALUE=''>-</OPTION>");	
					}
					else
					{
						for ($i1=0; $i1<$n_author; $i1++)
						{
							print ("<OPTION VALUE='$name_author[$i1]'>$name_author[$i1]</OPTION>");		
						}
					}
					
					print ("</select>");
					print ("</td><td align='center' width='5%'>
								<form action='find_author.php' method='post' style='display:inline'> 
								<input type='submit' name='plus' value=' + ' class='more_button'>
								</form>
							 </td>");
										
					if ($i > 0)		 
						print ("</td><td align='center' width='5%'>
									<form action='find_author.php' method='post' style='display:inline'> 
									<input type='submit' name='remove' value=' - ' class='more_button'>
									<input type='hidden' name='id' value='$id'>
									</form>
								 </td>");
					else
						print ("</td><td align='center' width='5%'> </td>");
					
					print ("</td><td align='center' width='40%'>  </td>");
			} // FOR $i
		?>
		</tr>
	</table>
	<br /><br /><br />

	<div align="center" >
		<form action='find_author.php' method='post' style='display:inline'> 
		<input type="submit" name='see_result' value='SEE RESULTS' />
		<input type="hidden" name='id_results' value='<?php print $article_id ?>' />
		</form>

	
	<br /><br /><br />
	<?php
		if ($_REQUEST['see_result'])
		{
			
			print ("<table border='0'  class='table_result' id='tab_res' width='100%'>");
			print ("<thead><tr>
						<th align='center' width='20%' class='table_neuron_page1'> <strong>Authors</strong> </th>
						<th align='center' width='40%' class='table_neuron_page1'> <strong>Title </strong></th>
						<th align='center' width='10%' class='table_neuron_page1'> <strong>Journal/Book</strong> </th>
						<th align='center' width='5%' class='table_neuron_page1'> <strong>Year </strong></th>
						<th align='center' width='5%' class='table_neuron_page1'> <strong>PMID/ISBN</strong></th>
						<th align='center' width='20%' class='table_neuron_page1'> <strong>Types</strong></th>											
					</tr></thead><tbody>");
			//print ("</table>");
			
	
			// If the name of authors is egual at search name --> use the BOLD text:
			$temporary -> retrieve_id();			
			$mm = $temporary -> getN_id();		
			
			for ($i=0; $i<$n_tot_id_results; $i++)
			{
				$fl=0;
				for ($ii4=0; $ii4<$mm; $ii4++)
					$name_temp[$ii4] = $temporary -> getAuthor_array($ii4);
					
				// retrieve tha list of authors: -----------------------------------------------			
					$articleauthorrel -> retrive_author_position($article_id[$i]);
					$n_author = $articleauthorrel -> getN_author_id();
					for ($ii3=0; $ii3<$n_author; $ii3++)
						$auth_pos[$ii3] = $articleauthorrel -> getAuthor_position_array($ii3);
											
					sort ($auth_pos);

					for ($ii3=0; $ii3<$n_author; $ii3++)
					{
						$articleauthorrel -> retrive_author_id($article_id[$i], $auth_pos[$ii3]);
						$id_author = $articleauthorrel -> getAuthor_id_array(0);
						
						$author_1 -> retrive_by_id($id_author);
						$name_a = $author_1 -> getName_author_array(0);

						for ($ii4=0; $ii4<$mm; $ii4++)
						{
							if ($name_a == $name_temp[$ii4])
							{
								$name_b = "<strong>$name_a</strong>";
								break;
							}
							else
								$name_b = $name_a;
						}
						
						$name_authors[$ii3] = $name_b;	
					}

					$name_authors1 = NULL;
					for ($ii3=0; $ii3<$n_author; $ii3++)
					{
						$name_authors1 = $name_authors1.", ".$name_authors[$ii3];
					}
					$name_authors1[0]='';
					
				// -------------------------------------------------------------------------------
				
				// Divide if there is PMID or ISBN: ----------------------------------------------
				if (strlen($pmid[$i]) > 10 )
				{	
					$link2 = "<a href='$link_isbn$pmid[$i]' target='_blank'>";	
				}
				else
				{
					$value_link ='PMID: '.$pmid[$i];
					$link2 = "<a href='http://www.ncbi.nlm.nih.gov/pubmed?term=$value_link' target='_blank'>";										
				}
				// ----------------------------------------------------------------------------------
				
					
				$yea=substr($year[$i],0,4);
				
				print ("<tr>
						<td align='left' width='20%' class='table_neuron_page4'>$name_authors1.</td>
						<td align='left' width='40%' class='table_neuron_page4'>$title[$i] </td>
						<td align='left' width='10%' class='table_neuron_page4'>$journal[$i].</td>
						<td align='left' width='5%' class='table_neuron_page4'>$yea </td>
						<td align='left' width='5%' class='table_neuron_page4'>$link2 <font class='font13'>$pmid[$i]</font> </a></td>");		
				print("<td align='left' width='20%' class='table_neuron_page4'>");
				
				$a="SELECT `Article`.`id` AS `Article_id`, `pmid_isbn`, `Type`.* FROM `Article` INNER JOIN `ArticleSynonymRel` ON (`ArticleSynonymRel`.`Article_id` = `Article`.`id`) INNER JOIN `Synonym` ON (`Synonym`.`id` = `ArticleSynonymRel`.`Synonym_id`) INNER JOIN `SynonymTypeRel` ON (`SynonymTypeRel`.`Synonym_id` = `Synonym`.`id`) INNER JOIN `Type` ON (`Type`.`id` = `SynonymTypeRel`.`Type_id`) WHERE (`pmid_isbn` = '$pmid[$i]')";
				$Type_name = mysql_query($a);
				if (!$Type_name) {
					die("<p>Error in listing tables:" . mysql_error() . "</p>");
				}
				$f=0;
				$o=1;
				$t_n=array();
		while($rows=mysql_fetch_array($Type_name, MYSQL_ASSOC))
		{
			$ty_name=$rows['name'];
			$ty_nick=$rows['nickname'];
			
			$x=0;
			for($v=0;$v<sizeof($t_n);$v++)
			{
				if($t_n[$v]!=$ty_name)
				{
					$x=0;
					continue;
				}
				else 
				{
					$x=1;
					break;
				}
					
			}
				if($x==1)
				{
					continue;
				}
				
					if($ty_nick!=null)
					{
						print("$o)$ty_nick <br/>");
					}
					else
					{
						print("$o)$ty_name <br/>");
					}
			
			$t_n[$f]=$ty_name;
			$o=$o+1;
			$f=$f+1;
		}			
			if($o==1)
			{
				print("no type");
			}	
			
				print ("</td></tr>");
			}//END $i
			print("</tbody></table>");
		}
	?>
	<br /><br />

	</div>
</div>
</body>
</html>
