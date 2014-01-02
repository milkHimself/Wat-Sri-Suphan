function mymargtop() {
    var body_h = $(window).height();
    var container_h = $('#prewiev').height(); 
    var marg_top = Math.abs((body_h - container_h)/2);  
    $('#prewiev').css('padding-top', marg_top-60);
    $('#prewiev').css('padding-bottom', marg_top-20);
};

$(document).ready(function() {
    var oHeaderHeight = $("header").outerHeight(true),
        oBody= $("body");

    oBody.css({"padding-top":oHeaderHeight});

    mymargtop();


    /* Scroll to Sections
        ================================================== */
    $('#header-navigation a[href*=#]').click( function(event) {
        event.preventDefault();
        $.scrollTo( $(this).attr('href') , 650, { easing: 'swing' , offset: -oHeaderHeight , 'axis':'y' } );
    });

    $('.down_btn').click( function(event) {
        event.preventDefault();
        $.scrollTo( $(this).attr('href') , 650, { easing: 'swing' , offset: -oHeaderHeight , 'axis':'y' } );
    });

    $('#to-top').click(function(event) {
        event.preventDefault();
        $('body,html').animate({ scrollTop:0 } , 1000);
    });



    /* reflect scrolling in navigation
        ================================================== */
    $('.nav-waypoint').each(function() {
        $(this).waypoint( function( direction ) {

            if( direction === 'down' ) {

                var containerID = $(this).find('section:first').attr('id');

                /* update navigation */
                $('#header-navigation a').removeClass('current');
                $('#header-navigation a[href*=#'+containerID+']').addClass('current');
            
            }

        } , { offset: '150px' } );
        
        $(this).waypoint( function( direction ) {
            
            if( direction === 'up' ) {
            
                var containerID = $(this).find('section:first').attr('id');
                
                /* update navigation */
                $('#header-navigation a').removeClass('current');
                $('#header-navigation a[href*=#'+containerID+']').addClass('current');
            
            }

        } , { offset: function() { return -$(this).height() + 155; } });
    });


    /* Slider
        ================================================== */
    $.mbBgndGallery.buildGallery({
        containment:"#slider-wrapper",
        timer:2000,
        effTimer:6000,
        controls:"#slider-controls",
        grayScale:false,
        shuffle:true,
        preserveWidth:false,
        effect:"zoom",
        //effect:{enter:{transform:"scale("+(1+ Math.random()*2)+")",opacity:0},exit:{transform:"scale("+(Math.random()*2)+")",opacity:0}},

        // If your server allow directory listing you can use:
        // (however this doesn't work locally on your computer)

        //folderPath:"testImage/",

        // else:

         images:[
         "images/slide/1.jpg",
		 "images/slide/2.jpg"
         ],

        onStart:function(){},
        onPause:function(){},
        onPlay:function(opt){},
        onChange:function(opt,idx){},
        onNext:function(opt){},
        onPrev:function(opt){}
    });


    /* Parallax Effect
        ================================================== */
    $('#parallax .parallax-layer').parallax({
        mouseport: $('#parallax')
    });


    /* Custom-accordion
        ================================================== */
    $.fn.slideFadeToggle = function(options, callback) {
    if (typeof callback == 'function') { // make sure the callback is a function
           callback.call(this); // brings the scope to the callback
       }
       return this.animate({opacity: 'toggle', height: 'toggle'}, 400);
    };

    $(".toggle").next(".hidden").hide();
    
    $(".toggle").click(function() {
        $('.toggle-current').not(this).toggleClass('toggle-current').next('.hidden').slideFadeToggle();
        $(this).toggleClass('toggle-current').next().slideFadeToggle(500, function(){
        var this_element = $(this);
        setTimeout(function(){
        var scroll_to = this_element.prev('.toggle').offset().top;
        $('html, body').animate({scrollTop: scroll_to - oHeaderHeight}, 500);
        }, 500);
        });
    });


    /* Paralax_background
        ================================================== */
     $('section[data-type="background"]').each(function(){
        var $bgobj = $(this);
        $(window).scroll(function() {
            var yPos = -($(window).scrollTop() / $bgobj.data('speed'));
            var coords = 'center '+ yPos + 'px';
            $bgobj.css({ backgroundPosition: coords });
        });
    });


    /* PrettyPhoto
        ================================================== */
    $("a[rel^='prettyPhoto']").prettyPhoto();


    /* Contact form
        ================================================== */
    $("#ajax-contact-form").submit(function() {
        var str = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "contact_form/contact_process.php",
            data: str,
            success: function(msg) {
                // Message Sent - Show the 'Thank You' message and hide the form
                if(msg == 'OK') {
                    result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';
                    $("#fields").hide();
                } else {
                    result = msg;
                }
                $('#note').html(result);
            }
        });
        return false;
    });


    /* Scroll Animations
        ================================================== */
    $('#history').waypoint(function(direction) {

        if( direction === 'down' ) {
            
            /* Skills
                ================================================== */
            setTimeout ( function () {
                $('.chart').each(function(){
                    $(this).easyPieChart({
                        barColor: $(this).attr('data-barColor'),
                        trackColor: false,
                        scaleColor: false,
                        lineCap: 'butt',
                        lineWidth: 23,
                        size: 158,
                        animate: 3000,
                        onStep: function(from, to, percent) {
                            $(this.el).find('.percent').text(Math.round($(this.el).attr('data-text')));
                        }
                    });
                });
            },650);

        }

    } , { offset: '95%' } );


    function block_text() {

        $('.block-text.opacity-box ,.block-text .opacity-box').each(function( k ) {

            var el = $(this);

            setTimeout ( function () {
                el.animate({opacity: 1} , 600, "easeInExpo" );
            },  k * 80 );

        });

    }


    /* servisec-item */
    function animate_servisec_item() {

        $('.services-block .opacity-box').each(function( k ) {

            var el = $(this);

            setTimeout ( function () {
                el.animate({opacity: 1} , 600 , "easeInExpo");
            },  k * 60 );

        });

    }


    /* event_item */
    function event_item() {

        $('#events-block .opacity-box').each(function( k ) {
        
            var el = $(this);
            
            $(this).waypoint(function(direction) {
                
                if( direction === 'down' && !$(this).hasClass('animated') ) {
                    
                    setTimeout ( function () {
                        el.animate({opacity: 1} , 600 , "easeInExpo");
                    }, k * 50 );
                    
                }
            
            }, { offset: '99%' } );
            
        });

    }


    /* portfolio_item */
    function portfolio_item() {

        $('#portfolio-block .opacity-box').each(function( k ) {
        
            var el = $(this);
            
            $(this).waypoint(function(direction) {
                
                if( direction === 'down' && !$(this).hasClass('animated') ) {
                    
                    setTimeout ( function () {
                        el.animate({opacity: 1} , 600 , "easeInExpo");
                    }, k * 50 );
                    
                }
            
            }, { offset: '99%' } );
            
        });

    }

    function animate_sections() {

        /* about */
        $('#history').waypoint( function( direction ) {

            if( direction === 'down' && !$(this).hasClass('animated') ) {

                $('#history .heading-title').find('h2.opacity-box').delay(150).animate({ opacity: 1 } , 500 ,"easeInExpo");

                $('#history .heading-title').find('.caption.opacity-box').delay(250).animate({ opacity: 1 } , 500 ,"easeInExpo");

                $('#parallax.opacity-box').delay(450).animate({ opacity: 1 }, 500 , "easeInExpo");

                setTimeout( block_text , 550);

                $('.skills-block.opacity-box').delay(650).animate({ opacity: 1 }, 500 , "easeInExpo");

                $(this).addClass('animated');

            }

        } , { offset: '95%' } );


        /* services */
        $('#attractions').waypoint( function( direction ) {

            if( direction === 'down' && !$(this).hasClass('animated') ) {

                $('#attractions .heading-title').find('h2.opacity-box').delay(150).animate({ opacity: 1 } , 500 ,"easeInExpo");

                $('#attractions .heading-title').find('.caption.opacity-box').delay(250).animate({ opacity: 1 } , 500 ,"easeInExpo");

                setTimeout( animate_servisec_item , 450);

                $(this).addClass('animated');

            }

        } , { offset: '95%' } );


        /* events */
        $('#news').waypoint( function( direction ) {

            if( direction === 'down' && !$(this).hasClass('animated') ) {

                $('#news .heading-title').find('h2.opacity-box').delay(150).animate({ opacity: 1 } , 500 ,"easeInExpo");

                $('#news .heading-title').find('.caption.opacity-box').delay(250).animate({ opacity: 1 } , 500 ,"easeInExpo");	

				$('#news .heading-title').find('.caption2.opacity-box').delay(300).animate({ opacity: 1 } , 500 ,"easeInExpo");

                setTimeout( event_item , 450 , "easeInExpo");

                $(this).addClass('animated');

            }

        } , { offset: '95%' } );


        /* portfolio */
        $('#gallery').waypoint( function( direction ) {

            if( direction === 'down' && !$(this).hasClass('animated') ) {

                $('#gallery .heading-title').find('h2.opacity-box').delay(150).animate({ opacity: 1 } , 500 ,"easeInExpo");

                $('#gallery .heading-title').find('.caption.opacity-box').delay(250).animate({ opacity: 1 } , 500 ,"easeInExpo");

                setTimeout( portfolio_item , 450);

                $(this).addClass('animated');

            }

        } , { offset: '99%' } );


        /* contact */
        $('#map').waypoint( function( direction ) {

            if( direction === 'down' && !$(this).hasClass('animated') ) {

                $('#map .heading-title').find('h2.opacity-box').delay(150).animate({ opacity: 1 } , 500 , "easeInExpo");

                $('#map .heading-title').find('.caption.opacity-box').delay(250).animate({ opacity: 1 } , 500 , "easeInExpo");

                $('#map .opacity-box').delay(450).animate({ opacity: 1 } , 800 , "easeInExpo");

                $(this).addClass('animated');

            }

        } , { offset: '95%' } );


    };

    /* no animation for mobile */
    if( !device.tablet() && !device.mobile()) {
        animate_sections();
    };


    /* Tablet and mobile menu
        ================================================== */
    var oMenuLink = $('#menu_link');
    oMenuLink.click(function() {
        var $this = $(this);

        $this.toggleClass('active');

        $this.next().stop().slideToggle();
    });


    $('#header-navigation a').click(function() {

        if ( oMenuLink.hasClass('active')) {
            oMenuLink.removeClass('active');

            $('header nav').slideUp();
        };
    });

});

$(window).load(function() {
    $("#status").fadeOut();
    $("#preloader").delay(350).fadeOut("slow");
});

$(window).resize(function() {
    mymargtop();

    var oHeaderHeight = $("header").outerHeight(true),
        oBody= $("body");

    oBody.css({"padding-top":oHeaderHeight});
});