var Carousel = BaseClassWithOptions.extend({
    container: null,
    timer: null,
    defaultOptions: {
        "delay": 0
    },
    /**
     * var data [{
     *  title: 'title1',
     *  text: 'text',
     *  image: '/images/x.jpg'
     * }]
     */
    data: null,
    isAnimating: false,
    /**
     * When the user click on a page one execution cycle will be skipped
     */
    manualPaging: false,
    enableSwipe: true,
    /**
     * Starts from 0
     */
    currentIndex: 0,
    init: function(container, data, options) {
        this._super(options);
        this.container = typeof(container) == 'string' ? $("#" + container) : $(container);
        this.addDefaultMarkup();
        this.data = data;
        this.addHandlers();
        this.addPages();
        this.page(0);
    },
    addPages: function() {
        var i = 0;

        $(this.data).each($.proxy(function(i, data) {
            var page = $("<div/>", {
                "class": "page"
            })


            page.bind("click", $.proxy(function() {
                this.page(i)
            }, this))

            $(this.container.find(".paging")[0]).append(page)
        }, this))


    },
    addHandlers: function() {

        if (this.options.delay > 0) {
            this.timer = $.timer(this.options.delay * 1000, $.proxy(function(timer) {
                if (this.manualPaging) {
                    this.manualPaging = false;
                } else {
                    this.next();
                }
            }, this));
        }

        //Enable swiping...
        if (this.options.enableSwipe)
            this.container.swipe({
                swipe: $.proxy(function(e, direction) {
                    switch (direction) {
                        case "right":
                            this.previous();
                            break;
                        case "left":
                            this.next();
                            break;
                    }
                }, this),
                threshold: 150,
                triggerOnTouchEnd: false,
                allowPageScroll: "vertical"
            });

        $.each(this.container.find(".page"), $.proxy(function(i, elem) {

            elem = $(elem)
            elem.click($.proxy(function() {

                var container = elem.parent();

                var index = 0;
                var child = $(container.children()[index])

                while (child.is(elem) == false) {
                    child = $(container.children()[++index]);
                }

                this.page(index);

            }, this))
        }, this));

        this.hookKeyboardEvents();
    },
    addDefaultMarkup: function() {
        if (this.container.find(".imageContainer").length == 0)
            this.container.append("<div class='imageContainer'></div>")

        if (this.container.find("p").length == 0)
            this.container.append("<p></p>")

        if (this.container.find(".paging").length == 0)
            this.container.append("<div class='paging'></div>")

    },
    hookKeyboardEvents: function() {
        $(document).keydown($.proxy(function(e) {
            if (e.keyCode == Event.KEY_LEFT) {
                this.timer.reset(this.options.delay * 1000)
                this.previous();
            } else if (e.keyCode == Event.KEY_RIGHT) {
                this.timer.reset(this.options.delay * 1000)
                this.next();
            }
        }, this))
    },
    page: function(index) {

        if (this.isAnimating)
            return

        this.currentIndex = index;
        this.populateContent();
        this.updatePaging();

        this.manualPaging = true;

    },
    next: function() {
        if (this.isAnimating)
            return

        if (this.currentIndex == this.data.length - 1) {
            this.currentIndex = 0;
        } else {
            this.currentIndex++;
        }

        this.populateContent();
        this.updatePaging();
   },
    previous: function() {

        if (this.isAnimating)
            return

        if (this.currentIndex == 0) {
            this.currentIndex = this.data.length - 1;
        } else {
            this.currentIndex--;
        }

        this.populateContent();
        this.updatePaging();
   },
    populateContent: function() {

        this.isAnimating = true;

        var oldImage = $(this.container.find(".imageContainer")[0]).children();
        var newZIndex = parseInt(oldImage.css("zIndex")) + 1
        var newImage = $('<img></img>')
                .attr({
            style: "display: none; z-index: " + newZIndex
        }).addClass("image");

        newImage.load($.proxy(function() {
            newImage.fadeIn(1000,
                    $.proxy(function() {
                this.isAnimating = false
            }, this)
                    )
        }, this))

        newImage.attr({
            src: this.data[this.currentIndex].image
        })

        $(this.container.find(".imageContainer")[0]).append(newImage)
        $(this.container.find("p")[0]).html(this.data[this.currentIndex].content)

        if (this.data[this.currentIndex].link != null) {
            $(this.container.find("a")[0]).show()
            $(this.container.find("a")[0]).attr("href", this.data[this.currentIndex].link);
        } else {
            $(this.container.find("a")[0]).hide()
        }

        oldImage.fadeOut(1000, function() {
            oldImage.remove()
        })

    },
    updatePaging: function() {
        $($(this.container.find(".paging")[0]).find(".active")[0]).removeClass("active");
        $($(this.container.find(".paging")[0]).find(".page")[this.currentIndex]).addClass("active");
    }
})