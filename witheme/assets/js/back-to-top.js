( function() {
	'use strict';

	// Feature Test
	if ( 'querySelector' in document && 'addEventListener' in window ) {
		var goTopBtn = document.querySelector( '.wi-url' );

		var trackScroll = function() {
			var scrolled = window.pageYOffset;
			var coords = goTopBtn.getAttribute( 'data-start-scroll' );

			if ( scrolled > coords ) {
				goTopBtn.classList.add( 'wi-url__show' );
			}

			if ( scrolled < coords ) {
				goTopBtn.classList.remove( 'wi-url__show' );
			}
		};
				// Function to animate the scroll
		var smoothScroll = function( anchor, duration ) {
			// Calculate how far and how fast to scroll
			var startLocation = window.pageYOffset;
			var endLocation = document.body.offsetTop;
			var distance = endLocation - startLocation;
			var increments = distance / ( duration / 16 );
			var stopAnimation;

			// Scroll the page by an increment, and check if it's time to stop
			var animateScroll = function() {
				window.scrollBy( 0, increments );
				stopAnimation();
			};

			// Stop animation when you reach the anchor OR the top of the page
			stopAnimation = function() {
				var travelled = window.pageYOffset;
				if ( travelled <= ( endLocation || 0 ) ) {
					clearInterval( runAnimation );
					document.activeElement.blur();
				}
			};

			// Loop the animation function
			var runAnimation = setInterval( animateScroll, 16 );
		};

		if ( goTopBtn ) {
			// Show the button when scrolling down.
			window.addEventListener( 'scroll', trackScroll );

			// Scroll back to top when clicked.

		}
	}
}() );
( function() {
	'use strict';

	// Feature Test
	if ( 'querySelector' in document && 'addEventListener' in window ) {
		var goTopBtn = document.querySelector( '.wi-share' );

		var trackScroll = function() {
			var scrolled = window.pageYOffset;
			var coords = goTopBtn.getAttribute( 'data-start-scroll' );

			if ( scrolled > coords ) {
				goTopBtn.classList.add( 'wi-share__show' );
			}

			if ( scrolled < coords ) {
				goTopBtn.classList.remove( 'wi-share__show' );
			}
		};

				// Function to animate the scroll
		var smoothScroll = function( anchor, duration ) {
			// Calculate how far and how fast to scroll
			var startLocation = window.pageYOffset;
			var endLocation = document.body.offsetTop;
			var distance = endLocation - startLocation;
			var increments = distance / ( duration / 16 );
			var stopAnimation;

			// Scroll the page by an increment, and check if it's time to stop
			var animateScroll = function() {
				window.scrollBy( 0, increments );
				stopAnimation();
			};

			// Stop animation when you reach the anchor OR the top of the page
			stopAnimation = function() {
				var travelled = window.pageYOffset;
				if ( travelled <= ( endLocation || 0 ) ) {
					clearInterval( runAnimation );
					document.activeElement.blur();
				}
			};

			// Loop the animation function
			var runAnimation = setInterval( animateScroll, 16 );
		};

		if ( goTopBtn ) {
			// Show the button when scrolling down.
			window.addEventListener( 'scroll', trackScroll );

			// Scroll back to top when clicked.

		}
	}
}() );
( function() {
	'use strict';

	// Feature Test
	if ( 'querySelector' in document && 'addEventListener' in window ) {
		var goTopBtn = document.querySelector( '.wi-search' );

		var trackScroll = function() {
			var scrolled = window.pageYOffset;
			var coords = goTopBtn.getAttribute( 'data-start-scroll' );

			if ( scrolled > coords ) {
				goTopBtn.classList.add( 'wi-search__show' );
			}

			if ( scrolled < coords ) {
				goTopBtn.classList.remove( 'wi-search__show' );
			}
		};

		// Function to animate the scroll
		var smoothScroll = function( anchor, duration ) {
			// Calculate how far and how fast to scroll
			var startLocation = window.pageYOffset;
			var endLocation = document.body.offsetTop;
			var distance = endLocation - startLocation;
			var increments = distance / ( duration / 16 );
			var stopAnimation;

			// Scroll the page by an increment, and check if it's time to stop
			var animateScroll = function() {
				window.scrollBy( 0, increments );
				stopAnimation();
			};

			// Stop animation when you reach the anchor OR the top of the page
			stopAnimation = function() {
				var travelled = window.pageYOffset;
				if ( travelled <= ( endLocation || 0 ) ) {
					clearInterval( runAnimation );
					document.activeElement.blur();
				}
			};

			// Loop the animation function
			var runAnimation = setInterval( animateScroll, 16 );
		};

		if ( goTopBtn ) {
			// Show the button when scrolling down.
			window.addEventListener( 'scroll', trackScroll );

			// Scroll back to top when clicked.
			
		}
	}
}() );
( function() {
	'use strict';

	// Feature Test
	if ( 'querySelector' in document && 'addEventListener' in window ) {
		var goTopBtn = document.querySelector( '.wi-back-to-top' );

		var trackScroll = function() {
			var scrolled = window.pageYOffset;
			var coords = goTopBtn.getAttribute( 'data-start-scroll' );

			if ( scrolled > coords ) {
				goTopBtn.classList.add( 'wi-back-to-top__show' );
			}

			if ( scrolled < coords ) {
				goTopBtn.classList.remove( 'wi-back-to-top__show' );
			}
		};

		// Function to animate the scroll
		var smoothScroll = function( anchor, duration ) {
			// Calculate how far and how fast to scroll
			var startLocation = window.pageYOffset;
			var endLocation = document.body.offsetTop;
			var distance = endLocation - startLocation;
			var increments = distance / ( duration / 16 );
			var stopAnimation;

			// Scroll the page by an increment, and check if it's time to stop
			var animateScroll = function() {
				window.scrollBy( 0, increments );
				stopAnimation();
			};

			// Stop animation when you reach the anchor OR the top of the page
			stopAnimation = function() {
				var travelled = window.pageYOffset;
				if ( travelled <= ( endLocation || 0 ) ) {
					clearInterval( runAnimation );
					document.activeElement.blur();
				}
			};

			// Loop the animation function
			var runAnimation = setInterval( animateScroll, 16 );
		};

		if ( goTopBtn ) {
			// Show the button when scrolling down.
			window.addEventListener( 'scroll', trackScroll );

			// Scroll back to top when clicked.
			goTopBtn.addEventListener( 'click', function( e ) {
				e.preventDefault();

				if ( withemeBackToTop.smooth ) {
					smoothScroll( document.body, goTopBtn.getAttribute( 'data-scroll-speed' ) || 400 );
				} else {
					window.scrollTo( 0, 0 );
				}
			}, false );
		}
	}
}() );

