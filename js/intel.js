            jQuery(window).load(function() {

                jQuery('#carousel').flexslider({
                    animation: "slide",
                    controlNav: false,
                    animationLoop: false,
                    slideshow: true,
                    animationSpeed: 300,
                    itemWidth: 245,
                    asNavFor: '#slider'
                });
                jQuery('#slider').flexslider({
                    animation: "slide",
                    controlNav: false,
                    directionNav: false,
                    animationLoop: true,
                    slideshow: true,
                    sync: "#carousel"
                });

            });