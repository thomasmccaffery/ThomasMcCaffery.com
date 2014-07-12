<?
include('Arr_Data.php');

$current_article = '';
$current_article = $_GET['Articles'];
$current_articleS = str_replace('-', ' ', $_GET['Articles']); 


/* Add check to see if title is in array to show if not show whole list with error*/
if((isset($_GET['Articles'])) && ($current_article!='')) {
$Article_Number = searchFor($current_articleS, $Articles_Array, '1');
?>
	<div class="box2 Full_block"> 
		<div class="content_in main_imge details_cover" style="background-image: url('assets/img/Articles/Covers/<? echo $Articles_Array[$Article_Number][7]; ?>')">
			<div class="summary-wrap shaded">
                <h1 <?if($Articles_Array[$Article_Number][9]==1){echo 'class= "shaded"';}?>><b><? echo $Articles_Array[$Article_Number][1]; ?></b></h1>
                <h2 class="text-hl <?if($Articles_Array[$Article_Number][9]==1){echo "shaded";}?>"><? echo $Articles_Array[$Article_Number][2]; ?></h2>
                <p class="summary <?if($Articles_Array[$Article_Number][9]==1){echo "shaded_H";}?>"><? echo $Articles_Array[$Article_Number][3]; ?></p>
            </div>
		</div>
	</div>
	
	<div class="boxV Full_block"> 
		<div class="Article_Content">
			<p><? echo $Articles_Array[$Article_Number][8]; ?></p>
		</div>
	</div>
<?
} else {
	$i=1;
	$j=1;
	$IC=0;
	foreach ($Articles_Array as $value) {
		if($value[0]=='1') {
			if ($i % 2 != 0) { echo '<div class="box3"><div class="box3_holder">'; $IC=1; }
			?>
			<div class="box stack_quarter_block_third T view-first"> 
				<div class='content_in i_block'>
					<img src="assets/img/Articles/Tiles/<? echo $value[4]; ?>" class="imge" />
					<h3><? echo $value[1]; ?></h3>
					<div class="mask">
						<div class="t_head"><? echo $value[2]; ?></div>
						<p><? echo $value[3]; ?></p>
						<div class="info">Read More</div>
					</div>
					<a class="view-link" href="./?Articles=<? echo str_replace(' ', '-', $value[1]); ?>"></a>
				</div>
			</div>  
			<?
			if ($i % 2 == 0) { echo '</div></div>'; $IC=2; }
			$i++; 
		} else if($value[0]=='2') { $IC=0; ?>
			<div class='box half_block view-first'> 
				<div class='content_in main_imge i_block'>
					<img src="assets/img/Articles/Tiles/<? echo $value[6]; ?>" class="imge" />
					<h3><? echo $value[1]; ?></h3>
					<div class="mask">
						<div class="t_head"><? echo $value[2]; ?></div>
						<p><? echo $value[3]; ?></p>
						<div class="info">Read More</div>
					</div>
					<a class="view-link" href="./?Articles=<? echo str_replace(' ', '-', $value[1]); ?>"></a>
				</div>
			</div><!-- #22 -->
		<? }
		if ($j % 3 == 0) { echo '<div class="spacer-3"></div>'; }
		if ($j % 4 == 0) { echo '<div class="spacer-4"></div>'; }
		$j++;
	}
	if ($IC==1) { echo '</div></div>'; }
} ?>
	
	<div class="clear_both"></div>