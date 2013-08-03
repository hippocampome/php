<?php
	session_start();
	$perm = $_SESSION['perm'];
	if ($perm == NULL)
		header("Location:error1.html");
		
	include ("access_db.php");
	include ("function/stm_lib.php");
	require_once('class/class.type.php');
	require_once('class/class.property.php');
	require_once('class/class.evidencepropertyyperel.php');
	require_once('class/class.temporary_result_neurons.php');	
	
	$type = new type($class_type);
	
	$research = $_REQUEST['research'];
	
	if ($research) { // From page of search; retrieve the id from search_table (temporary) -----------------------	
		$table_result = $_REQUEST['table_result'];
	
		$temporary_result_neurons = new temporary_result_neurons();
		$temporary_result_neurons -> setName_table($table_result);
	
		$temporary_result_neurons -> retrieve_id_array();
		$n_id_res = $temporary_result_neurons -> getN_id();
	
		$number_type = 0;
		for ($i2=0; $i2<$n_id_res; $i2++) {
			$id2 = 	$temporary_result_neurons -> getID_array($i2);
	
			if (strpos($id2, '0_') == 1);
			else {
				$type -> retrive_by_id($id2);
				$status = $type -> getStatus();
					
				if ($status == 'active') {
					$id_search[$number_type] = $id2;
					$position_search[$number_type] = $type -> getPosition();
					$number_type = $number_type + 1;
				}
			}
		} // END $i2
	
		array_multisort($position_search, $id_search);
		// sort($id_search);		
	}
	else {// not from search page --------------	
		$type -> retrive_id();
		$number_type = $type->getNumber_type();
	}	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<?php include ("function/icon.html"); ?>
	<title>Connectivity Matrix</title>
	<style>
.highlighted{
	border: solid 1px Chartreuse !important;
}

#connectivity_table_wrapper{
width:1155px;
}

</style>
<script type="text/javascript" src="style/resolution.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<script src="DataTables-1.9.4/media/js/jquery.js" type="text/javascript"></script>
<script src="style/blockUI.js" type="text/javascript"></script>
<script src="DataTables-1.9.4/media/js/jquery.dataTables.js" type="text/javascript"></script>
<script src="DataTables-1.9.4/media/js/FixedColumns.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="DataTables-1.9.4/media/css/demo_table_jui.css"/>
<link rel="stylesheet" type="text/css" href="DataTables-1.9.4/examples/examples_support/themes/smoothness/jquery-ui-1.8.4.custom.css"/>


<script type="text/javascript" charset="utf-8">
$(document).ready(function(){
	$('.blockUI').remove();
	var he;
	var oTable=$('#connectivity_table').dataTable({
			"sScrollY": 400,
			"sScrollX": "100%",
			"bScrollCollapse": true,
			"bAutoWidth":false,
			"bJQueryUI":true,
			"aaSorting": [],
			"bFilter": false,
			 "bPaginate": false,
			"iDisplayLength":20,
			"bDestroy": true,
			"bSortClasses": false
			});

	/*new FixedColumns( oTable );*/
	new FixedColumns( oTable);
	
	oTable.$('td').hover( function() {
        var iCol = $('td', this.parentNode).index(this) % 123;
        $('td:nth-child('+(iCol+1)+')', oTable.$('tr')).addClass( 'highlighted' );
    }, function() {
        oTable.$('td.highlighted').removeClass('highlighted');
    });	

	oTable.$('tr').mouseover( function() {
		$(this).find("td").each(function(){ 
			$(this).addClass("highlighted");

			});
		});
	oTable.$('tr').mouseout(function(){
			$(this).find("td").each(function(){ 
				$(this).removeClass("highlighted");
			});
		});
});
</script> 

<style>
 div.table_position div#connectivity_table_wrapper.dataTables_wrapper div.fg-toolbar
 { 
 width: 1012px;
 height: 0px;
 padding: 0px;
 border-top-width: 0px;
 border-right-width: 0px; 
 border-bottom-width: 0px; 
 }

</style>
</head>

