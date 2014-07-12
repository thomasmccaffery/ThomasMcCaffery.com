<div class="Port_swiper">
<?
include('Arr_Data.php');
$current_proj = '';
$current_proj = $_GET['Project'];
$current_projS = str_replace('-', ' ', $_GET['Project']);

if(($current_proj=='')||($current_proj==null)) {header("Location: ./?Portfolio");exit;}
if((isset($_GET['Project'])) && ($current_proj!='')) {
	$Project_Number = searchFor($current_projS, $Projects_Array, '1'); 
	if(($Project_Number=='no')&&($Project_Number!=0)) {header("Location: ./?Portfolio");exit;} ?>
	<div class="box2 Full_block"> 
		<div class="content_in main_imge details_cover" style="background-image: url('assets/img/Portfolio/Covers/<? echo $Projects_Array[$Project_Number][7]; ?>')">
			<div class="summary-wrap">
                <h1 <?if($Projects_Array[$Project_Number][8]==1){echo 'class="shaded"';}?>><b><a href="<? echo $Projects_Array[$Project_Number][10]; ?>" target="_blank"><? echo $Projects_Array[$Project_Number][1]; ?><span class="icon-newtab port_link"></a></b></h1>
                <h2 class="text-hl <?if($Projects_Array[$Project_Number][8]==1){echo "shaded";}?>"><? echo $Projects_Array[$Project_Number][2]; ?></h2>
                <p class="summary <?if($Projects_Array[$Project_Number][8]==1){echo "shaded_H";}?>"><? echo $Projects_Array[$Project_Number][3]; ?></p>
            </div>
		</div>
	</div>
<? /* ------------  Header Above -- Blocks Below ----------- */
	$i=1;
	$BlockCount=0;
	$OpenDiv=0;
	$lock=0;
	foreach ($Projects_Layout_Array[$Project_Number] as $value) {
		if($value[0]=='1x1x0') {
			if($OpenDiv==2) {echo '<div>';}
			else if ($i % 2 != 0) { $BlockCount++; echo '<div class="box3"><div class="box3_holder">'; $OpenDiv=1; }
			?>
			<?
			if($OpenDiv==3) {echo '</div></div></div>';$OpenDiv=0;$lock=0;}
			else if($OpenDiv==2) {$OpenDiv=3;$lock=1;}
			else if ($i % 2 == 0) { echo '</div></div>'; $OpenDiv=0; }
			$i++;
		} else if($value[0]=='1x1') {
			if($OpenDiv==2) {echo '<div>';}
			else if ($i % 2 != 0) { $BlockCount++; echo '<div class="box3"><div class="box3_holder">'; $OpenDiv=1; }
			?>
			<div class="box <?if($OpenDiv==2){echo "stack_quarter_block bl";}else if($OpenDiv==3){echo "stack_quarter_block br";}else{echo "stack_quarter_block_third T";}?>"> 
				<? if($value[1]=='IMG') { ?> 
				<div class='content_in'>
					<img src="assets/img/Portfolio/Tiles/<? echo $value[2]; ?>" alt="<? echo $value[5]; ?>" class="imge" />
				</div>
				<? } else if($value[1]=='Text') { ?>
				<div class='content_in text_block uni l_text'>
					<? echo $value[6]; ?>
				</div>
				<? } ?>
			</div>  
			<?
			if($OpenDiv==3) {echo '</div></div></div>';$OpenDiv=0;$lock=0;}
			else if($OpenDiv==2) {$OpenDiv=3;$lock=1;}
			else if ($i % 2 == 0) { echo '</div></div>'; $OpenDiv=0; }
			$i++; 
		} else if($value[0]=='2x2') { $OpenDiv=0; $BlockCount+=2; ?>
			<div class='box half_block'>
				<? if($value[1]=='IMG') { ?>
				<div class='content_in main_imge i_block'>
					<img src="assets/img/Portfolio/Tiles/<? echo $value[4]; ?>" alt="<? echo $value[5]; ?>" class="imge" />
				</div>
				<? } else if($value[1]=='Text') { ?>
				<div class='content_in main_t text_block2 l_text'>
					<? echo $value[6]; ?>
				</div>
				<? } ?>
			</div>
		<? } else if($value[0]=='1x2') {  $BlockCount++; ?>
			<div class="box3"><div class="box3_holder">
				<? if($value[1]=='IMG') { ?>
					<div class='content_in i_block'>
						<img src="assets/img/Portfolio/Tiles/<? echo $value[3]; ?>" alt="<? echo $value[5]; ?>" class="imge" />
					</div>
				<? } else if($value[1]=='Text') { ?>
					<div class='content_in text_block l_text'>
						<? echo $value[6]; ?>
					</div>
				<? } ?>
			</div></div>
		<? } else if($value[0]=='2x1') {
			if ($OpenDiv!=2) { $BlockCount+=2; $lock=1; ?>
				<div class='box half_block'> 
					<div class="holder2">
			<? } ?>
						<div class='box2 abs stack_half_block top'>							
							<? if($value[1]=='IMG') { ?>
							<div class='content_in i_block'>
								<img src="assets/img/Portfolio/Tiles/<? echo $value[3]; ?>" alt="<? echo $value[5]; ?>" class="imge" />
							</div>
							<? } else if($value[1]=='Text') { ?>
							<div class='content_in text_block2 l_text'>
								<? echo $value[6]; ?>
							</div>
							<? } ?>
						</div>
			<? if ($OpenDiv==2) { ?> </div></div> <? $OpenDiv=0; } else {$OpenDiv=2;}; 
		}
		if ($BlockCount % 3 == 0 && ($lock!=1)) { echo '<div class="spacer-3"></div>'; }
		if ($BlockCount % 4 == 0 && ($lock!=1)) { echo '<div class="spacer-4"></div>'; }
	}
	if($OpenDiv==3) {echo '</div></div></div>';$OpenDiv=0;}
	else if ($OpenDiv==2) { echo '</div></div>';$OpenDiv=0;}
	else if ($OpenDiv==1) { echo '</div></div>'; }
	
} ?>

	<? if($Projects_Array[$Project_Number][11]!='') { ?>
	<div class='boxV Full_block'> 
		<div class='Article_Content'>
			<? echo $Projects_Array[$Project_Number][11]; ?>
		</div>
	</div>
	<? } ?>
	
	<a id="prev_page" href="./?Project=<? echo str_replace(' ', '-', $Projects_Array[$Project_Number-1][1]); ?>" data-ajax="false" class="ui-link"></a>
	<a id="next_page" href="./?Project=<? echo str_replace(' ', '-', $Projects_Array[$Project_Number+1][1]); ?>" data-ajax="false" class="ui-link"></a>
	<div class="clear_both"></div>
	</div>