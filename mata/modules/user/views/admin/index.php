<h1><?php echo UserModule::t("Users"); ?></h1>

<div class="nav-buttons floated top-right">
    <a class="btn-small btn" href="/user/registration">Create New User</a>
</div>

<?php
$this->widget('mata.widgets.MListView', array(
    'dataProvider' => $model->search(),
    "id" => "user-grid",
    'sortableAttributes' => array("username", 'profile.FirstName', 'profile.LastName', 'lastvisit_at'),
    'itemView' => '_view',
));
?>

<script>
    function getNextPage(e) {

        var currentTarget = $(e.currentTarget)
        $("#user-grid").addClass("list-view-loading")
        $.ajax(currentTarget.attr("href")).success(function(data) {
            var container = $("<div id ='sss'/>").html(data)

            $("#user-grid").find(".items").append($(container).find(".items").html());
            var pager = $(container.find(".pager a"));
            if (pager.length > 0) {
                currentTarget.attr("href", pager.attr("href"))
            } else
                $("#user-grid").find(".pager").hide();

            // console.log(container)
//        $("#user-grid").html(data)
        }).always(function() {
            $("#user-grid").removeClass("list-view-loading")
        })
        e.stopPropagation();
        return false;
    }

    (function($) {

        var selection = [];

        function formatDisplayableTextForSelection(selection) {
            if (selection.length <= 3) {
                return selection.join(", ");
            } else {
                var selection = selection.slice(0);
                var retVal = selection.slice(0, 3).join(", ");
                retVal += "<br/> and " + selection.slice(3).length + " other" + (selection.slice(3).length > 1 ? "s" : "")
                return retVal;
            }
        }



        $.fn.toggleItem = function(item) {

            $(item).each(function(i, item) {
                item = $(item);
                item.width(item.width());

                var isSelected = item.hasClass("selected");

                if (isSelected) {
                    deselectItem(item)
                } else {
                    selectItem(item)
                }

            })
        }

        $.fn.updateLabel = function() {
            var el = $("#list-selection-user-grid");
            var label = el.find(".label");
            if (selection.length > 0) {
                el.css("display", "block")
                el.stop().transition({opacity: 1});
                label.html(formatDisplayableTextForSelection(selection))
            } else {
                label.css("opacity", 0);
                el.stop().transition({opacity: 0}, function() {
                    $(this).css("display", "none")
                    label.css("opacity", 1)
                });
            }
        }

        function deselectItem(item) {
            item.removeClass("selected");
            var itemLabel = item.find(".model-label").first().html();
            $.each(selection, function(i) {
                if (selection[i] === itemLabel)
                    selection.splice(i, 1);
            });

            item.transition({"padding-left": 0});

            $("#user-grid").trigger("selection-changed");
        }

        function selectItem(item) {
            item.addClass("selected");
            var itemLabel = item.find(".model-label").first().html();
            $.each(selection, function(i) {
                if (selection[i] === itemLabel)
                    selection.splice(i, 1);
            });

            selection.push(itemLabel);
            item.transition({"padding-left": 30})
            $("#user-grid").trigger("selection-changed")
        }

        var methods = {
            cancelSelection: function() {
                $("#user-grid").find(".selected").each(function() {
                    deselectItem($(this))
                });
            },
            delete: function() {

                if (confirm("Confirm removal of " + formatDisplayableTextForSelection(selection).replace(/<br ?\/?>/g, "")) == false)
                    return;


                $("#user-grid").find(".selected").each(function() {
                    var deleteLink = $(this).find(".delete").attr("href");
                    var linkElem = $(this);

                    $.ajax(deleteLink, {
                        "type": "POST"
                    }).success(function() {
                        deselectItem(linkElem);
                        linkElem.transition({"height": "0px"}, function() {
                            linkElem.remove()
                        })
                    })

                })
            }
        }

        $.fn.selection = function(method) {

            if (methods[method]) {
                return methods[ method ].apply(this, Array.prototype.slice.call(arguments, 1));
            } else if (typeof method === 'object' || !method) {
                return methods.init.apply(this, arguments);
            } else {
                $.error('Method ' + method + ' does not exist on jQuery.selection');
            }

        };
    })(jQuery);

    $("#user-grid").on("click", ".list-view-item", function(e) {
        if (e.metaKey) {
            $.fn.toggleItem($(this))
            e.stopPropagation();
            return false;
        }
    })

    $("#user-grid").on("click", "a.delete", function() {
        $.fn.selection.delete()
    })

    $("#user-grid").on("selection-changed", function() {
        $.fn.updateLabel()
    })

    $.fn.selection('cancelSelection');

</script>