	<div class='box half_block '> 
		<div class='content_in main_b text_block'><h2>An <em>engineer</em> who loves a good <em>challenge</em>, brainstorming <em>great ideas</em>.</h2></div> 
	</div>
		
	<?
	include('Arr_Data.php');
	$i=1; $IC=0;
	foreach ($Projects_Array as $value) {
		if ($i % 2 != 0) { echo '<div class="box3"><div class="box3_holder">'; $IC = 1; }
	?>	
	<div class="box stack_quarter_block_third T view-first"> 
		<div class='content_in i_block'>
			<img src="assets/img/Tiles/<? echo $value[4]; ?>" class="imge" />
			<h3><? echo $value[1]; ?></h3>
			<div class="mask">
				<div class="t_head"><? echo $value[2]; ?></div>
				<p><span><? echo $value[3]; ?></span></p>
				<div class="info">View Details</div>
			</div>
			<a class="view-link" href="./?Project=<? echo str_replace(' ', '-', $value[1]); ?>"></a>
		</div>
	</div>  
	<?
		if ($i % 2 == 0) { echo '</div></div>'; $IC = 2; }
		$i++;
		if ($i % 3 == 0) { echo '<div class="spacer-3"></div>'; }
		if ($i % 4 == 0) { echo '<div class="spacer-4"></div>'; }
	}
	if ($IC==1) { echo '</div></div>'; }
	?>
	
	<div class="clear_both"></div>