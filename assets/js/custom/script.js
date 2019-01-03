//--------------------
// IMAGE LAZY LOADING
//--------------------
window.lazySizesConfig = window.lazySizesConfig || {};

var lazy = function lazy() {
	document.addEventListener('lazyloaded', function (e)  {
		e.target.parentNode.classList.add('image-loaded');
		e.target.parentNode.classList.remove('loading');
	});
}

lazy();

jQuery(document).ready(function($) {

	//--------------------
	//  SMOOTH ANCHOR SCROLLING
	//--------------------
	// Select all links with hashes
	$('a[href*="#"]')
	// Remove links that don't actually link to anything
	.not('[href="#"]')
	.not('[href="#0"]')
	.not('.tab-link')
	.click(function(event) {
		// On-page links
		if (
			location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
			&&
			location.hostname == this.hostname
		) {
			// Figure out element to scroll to
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
			// Does a scroll target exist?
			if (target.length) {
				// Only prevent default if animation is actually gonna happen
				event.preventDefault();
				$('html, body').animate({
					scrollTop: target.offset().top
				}, 1000, function() {
					// Callback after animation
					// Must change focus!
					var $target = $(target);
					$target.focus();
					if ($target.is(":focus")) { // Checking if the target was focused
						return false;
					} else {
						$target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
						$target.focus(); // Set focus again
					};
				});
			}
		}
	});

	//--------------------
	// ANCHOR TABS
	//--------------------
	var $tabs 	= $('.tabs > div'), _currhash, $currTab,
			$links 	= $('.tab-navigation > a');

	$(document).on('click', '.tab-navigation > a', function(e) {
    var $el = $(this);
    $el.addClass("active").siblings().removeClass('active');
	});

  function showTab() {
		if($currTab.length>0) {
		 $tabs.removeClass('active');
		 $currTab.addClass('active');
		}
  }

	function tabLink() {
		$links.each(function() {
			$(this).removeClass('active');
	    var currentHref = $(this).attr('href');
	    if(_currhash == currentHref ) {
	      $(this).addClass("active");
	    }
		})
	}

  /* find the panels and 'unlink' the id to prevent page jump */
  $tabs.each(function() {
     var _id = $(this).attr('id');
     $(this).attr('id',_id+'_tab');
     /* eg we have given the tab an id of 'tab1_tab' */
  });

	/* set up an anchor 'watch' for the panels */
	function anchorWatch() {
	  if(document.location.hash.length>0) {
	    /* only run if 'hash' has changed */
	    if(_currhash!==document.location.hash) {
		     _currhash = document.location.hash;
		     /* we only want to match the 'unlinked' id's */
		     $currTab = $(_currhash+'_tab');
		     showTab();
				 tabLink();
	  	}
	  }
	}
	setInterval(anchorWatch,200);

});