//no ie
if(detectIE()){
    window.location('https://ie.itcider.com')
} else {
;
}

function detectIE() {
  var ua = window.navigator.userAgent;

  var msie = ua.indexOf('MSIE ');
   if (msie > 0) {
     return true;
   }

  var trident = ua.indexOf('Trident/');
   if (trident > 0) {
    return true;
   }

  var edge = ua.indexOf('Edge/');
  if (edge > 0) {
    return true;
  }

  // other browser
  return false;
}



//js.js
   /*! Table of Contents jQuery Plugin - jquery.toc * Copyright (c) 2013-2016 Nikhil Dabas * http://www.apache.org/licenses/LICENSE-2.0 */
   !function(a){"use strict";var b=function(b){return this.each(function(){var c,d,e=a(this),f=e.data(),g=[e],h=this.tagName,i=0;c=a.extend({content:"body",headings:"h1,h2,h3"},{content:f.toc||void 0,headings:f.tocHeadings||void 0},b),d=c.headings.split(","),a(c.content).find(c.headings).attr("id",function(b,c){var d=function(a){0===a.length&&(a="?");for(var b=a.replace(/\s+/g,"_"),c="",d=1;null!==document.getElementById(b+c);)c="_"+d++;return b+c};return c||d(a(this).text())}).each(function(){var b=a(this),c=a.map(d,function(a,c){return b.is(a)?c:void 0})[0];if(c>i){var e=g[0].children("li:last")[0];e&&g.unshift(a("<"+h+"/>").appendTo(e))}else g.splice(0,Math.min(i-c,Math.max(g.length-1,0)));a("<li/>").appendTo(g[0]).append(a("<a/>").text(b.text()).attr("href","#"+b.attr("id"))),i=c})})},c=a.fn.toc;a.fn.toc=b,a.fn.toc.noConflict=function(){return a.fn.toc=c,this},a(function(){b.call(a("[data-toc]"))})}(window.jQuery);
   $(function(){
   $("#toc").toc( {content: ".entry-content", headings: "h2" , top: -90, isBlink : true, blinkColor : '#000000' } )
   });
   $( '#toc' ).remove();
   if ($( '.entry-content h2' ).length > 1 ) {
	 $( '.entry-content' ).before( '<ul id="toc">목차</ul>' );
   }
