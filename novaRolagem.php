<html>
    <head>
        <link href="img/favicon.ico" rel="shortcut icon"/>
        <link href="css/novaRolagem.css" rel="stylesheet"/>
        <script src="lib/js/jquery/js/jquery-1.9.0.js"></script>
        <script src="lib/js/jquery/js/jquery-ui-1.10.0.custom.js"></script>

    </head>
    <body>
        <div id="pattern" class="pattern">
            <div class="c">
                <div class="c-list-container">
                    <ul class="c-list">
                        <li>
                            <a href="#">
                                <img src="http://bradfrost.github.com/this-is-responsive/patterns/images/fpo_landscape.png" alt="FPO Image" />
                                <div class="summary">
                                    <h2>This is the first title</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer eget lacus erat, sit amet tempor nibh. Aliquam erat volutpat. Nulla et porta tortor. </p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="http://bradfrost.github.com/this-is-responsive/patterns/images/fpo_landscape.png" alt="FPO Image" />
                                <div class="summary">
                                    <h2>This is the second title</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer eget lacus erat, sit amet tempor nibh. Aliquam erat volutpat. Nulla et porta tortor. </p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="http://bradfrost.github.com/this-is-responsive/patterns/images/fpo_landscape.png" alt="FPO Image" />
                                <div class="summary">
                                    <h2>This is the third title</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer eget lacus erat, sit amet tempor nibh. Aliquam erat volutpat. Nulla et porta tortor. </p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="http://bradfrost.github.com/this-is-responsive/patterns/images/fpo_landscape.png" alt="FPO Image" />
                                <div class="summary">
                                    <h2>This is the fourth title</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer eget lacus erat, sit amet tempor nibh. Aliquam erat volutpat. Nulla et porta tortor. </p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="http://bradfrost.github.com/this-is-responsive/patterns/images/fpo_landscape.png" alt="FPO Image" />
                                <div class="summary">
                                    <h2>This is the fifth title</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer eget lacus erat, sit amet tempor nibh. Aliquam erat volutpat. Nulla et porta tortor. </p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="http://bradfrost.github.com/this-is-responsive/patterns/images/fpo_landscape.png" alt="FPO Image" />
                                <div class="summary">
                                    <h2>This is the sixth title</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer eget lacus erat, sit amet tempor nibh. Aliquam erat volutpat. Nulla et porta tortor. </p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="http://bradfrost.github.com/this-is-responsive/patterns/images/fpo_landscape.png" alt="FPO Image" />
                                <div class="summary">
                                    <h2>This is the seventh title</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer eget lacus erat, sit amet tempor nibh. Aliquam erat volutpat. Nulla et porta tortor. </p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="http://bradfrost.github.com/this-is-responsive/patterns/images/fpo_landscape.png" alt="FPO Image" />
                                <div class="summary">
                                    <h2>This is the eighth title</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer eget lacus erat, sit amet tempor nibh. Aliquam erat volutpat. Nulla et porta tortor. </p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="http://bradfrost.github.com/this-is-responsive/patterns/images/fpo_landscape.png" alt="FPO Image" />
                                <div class="summary">
                                    <h2>This is the ninth title</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer eget lacus erat, sit amet tempor nibh. Aliquam erat volutpat. Nulla et porta tortor. </p>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <nav class="c-nav">
                    <a href="#" class="prev">&larr; Prev</a>
                    <a href="#" class="next">Next &rarr;</a>
                </nav>
            </div>

        </div>
        <!--End Pattern HTML-->
        <script>
            (function(w){
                var sw = document.body.clientWidth,
                current = 0,
                breakpointSize = window.getComputedStyle(document.body,':after').getPropertyValue('content'),
                multiplier = 1, /*Determines the number of panels*/
                $carousel = $('.c'),
                $cList = $('.c-list'),
                $cContainer = $('.c-list-container'),
                $cWidth = $cContainer.outerWidth(),
                cLeft = $cList.css("left").replace("px",""),
                $li = $('.c li'),
                $liLength = $li.size(),
                numPages = $liLength/multiplier,
                $prev = $('.c-nav .prev'),
                $next = $('.c-nav .next');
	
                $(document).ready(function() {
                    buildCarousel();
                });
	
	
                $(window).resize(function(){ //On Window Resize
                    sw = document.body.clientWidth;
                    $cWidth = $cContainer.width();
                    breakpointSize = window.getComputedStyle(document.body,':after').getPropertyValue('content');  /* Conditional CSS http://adactio.com/journal/5429/ */
                    sizeCarousel();
                    posCarousel();
                });
	
                function sizeCarousel() { //Determine the size and number of panels to reveal
                    current = 0;

                    if (breakpointSize == 'medium') {
                        multiplier = 2;
			
                    } else if (breakpointSize == 'large') {
                        multiplier = 3;
                    } else {
                        multiplier = 1;
                    }
		
                    animLimit = $liLength/multiplier-1;
		
                    $li.outerWidth($cWidth/multiplier); //Set panel widths
		
                }
	
	
                function buildCarousel() { //Build the Carousel
                    sizeCarousel();

                    if(Modernizr.touch) {
                        buildSwipe(); 
                    }
                }
	
                function posCarousel() { //Animate Carousel. CSS transitions used for the actual animation.
                    var pos = -current * $cWidth;
                    $cList.addClass('animating').css("left",pos);
    
                    setTimeout(function() {
                        $cList.removeClass('animating');
                        cLeft = $cList.css("left").replace("px","");
                    }, 500);  // will work with every browser
                }
	
                $prev.click(function(e){ //Previous Button Click
                    e.preventDefault();
                    moveRight();
                });
  
                $next.click(function(e){ //Next Button Click
                    e.preventDefault();
                    moveLeft();
                });

                function moveRight() {
                    if(current>0) {
                        current--;
                    }
                    posCarousel();
                }
  
                function moveLeft() {
                    if(current<animLimit) {
                        current++;
                    }
                    posCarousel();
                }
  
                function buildSwipe() {
                    var threshold = 80,
                    origX = 0,
                    finalX = 0,
                    changeX = 0,
                    changeY = 0,
                    curPos;
		    
                    //Touch Start
                    $cContainer.get(0).addEventListener("touchstart", function (event) {
                        origX = event.targetTouches[0].pageX;
                        curPos = origX;
                    });
		
                    //Touch Move
                    $cContainer.get(0).addEventListener("touchmove", function (event) {
                        finalX = event.touches[0].pageX,
                        diffX = origX - finalX,
                        leftPos = cLeft-diffX;
        
                        event.preventDefault();
                        $cList.css("left",leftPos);
                    });
		
                    //Touch Move
                    $cContainer.get(0).addEventListener("touchend", function (event) {
                        var diffX = origX - finalX,
                        diffXAbs = Math.abs(diffX);
      
                        if (diffX > 0 && diffXAbs > threshold) {
                            moveLeft();
                        } else if (diffX < 0 && diffXAbs > threshold) {
                            moveRight();
                        } else {
                            posCarousel();
                        }
			
                        origX = finalX = diffX = 0;
                    });
                }
  
            })(this);
        </script>
        <div class="container">	
            <section class="pattern-description">
                <h1>3-Up Touch Carousel</h1>
                <p>A carousel that shows one panel on smaller screens, 2 panels for medium screens, and reveals three panels at a time when space becomes available. The user can click the previous and next buttons to advance, but touch-enabled users can also swipe through the carousel.</p>
            </section>
            <footer role="contentinfo">   
                <div>
                    <nav id="menu">
                        <a href="http://bradfrost.github.com/this-is-responsive/patterns.html">&larr;More Responsive Patterns</a>
                    </nav>
                </div>
            </footer>
        </div>
    </body>
</html>