<body>
<div style="z-index: 1000; border: medium none; margin: 0pt; padding: 0pt; width: 100%; height: 100%; top: 0pt; left: 0pt; background-color: rgb(0, 0, 0); opacity: 0.6; cursor: wait; position: fixed;" class="blockUI blockOverlay"></div>
<div style="z-index: 1001; position: fixed; padding: 0px; margin: 0px; width: 20%; top: 40%; left: 35%; text-align: center; color: rgb(0, 0, 0); border: 3px solid rgb(170, 170, 170); background-color: rgb(255, 255, 255); cursor: wait;" class="blockUI blockMsg blockPage"><span><img src="images/busy.gif" style="width:100%;"/><h4 style="line-height:3px;">Loading Page...</h4></span></div>

<!-- COPY IN ALL PAGES -->
<?php include ("function/title.php"); ?>

	<div id="menu_main_button_new">
	<form action="index.php" method="post" style='display:inline'>
		<input type="submit" name='index' value='Home' class="main_button"/> 
	</form>
	<form action="search.php" method="post" style='display:inline' target="_blank">	
		<input type="submit" name='searching' value='Search' class="main_button" /> 
	</form>
	<form action="help.php" method="post" style='display:inline' target="_blank">
		<input type="submit" name='help' value='Help' class="main_button"/>
	</form>
	</div>
		
<div class='sub_menu'>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td align="left">
			<a href='morphology.php'><font class="font7">Morphology</font></a> <font class="font7_A">|</font> 
			<a href='markers.php'><font class="font7">Molecular Markers</font></a> <font class="font7_A">|</font> 
			<a href='ephys.php'><font class="font7">Electrophysiology</font></a><font class="font7_A">|</font> 
			<font class="font7_B">Connectivity</font>
		</td>
	</tr>
	</table>
</div>
<!-- ------------------------ -->

