<?php
//$this->breadcrumbs=array(
//	UserModule::t('Users')=>array('/user'),
//	UserModule::t('Manage'),
//);
//
//$this->menu=array(
//    array('label'=>UserModule::t('Create User'), 'url'=>array('create')),
//    array('label'=>UserModule::t('Manage Users'), 'url'=>array('admin')),
//    array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('profileField/admin')),
//    array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
//);
//Yii::app()->clientScript->registerScript('search', "
//$('.search-button').click(function(){
//    $('.search-form').toggle();
//    return false;
//});	
//$('.search-form form').submit(function(){
//    $.fn.yiiGridView.update('user-grid', {
//        data: $(this).serialize()
//    });
//    return false;
//});
//");

Yii::app()->clientScript->registerScript('search', "var ajaxUpdateTimeout;
    var ajaxRequest;
    $('input#filter').keyup(function(){
        ajaxRequest = $(this).serialize();
        clearTimeout(ajaxUpdateTimeout);
        ajaxUpdateTimeout = setTimeout(function () {
            $.fn.yiiListView.update(
           
// this is the id of the CListView
                'user-grid',
                {data: ajaxRequest,  url: '/user/admin'}
            )
        },
// this is the delay
        300);
    });"
);
?>

<style>
    .list-selection {
        cursor: default;
        position: absolute;
        top: 20px;
        left: 50%; 
        width: 350px;
        opacity: 0;
        display: none;
        margin-left: -175px;
        background: rgba(55,55,55, 0.8);
        padding: 20px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
        text-align: center;
        color: #FFF;
    }
</style>

<div class="list-selection">
    <h4>Selection</h4>
    <p class="label"></p>
    <div class="actions">
        <a href="#">
            <img src="/images/layout/icons/trash-icon.png" />
        </a>
        <a onclick="$.fn.selection('cancelSelection')" href="javascript:void(0)">
            <img src="/images/layout/icons/stop-icon2.png" />
        </a>
    </div>
</div>

<h1><?php echo UserModule::t("Users"); ?></h1>


<?php
echo CHtml::textField('filter', (isset($_GET['filter'])) ? $_GET['filter'] : '', array('id' => 'filter', "placeholder" => "Search"));
?>

<div class="nav-buttons floated top-right">
    <a class="btn-small btn" href="/user/registration">Create New User</a>
</div>

<?php //echo CHtml::link(UserModule::t('Advanced Search'), '#', array('class' => 'search-button'));   ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $model->search(),
    "id" => "user-grid",
    'sortableAttributes' => array("username", 'profile.FirstName', 'profile.LastName', 'lastvisit_at'),
    "template" => "{sorter}<div class='list-view standard-list'>{items}</div>",
    'itemView' => '_view',
));
?>

<script>


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
                        item.toggleClass("selected");
                        item.width(item.width());

                        var isSelected = item.hasClass("selected");

                        if (isSelected) {
                            selectItem(item)
                        } else {
                            deselectItem(item)
                        }

                    })
                }

                $.fn.updateLabel = function() {
                    if (selection.length > 0) {
                        $(".list-selection").css("display", "block")
                        $(".list-selection").stop().transition({opacity: 1});
                        $(".list-selection .label").html(formatDisplayableTextForSelection(selection))
                    } else {
                        $(".list-selection .label").css("opacity", 0) // to prevent jumping of text
                        $(".list-selection").stop().transition({opacity: 0}, function() {
                            $(this).css("display", "none")
                            $(".list-selection .label").css("opacity", 1) 
                        });
                    }
                }

                function deselectItem(item) {
                    var itemLabel = item.find("h4").first().html();
                    $.each(selection, function(i) {
                        if (selection[i] === itemLabel)
                            selection.splice(i, 1);
                    });

                    item.transition({"padding-left": 0});

                    $("#user-grid").trigger("selection-changed")
                }

                function selectItem(item) {
                    var itemLabel = item.find("h4").first().html();
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
                        console.log(selection);

                        $("#user-grid").find("a.selected").each(function() {
                            deselectItem($(this))
                        })
                    }
                }

                $.fn.selection = function(method) {

                    // Method calling logic
                    if (methods[method]) {
                        return methods[ method ].apply(this, Array.prototype.slice.call(arguments, 1));
                    } else if (typeof method === 'object' || !method) {
                        return methods.init.apply(this, arguments);
                    } else {
                        $.error('Method ' + method + ' does not exist on jQuery.selection');
                    }

                };
            })(jQuery);

            $("#user-grid").on("click", "a.list-view-item", function(e) {
                // $.fn.selectItem($(this))
                if (e.metaKey)
                    $.fn.toggleItem($(this))
                e.stopPropagation();
                return false;
            })
            
            $("#user-grid").on("selection-changed", function() {
                $.fn.updateLabel()
            })

</script>