<?
/* Array Layout:

|___________________________________________________________________________________________|
| Box-Type | Main-Order | Main-Box-Size | Article-Order | Article-Box-Size | Inner-HTML | IMG LINK | Front Title | Popup Title | Popup Detail | Popup Link
|___________________________________________________________________________________________|

*/

/* Eventually have 4 image slots - 1x1,2x1,2x2,cover img*/
/* array("Size","Title","Secondary_Title","Blurb","1x1","2x1","2x2","Cover","shaded?","DataLocation","Link",'HTML')
Sizes:
1x1 
2x1
2x2 
array(array("Size","IMG/Text","1x1","2x1","2x2",'Text'))
 */
$Projects_Array = array( 
array("1x1","ScratchDoge.com","1st Doge Scratcher!","Experience making the first Crypto-Currency Scratch-Off.","ScratchDoge-1x1.jpg","2x1","2x2","ScratchDoge_Cover.jpg","1","1","http://scratchdoge.com",'<h3><b>More About the Project: </b></h3>
	<p>
  	Overall the ScratchDoge project was a fun one. From getting the Crypto-wallet system to properly deposit the coins to each user efficiently, to the security locks on each game and withdrawal it was quite the experience. I am proud to say that to this day (June 2014 at least) we have not been hacked or compromised, despite over 18 million Dogecoins wagered. In the following sections I would like to further write about select sub-sections functionalities, and how they were made possible.
  	</p>
  <hr/>
  <a name="Deposits"></a>
  <h3><b>Deposits</b></h3>
  	<p>
      Next to WebSockets, I would say that the deposit system was one of my favorite challenges.  In the early stages, we had initially used an already developed deposit system which was just a PHP loop that checked each transaction that occurred on the wallet, made sure it had over three confirmations, dropped the coins into the users account, and then marked the transaction as complete.  However, this system proved to be faulty many times over when running it on the sister project ShibaDice.  It was notorious in the community for allowing double deposits or more, or even just missing a whole transaction all together.  This was because of the way it was set up. The process to check for deposits was run every minute, which was the main reason all of these issues arises. If the transaction list got too long (in our case over 600,000 entries) the process would take over a minute to complete; which if you did not catch, would start a whole new process. Thus when one loop hit the 1 minute mark and did not complete the next minutes loop was starting, which caused any transactions after that minute to be double deposited.  
  </p>
  <p>
    Many Solutions? Sure! There could be any number of ways to go about a programming problem. However the way I took it, was that the efficiency was the main cause of concern here. So the only logical step to take, was to rebuild the way a deposit happens from the ground up!
  </p>
  <p>
  	Lets break down the steps to gaining a successful, and problematic-free deposit:
  </p>
	<p>First, every minute a Cron Task is run to pull the top couple thousand transactions, as well as how many confirmations it has.  This allows for 1) Quickness, as a few thousand entries is nothing to add to a database, and 2) efficiency as we will never go higher than 10,000 entries, freeing up any slow loops or resource hogs.</p>
	<p>Secondly, a loop is applied to those few thousand transactions, which checks how many confirmations are present. If it is over our set criteria, then the transaction is processed and moves onto the next step; if not the loop moves onward.</p>
    <p>Thirdly, when confirmation is reached, the transaction is given a unique ID and is submitted along with the current information about the transaction to several databases for cross reference.  This allows for tamper-proof / cheater-proof checking later. After all data is inserted, the balance is then applied to the users account, and the transaction is marked as checked.</p>
    <p>At this point, the deposit has been completed, and is now ignored from then on. This transaction is kept on file until overwritten eventually by the new thousands of entries coming in, however is kept backed up on other tables to be checked with in case of future issues.  All this while freeing up the database and PHP to run quickly through the script without ever going near its limit of running out of that minute time-span. No more double deposits, no more problems!</p>
  <hr/>
  <h3><b>JackPot (WebSockets)</b></h3>
	<p>As mentioned above, WebSockets turned out to be quite the pain.  The first real issue was that Nginx, while supporting sockets, has little support to it. The Second issue being CloudFlares blocking of ports.  The first problem was easily solved by making a PHP WebSocket server, which on the surface is only a giant loop checking each new and current connection for a change in data.  This PHP process is run on the server using the "nohup &" function to allow a continuous background process much like a daemon. The second issue which was described earlier relied on tons of frustrating hours of working code, but locked ports.  It took hours to realize that the data kept getting held up and that CloudFlare was the reason. As a last resort we tried turning CloudFlare off and finally stumbled upon this! However due to the nature of DDOS attacks to crypto-currency websites, CloudFlare was a necessity. So after much reading I was able to find a StackOverflow request about a similar port problem.  This led to the page listed below, which finally explained why we were always getting a 404 error over time. By simply testing the ports they had listen in their blog (why this is not mentioned on their WebsScket FAQ, I do not understand), a 101 Web Socket Protocol Handshake was delivered!   </p>
	<p>With all the ports figured out, rolling the jackpot was as easy as adding a few lines of code.  The idea is simple: every time the jackpot entry in the database is updated, the new jackpot value is pushed out to all connected users via WebSockets.  This cut down on database overhead, as the old system had to poll or long-poll continuously every minute.</p>
	<br/><a name="Ports">*CloudFlare Ports</a><p>A List of all ports which are supported by CloudFlare to be used with WebSockets can be found at <a href="http://blog.cloudflare.com/cloudflare-now-supporting-more-ports" target="_blank">http://blog.cloudflare.com/cloudflare-now-supporting-more-ports</a>; I particularly had trouble with the 2000 range, however 8080, 8443, and 8880 provided to work successfully.</p>
  <hr/>
  <a name="Withdrawal"></a>
  <h3><b>Withdrawal</b></h3>
	<p>The withdrawal system proved to be a bit problematic in the original version on ShibaDice.  However after a full re-write and an addition of many logic checks, a stable secure system was developed.  Without giving away too much, many of these security checks seek any foul play, or any attempt to change values, over-ride defaults, go over set limits, and many others. The best protection we could have ever added was the wait time limits. To deter bots from trying to over-run our withdrawal scripts, we set up a one (1) minute wait after each game is played, and another fifteen (15) minutes after each withdrawal.  The attempt of bot usage we recorded on our logs dropped from 20% to 3% of withdrawal attempts. Poor bots will only get a time error now.</p>
  <hr/>
  <a name="Provability"></a>
  <h3><b>Provability</b></h3>
	<p>"Provability" - The proving of unchanged probability. The whole crypto-game world is in love with this idea, as a client and server must put their strings together to form a non-editable and non-rigged game. The idea is simple; If the server cannot know what string a user or a users browser is going to produce, it cannot make a false game or change the outcome afterwards, as the user can check if their string combined with the servers string renders the proper game outcome. This is the feature I am currently working on, and will be coming soon to ScratchDoge.  I will eventually update how it works here when completed.</p>
	'),
