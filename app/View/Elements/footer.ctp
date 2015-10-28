
<a href="/about">About</a> <?php if (isset($_COOKIE['UID']) || !isset($_COOKIE['UID'])) { ?> | 
<a href="/contact">Contact Us</a> | 
<a href="/refer">Refer a friend</a><?php } ?> | 
<a href="/disclaimer">Disclaimer</a><br/>
<span style="font-size:8pt">We are not affiliated with <a href="http://www.crossfit.com" target="_blank">Crossfit.com</a> or <a href="http://www.crossfit.com" target="_blank">CrossfitHQ.com</a></span>

<script>
	$(document).ready(function(){
		/*$(document).ajaxError(function( event, request, settings ) {
			alert("It seems we have lost connection. Hang tight, CommanderHQ will return as soon as there is an active Internet connection!");
		});*/
		$.fn.testOrientation = function() {
			if(window.orientation !== undefined && window.orientation != 0) {
				mask = $('<div class="sitemask" style="z-index:2147483648; display:block;"><p>To get the best CrossFit experience, switch to portrait view.</p></div>');
				$('body').append(mask);
				$('.sitemask').css({
					'width': '100%',
					'height': ($("#footer").offset().top + $("#footer").height()+30)+'px'
				});
				$('.sitemask p').css({
					'margin-top': ($(window).height() / 2 ) + 'px'
				});
				var viewportHeight = $(window).height(),
				$foo = $('.sitemask p'),
				elOffset = $foo.offset(),
				elHeight = $foo.height();
				$(window).scrollTop(elOffset.top + (elHeight/2) - (viewportHeight/2));
			} else {
				$(".sitemask").remove();
			}
		}
		$(this).testOrientation();
		$(window).bind('orientationchange', function() {
			$(this).testOrientation();
		});
	});
</script>