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
		 $tabs.fadeOut();
		 $currTab.fadeIn();
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

	$(document).scroll(function() {
	   if($(window).scrollTop() === 0) {
	     $(".header").removeClass("show");
	   } else {
			 $(".header").addClass("show");
		 }
	});

	//--------------------
	//  VARIABLES
	//--------------------
	var link = $(".header__bottom__toggler"),
			body = $("body"),
			close = $(".header_navigation_close"),
			menu = $(".header__menu");


	//--------------------
	//  MENU TOGGLE
	//--------------------
	link.on('click touch', function(e) {
		e.stopPropagation();
		$(this).toggleClass("is-active");
		body.toggleClass("is-active");
		menu.toggleClass('is-active');
	});

	close.on('click touch', function(e) {
		e.stopPropagation();
		menu.removeClass("is-active");
		link.removeClass("is-active");
	});



});

// //--------------------
// // SHOW HIDE MENU ON SCROLL
// //--------------------
// var lastKnownScrollY = 0;
// var currentScrollY = 0;
// var ticking = false;
// var idOfHeader = 'header';
// var eleHeader = null;
// const classes = {
//   pinned: 'header-pin',
//   unpinned: 'header-unpin',
// };
// function onScroll() {
//   currentScrollY = window.pageYOffset;
//   requestTick();
// }
// function requestTick() {
//   if (!ticking) {
//     requestAnimationFrame(update);
//   }
//   ticking = true;
// }
// function update() {
//   if (currentScrollY < lastKnownScrollY) {
//     pin();
//   } else if (currentScrollY > lastKnownScrollY) {
//     unpin();
//   }
//   lastKnownScrollY = currentScrollY;
//   ticking = false;
// }
// function pin() {
//   if (eleHeader.classList.contains(classes.unpinned)) {
//     eleHeader.classList.remove(classes.unpinned);
//     eleHeader.classList.add(classes.pinned);
//   }
// }
// function unpin() {
//   if (eleHeader.classList.contains(classes.pinned) || !eleHeader.classList.contains(classes.unpinned)) {
//     eleHeader.classList.remove(classes.pinned);
//     eleHeader.classList.add(classes.unpinned);
//   }
// }
// window.onload = function() {
//   eleHeader = document.getElementById(idOfHeader);
//   document.addEventListener('scroll', onScroll, false);
// }

//--------------------
// ANIMATE ELEMENTS SCROLL VIEW
//--------------------
var animateHTML = function() {
  var elems;
	var animation;
	var duration;
  var windowHeight;
  function init() {
    elems = document.querySelectorAll('.hidden');
    windowHeight = window.innerHeight;
    addEventHandlers();
    checkPosition();
  }
  function addEventHandlers() {
    window.addEventListener('scroll', checkPosition);
    window.addEventListener('resize', init);
  }
  function checkPosition() {
    for (var i = 0; i < elems.length; i++) {
      var positionFromTop = elems[i].getBoundingClientRect().top;

			animation = elems[i].dataset.animate;
			elems[i].style["animation-duration"] 	= elems[i].dataset.duration + 's';

      if (positionFromTop - windowHeight <= 0) {
        elems[i].className = elems[i].className.replace(
          'hidden',
          animation
        );
      }
    }
  }
  return {
    init: init
  };
};
animateHTML().init();