<div class="table_position">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class='body_table'>
  <tr height="30">
    <td></td>
  </tr>
  <tr>
    <td>
		<!-- ****************  BODY **************** -->

		<font class='font1'>Connectivity matrix</font>
		<?php 
			if ($research){
				$full_search_string = $_SESSION['full_search_string'];
				if ($number_type == 1)
					print ("<font class='font3'> $number_type Result  [$full_search_string]</font>");
				else
					print ("<font class='font3'> $number_type Results  [$full_search_string]</font>");			
			}
		?>
			
		<br />
		<font class='font3'>You can also view the entire matrix as a <a href='images/connectivity/Connectivity_Matrix.jpg' target='_blank'>.jpg image</a></font>
		<br/><font class='font5'><strong>Legend:</strong> </font>&nbsp; &nbsp;
		<img src="images/connectivity/excitatory.png" width="10px" border="0"/>
				<font class='font5'>Potential Excitatory Non-PCL Connection</font>&nbsp; &nbsp;
	     <img src="images/connectivity/inhibitory.png" width="10px" border="0"/>
				<font class='font5'>Potential Inhibitory Non-PCL Connection</font>&nbsp; &nbsp;
				
		<img src="images/connectivity/PCL_only.png" width="10px" border="0"/>
				<font class='font5'>Potential Inhibitory PCL-Only Connection</font><br/>&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;	
					<img src='images/connectivity/known_connection.png' width="20px" border="0" height="10px"/>
					<font face="Verdana, Arial, Helvetica, sans-serif" size="2">Known Connection</font>
			
			<img src='images/connectivity/known_nonconnection.png' width="20px" border="0" height="10px"/>
				<font face="Verdana, Arial, Helvetica, sans-serif" size="2">Known Non-Connection</font>		
		<br />
		&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
		<font class="font5"><strong>PCL</strong>&nbsp;&nbsp;:Principal Cell Layer</font>
		</td>
	</tr></table>
		
		<?php 				
			if ($research) {
				$n_DG = 0;
				$n_CA3 = 0;
				$n_CA2 = 0;
				$n_CA1 = 0;
				$n_SUB = 0;
				$n_EC = 0;
				$n_All = 0;
				
				for($W1=0; $W1<$number_type; $W1++) {
					if ($id_search[$W1] < 1999) {
						//$type -> retrive_by_id($id_search[$W1]);
						//$DG_position[$n_DG] = $type->getPosition();
						// $DG_position[$n_DG]=$id_search[$W1];
						$DG_position[$n_DG] = $id_search[$W1];
						$n_DG = $n_DG + 1;
						$n_All += 1; 
					}
					if ( ($id_search[$W1] >= 2000) && ($id_search[$W1] < 2999) ) {
						$CA3_position[$n_CA3]=$id_search[$W1];
						$n_CA3 = $n_CA3 + 1;
						$n_All += 1;
					}
					if ( ($id_search[$W1] >= 3000) && ($id_search[$W1] < 3999) ) {
						$CA2_position[$n_CA2]=$id_search[$W1];
						$n_CA2 = $n_CA2 + 1;
						$n_All += 1;
					}
					if ( ($id_search[$W1] >= 4000) && ($id_search[$W1] < 4999) ) {
						$CA1_position[$n_CA1]=$id_search[$W1];
						$n_CA1 = $n_CA1 + 1;
						$n_All += 1;
					}
					if ( ($id_search[$W1] >= 5000) && ($id_search[$W1] < 5999) ) {
						$SUB_position[$n_SUB]=$id_search[$W1];
						$n_SUB = $n_SUB + 1;
						$n_All += 1;
					}
					if ( ($id_search[$W1] >= 6000) && ($id_search[$W1] < 6999) ) {
						$EC_position[$n_EC]=$id_search[$W1];
						$n_EC = $n_EC + 1;
						$n_All += 1;
					}
				} // end for W1
						
				if ($n_DG != 0) {
					sort($DG_position);
					$first_DG = $DG_position[0];
				}
				if ($n_CA3 != 0) {
					sort($CA3_position);
					$first_CA3 = $CA3_position[0];
				}
				if ($n_CA2 != 0) {
					sort($CA2_position);
					$first_CA2 = $CA2_position[0];
				}
				if ($n_CA1 != 0) {
					sort($CA1_position);
					$first_CA1 = $CA1_position[0];
				}
				if ($n_SUB != 0) {
					sort($SUB_position);
					$first_SUB = $SUB_position[0];
				}
				if ($n_EC != 0) {
					sort($EC_position);
					$first_EC = $EC_position[0];
				}
			} // end if ($research)		
						
				
			// if table is big enough, use a fixed first column
			if ( ($research) And ($n_All < 26) )
			{
				print("<table id='connectivity_table_small' class='fancyTable body_table' cellpadding='0' cellspacing='0' border='1' width='100%'>");
			}
			else
			{
				print("<table id='connectivity_table' class='fancyTable body_table' cellpadding='0' cellspacing='0' border='1' width='100%'>");
			}
			
			/* Connectivity matrix header */
			
			print("<thead><tr height='200px'>");
				print("<th bgcolor='#FFFFFF' style='height:190px; width:195px;'><img src='images/connectivity/spacer_first_cell_2.png' width='195px' height='200px' border='0'/></th>");				
				
				// read in potential connectivity csv file
				$pot_conn_csv = file_get_contents('connectivity_data_files/potential_connectivity_matrix_v1.0alpha.csv', FILE_USE_INCLUDE_PATH);

				$pot_rows = explode("\n", $pot_conn_csv);
				$num_pot_rows = count($pot_rows);
				unset($pot_rows[$num_pot_rows-1]);
				$pot_header = str_getcsv(array_shift($pot_rows));	// pulls out header row from array				
				
				$pot_conn_matrix = array();
				foreach ($pot_rows as $this_pot_row) {
					$pot_conn_matrix[] = array_combine($pot_header, str_getcsv($this_pot_row));
				}					

				// read in known connectivity csv file
				$known_conn_csv = file_get_contents('connectivity_data_files/known_connectivity_matrix_v1.0alpha.csv', FILE_USE_INCLUDE_PATH);
				
				$known_rows = explode("\n", $known_conn_csv);
				$num_known_rows = count($known_rows);
				unset($known_rows[$num_known_rows-1]);
				$known_header = str_getcsv(array_shift($known_rows));	// pulls out header row from array
					
				$known_conn_matrix = array();
				foreach ($known_rows as $this_known_row) {
					$known_conn_matrix[] = array_combine($known_header, str_getcsv($this_known_row));
				}			
					
				$num_columns = 0;
				for ($i1=0; $i1<$number_type; $i1++) {
					$num_columns = $num_columns + 1;
					 
					// retrieve the id_type from Type
					if ($research)
						$id = $id_search[$i1];
					else
						$id = $type->getID_array($i1);
					
					$type -> retrive_by_id($id);
					$nickname_type = $type->getNickname();
					$subregion_type = $type->getSubregion();
					
					$nickname_type = str_replace('_', ' ', $nickname_type);
					$subregion_nickname_type = $subregion_type . ":" . $nickname_type;
					$position = $type->getPosition();
					
					if (!$research) {
						if ( ($position == 201) || ($position == 301) || ($position == 401) || ($position == 501) || ($position == 601)) {
							$num_columns = $num_columns + 1;
							//print ("<th style='width:4px' bgcolor='#FF0000'></th>");
						}
					}
					else {
						if ($i1 !=0 And ( ($id == $first_CA3) || ($id == $first_CA2) || ($id == $first_CA1) || ($id == $first_SUB) || ($id == $first_EC)) )
						{								
							$num_columns = $num_columns + 1;
							//print ("<th style='width:4px' bgcolor='#FF0000'></th>");
						}
					}
				
					print ("<th bgcolor='#E0FFFF' style='vertical-align:bottom; width:10px;'>");
					
					print ("<a href='neuron_page.php?id=$id' target='_blank' class='font_cell_3'>");	

					/* needed for .png images of text */
					$type_name_image_path = str_replace(':', '_', $subregion_nickname_type);
					$type_name_image_path = str_replace('/', '_', $type_name_image_path);
					$type_name_image_path = '\'images/name_neuron_type/rotated/' . $type_name_image_path . '.png\'';
					//print ("<img src=$type_name_image_path alt=$type_name_image_path style='max-height:175px' border='0'/>");

					print ("<div class='connectVerticalText'><font color='#339900'>$subregion_nickname_type</font></div>");
					/* needed for vText */
					//print ("<div style='display: inline-block; width: 30px; height: 200px; position: relative; background-color: #ffffff; '>");
					//print ("<div style='position:absolute; left:0; bottom:0;' class='vText'>");						
					//$subregion_nickname_type = $string = str_replace(' ', '', $subregion_nickname_type);
					
					/* needed for either normal, horizontal text OR for vText */
					//if (strpos($subregion_nickname_type, '(+)') == TRUE)
					//	print ("<font style='font-size:12px' color='#339900'>$subregion_nickname_type</font>");
					//if (strpos($subregion_nickname_type, '(-)') == TRUE)
					//	print ("<font style='font-size:12px' color='#CC0000'>$subregion_nickname_type</font>");												
					
					/* needed for vText */
					//print ("</div></div></div>");
					
					print ("</a>");						
					print ("</th>");
				}					
				
				$num_columns = $num_columns + 1;
				
				print ("</tr></thead>");
				
				
				/* Connectivity matrix body */
									
				print ("<tbody>");
			
				for ($row=0; $row<$number_type; $row++) { //$number_type					
					// retrieve the id_type from Type
					if ($research)
						$id_type_row = $id_search[$row];
					else
						$id_type_row = $type->getID_array($row);
					
					$type -> retrive_by_id($id_type_row);
					$nickname_type_row = $type->getNickname();
					$subregion_type_row = $type->getSubregion();
				
					$nickname_type_row = str_replace('_', ' ', $nickname_type_row);
					$subregion_nickname_type_row = $subregion_type_row . ":" . $nickname_type_row;
					$position_row = $type->getPosition();
					
					$num_merged_cols = $num_columns-1;
					
					if (!$research) {
						$rowIdx = $row;
						if ( ($position_row == 201) || ($position_row == 301) || ($position_row == 401) || ($position_row == 501) || ($position_row == 601))					
						{
							//print ("<tr style='height:4px'><td bgcolor=#FF0000 style='width:175px'></td><td colspan='" . $num_merged_cols . "' bgcolor='#FF0000'></td></tr>");
						}
						}
					else {
						$rowIdx = array_search($id_type_row, $known_header) - 1;
						if ($row !=0 And ( ($id_type_row == $first_CA3) || ($id_type_row == $first_CA2) || ($id_type_row == $first_CA1) || ($id_type_row == $first_SUB) || ($id_type_row == $first_EC)) )
						{
							//print ("<tr style='height:4px'><td bgcolor=#FF0000 style='width:175px'></td><td colspan='" . $num_merged_cols . "' bgcolor='#FF0000'></td></tr>");
						}
					}
						
					print ("<tr><td bgcolor='#E0FFFF' style='text-align:left; overflow:hidden; vertical-align:middle; width:195px; height:20px;'>");
														
					print ("<a href='neuron_page.php?id=$id_type_row' target='_blank' class='font_cell_3'>");

					/* needed for .png images of text */
					$type_name_image_path = str_replace(':', '_', $subregion_nickname_type_row);
					$type_name_image_path = str_replace('/', '_', $type_name_image_path);
					$type_name_image_path = '\'images/name_neuron_type/unrotated/' . $type_name_image_path . '.png\'';
					//print ("<img src=$type_name_image_path alt=$type_name_image_path border='0' style='max-width:175px'/>");
					
					//needed for normal, horizontal text 
					if (strpos($subregion_nickname_type_row, '(+)') == TRUE)
						print ("<font style='font-size:12px' color='#339900'>$subregion_nickname_type_row</font>");
					if (strpos($subregion_nickname_type_row, '(-)') == TRUE)
						print ("<font style='font-size:12px' color='#CC0000'>$subregion_nickname_type_row</font>");							
					
					print ("</a>");								
					print ("</td>");
	
					for ($col=0; $col<$number_type; $col++) {
						// retrieve the id_type from Type
						if ($research)
							$id_type_col = $id_search[$col];
						else
							$id_type_col = $type->getID_array($col);
						
						$type -> retrive_by_id($id_type_col);
						$nickname_type_col = $type->getNickname();
						$subregion_type_col = $type->getSubregion();
					
						$nickname_type_col = str_replace('_', ' ', $nickname_type_col);
						$subregion_nickname_type = $subregion_type_col . " " . $nickname_type_col;
						$position_col = $type->getPosition();
						
						if (!$research) {
							$colIdx = $col;
							if ( ($position_col == 201) || ($position_col == 301) || ($position_col == 401) || ($position_col == 501) || ($position_col == 601))
							{
								//print ("<td style='width:4px' bgcolor='#FF0000'></td>");
							}
					   }
						else {		
							$colIdx = array_search($id_type_col, $known_header) - 1;
							if ($col !=0 And ( ($id_type_col == $first_CA3) || ($id_type_col == $first_CA2) || ($id_type_col == $first_CA1) || ($id_type_col == $first_SUB) || ($id_type_col == $first_EC)))
							{
								//print ("<td style='width:4px' bgcolor='#FF0000'></td>");
							}
						}
						
						if ($known_conn_matrix[$rowIdx][$known_header[$colIdx+1]] == 0)
							$presynaptic_bg_color = '#FFFFFF';
						else {
							switch ($pot_conn_matrix[$rowIdx][$pot_header[$colIdx+1]]) {
								case -1:
									$presynaptic_bg_color = '#AAAAAA';
									break;
								case 1:
									$presynaptic_bg_color = '#000000';
									break;
								case 4:
									$presynaptic_bg_color = '#FF8C00';
									break;
								default:
									$presynaptic_bg_color = '#FFFFFF';
									break;
							}
						}
						
						print ("<td bgcolor=$presynaptic_bg_color style='text-align:center; vertical-align:middle' width='20px'>");
						
						if ($known_conn_matrix[$rowIdx][$known_header[$colIdx+1]] == 0)
							print ("<img src='images/connectivity/known_nonconnection.png' width='20px' border='0'/>");
						elseif ($known_conn_matrix[$rowIdx][$known_header[$colIdx+1]] == 1)
							print ("<img src='images/connectivity/known_connection.png' width='20px' border='0'/>");
						
						// space rows & columns using images on the main diagonal
						elseif ( ($rowIdx == $colIdx) And ($pot_conn_matrix[$rowIdx][$pot_header[$colIdx+1]] == 0) )
							print ("<img src='images/connectivity/spacer_white.png' height='20px' 'width='20px' border='0'/>");
						elseif ( ($rowIdx == $colIdx) And ($pot_conn_matrix[$rowIdx][$pot_header[$colIdx+1]] == -1) )
							print ("<img src='images/connectivity/spacer_gray.png' height='20px' 'width='20px' border='0'/>");
						elseif ( ($rowIdx == $colIdx) And ($pot_conn_matrix[$rowIdx][$pot_header[$colIdx+1]] == 1) )
							print ("<img src='images/connectivity/spacer_black.png' height='20px' 'width='20px' border='0'/>");
						elseif ( ($rowIdx == $colIdx) And ($pot_conn_matrix[$rowIdx][$pot_header[$colIdx+1]] == 4) )
							print ("<img src='images/connectivity/spacer_orange.png' height='20px' 'width='20px' border='0'/>");
						
						print ("</td>");
					}			
					
					print ("</tr>");
				}
				
				
				
				print("</tbody>");
				print("</table>");			
			?>
			
		</div>
		</div>	
</div>
</body>
</html>