array("1x1","ShibaDice.com","Dogecoin Dice Game in PHP","A Dogecoin dice game which needed a heavy overhaul.","ShibaDice-1x1.jpg","2x1","2x2","ShibaDice_Cover.jpg","1","1","http://shibadice.com"),
array("1x1","EXIF Viewer","Photo Meta-Data Viewer","Quickly view your photos meta-data and GPS location.","EXIF-1x1.jpg","2x1","2x2","EXIF_Cover.jpg","1","1","http://thomasmccaffery.com/Labs/PhotoLocation/"),
array("1x1","Mobile Weather","Weather at a Glance...On Mobile!","A mobile weather map to find a quick warm get away!","WeatherMobile-1x1.jpg","2x1","2x2","MobileWeather_Cover.jpg","1","1","http://thomasmccaffery.com/Labs/weather/","<h3><b>More About the Project: </b></h3>
<p>MobileWeather, like many projects, was made to solve a problem.  I like to travel to new locations all the time by car a lot throughout the year, but like to do so randomly.  There is no particular place which stands out to me, so I often find myself scrolling around Google maps looking for a new, unique place to visit.  However in the summer of 2013, I realized that weather was the most common denominator to choosing a location, and wanted to begin seeking weekend getaways which had a clear and warm weekend ahead.  So I began searching online for a simple map I could use on my phone to browse around the country while seeing a weather overlay that also shows the forecast for the weekend.  I was amazed that there was little such applications out there, and that the Google version was only an example in how to use their API.</p>
<p>So the project began! I used twitters Bootstrap to quickly draw up a responsive minimalist page to hold the map as the main feature, while hiding the menu unless it was necessary to pull out.  Once the bootstrap layout was complete all I had to do was drop in the new v3 Google maps JS API, and add in the weather overlay functions.  I also threw in a bunch of options in the menu pull-out so that it would be quick and easy to change things such as unit changes or cloud coverage.  In addition, a Google search box was added to quickly find a location which a user may want to go.</p>
<br/><p>I could now easily and happily browse through the areas I most wanted to visit with a nice overlay.  Clicking on the location reveals the 5-day forecast too! So all problems solved and I can now find the best weather vacation spot for the weekend!</p>"),
array("1x1","NYC Parking","Makes parking easier!","I always park in NYC, but all the good Apps are gone. So I made one!","NYCParking-1x1.jpg","2x1","2x2","NYC_Parking_Cover.jpg","1","1","http://thomasmccaffery.com/Labs/NYC/","<p>NYC Parking Maps is an ongoing project of mine to plot all current street parking spaces onto Google maps.</p> <br/> <p>As I have just changed servers, the parking data has not yet been uploaded to MySQL as I lack the time, however when I get around to it, I will be updating this page here with the most recent work and details about the project.</p> <br/> <p>At the moment, all spots have been converted from a 6GB shape-way file to a huge MySQL database.  Every spot appears on the correct location, Location Search, and the App can use your current location to find the nearest parking.</p> <br/> <p>The current to do list includes but is not limited to: Optimizing Loading Times, Allowing for options such as checking how long a spot is opened, and adding the times available for every spot into the database (this still needs to be scripted).</p> <br/><br/> <h3><b>Please Check Back Shortly for Updates.</b></h3>"),
array("1x1","BitQuick.net","Bitcoin-Credit Card Exchange","A Bitcoin-Credit Card Exchange I co-founded and developed in PHP.","BitQuicka-1x1.jpg","2x1","2x2","BitQuick_Cover.jpg","1","1","http://thomasmccaffery.com/Archive/Mirror/BitQuick.net/"),
array("1x1","Bitcoin Converter","Light Bitcoin Converter","Light-weight Bitcoin to USD converter using JS.","BitcoinConv-1x1.jpg","2x1","2x2","BTC_Conv_Cover.jpg","1","1","http://thomasmccaffery.com/Labs/Bitcoin_Converter/"),
array("1x1","K25Designs.com","Graphic Designer Portfolio","An Artistic Portfolio for a local graphic designer.","K25Designsa-1x1.jpg","2x1","2x2","K25_Cover.jpg","1","1","http://k25designs.com"),
array("1x1","3Ger","Read Quicker; Less Data!","With lack of data at times, the 3Ger strips images or all but text from websites for quick reading!","3Ger-1x1.jpg","2x1","2x2","3Ger_Cover.jpg","1","1","http://thomasmccaffery.com/Labs/3Ger/"),
array("1x1","Genesis Global Media","From HTML to Drupal","Advertising Agencies Company Website rebuilt using Drupal 7.","GGMb-1x1.jpg","2x1","2x2","GGM_Cover.jpg","1","1","http://GenesisGlobalMedia.com"),
array("1x1","GGM Social","Social Media Center","I created this media page to help management keep track of all clients' social media.","GGMSMC-1x1.jpg","2x1","2x2","GGM_SMC_Cover.jpg","1","1","http://genesisglobalmedia.com/SMC/"),
array("1x1","SandraGroscost.com","WordPress Website","A clients website made using WordPress.","Groscost-1x1.jpg","2x1","2x2","Groscost_Cover.jpg","1","1","http://sandygroscost.com/"),
array("1x1","BonnieGP.com","WordPress Website","A clients website made using WordPress.","BonniePrebula-1x1.jpg","2x1","2x2","BonnieGP_Cover.jpg","1","1","http://bonniegp.com/"),
array("1x1","OCCT Bus","College Google Transit Project","A conversion of the university bus schedule from paper to Google Maps!","OCCT-1x1.jpg","2x1","2x2","OCCT-Cover.jpg","1","1","http://thomasmccaffery.com/Labs/occt_bus"),
array("1x1","BigHeartBridges.com","WordPress Website","A clients website made using WordPress.","BigHeartBridges-1x1.jpg","2x1","2x2","BigHeartBridges_Cover.jpg","1","1","http://bigheartbridgesint.com/"),
array("1x1","Cenergy","Solar Panel Landing Page","A Solar Panel Company sought out a landing page for future investors.","Cenergy-1x1.jpg","2x1","2x2","Cenergy_Cover.jpg","1","1","http://thomasmccaffery.com/Archive/Cenergy/"),
array("1x1","EyesEverywhere","iOS 5.0 App","A visual social search engine start-up I created. <br/> Published on the AppStore October 2011.","EyesEverywhere-1x1.jpg","2x1","2x2","EyesEverywhere_Cover.jpg","1","1","http://thomasmccaffery.com/Archive/Mirror/EyesEverywhe.re/",""),
array("1x1","BingBooks.com","University eTextBook Store","Before all these virtual book stores came about, I tried to create a college eTextBook MarketPlace using PayPal.","BingBooks-1x1.jpg","2x1","2x2","BingBooks_Cover.jpg","1","1","http://thomasmccaffery.com/Archive/BingBooks/"),
array("1x1","LastCallBU","Logistical Fun","A social web experiment in college which had over 1000 users. Fun logistical coding which was mentioned in many outlets including the schools newspaper.","LCBUa-1x1.jpg","2x1","2x2","LCBU_Cover.jpg","1","1","http://thomasmccaffery.com/LCBU","<h3><b>Matching Script</b></h3><p>In LastCallBU, users would sign up and hope to be anonymously matched with someone who wanted to be matched with them.  This happened by choosing 5 people and hoping that one or more of those people chosen had picked them too.  Below is the matching script used in LastCallBU to check each users top 5 picks for any pairs.</p><p>It starts off by calling all active (confirmed) users in the database, and running through each user in a while loop. If a users email was found in another's list, it would check if matched with their own.  If this happened both users would be emailed - seen below in the swift section - and flagged as a match, if not the process moved on.  </p><br/><br/>\$looper = mysql_query(\"SELECT * FROM BWL_users WHERE active LIKE '1' \"); <br />while (\$check = mysql_fetch_assoc(\$looper)) <br />{ <div class=\"indent_1\">\$c = \$check[\"yours\"];</div> <div class=\"indent_1\">\$resulting = mysql_query(\"SELECT * FROM BWL_users WHERE active LIKE '1' AND pick1 LIKE '\$c%' OR pick2 LIKE '\$c%' OR pick3 LIKE '\$c%' OR pick4 LIKE '\$c%' OR pick5 LIKE '\$c%'\");</div> <br /> <div class=\"indent_1\">while (\$row = mysql_fetch_assoc(\$resulting)) {</div> <div class=\"indent_2\">\$ry = \$row[\"yours\"];</div> <div class=\"indent_2\">for (\$i = 1; \$i <=5; \$i++) </div> <div class=\"indent_2\">{</div> <div class=\"indent_3\">\$p = \"pick\" . \$i;</div> <div class=\"indent_3\">if (\$check[\"\$p\"] == \$row[\"yours\"]) {</div> <div class=\"indent_4\">// Sending mail between two matches</div> <div class=\"indent_4\">\$varyours = \$c;</div> <div class=\"indent_4\">\$vartheirs = \$row[\"yours\"];</div> <br /> <div class=\"indent_4\">//include the swift class</div> <div class=\"indent_4\">include_once 'inc/php/swift/swift_required.php';</div> <br /> <div class=\"indent_4\">//put info into an array to send to the function</div> <div class=\"indent_4\">\$domain = '@Binghamton.edu';</div> <div class=\"indent_4\">\$varyours .= \$domain;</div> <br /> <div class=\"indent_4\">\$info = array(</div> <div class=\"indent_5\">'yours' => \$varyours,</div> <div class=\"indent_5\">'key' => \$vartheirs);</div> <br /> <div class=\"indent_4\">//Begin Send Match Email</div> <div class=\"indent_4\">if(send_email(\$info)) {</div> <div class=\"indent_5\">\$up = \$check[\"\$p\"] . \"!\";</div> <div class=\"indent_5\">mysql_query(\"UPDATE BWL_users SET \$p='\$up' WHERE yours='\$c'\");</div> <div class=\"indent_5\">for (\$j = 1; \$j <=5; \$j++) {</div> <div class=\"indent_6\">\$pu = \"pick\" . \$j;</div> <div class=\"indent_6\">if (\$row[\"\$pu\"] == \$c) {</div> <div class=\"indent_7\">\$upm = \$row[\"\$pu\"] . \"!\"; </div> <div class=\"indent_7\">mysql_query(\"UPDATE BWL_users SET \$pu='\$upm' WHERE yours='\$ry'\");</div> <div class=\"indent_6\">}</div> <div class=\"indent_5\">}</div> <div class=\"indent_4\">} //End Send Mail</div> <div class=\"indent_3\">}</div> <div class=\"indent_2\">}</div> <div class=\"indent_1\">}</div> }"),
array("1x1","WatsGood App","First iOS experience!","An iOS 5 Frequent Visitors app which I was contracted to develop.","WatsGood-1x1.jpg","2x1","2x2","WatsGood_Cover.jpg","1","1",'','<h3><b><u>XCode 4.1 & The Experience</u></b></h3> <br/> <img class="Full_Width" src="assets/img/Portfolio/Tiles/WatsGood_Xcode.jpg" /> <p>Above: The Building of the Registration UI in XCode 4.1.</p>
			<br/><h3><b>Beta & Source Code</b></h3>
			<div class="File_Tile"><a class="light" href="./Files/WatsGood/WatsGood_Beta.ipa" target="_blank"><div class="File_icon site"></div>.IPA</a></div>
			<div class="File_Tile"><a class="light" href="./Files/WatsGood/WatsGood_Beta.zip" target="_blank"><div class="File_icon site"></div>.ZIP</a></div>
			<br/><br/><p></p><div class="clear_both"></div>'),
);

/*array("1x1","OCCT Transit","Google Maps Transit","A conversion of the campus bus information to a google maps google transit feed.","OCCT-1x1.jpg","2x1","2x2","OCCT_Cover.jpg","1","1")*/

$Projects_Layout_Array = array(
	array(
		array("2x2","Text","1x1","2x1","2x2","IMG Alt text","<p>I had always been interested in making a useful digital scratch off since the advent of the touch-screen era.  While initially I was debating about creating an iOS scratcher game, the opportunity to invent a scratcher digital currency game came up one day.  After carefully learning the flaws and security of my co-founded digital dice game, and noticing that there were no competitors in the digital scratch off world, we decided to begin programming ScratchDoge!</p>
			<p>ScratchDoge was the accumulation of a months worth of mock-up designs to a working PHP game system. The project itself wasn't too much of a hassle. I built each sub-system at a time - Login/User Accounts, Withdrawals &amp; Deposits ScratchCard (JS), Betting Algorithm, Jackpot via WebSockets, Statistics &amp; Charts, in that respective order.</p>"),
		array("1x1","IMG","ScratchDoge_Card.jpg","2x1","2x2","ScratchOff Card",'Text'),
		array("1x1","IMG","ScratchDoge_List.jpg","2x1","2x2","List of Statistics",'Text'),
		array("1x1","IMG","ScratchDoge_Charts.jpg","2x1","2x2","Chart of User vs. House Profits",'Text'),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text","<h3><b>Statistics</b></h3>
			<p>All relevant game data is pulled from the database via PHP and outputted into a JSON file to prove our legitimacy by showing <em>transparency</em> of the games.</p>"),
		array("2x2","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>WebSockets</b></h3>
			<p>While learning with <a href="./?Project=ShibaDice.com">ShibaDice</a>, it quickly became apparent that directly loading data for every visitor was draining our servers resources.  In order to combat this we decided to solve this problem by outfitting both with WebSockets, starting with ScratchDoge.  The coding was straight-through and not too difficult, written in PHP using a simple ws:// request on the client side.  However the real dilemma was when we added our SSL-Cert and switched to WebSocket secure (wss://), as you cannot connect to an unsure WebSocket server (ws://) over https.</p>
			<p>It was found that our CDN (CloudFlare) only allowed set ports for WebSockets - some did not work! After trial and error of their ports, we were able to get the WebSockets up and running using 8880 and 8443. <a href="#Ports">*</a></p>'),
		array("2x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Security</b></h3>
			<p>As a monetary transactional service, security was the highest of priorities. Many catches have been set in place to <em>flag</em> and/or <em>block</em> any cheaters/hackers which may attempt to steal or falsify funds. All DBs locked down to local, all code checked/tested, all data <em>sanitized</em>, and stored in multiple places.</p>'),
		array("1x1","IMG","ScratchDoge_JackPot_Mobile.jpg","2x1","2x2","View of Jackpot Counter",''),
		array("1x1","IMG","ScratchDoge_Login_Mobile.jpg","2x1","2x2","Login Box",''),
		array("1x1","IMG","ScratchDoge_ExamplePlay.jpg","2x1","2x2","Game Play Example",''),
		array("1x1","IMG","ScratchDoge_Redeem.jpg","2x1","2x2","Half Scratched Off Card",''),
		array("2x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>House Edge</b></h3>
			<p>The house edge was initially calculated via a formula in excel. It was fit around our set requirements to hold an average of a 1% house-edge based on a bell-curve. The formula was then broken down into two functions (win/lose) in PHP which takes a random value to determine the payout.</p>'),
		array("1x1","IMG","ScratchDoge_QR.jpg","2x1","2x2","Deposit QR code",''),
		array("1x1x0","Text","","","","",''),
		array("1x1","IMG","ScratchDoge_Edge_Excel.jpg","2x1","2x2","House Edge Curve in Excel",'')
	), array(
		array("1x2","IMG","1x1","ShibaDice_Mobile.jpg","2x2","Mobile View of ShibaDice",''),
		array("2x1","Text","1x1","2x1","2x2","IMG Alt text",'<p>ShibaDice is a Dogecoin probability dice game written in PHP. It is currently in its <em>fourth</em> major revision since the original basic script and includes a responsive sleek UI and fluid flow of live game data via a 101 Secure WebSocket Protocol (<em>wss://</em>). Among other custom upgrades are the referral, deposit, and withdrawal systems.</p>'),
		array("2x1","IMG","1x1","ShibaDice_List.jpg","2x2","List of current games",''),
		array("1x1","IMG","ShibaDice_WebSockets.jpg","2x1","2x2","Web Socket 101 Connection",''),
		array("1x1","IMG","ShibaDice_Referral.jpg","2x1","Circuit-2x2.jpg","Referral Modal Box",'Text'),
		array("2x2","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Live Games (WebSockets)</b></h3>
			<p>WebSockets were so much easier to implement into revision 4 of ShibaDice since it was already completed on <a href="./?Project=ScratchDoge.com">ScratchDoge (more details here)</a>. With the previous CloudFlare port issue sorted out, I could focus my attention on getting games to update in real-time.  In revision 3 and below, the games were updated directly from a PHP script via Ajax every minute, or time the user played a game. However, this killed server resources and all game play was never true real-time.  By modifying the PHP WebSocket Servers output, it was possible to push all game data straight into the HTML every time a game was played. This way, each game pushed its details to every client connected to the socket server. Fast and efficient data usage, with a beautiful looking update! </p>'),
		array("2x2","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Referral System</b></h3>
			<p>While the current revision shares much of its back-end with ScratchDoge now, the referral system is an exclusive to ShibaDice.  As the crypto-dice game world is filled with all sorts of variants, it was made apparent that Shiba needed something unique.  Thus a referral system was born, at the time with a 20% referral rate, to allow users to invite people to make a heavy profit.</p>
			<p>Each user is assigned two IDs - one to identify the user (referral ID), with the second being the referred ID (attaching a user to the referee).  By simply following a URL with the referral attached, any new user who clicked that link would be permanently attached to the person who referred them. Now each game played, if that user was referred, a percentage would be given to the original referee.</p>'),
		array("1x1","IMG","ShibaDice_Bet.jpg","2x1","2x2","View of Bet Layout",''),
		array("1x1","IMG","ShibaDice_Login.jpg","2x1","2x2","Login Box",''),
		array("2x2","IMG","1x1","2x1","ShibaDice_QR.jpg","Despot QR Code",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Withdrawal</b></h3>
			<p>An Ajax request sends the data (user, amount, address) to a PHP script which checks for <em>validity</em>. The coins are then transferred automatically.</p>'),
		/*Security checks and Time lockouts per user keeps potential hacks from flooding the withdrawal script.*/
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Deposit</b></h3>
			<p>Deposits are made quickly by scan-able <em>QR codes</em>, or by using the provided address. A whole write-up on the new deposit system can be found <a href="./?Project=ScratchDoge.com#Deposits">here</a>.</p>'),
		array("2x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>NGINX & HTTPS</b></h3>
			<p>	rewrite ^ https://shibadice.com$request_uri? permanent; listen 443; ssl on;</p>
			<p>Having a secure connection when dealing with currencies is always a must. Setting this up in Nginx, is a quick configuration edit and reboot. <a href="http://thomasmccaffery.com/?Articles=Nginx-HTTPS">Read More.</a></p>'),
		array("1x1","IMG","ShibaDice_HTTPS.jpg","2x1","2x2","TLS 1.2 HTTPS Connection",'')
	), array( 
		array("2x2","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>EXIF Data</b></h3>
			<p>Most images contain tons of meta-data within them from aperture, camera model, to even GPS location! This data can be useful for any number of things, but in this case, it was just used as a proof of concept.  Perhaps you wanted to know more about an image, or find where it was taken (assuming it had GPS data). A quick upload and the script analyses the EXIF by looping through each data tag and outputting it into the browser.</p>
			<p>All EXIF data can be viewed on a computer by clicking into the photos properties and then going to the Details section.  Data is usually broken down into the following categories:  Description (Name), Image (Size), Camera (About the Camera), GPS, Advanced Photo (Sharpness), File (Filename).</p>'),
		array("1x1","IMG","EXIF_GPS.jpg","2x1","2x2","Example of APp: Sydney Opera House on Google Maps.",''),
		array("1x1","IMG","EXIF_Hierarchy.jpg","2x1","2x2","EXIF hierarchy breakdown",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Google Maps</b></h3>
			<p>Photos uploaded with GPS EXIF data are mapped to show the location it was taken using Google maps API.</p>'),
		array("1x1","IMG","EXIF_Ex.jpg","2x1","2x2","Example of App: Brooklyn on Map.",''),
		array("2x2","Text","1x1","2x1","2x2","IMG Alt text","<h3><b>PHP Import</b></h3>
			<p>Using a file-type html form input, the image is selected by the user.  The image is then uploaded to the server into to a temporary image folder. Once uploaded the PHP script checks for, then reads the EXIF data using a function written named 'getGPS'.</p>
			<p>getGPS() returns a JSON array of each data tag received via the 'exif_read_data' PHP function. For reference: \$exif['GPSLatitude'][0]; would yield the Latitude in Degrees, all 6 GPS data-tags (Degrees, Minutes, Seconds) and converted to two latitude, longitude numbers which are put into the Google API to map. Additional data is pulled out such as camera model (checking if it exists in the array via @array_key_exists('Model', \$exif)) then pulling it out using \$exif['Model']. </p>"),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text","<h3><b>iOS Issue</b></h3>
			<p>GPS won't show due to the way iOS works; Any picture that is uploaded from iOS is stripped of most its EXIF data for user privacy (says Apple).</p>"),
		array("1x1","IMG","EXIF_NoGPS.jpg","2x1","2x2","Example of App: No GPS Data",'')
	), array(
		array("1x1","IMG","MobileWeather_Bar.jpg","2x1","2x2","View of weather App",''),
		array("1x1","IMG","MobileWeather_Local.jpg","2x1","2x2","Local weather view of NYC",''),
		array("2x2","Text","1x1","2x1","2x2","IMG Alt text","<h3><b>Google Maps</b></h3>
			<p>Thanks to Google's v3 maps JavaScript API, adding maps and weather lay-over could not be simpler! Adding the maps is simple, just hit the Google developers page, and copy the required links into your web-page.</p>
			<p>To gain access to weather data and location searches, all one must do is add 'libraries=weather,places' to the end of the maps JavaScript URL in their code.  By doing so, the page gains access to all weather data, including 5-day forecast which was necessary, as well as location searching.  </p>
			<p>weatherLayer = new google.maps.weather.WeatherLayer({
			temperatureUnits: google.maps.weather.TemperatureUnit.FAHRENHEIT});
			weatherLayer.setMap(map);</p>"),
		array("1x1","IMG","MobileWeather_Search.jpg","2x1","2x2","Searching for Newport on auto-populate search bar",''),
		array("1x1","IMG","MobileWeather_National.jpg","2x1","2x2","National Weather View of App",''),
		array("2x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Bootstrap</b></h3>
			<p>Twitters Bootstrap is an easy to use open-sourced front-end framework. By dropping in the required css and JS files, anyone can create beautiful looking designs.  Bootstrap helped cut down time on this project by taking the design and layout work out of the way.  </p>'),
		array("1x1","IMG","MobileWeather_Settings.jpg","2x1","2x2","View of 5-day forecast on map",'')
	), array(
	), array(
		array("1x2","IMG","1x1","BitQuick_Mobile.jpg","2x2","Mobile View of BitQuick",''),
		array("2x2","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>How It Works</b></h3>
			<p>As a US FinCen Regulated and Legal (at the time) Bitcoin Exchange, BitQuick was quite the undertaking.  The service allowed for users to exchange originally between MoneyPak (PrePaid Debit) and Bitcoins, however eventually added credit card support. </p>
			<p>All that was needed was for a user to sign up, confirm their registration, and they were on their way to trading.  A limit set in place lowered the chance of fraud, and all transactions were logged in MySQL for any future use or needs by the federal government.  Trades were as simple as typing in the amount you wanted to convert. Using JavaScript, the value was converted on the fly and once submitted a PHP script took care of sending the proper funds using the BalancePayments and Coinbase APIs. </p>'),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Responsive Design</b></h3>
			<p>Beautifully scaling page which conforms to fit any screen size perfectly while keeping everything in a clean, legible format.</p>'),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Closed</b></h3>
			<p>Due to pending government regulations, and lack of clarity in laws, we decided to close BitQuick at the end of the summer of 2012.</p>'),
		array("1x1","IMG","BitQuick_Send.jpg","2x1","2x2","Deposit QR Code",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Deposits</b></h3>
			<p>Easily deposit funds from the easy to scan uniquely generated QR-Code, or BTC deposit address. </p>'),
		array("1x1","IMG","BitQuick_Convert.jpg","2x1","2x2","Converting of 1 BTC to $95 USD",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Limits</b></h3>
			<p>To prevent fraud and hackers, a limit level was placed upon each account based on time and trade volume.</p>'),
		array("2x2","IMG","1x1","2x1","BitQuick_Account.jpg","User Account layout, featuring limits, all transactions, and quick access to orders",''),
		array("1x2","Text","1x1","2x1","2x2","IMG Alt text","<h3><b>Coinbase APIs</b></h3>
			<p>By connecting to Coinbase through their API, BitQuick was able to handle all Bitcoin transactions. The service made sending and receiving easy and as simple as sending short JSON strings from our PHP script to conduct a transfer.</p>"),
		array("2x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>BalancedPayments APIs</b></h3>
			<p>Using the payment processor API allowed BitQuick to be able to take credit/debit card payments with ease.  By hooking it into our PHP script, once transactions were approved, the card was either charged or credited based on which direction the trade was being placed with only a 1% fee.</p>'),
		array("2x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>API Limits</b></h3>
			<p>Requests for the MtGox API at the time exceeded the call limit of five (5) requests per minute.</p>
			<p>By creating a PHP script to archive the exchange rate every half-minute into our DB, BitQuick was able to prevent the API lockout.</p>'),
		array("1x1","IMG","BitQuick_Balanced.jpg","2x1","2x2","PHP example of connecting to BalancedPayments API",''),
		array("1x1","IMG","BitQuick_API_Limit.jpg","2x1","2x2","MtGox API Limits",''),
		array("1x2","IMG","1x1","BitQuick_Card.jpg","2x2","Design of BitQuick Card",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>BitQuick Card</b></h3>
			<p>Our custom card solution; we were in the process of allowing users to receive our custom printed debit card for quick and east Bitcoin transfers.</p>'),		
	), array (
		array("2x2","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Bitcoin APIs</b></h3>
			<p>Originally when MtGox was the go-to standard of the Bitcoin trading world, BTConverter used MtGoxs JSON API to gain access to the current exchange rates. But as the company has fallen off the wagon and crashed, BTConvert now uses the BitStamp API.</p>
			<p>As the WebApp is meant to be lightweight, it is only a two field form for Dollar or Bitcoin value, which when typed into one, the other is populated with the converted currency value.  The input value is pushed into the function XChange(), which takes the value and which box it was taken from, and then call upon BitStamps API URL to get the JSON array which holds to exchange rates.  The exchange rate is then either multiplied to (from USD) or divided by (BTC) to get the proper money conversion. </p>'),
		array("1x1","IMG","BTConvert_Code.jpg","2x1","2x2","JavaScript cod example of currency conversion",''),
		array("1x1","IMG","BTConvert_Cash.jpg","2x1","2x2","Example of App: Converting 1 USD to 0.018 BTC",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>New API</b></h3><p>Due to the Mt.Gox collapse, the API was switched to BitStamp. But in the BitQuick.net pictures you can see how low Bitcoins use to be!</p>'),
		array("1x1x0","Text","","","","",''),
		array("2x1","Text","1x1","2x1","2x2","IMG Alt text",'
		<h3><b>Converter JS Code:</b></h3>
		<div style="font-size: 1.5rem;">
		function XChange(val,type) {
		<br/>$.getJSON("https://api.bitcoinaverage.com/ticker/USD/", function(json) {
			<div class="indent_1">if(type==1) {</div>
			<div class="indent_2">var Rate = addCommas((val/json.last).toFixed(4));</div>
			<div class="indent_2">document.getElementById("BTCval").value=Rate;</div>
			<div class="indent_1">} else if(type==2) {</div>
			<div class="indent_2">var Rate = addCommas((val*json.last).toFixed(2));</div>
			<div class="indent_2">document.getElementById("USDval").value=Rate;</div>
			<div class="indent_1">} } }</div>
		</div>
		')
	), array(
		array("2x1","IMG","1x1","K25Designs_Details.jpg","2x2","View of individual photo example page",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Swipe Support</b></h3><p>Easily browse the portfolio by swiping left/right, or using the arrow keys!</p>'),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Responsive</b></h3><p>Scales to any sized window while keeping images at a 1:1 aspect ratio and keeping font sizes legible.</p>'),
		array("1x2","IMG","1x1","K25Designs_Mobile.jpg","2x2","Mobile View of K25Designs.com",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>CSS3 Transforms</b></h3><p>Using :hover with CSS3 transforms, details pop as everything appears to grow when you focus on images and links.</p>'),
		array("1x1","IMG","K25Designs_Resume.jpg","2x1","2x2","View of Resume Page",''),
		array("2x2","IMG","1x1","2x1","K25Designs_Front.jpg","Grid Layout Design",''),
	), array(
		array("2x1","Text","1x1","1x2","2x2","IMG Alt text",'<h3><b>About</b></h3><p>Originally created when I had an iPhone 3G at 3G speeds; websites took forever to load! I realized most of the time all I needed was the text for a quick read.  So a WebApp was built using PHP to strip either the images or everything except text. Loading time was cut from minutes to seconds!</p>'),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Curl</b></h3><p>Using PHPs Curl function, the received website is pulled into the script and stripped of all images and/or JavaScript and tags.</p>'),
		array("1x1","IMG","3Ger_Code.jpg","2x1","2x2","PHP Curl Code Example",''),
		array("1x2","IMG","1x1","3Ger_Mobile.jpg","2x2","Example of 3Ger displaying cnn.com",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Example(s)</b></h3><p>As can be seen on this page, CNN.com is stripped to only show the pages text, while Digg.com is only stripped of its images.</p>'),
		array("1x1x0","Text","1x1","2x1","2x2","IMG Alt text",''),
		array("2x2","IMG","1x1","2x1","3Ger_StripImages.jpg","Example of 3Ger displaying digg.com",'')	
	), array(
		array("1x1","IMG","GGM_Drupal.jpg","2x1","2x2","Drupal Logo",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Drupal 7</b></h3><p>Converted entire site to a dynamic highly customizable Drupal 7 Content Management System from their static HTML page.</p>'),
		array("2x1","IMG","1x1","GGM_RiseButton.jpg","2x2","Social Media icons which rise when hovered upon",''),
		array("1x1","IMG","GGM_Layout.jpg","2x1","2x2","Drupal Block Layout Design",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Rising Social Media</b></h3><p>Using some basic CSS, we are able to make the social media icons float with :hover and margin-bottom attributes!</p>'),	
		array("1x2","IMG","1x1","GGM_Twitter.jpg","2x2","Sidebar Twitter Feed",''),
		array("2x2","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>At a Glance</b></h3>
			<p>Converting to a content management system (CMS) replaces the need for a consistent web developer for a small company who contracted out.  Once implemented, even the least technical person was able to log into the back-end and make any quick changes, or even manage/add content with ease!</p>
			<p>Converting the whole site only took a week, and included many additional modules which were not possible and/or present on the previous version of the site. Including live twitter feeds, live radio streams, and front-end editable content.</p>'),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Interactive Blog</b></h3><p>Using Drupals blog pages, an interactive blog was set-up, which automatically posted to twitter, facebook, and pinterest using each API.</p>'),
		array("1x1","IMG","GGM_Blog.jpg","2x1","2x2","Blog page",''),
		array("1x1","IMG","GGM_YouTube.jpg","1x2","2x2","View of Youtube channel with videos I created",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>YouTube</b></h3><p>Videos or "Visual Slideshows" were created for each radio show produced. Each video was then pushed out to all the social media outlets.</p>'),
		array("1x2","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Crawler</b></h3><p>Web-crawler developed in PHP to build a list of potential businesses only given a domain name. Data was parsed then organized into MySQL. Creating a list of 5,200 companies for future calls in less than a minute. Compared to the old way in which employees clicked through pages to find the number.</p>'),
		array("2x1","IMG","1x1","GGM_Crawler.jpg","2x2","Partial PHP Code Example of Web Crawler",'')
	), array(
		array("2x2","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>About</b></h3>
			<p>The Social Media Center was a pet project that I had created while at Genesis Global Media, to allow for quick views of all client work progress.  While working there, there was often a lack of communication as to what was going on with which project, and how far along it was. So the solution I came up with one night, was to consolidate all that information into one place on the back-end that all employees could access to keep track of the progressions.</p>
			<p>Using the Facebook and Twitter APIs the SMC pulled data hourly for each user via a PHP Cron script, and stored that data in a database. Once in the database it could be used to track how far along each user had progressed in details such as likes, followers, comments, and more. </p>'),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>HighCharts</b></h3><p>High Charts (JS) were used to plot daily social media information using the Facebook and Twitter APIs.</p>'),
		array("1x1","IMG","GGMSMC_Charts.jpg","2x1","2x2","JavaScript HighCharts of social media users",''),
		array("1x1","IMG","GGMSMC_AddUser.jpg","2x1","2x2","Form to add users to the media center",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Add a Client</b></h3><p>Just click and enter their social media usernames. A site-wide password was put in place so people could not abuse the system.</p>'),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>At a Glance</b></h3><p>Each client had its own subsection detailing who was working on them, what had been previously done, and what the current progress was.</p>'),
		array("1x1","IMG","GGMSMC_Info.jpg","2x1","2x2","Example of detailed breakdown of client progress",''),
		array("1x1","IMG","GGMSMC_Code.jpg","2x1","2x2","Example PHP code of facebook API",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Json + Curl</b></h3><p>Data was extracted from the APIs JSON response using Curl in PHP. It was then placed into a MySQL database for statistical use by the media center.</p>')
	), array(
		array("2x1","IMG","1x1","Groscost_Carousel.jpg","2x2","Carousel Header shown scrolling through images",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Ease of Use</b></h3><p>As required, the clients website was built using WordPress to allow for easy management and quick learning.</p>'),
		array("1x1","IMG","WordPress.jpg","2x1","2x2","WordPress Logo",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Carousel Header</b></h3><p>A slightly customized WordPress plugin was used to display the main content headers as a rotating image carousel.</p>'),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Responsive Design</b></h3><p>With a responsive design, the site looks good on all screen sizes! Everything is scaled to fit the view-port nicely.</p>'),
		array("1x2","IMG","1x1","Groscost_Mobile.jpg","2x2","Mobile View on iPhone",''),
		array("2x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Daily Feed</b></h3><p>Content Management for the non-technical; WordPress makes posting easy! A feed was put front and center, along with instant share links so that users could share their favorite articles right away!</p>'),
		array("1x1","IMG","Groscost_SocialMedia.jpg","2x1","2x2","Social Media and Search Sidebar",''),
		array("1x1","IMG","Groscost_Article.jpg","2x1","2x2","Recent Articles View",'')
	), array(
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Ease of Use</b></h3><p>As required, the clients website was built using WordPress to allow for easy management and quick learning.</p>'),
		array("1x1","IMG","WordPress.jpg","2x1","2x2","WordPress Logo",''),
		array("2x1","IMG","1x1","BonnieGP_Carousel.jpg","2x2","Scrolling Image Carousel Header",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Carousel Header</b></h3><p>A slightly customized WordPress plugin was used to display the main content headers as a rotating image carousel.</p>'),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Social Media</b></h3><p>A twitter feed was added to the sidebar to show daily tweets being made through Genesis Global Media, as it was part of their package.</p>'),
		array("1x2","IMG","1x1","BonnieGP_SideBar.jpg","2x2","Sidebar featuring social media buttons, recent articles, and twitter feed",''),
		array("2x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Daily Feed</b></h3><p>Content Management for the non-technical; WordPress makes posting easy! A feed was put front and center, along with instant share links so that users could share their favorite articles right away!</p>'),
		array("1x1","IMG","BonnieGP_Posts.jpg","2x1","2x2","Recent Article Entries",'')
	), array(
		array("1x2","Text","1x1","2x1","2x2","",'<h3><b>About</b></h3><p>During 2011 in college, Google transit was starting to pop up everywhere. I had used it plenty of times in the city and wanted to make getting to campus from my apartment, or around Binghamton much easier!</p> <p>Creating a Google Transit Feed was not too difficult. </p>'),
		array("2x1","IMG","1x1","OCCT_Triple_Cities.jpg","2x2","Binghamton Universities 2011 Triple Cities OCCT Bus Route",''),
		array("1x1","IMG","OCCT_Logo.jpg","2x1","2x2","OCCT Bus Logo",''),
		array("1x1","Text","1x1","2x1","2x2","",'<h3><b>Never Added</b></h3><p>Google required the official bus company to publish the feed, but the Bus eBoard did not feel it was important enough to add. </p>'),
		array("1x1","Text","1x1","2x1","2x2","",'<h3><b>Schedule</b></h3><p>This is how it all started. A list of stops and times for each route on a pdf.</p>'),
		array("1x1","IMG","OCCT_Schedule.jpg","2x1","2x2","PDF view of Bus Schedule",''),
		array("2x1","Text","1x1","2x1","2x2","",'<h3><b>Data Points</b></h3><p>All bus stop locations were recorded using Google maps to get the closest GPS coordinate per spot. Shown below are these data points for one bus route. Once put together into a Google Transit Feed (GTFS), the maps would automatically connect the way-points to generate the transit maps.   </p>'),
		array("1x1","IMG","OCCT_Excel_Plots.jpg","2x1","2x2","Excel View of Bus Stops",''),
		array("1x1","IMG","OCCT_Excel_Stops.jpg","2x1","2x2","Excel View of Bus Stations",''),
		array("2x1","IMG","1x1","OCCT_Directions.jpg","2x2","Map of different directions a bus can take based on time",''),
		array("2x1","Text","1x1","2x1","2x2","",'<h3><b>Direction</b></h3><p>Bus routes are all optimized for certain times of the day, usually split between morning, school hours, late-night runs, and weekends. These differences are visually represented on the maps with a shaded line off the original route line and by arrows. </p>'),
		array("1x1","Text","1x1","2x1","2x2","",'<h3><b>Pop Up</b></h3><p>Click on a bus stop for more information about the stops physical location and any exclusions from routes. </p>'),
		array("1x1","IMG","OCCT_Pop_Up.jpg","2x1","2x2","Bus Stop clicked pop-up with information",''),
		array("1x1","IMG","OCCT_Validation.jpg","2x1","2x2","Validation success screen of GTFS",''),
		array("1x1","Text","1x1","2x1","2x2","",'<h3><b>Validation</b></h3><p>Using Googles open GTFS validation, debugging transit feeds are made simple!</p>'),
	), array(
		array("1x1","IMG","BigHeartBridges_Logo.jpg","2x1","2x2","BigHeartBridges Logo",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>BigHeartBridges</b></h3><p>A charity which helps the disabled and their family members. WordPress Layout was customized for them, as well as the Logo I had created.</p>'),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Responsive Design</b></h3><p>With a responsive design, the site looks good on all screen sizes! Everything is scaled to fit the view-port nicely.</p>'),
		array("1x1","IMG","BigHeartBridges_Carousel.jpg","2x1","2x2","Image Scrolling Carousel Header",''),
		array("1x2","IMG","1x1","BigHeartBridges_Mobile.jpg","2x2","Mobile view on iPhone",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Carousel Header</b></h3><p>A slightly customized WordPress plugin was used to display the main content headers as a rotating image carousel.</p>'),
		array("1x1","IMG","BigHeartBridges_SocialMedia.jpg","2x1","2x2","Design of Flat UI Social Media icons",''),
		array("2x2","IMG","1x1","2x1","BigHeartBridges_Bottom.jpg","Overview of Website",''),
		array("1x2","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Ease of Use</b></h3><p>As required, the clients website was built using WordPress to allow for easy management and quick learning.</p>'),
		array("1x1","IMG","WordPress.jpg","2x1","2x2","WordPress Logo",'')
	), array(
		array("1x2","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>About</b></h3><p>A small solar company contracted me to build a landing page for potential investors to quickly read up about them.</p>'),
		array("2x1","IMG","1x1","Cenergy_Green.jpg","2x2","Clean Green Energy Market Overview",''),
		array("1x1","IMG","Cenergy_Table.jpg","2x1","2x2","Company data in drop-down tables",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Data Tables</b></h3><p>The ability to show crucial data in a drop-down categorized table always keeps potential investors happy.</p>'),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<p>*The current site link is a mirror and may be missing minor features the live version had, such as links unfinished on the bottom.</p>')
	), array(
		array("1x1","IMG","EyesEverywhere_Icon.jpg","2x1","2x2","App Icons",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>AppStore</b></h3><p>After a two (2) week review period, and was approved  on its first submission and appeared on the AppStore in October 2011.</p>'),
		array("2x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>About</b></h3><p>Made for the iPhone 4 (most recent at the time) and below running iOS 5, EyesEverywhere was an attempt to practice my Objective-C programming abilities, while creating a unique start up.  However UI was my crux, and did not gain much following with only 127 active users.</p>'),		
		array("1x1","IMG","EyesEverywhere_Register.jpg","2x1","2x2","User Registration",''),
		array("1x1","IMG","EyesEverywhere_Home.jpg","2x1","2x2","App Home Screen",''),
		array("1x2","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Users & GPS</b></h3><p>Users would be greeted with a list of all current requests, or could switch to local requests using GPS triangulation to within 20 miles using the greater circle distance formula from the iPhones origin.</p>'),
		array("1x1","IMG","EyesEverywhere_Portfolio.jpg","2x1","2x2","User Portfolio View",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Portfolio</b></h3><p>A dedicated <em>portfolio tab</em> was crafted for users to view their active requests, favorites, and account settings.</p>'),
		array("1x2","IMG","1x1","EyesEverywhere_Mobile.jpg","2x2","Login Screen on iPhone 5",''),
		array("2x2","IMG","1x1","2x1","EyesEverywhere_Mobile_Display.jpg","View of three iPhones with Request Page (left), Home Screen (center), Found Photo (right).",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text","<h3><b>Requests</b></h3><p>Users post their questions title, description, and attach photos in the <em>request tab</em>; Which uploads the data to the server via PHP script.</p>"),
		array("1x1","IMG","EyesEverywhere_Requests.jpg","2x1","2x2","User Request View",''),
		array("1x1","IMG","EyesEverywhere_SocialEvo.jpg","2x1","2x2","Social Evolution Tab",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Social Evolution</b></h3><p>An entirely dedicated portal for users to leave feedback as to what they wanted the App to change into, add, or remove.</p>'),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Hits</b></h3><p>All users requests are displayed in the card format below, allowing others to read and/or answer with the found button.</p>'),
		array("1x1","IMG","EyesEverywhere_Details.jpg","2x1","2x2","Hits View, showing users request",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Spotted</b></h3><p>When a user wishes to answer a request, they may type up the answer in the text field and attach photos.</p>'),
		array("1x1","IMG","EyesEverywhere_Spotted.jpg","2x1","2x2","Spotted Tab",''),
		array("1x1","IMG","EyesEverywhere_Attached.jpg","2x1","2x2","Found Tab, showing the users request was answered with an attached photo.",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Found</b></h3><p>When a request is answered, Pictured Above, the attached photos are displayed with the details below it.</p>'),
	), array(
		array("1x1","IMG","BingEBooks_DropDown.jpg","2x1","2x2","Drop-down search",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Search</b></h3><p>Each book was broken down by Specific <em>Major</em> then by the subsequent <em>Class Number</em> in an easy navigational drop-down menu.</p>'),
		array("2x1","IMG","1x1","BingEBooks_PayPal.jpg","2x2","PayPal Book Purchase Example",''),
		array("1x1","IMG","BingEBooks_Book.jpg","2x1","2x2","Example of engineering book for sale",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Books</b></h3><p>Every books Title, Author, Edition, Cover, and Cost was displayed. As well as the PayPal button to purchase.</p>'),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>PayPal</b></h3><p>Using PayPal as a payment processor made selling the books in a market place setting easy as can be.</p>'),
		array("1x1","IMG","BingEBooks_Alt_Book.jpg","2x1","2x2","Example of chemistry book for sale",''),
		array("2x2","IMG","1x1","2x1","BingEBooks_Front.jpg","Front Page Grid Layout",''),
		array("2x2","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>About</b></h3>
			<p>BingBooks was created back in 2009 in an attempt to set-up a digital eTextBook store front.  This was before the invention of iTunes University, Amazon Textbooks, or even the whole books on a PDF controversy.  As can be seen by the horrendous design, 2009 was still early development years for myself as a web developer. This website is so old that the buying tutorial animation was an adobe flash swf video. However using just HTML and PayPal the marketplace was born, and that launched that Fall semester. Users just needed to select the Class Major, followed by the Class Number, and the book would pop right up.  A PayPal click away from being purchased. Once purchased a PHP script would send the book to the email provided by PayPal.</p>'),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Requests</b></h3><p>A quick form at the top allowed potential buyers to type in the necessary information needed to request a book which was not available.</p>'),
		array("1x1","IMG","BingEBooks_Request.jpg","2x1","2x2","eBook requests page",''),
		array("1x1","IMG","BingEBooks_FAQs.jpg","2x1","2x2","FAQs view",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>FAQs</b></h3><p>Users always have questions, and we had answers. All located in one tidy list.</p>')
	), array(
		array("1x2","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Idea</b></h3><p>Only students with a @Binghamton.edu emails were allowed to participate, in which they selected five (5) other students they wanted to be matched up with before they graduated. Once the form was filled out, and confirmed, a script was run daily to check if any students matched up with other students. </p>'),
		array("1x1","IMG","LCBU_Form.jpg","2x1","2x2","User form to fill out",''),
		array("1x1","IMG","LCBU_HowTo.jpg","2x1","2x2","3 Step tutorial",''),
		array("1x1","IMG","LCBU_SQL_Prep.jpg","2x1","2x2","Code Example of SQL sanitation",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Security</b></h3><p>All data was sanitized in the PrepSQL() function to prevent SQLinjects, which was attempted multiple times each day.  </p>'),
		array("1x2","IMG","1x1","LCBU_Mobile.jpg","2x2","Mobile View",''),
		array("2x1","IMG","1x1","LCBU_Confirm.jpg","2x2","Confirmation Email",''),
		array("2x1","IMG","1x1","LCBU_Confirm_Code.jpg","2x2","PHP Code example of confirmation",''),
		array("1x2","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Confirm</b></h3><p>Once the user submits the form, the Swift PHP mailer sent a confirmation to the email asking to confirm.  Inside the email was a randomized confirmation code and URL which when visited activated the user.  Once activated, the user was added to the queue list and checked daily for matches.</p>'),
		array("2x2","IMG","1x1","2x1","LCBU_Insert_Picks.jpg","Code Example of inserting picks into database",''),	
	), array(
		array("2x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>WatsGood</b></h3><p>Contracted to build an iOS App for iOS 3.0+ with zero experience in 3 months proved to be quite the learning experience.  WatsApp was a frequent visitors App, which allowed users to gain access to coupons and rewards by checking into participating venues around Binghamton.</p>'),
		array("1x1","IMG","WatsGood_Logo.jpg","2x1","2x2","WatsGood App Logo",''),
		array("1x1","IMG","WatsGood_Login.jpg","2x1","2x2","Login Screen",''),
		array("1x1","IMG","WatsGood_Register.jpg","2x1","2x2","User Registration View",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Register</b></h3><p>Simple as can be, fill out the form, the data is sent to the database and users are on their way to great local deals and reviews!</p>'),
		array("1x1","IMG","WatsGood_Home.jpg","2x1","2x2","Home View",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Home Screen</b></h3><p>Each of the options would open into a sub-list of local places based on the choice. The <em>roll up</em> button allowed for a quick <em>check-in</em> to the location. </p>'),
		array("2x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Bars</b></h3>
			<p>Every bar had its own detail card which showed popularity, reviews, and a frequent visitors system. Each day a user visited the bar and checked in from the App, it was checked by GPS and recorded in the database.  Once the bars threshold for visits was met, the user was awarded a reward, such as a free drink.</p>'),
		array("1x1","IMG","WatsGood_Bar.jpg","2x1","2x2","Bar View, showing details and reviews of bar",''),
		array("1x1","IMG","WatsGood_Redeemed.jpg","2x1","2x2","View of Redeemed Free Drink",''),
		array("2x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Restaurants</b></h3>
			<p>Each restaurant had its own card with details with a five-star rating system, coupons, and comments.  Once inside the restaurant users could click "redeem" to show the current coupon. This was done through a geo-fence GPS formula I wrote using the four corners of the building.</p>'),
		array("1x1","IMG","WatsGood_Redeem.jpg","2x1","2x2","View of Restaurant card",''),
		array("1x1","IMG","WatsGood_Coupon.jpg","2x1","2x2","View of coupon redeemed at restaurant",''),
		array("1x1","Text","1x1","2x1","2x2","IMG Alt text",'<h3><b>Lists</b></h3>
			<p>Each of the three categories (Bars, Restaurants, Frats) once clicked revealed a list of places for that specific category. </p>'),
		array("1x1","IMG","WatsGood_Bar_List.jpg","2x1","2x2","Tab view of list of available bars",''),
		array("1x1","IMG","WatsGood_Named.jpg","2x1","2x2","Secondary Logo",''),
		array("1x1","Text","2x1","2x1","2x2","IMG Alt text",'<h3><b>Objective-C</b></h3>
			<p>Pictured is a code sample of the text input field.  If text is submitted it is converted then uploaded to the database via the server side PHP script.</p>'),
		array("2x2","IMG","1x1","2x1","WatsGood_Code.jpg","Objective-C code example in XCode of comment uploads.",''),		
	)
);
 
 /* Each Article Must have 3 images a 1x1, 2x2, and cover for each case of the layout */
 /* array("Size","Title","Secondary_Title","Blurb","1x1","2x1","2x2","Cover","HTML") */
 /*
 1x1-400x400
 2x1-800x400
 2x2-800x800
 Cover-1810x874
 */

$Articles_Array = array(
array("1","Websockets and Cloudflare","STunnel Saviour and Ports","Needing to use websockets with cloudflare proved to be a far greater challenge than initially expected.  Ports and STunnel solved this one.","WebSockets-1x1.jpg","","WebSockets-2x2.jpg","WebSockets-Cover.jpg","<b>Site Update In Progress...</b> <br/> Articles will be published shortly."),
array("1","iOS Issues","Mobile Safari's Issue!","Testing this website led to a serious mobile safari fault when it came to the drop-down navigation menu not working on URL queries.","DropDown-1x1.jpg","","DropDown-2x2.jpg","DropDown-Cover.jpg","<b>Site Update In Progress...</b> <br/> Articles will be published shortly."),
array("2","Responsive Fix","Masonry Layout QuickFick","While my layout worked flawlessly on several browsers and screens, some older browsers needed this quick-fix to display properly.","ResponsiveFix-1x1.jpg","","ResponsiveFix-2x2.jpg","ResponsiveFix-Cover.jpg","<b>Site Update In Progress...</b> <br/> Articles will be published shortly."),
array("1","Flexbox vs Block","Battle of the Layouts","Flexbox has some nice promises, however I find it slightly unresponsive in a grid.","FlexBlock-1x1.jpg","","FlexBlock-2x2.jpg","FlexBlock-Cover.jpg","<b>Site Update In Progress...</b> <br/> Articles will be published shortly.","1"),
array("1","Building a Scratchoff","","A quick overview of my experience in building up ScratchDoge's primary scratch-off functions.","Scratcher-1x1.jpg","1x2","Scratcher-1x1.jpg","Scratcher-Cover.jpg","<b>Site Update In Progress...</b> <br/> Articles will be published shortly."),
array("1","NYC Parking","Parking Maps and Big Data","Current thoughts and attempts at building a decent street parking app.","NYCParking-1x1.jpg","1x2","NYCParking-1x1.jpg","Parking-Cover.jpg","<b>Site Update In Progress...</b> <br/> Articles will be published shortly."),
array("1","Nginx HTTPS","Nginx HTTPS Tutorial","How to activate HTTPS on Nginx in a few simple steps.","HTTPS_NGINX-1x1.jpg","","HTTPS_NGINX-2x2.jpg","HTTPS_NGINX_Cover.jpg","<b>Site Update In Progress...</b> <br/> Articles will be published shortly.")
);

function searchFor($id, $array, $Loc) {
   foreach ($array as $key => $val) {
       if ($val[$Loc] === $id) {
           return $key; 
       }
   }
   return "no";
}

?>