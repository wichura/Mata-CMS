
;
(function($) {
    /**
     * yiiListView set function.
     * @param options map settings for the list view. Availablel options are as follows:
     * - ajaxUpdate: array, IDs of the containers whose content may be updated by ajax response
     * - ajaxVar: string, the name of the GET variable indicating the ID of the element triggering the AJAX request
     * - pagerClass: string, the CSS class for the pager container
     * - sorterClass: string, the CSS class for the sorter container
     * - updateSelector: string, the selector for choosing which elements can trigger ajax requests
     * - beforeAjaxUpdate: function, the function to be called before ajax request is sent
     * - afterAjaxUpdate: function, the function to be called after ajax response is received
     */
    $.fn.mListView = function(options) {

        return this.each(function() {
            var container = $(this);
            container.on("click.mListview", "a.delete", function() {
                $.fn.mListView.delete(container)
            })

            container.parent().find(".list-selection a.cancelSelectionBtn").on("click", function() {
                $.fn.mListView.cancelSelection(container);
                container.trigger("selection-changed");
            })

            container.parent().find(".list-selection a.removeBtn").on("click", function() {
                $.fn.mListView.delete(container);
            })

            container.on("selection-changed", function() {
                $.fn.mListView.updateLabel(container)
            })

            container.on("click.mListView", ".list-view-item", function(e) {
                if (e.metaKey) {
                    $.fn.mListView.toggleItem($(this));
                    container.trigger("selection-changed");
                    e.stopPropagation();
                    return false;
                }
            })

            container.on("click.mListView", ".pager a", function(e) {
                $.fn.mListView.getNextPage(container, $(this));
                e.stopPropagation();
                return false;
            })

            $.fn.mListView('cancelSelection');
        })

        $.fn.mListView = function(method) {

            if (methods[method]) {
                return methods[ method ].apply(this, Array.prototype.slice.call(arguments, 1));
            } else if (typeof method === 'object' || !method) {
                return methods.init.apply(this, arguments);
            } else {
                $.error('Method ' + method + ' does not exist on jQuery.mListView');
            }

        };
    }

    var selection = [];


    $.fn.mListView.delete = function(container) {

        if (confirm("Confirm removal of " +
                $.fn.mListView.formatDisplayableTextForSelection(selection).replace(/<br ?\/?>/g, "")) == false)
            return;
        container.find(".selected").each(function() {
            var deleteLink = $(this).find(".delete").attr("href");
            var linkElem = $(this);
            $.ajax(deleteLink, {
                "type": "POST"
            }).success(function() {
                $.fn.mListView.deselectItem(linkElem);
                linkElem.transition({"height": "0px"}, function() {
                    linkElem.remove()
                })
                
                container.trigger("selection-changed");
            })

        })
    }

    $.fn.mListView.cancelSelection = function(container) {
        container.find(".selected").each(function(i) {
            $.fn.mListView.deselectItem($(this))
        });
    },
            $.fn.mListView.getNextPage = function(container, pageButton) {
        container.addClass("list-view-loading")
        $.ajax(pageButton.attr("href")).success(function(data) {
            var itemsContainer = $("<div id ='sss'/>").html(data)

            container.find(".items").append($(itemsContainer).find(".items").html());
            var pager = $(itemsContainer.find(".pager a"));
            if (pager.length > 0) {
                pageButton.attr("href", pager.attr("href"))
            } else
                container.find(".pager").hide();
        }).always(function() {
            container.removeClass("list-view-loading")
        })
    }

    $.fn.mListView.formatDisplayableTextForSelection = function(selection) {
        if (selection.length <= 3) {
            return selection.join(", ");
        } else {
            var selection = selection.slice(0);
            var retVal = selection.slice(0, 3).join(", ");
            retVal += " and " + selection.slice(3).length + " other" + (selection.slice(3).length > 1 ? "s" : "")
            return retVal;
        }
    }

    $.fn.mListView.toggleItem = function(item) {
        $(item).each(function(i, item) {
            item = $(item);
            item.width(item.width());
            var isSelected = item.hasClass("selected");
            if (isSelected) {
                $.fn.mListView.deselectItem(item)
            } else {
                $.fn.mListView.selectItem(item)
            }

        })
    }

    $.fn.mListView.deselectItem = function(item) {
        item.removeClass("selected");
        var itemLabel = item.find(".model-label").first().html();
        $.each(selection, function(i) {
            if (selection[i] === itemLabel)
                selection.splice(i, 1);
        });
        item.transition({"padding-left": 0});

    }

    $.fn.mListView.selectItem = function(item) {
        item.addClass("selected");
        var itemLabel = item.find(".model-label").first().html();
        $.each(selection, function(i) {
            if (selection[i] === itemLabel)
                selection.splice(i, 1);
        });
        selection.push(itemLabel);
        item.transition({"padding-left": 30})
    }


    $.fn.mListView.updateLabel = function(container) {
        var el = container.parent().find(".list-selection")
        var label = el.find(".label");
        if (selection.length > 0) {
            el.css("display", "block")
            el.stop().transition({opacity: 1});
            label.html($.fn.mListView.formatDisplayableTextForSelection(selection))
        } else {
            label.css("opacity", 0);
            el.stop().transition({opacity: 0}, function() {
                $(this).css("display", "none")
                label.css("opacity", 1)
            });
        }
    }


})(jQuery);