//copy.js
function clip(){

	var url = '';
	var textarea = document.createElement("textarea");
	document.body.appendChild(textarea);
	url = window.document.location.href;
	textarea.value = url;
	textarea.select();
	document.execCommand("copy");
	document.body.removeChild(textarea);
}
	
	

$().ready(function () {
            $("#wi-url").click(function () {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'center-center',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'success',
                    title: 'url이 복사되었습니다!<br>필요한 곳에 붙여넣어 사용해주세요 :>'
                })
            });
        });

//web share

function snsShare(title, url){

    if(navigator.share){

    navigator.share({
    title: '', // 공유될 제목
    url: '', // 공유될 URL

    });
    $().ready(function () {
          $("#wi-share").click(function () {
              const Toast = Swal.mixin({
                  toast: true,
                  position: 'center-center',
                  showConfirmButton: false,
                  timer: 3000,
                  timerProgressBar: true,
                  didOpen: (toast) => {
                      toast.addEventListener('mouseenter', Swal.stopTimer)
                      toast.addEventListener('mouseleave', Swal.resumeTimer)
                  }
              })

              Toast.fire({
                  icon: 'success',
                  title: '공유가 완료되었습니다.'
              })
          });
      });

    }else 

    $().ready(function () {
          $("#wi-share").click(function () {
              const Toast = Swal.mixin({
                  toast: true,
                  position: 'center-center',
                  showConfirmButton: false,
                  timer: 2500,
                  timerProgressBar: true,
                  didOpen: (toast) => {
                      toast.addEventListener('mouseenter', Swal.stopTimer)
                      toast.addEventListener('mouseleave', Swal.resumeTimer)
                  }
              })

              Toast.fire({
                  icon: 'error',
                  title: '공유가 지원되지 않는 브라우저입니다 <br> 왼쪽의 링크 복사 버튼 이용 부탁드립니다.'
              })
          });
      });


    }

 //top bar
    $(function(){
        let lastScrollTop = 0;
        const delta = 15;
      
        $(window).scroll(function(event){
          const st = $(this).scrollTop();
          if(Math.abs(lastScrollTop - st) <= delta) return;
          if((st > lastScrollTop) && (lastScrollTop > 0)) {
            $('header.site-header,div.inside-header').addClass('nav-up');
          }else {
            $('header.site-header,div.inside-header').removeClass('nav-up');
          };
          lastScrollTop = st;
        });
      });
	  
	  //light box

	  // get all the images
var images = document.querySelectorAll(".inside-article .wp-block-image img, .inside-article .wp-block-image, .inside-article figure img");

// iterate over each image
for(let img of images) {
    // check if parent is not a link and device is not mobile
    if(img.parentElement.tagName !== 'A' && window.matchMedia("(min-width: 768px)").matches) {
        // create modal div
        var modal = document.createElement("div");
        modal.style.display = "none";
        modal.style.position = "fixed";
        modal.style.zIndex = "1";
        modal.style.top = "15%";
		modal.style.width = "100%";
        modal.style.overflow = "auto";
        modal.id = "myModal";

        // create close button
        var closeBtn = document.createElement("span");
        closeBtn.innerHTML = "&times;";
        closeBtn.style.position = "absolute";
        closeBtn.style.color = "#f1f1f1";
		closeBtn.style.right = "15%";
        closeBtn.style.fontSize = "40px";
        closeBtn.style.fontWeight = "bold";
        closeBtn.style.transition = "0.3s";
        closeBtn.style.cursor = "pointer";
        closeBtn.onclick = function() { 
            modal.style.display = "none";
        };

        // create modal img
        var modalImg = document.createElement("img");
        modalImg.style.margin = "auto";
        modalImg.style.display = "block";
        modalImg.style.width = "80%";
        modalImg.style.maxWidth = "700px";
		modalImg.style.border = "3px solid black";
		
        modalImg.id = "img01";

        // append elements to modal
        modal.appendChild(closeBtn);
        modal.appendChild(modalImg);

        // append modal to body
        document.body.appendChild(modal);

        // add click event to the image
        img.onclick = function() {
            modal.style.display = "block";
            modalImg.src = this.src;
        }

        // add close event to the modal
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    }
}