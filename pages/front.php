<?
include('Arr_Data.php');
?>
	<div class="box3">
		<div class="box3_holder">
			<div class="box stack_quarter_block_third T"> 
				<div class='content_in i_block Logod'>
					<img src="assets/img/Tiles/Logo-2x2.jpg" class="imge" />
					<h3>
					<div class="nav_Social"> 
						<ul class="social-media">
							<li><a href="https://github.com/thomasmccaffery" class="githubH" target="_blank"><span class="icon-github"></span></a></li>
							<li><a href="https://www.facebook.com/thomas.mccaffery.79" target="_blank"><span class="icon-facebook2 facebookH"></span></a></li>
							<li><a href="http://www.linkedin.com/in/thomasmccaffery" target="_blank"><span class="icon-linkedin2 linkedinH"></span></a></li>
						</ul>
					</div> 
					</h3>
				</div> 
			</div>
  
			<div class="box stack_quarter_block_third view-first"> 
				<div class='content_in i_block'>
					<img src="assets/img/Articles/Tiles/<? echo $Articles_Array[0][4]; ?>" class="imge" />
					<h3><? echo $Articles_Array[0][1]; ?></h3>
					<div class="mask">
						<div class="t_head"><? echo $Articles_Array[0][1]; ?></div>
						<p><? echo $Articles_Array[0][3]; ?></p>
						<div class="info">Read More</div>
					</div>
					<a class="view-link" href="./?Articles=<? echo str_replace(' ', '-', $Articles_Array[0][1]); ?>"></a>
				</div>
			</div>
		</div>
	</div><!-- #1 & #2-->
	
	<div class='box half_block '> 
		<div class='content_in main_b text_block'><h2>An <em>engineer</em> who loves a good <em>challenge</em>, brainstorming <em>great ideas</em>.</h2></div> 
	</div><!-- #3 -->
	
	<div class="spacer-3"></div>
	
	<div class="box3">
		<div class="box3_holder">
			<div class="box stack_quarter_block_third T"> 
				<div class="content_in text_block uni"><p>
					<b>Binghamton University</b> <br>
					<br>
					<i>B.S. Mechanical Engineering</i> <br>
					<br>
					E.I.T State of New York <br>
				</p></div> 
			</div>
  
			<div class="box stack_quarter_block_third"> 
				<div class='content_in'>
					<img src="assets/img/Tiles/BKa-2x2.jpg" class="imge" />
				</div> 
			</div>
		</div>
	</div><!-- #4 & #5 -->
	
	<div class="spacer-4"></div>
	
	<div class='box half_block'> 
		<div class="holder2">
			<div class='box2 abs stack_half_block view-first top'> 
				<div class="half_pic i_block">
					<img src="assets/img/Tiles/ScratchDoge-2x1.jpg" class="half_imge" />
					<h3>ScratchDoge.com</h3>
					<div class="mask">
						<div class="lone"><? echo $Projects_Array[0][1]; ?> <br/> <span class="lone"><? echo $Projects_Array[0][3]; ?></span></div>
						<div class="info">View Details</div>
					</div>
					<a class="view-link" href="./?Project=<? echo str_replace(' ', '-', $Projects_Array[0][1]); ?>"></a>
				</div>
			</div>
			
			<div>
				<div class='box stack_quarter_block bl'> 
					<div class='content_in text_block'>
						<h3><b>Engineer With a Twist</b></h3>
						<p>The <em>education</em> and <em>logic</em> of a mechanical engineer. </p>
						<p>The <em>passion</em> and <em>detail</em> of a developer. </p>
					</div> 
				</div>
				<div class='box stack_quarter_block br  view-first'> 
					<div class='content_in i_block'>
						<img src="assets/img/Tiles/BitQuicka-1x1.jpg" class="imge" />
						<h3>BitQuick.net</h3>
						<div class="mask">
							<div class="lone"><? echo $Projects_Array[5][1]; ?> <br/> <span class="lone"><? echo $Projects_Array[5][3]; ?></span></div>
							<div class="info">View Details</div>							
						</div>
						<a class="view-link" href="./?Project=<? echo str_replace(' ', '-', $Projects_Array[5][1]); ?>"></a>
					</div>
				</div>
			</div>
		</div>
	</div><!-- #6 + #7 + #8 -->
	
	<div class="spacer-3"></div>
	
	<div class="box3">
		<div class="box3_holder">
			<div class="box stack_quarter_block_third T view-first"> 
				<div class='content_in i_block'>
					<img src="assets/img/Articles/Tiles/<? echo $Articles_Array[1][4]; ?>" class="imge" />
					<h3><? echo $Articles_Array[1][1]; ?></h3>
					<div class="mask">
						<div class="t_head"><? echo $Articles_Array[1][1]; ?></div>
						<p><? echo $Articles_Array[1][3]; ?></p>
						<div class="info">Read More</div>
					</div>
					<a class="view-link" href="./?Articles=<? echo str_replace(' ', '-', $Articles_Array[1][1]); ?>"></a>
				</div>
			</div>
  
			<div class="box stack_quarter_block_third"> 
				<div class='content_in'>
					<img src="assets/img/Tiles/Medal-1x1.jpg" class="imge" />
				</div> 
			</div>
		</div>
	</div><!-- #9 & #10 -->
			
	<div class="box3">
		<div class="box3_holder">
			<div class="box stack_quarter_block_third T view-first"> 
				<div class='content_in i_block'>
					<img src="assets/img/Tiles/ShibaDice-1x1.jpg" class="imge" />
					<h3>ShibaDice.com</h3>
					<div class="mask">
						<div class="lone"><? echo $Projects_Array[1][1]; ?> <br/> <span class="lone"><? echo $Projects_Array[1][3]; ?></span></div>
						<div class="info">View Details</div>
					</div>
					<a class="view-link" href="./?Project=<? echo str_replace(' ', '-', $Projects_Array[1][1]); ?>"></a>
				</div>
			</div>
  
			<div class="box stack_quarter_block_third view-first"> 
				<div class='content_in i_block'>
					<img src="assets/img/Articles/Tiles/<? echo $Articles_Array[2][4]; ?>" class="imge" />
					<h3><? echo $Articles_Array[2][1]; ?></h3>
					<div class="mask">
						<div class="t_head"><? echo $Articles_Array[2][1]; ?></div>
						<p><? echo $Articles_Array[2][3]; ?></p>
						<div class="info">Read More</div>
					</div>
					<a class="view-link" href="./?Articles=<? echo str_replace(' ', '-', $Articles_Array[2][1]); ?>"></a>
				</div>
			</div>
		</div>
	</div><!-- #11 & #12 -->
	
	<div class="spacer-4"></div>
	
	<div class="box3">
		<div class="box3_holder">
			<div class="box stack_quarter_block_third T view-first"> 
				<div class='content_in i_block'>
					<img src="assets/img/Tiles/WeatherMobile-1x1.jpg" class="imge" />
					<h3>MobileWeather</h3>
					<div class="mask">
						<div class="lone"><? echo $Projects_Array[3][1]; ?> <br/> <span class="lone"><? echo $Projects_Array[3][3]; ?></span></div>
						<div class="info">View Details</div>
					</div>
					<a class="view-link" href="./?Project=<? echo str_replace(' ', '-', $Projects_Array[3][1]); ?>"></a>
				</div>
			</div>
  
			<div class="box stack_quarter_block_third"> 
				<div class='content_in text_block'>
					<h3><b>The goal?</b></h3>
					<p>To break out into the world of software to <em>exponentially</em> increase my coding knowledge. </p>
				</div>
			</div>
		</div>
	</div><!-- #13 & #14 -->
	
	<div class="spacer-3"></div>
	
	<div class="box3">
		<div class="box3_holder">
			<div class="box stack_quarter_block_third T view-first"> 
				<div class='content_in i_block'>
					<img src="assets/img/Tiles/EXIF-1x1.jpg" class="imge" />
					<h3>EXIF Viewer</h3>
					<div class="mask">
						<div class="lone"><? echo $Projects_Array[2][1]; ?> <br/> <span class="lone"><? echo $Projects_Array[2][3]; ?></span></div>
						<div class="info">View Details</div>
					</div>
					<a class="view-link" href="./?Project=<? echo str_replace(' ', '-', $Projects_Array[2][1]); ?>"></a>
				</div>
			</div>
  
			<div class="box stack_quarter_block_third view-first"> 
				<div class='content_in i_block'>
					<img src="assets/img/Articles/Tiles/<? echo $Articles_Array[3][4]; ?>" class="imge" />
					<h3><? echo $Articles_Array[3][1]; ?></h3>
					<div class="mask">
						<div class="t_head"><? echo $Articles_Array[3][1]; ?></div>
						<p><? echo $Articles_Array[3][3]; ?></p>
						<div class="info">Read More</div>
					</div>
					<a class="view-link" href="./?Articles=<? echo str_replace(' ', '-', $Articles_Array[3][1]); ?>"></a>
				</div> 
			</div>
		</div>
	</div><!-- #15 & #16 -->
			
	<div class='box half_block '> 
		<div class='content_in main_b text_block'><h2><em>Entrepreneur</em> at heart; I love being able to see a product come to <em>life</em>.</h2></div> 
	</div><!-- #17 -->
	
	<div class="spacer-3"></div>
	<div class="spacer-4"></div>
	
	<div class='box stack_third_solo'>
		<div class='content_in solo_holder'>
			<img src="assets/img/Tiles/Landinga-1x1.jpg" class="imge" />
		</div> 
	</div> <!-- #18 -->
	
	<div class='box stack_third_solo'>
		<div class='content_in solo_holder'>
			<img src="assets/img/Tiles/Cliff-1x1.jpg" class="imge" />
		</div> 
	</div> <!-- #19 -->
	
	<div class='box stack_third_solo view-first'> 
		<div class='content_in i_block solo_holder'>
			<img src="assets/img/Tiles/K25Designsa-1x1.jpg" class="imge" />
			<h3>K25Designs</h3>
			<div class="mask">
				<div class="lone"><? echo $Projects_Array[7][1]; ?> <br/> <span class="lone"><? echo $Projects_Array[7][3]; ?></span></div>
				<div class="info">View Details</div>
			</div>
			<a class="view-link" href="./?Project=<? echo str_replace(' ', '-', $Projects_Array[7][1]); ?>"></a>
		</div>
	</div> <!-- #20 -->
	
	<div class='box stack_third_solo last_solo'> 
			<div class='content_in text_block solo_holder'>
				<p>I've previously worked on projects using PHP, Objective-C, Java, C++, Mathematica, MatLab, and of course HTML5, CSS3, JS, and JQuery.  </p>
			</div> 
	</div> <!-- #21 -->
	
	<div class="spacer-3"></div>
	<div class="spacer-4"></div>
	
	<div class='box half_block '> 
		<div class='content_in main_imge'>
			<img src="assets/img/Tiles/NYC-2x2.jpg" class="imge" />
		</div>
	</div><!-- #22 -->
	
	<div class="box3">
		<div class="box3_holder">
			<div class="box stack_quarter_block_third T view-first"> 
				<div class='content_in i_block'>
					<img src="assets/img/Tiles/GGMb-1x1.jpg" class="imge" />
					<h3>Genesis Global Media</h3>
					<div class="mask">
						<div class="lone"><? echo $Projects_Array[9][1]; ?> <br/> <span class="lone"><? echo $Projects_Array[9][3]; ?></span></div>
						<div class="info">View Details</div>
					</div>
					<a class="view-link" href="./?Project=<? echo str_replace(' ', '-', $Projects_Array[9][1]); ?>"></a>
				</div>
			</div>
  
			<div class="box stack_quarter_block_third"> 
				<div class='content_in text_block'>
					<h3><b>Current Projects: </b></h3>
						<p><em><a href="/?Project=ScratchDoge.com">ScratchDoge</a></em> - Worlds First Crypto Scratch off.</p>
						<p><em><a href="/?Project=NYC-Parking">NYC Parking</a></em> - HTML5 street-parking availability parking map.</p>
				</div>
			</div>
		</div>
	</div><!-- #23 & #24 -->
	
	<div class="spacer-3"></div>
	
	<div class="box3">
		<div class="box3_holder">
			<div class="box stack_quarter_block_third T"> 
				<div class='content_in text_block Resume_Tile'>
					<h3><b>Resume</b></h3>
					<div class="File_Tile"><a class="light" href="http://thomasmccaffery.com/Files/Resumes/McCaffery_Thomas_EIT_Resume_2014.docx" target="_blank"><div class="File_icon word"></div>Word</a></div>
					<div class="File_Tile"><a class="light" href="http://thomasmccaffery.com/Files/Resumes/McCaffery_Thomas_EIT_Resume_2014.pdf" target="_blank"><div class="File_icon pdf"></div>PDF</a></div>
					<div class="File_Tile"><a class="light" href="http://thomasmccaffery.com/Files/samples.zip" target="_blank"><div class="File_icon site"></div>Code</a></div>
				</div>
			</div>
			
			<div class="box stack_quarter_block_third view-first"> 
				<div class='content_in i_block'>
					<img src="assets/img/Tiles/LCBUa-1x1.jpg" class="imge" />
					<h3>LastCallBU</h3>
					<div class="mask">
						<div class="lone"><? echo $Projects_Array[18][1]; ?> <br/> <span class="lone"><? echo $Projects_Array[18][3]; ?></span></div>
						<div class="info">View Details</div>
					</div>
					<a class="view-link" href="./?Project=<? echo str_replace(' ', '-', $Projects_Array[18][1]); ?>"></a>
				</div>
			</div>
		</div>
	</div><!-- #25 & #26 -->
	
	<div class="spacer-4"></div>
	
	<div class='box half_block '> 
		<div class='content_in main_b text_block'><h2>I strive to work on cutting-edge technology in which the world has not even dreamed of yet! </h2></div> 
	</div><!-- #27 -->
	
	<div class="spacer-3"></div>
	
	<div class='box half_block '> 
		<div class='content_in main_imge'>
			<img src="assets/img/Tiles/Circuit-2x2.jpg" class="imge" />
		</div>
	</div><!-- #28 -->
	
	<div class="spacer-4"></div>
	
	<div class="box3">
		<div class="box3_holder">
			<div class="box stack_quarter_block_third T view-first"> 
				<div class='content_in i_block'>
					<img src="assets/img/Tiles/Cenergy-1x1.jpg" class="imge" />
					<h3>Cenergy</h3>
					<div class="mask">
						<div class="lone"><? echo $Projects_Array[15][1]; ?> <br/> <span class="lone"><? echo $Projects_Array[15][3]; ?></span></div>
						<div class="info">View Details</div>
					</div>
					<a class="view-link" href="./?Project=<? echo str_replace(' ', '-', $Projects_Array[15][1]); ?>"></a>
				</div>
			</div>
			
			<div class="box stack_quarter_block_third view-first"> 
				<div class='content_in i_block'>
					<img src="assets/img/Tiles/Groscost-1x1.jpg" class="imge" />
					<h3>SandraGroscost.com</h3>
					<div class="mask">
						<div class="lone"><? echo $Projects_Array[11][1]; ?> <br/> <span class="lone"><? echo $Projects_Array[11][3]; ?></span></div>
						<div class="info">View Details</div>
					</div>
					<a class="view-link" href="./?Project=<? echo str_replace(' ', '-', $Projects_Array[11][1]); ?>"></a>
				</div>
			</div>
		</div>
	</div><!-- #29 & #30 -->
	
	<div class="spacer-3"></div>
	
	<div class="box3">
		<div class="box3_holder">
			<div class="box stack_quarter_block_third T view-first"> 
				<div class='content_in i_block'>
					<img src="assets/img/Tiles/BonniePrebula-1x1.jpg" class="imge" />
					<h3>BonnieGP.com</h3>
					<div class="mask">
						<div class="lone"><? echo $Projects_Array[12][1]; ?> <br/> <span class="lone"><? echo $Projects_Array[12][3]; ?></span></div>
						<div class="info">View Details</div>
					</div>
					<a class="view-link" href="./?Project=<? echo str_replace(' ', '-', $Projects_Array[12][1]); ?>"></a>
				</div>
			</div>
			
			<div class="box stack_quarter_block_third view-first"> 
				<div class='content_in i_block'>
					<img src="assets/img/Tiles/BigHeartBridges-1x1.jpg" class="imge" />
					<h3>BigHeartBridges.com</h3>
					<div class="mask">
						<div class="lone"><? echo $Projects_Array[14][1]; ?> <br/> <span class="lone"><? echo $Projects_Array[14][3]; ?></span></div>
						<div class="info">View Details</div>
					</div>
					<a class="view-link" href="./?Project=<? echo str_replace(' ', '-', $Projects_Array[14][1]); ?>"></a>
				</div>
			</div> 
		</div>
	</div><!-- #31 & #32 -->
	
	<div class='box stack_third_solo view-first'> 
			<div class='content_in i_block solo_holder'>
				<img src="assets/img/Tiles/3Ger-1x1.jpg" class="imge" />
				<h3>3Ger</h3>
				<div class="mask">
					<div class="lone"><? echo $Projects_Array[8][1]; ?> <br/> <span class="lone"><? echo $Projects_Array[8][3]; ?></span></div>
					<div class="info">View Details</div>
				</div>
				<a class="view-link" href="./?Project=<? echo str_replace(' ', '-', $Projects_Array[8][1]); ?>"></a>
			</div> 
	</div> <!-- #33 -->
	
	<div class='box stack_third_solo view-first'>
			<div class='content_in i_block solo_holder'>
				<img src="assets/img/Tiles/EyesEverywhere-1x1.jpg" class="imge" />
				<h3>EyesEverywhere</h3>
				<div class="mask">
					<div class="lone"><? echo $Projects_Array[16][1]; ?> <br/> <span class="lone"><? echo $Projects_Array[16][3]; ?></span></div>
					<div class="info">View Details</div>
				</div>
				<a class="view-link" href="./?Project=<? echo str_replace(' ', '-', $Projects_Array[16][1]); ?>"></a>
			</div>
	</div> <!-- #34 -->
	
	<div class="clear_both"></div>