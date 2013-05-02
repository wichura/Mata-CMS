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
