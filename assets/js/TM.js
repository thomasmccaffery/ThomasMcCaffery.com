function resizeMe() {
	/* Scale Font */
	var htmD = $('html');
	var rsz = parseFloat(htmD.css('width'));
		if(rsz>=1258) { var scale = 0.0079; }
		else if(rsz>=599) { var scale = 0.01; }
		else { var scale = 0.01075; }
	htmD.css('font-size', (rsz*scale)+"px");
	
	/* Change Menu Height Offset */
	setTimeout(function() {
		var MHeight = $(".header").height();
		$("body").css("margin-top",(MHeight+15)+"px");
	}, 100);
}
		
$( document ).ready(function() {
	/* Resize Page */
	resizeMe();
	
	/* Hide Menu Bar - Mobile */
	$(".mobile-toggle").click( function(event){
		/*event.preventDefault();*/
		if($(".nav").hasClass("active")) {
			$("ul.nav").removeClass("active");
			$("#menu_Ico").removeClass("icon-cross").addClass("icon-list");
			setTimeout(function() { $("ul.nav").addClass( "left-align" ); }, 300);
		} else {
			$("#menu_Ico").removeClass("icon-list").addClass("icon-cross");
			$("ul.nav").addClass("active").removeClass( "left-align" );
		};
		return false;
	});
	
	/* Load Web Fonts */
	WebFontConfig={google:{families:["Lato:400,700,300,100,900:latin"]}};(function(){var a=document.createElement("script");a.src=("https:"==document.location.protocol?"https":"http")+"://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js";a.type="text/javascript";a.async="true";var b=document.getElementsByTagName("script")[0];b.parentNode.insertBefore(a,b)})();
	
	/* Key to change Portfolio Projects */
	function leftArrowPressed() {
		var prevPage = $("#prev_page");
		prevUrl = prevPage.attr("href");
		if((prevUrl!='./?Project=') && (prevUrl!='') && (prevUrl!=null)) {		
			window.location = prevUrl; 
		}		
	}

	function rightArrowPressed() {
		var nextPage = $("#next_page");
		nextUrl = nextPage.attr("href");
		if((nextUrl!='./?Project=') && (nextUrl!='') && (nextUrl!=null)) {
			window.location = nextUrl;  
		}
	}

	document.onkeydown = function(evt) {
		evt = evt || window.event;
		var path = window.location.search;
		var Port = new RegExp("Project\\=");
		switch (evt.keyCode) {
			case 37:
				if(Port.test(path)) { leftArrowPressed(); }
			break;
			case 39:
				if(Port.test(path)) { rightArrowPressed(); }
			break;
		}
	};
	
	/* Swipe to change Portfolio Projects */
	$("#Ajax_Container").swiperight(function() { leftArrowPressed(); });
	$("#Ajax_Container").swipeleft(function() { rightArrowPressed(); });

	/* Click to Top Bar */
	window.addEventListener("scroll",function() { 
	   if(window.scrollY > 500) { $('.Quick-Up').slideDown(); }
	   else { $('.Quick-Up').slideUp(); }
	},false);
	
	/* Form validation */
	$("#leave-submit").click( function(event){
		event.preventDefault();
		jQuery.ajax({
			url: 'assets/Ajax/sendmail.php',
			method: 'POST',
			data: $('#leave-message').serialize()
		}).done(function (response) {
			$('#contact-form-result').html(response);
			$('#contact-form-result').fadeIn(500); 
		}).fail(function () {
			$('#contact-form-result').html(response);
			$('#contact-form-result').fadeIn(500); 
		});
	})
});

$( window ).resize(function() {
	/* Resize when window change */
	resizeMe();
	$("ul.nav").removeClass("active");
	$("ul.nav").addClass( "left-align" );
});