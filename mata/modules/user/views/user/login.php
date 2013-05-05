
<link rel="stylesheet" type="text/css" href="/css/login.css" />
<?php
$this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Login");
?>

<div id='user-login' class='floating-panel animated'>
    <?php if (Yii::app()->user->hasFlash('loginMessage')): ?>

        <div class="success">
            <?php echo Yii::app()->user->getFlash('loginMessage'); ?>
        </div>

    <?php endif; ?>

    <div class="form">
        <?php
        echo CHtml::beginForm('', 'post', array(
            "id" => "login-form"
        ));
        ?>

        <?php echo CHtml::errorSummary($model); ?>

        <div class="row">
            <?php
            echo CHtml::activeTextField($model, 'username', array(
                "placeholder" => "Login or Email"
            ))
            ?>
        </div>

        <div class="row">
            <?php
            echo CHtml::activePasswordField($model, 'password', array(
                "placeholder" => "Password"
            ))
            ?>
        </div>

        <div class="row">
            <p class="hint">
                <?php echo CHtml::link(UserModule::t("Lost Password?"), Yii::app()->getModule('user')->recoveryUrl); ?>
            </p>
        </div>

<!--        <div class="row rememberMe">
            <?php echo CHtml::activeCheckBox($model, 'rememberMe'); ?>
            <?php echo CHtml::activeLabelEx($model, 'rememberMe', array(
                "class" => "clickable"
            )); ?>
        </div>-->

        <div class="row submit">
            <?php
            echo CHtml::submitButton(UserModule::t("Login"), array(
                "class" => "btn-success",
                "id" => "login-btn"
            ));
            ?>
        </div>

        <?php echo CHtml::endForm(); ?>
    </div><!-- form -->


    <?php
    $form = new CForm(array(
        'elements' => array(
            'username' => array(
                'type' => 'text',
                'maxlength' => 32,
            ),
            'password' => array(
                'type' => 'password',
                'maxlength' => 32,
            ),
            'rememberMe' => array(
                'type' => 'checkbox',
            )
        ),
        'buttons' => array(
            'login' => array(
                'type' => 'submit',
                'label' => 'Login',
            ),
        ),
            ), $model);
    ?>

</div>

<script>



    $("#login-form").on("submit", function(e) {
//        mata.login();
//        e.stopPropagation();
//        return false;
    });

    mata.login = function(e) {
        $('#user-login').transition({opacity: 0}, function() {
            $(this).remove();
        });
    }

</script>