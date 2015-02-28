(function($) {

    var DEFAULT_DURATION = 30; // Seconds

    /**
     * Initializes each stage element by:
     * - Removing extra breaks (put there by WP) and empty paragraphs.
     * - Cloning remaining elements (so the 'ribbon' can repeat)
     * - Setting the height if set for the stage
     *
     * @param stage
     */
    function initStage(stage) {
        // Remove breaks, clone others, set styles
        var css = {};
        var height = stage.attr('data-height');
        if (height) {
            css.height = height;
        }
        var children = stage.children();
        children.each(function (_, e) {
            var el = $(e);
            if (el.is('br') || (el.is('p') && el.children().length == 0)) {
                el.remove();
            } else {
                el.css(css);
                el.clone().appendTo(stage);
            }
        });
    }

    /**
     * Starts the scrolling of the given stage.
     * The first time, starts at a random spot.
     *
     * @param stage
     */
    function startStage(stage) {
        LOG("Starting stage");

        //console.log("Starting stage");
        // Calculate stage width and loop width
        var stageWidth = 0;
        stage.children().each(function (_, el) {
            stageWidth += $(el).width();
        });
        if (!stageWidth) {
            console.log("Empty stage; aborting");
            return;
        }
        var loopWidth = stageWidth / 2; // Since we duplicated em all

        LOG("Repeating elements");
        // Repeat elements until the stage is at least 2x as wide as the carousel
        var carouselWidth = stage.parent().width();
        while (stageWidth < 2*carouselWidth) {
            stage.children().each(function (_, e) {
                if (stageWidth < 2*carouselWidth) {
                    var el = $(e);
                    el.clone().appendTo(stage);
                    stageWidth += el.width();
                }
            });
        }

        // Use specified duration else default
        var duration = stage.attr('data-duration');
        if (!duration) {
            duration = DEFAULT_DURATION;
        }

        LOG("Starting scroll");
        function scroll(start) {
            if (typeof(start) == 'undefined') {
                start = 0;
            }
            var delta = loopWidth - start;
            var dur = duration * 1000 * (delta / loopWidth);
            LOG("Starting at "+start+". Animating for "+delta+"px for "+dur+"ms");
            stage.velocity({left: "-=" + delta}, dur, 'linear', function () {
                stage.css('left', '0px');
                scroll();
            });
        }

        // Start scrolling at a random spot
        var start = Math.floor((Math.random() * loopWidth));
        stage.css({'visibility': 'visible', 'left': -start});
        scroll(start);
    }

    // On doc ready, find and init stages, and then start stages
    $( document ).ready(function() {
        LOG("Document ready");
        // Initialize each stage
        LOG("Initializing stages");
        var $stages = $('.g11-carousel-stage');
        $stages.each(function(_, stage) { initStage($(stage)); });

        // Wait half a sec for rendering (so sizes are accurate) and then start
        LOG("Wait to start stages");
        setTimeout(function() {
            LOG("Starting stages");
            $stages.each(function(_, stage) { startStage($(stage)); });
        }, 500);
    });

    function LOG(o) {
        console.log(o);
    }

})(jQuery);
//console.log("Loaded carousel");