<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
        <meta HTTP-EQUIV="Expires" CONTENT="-1">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="/css/gumby.css" media="screen, projection" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/js/js-base/lib/jQuery/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="/js/js-base/lib/jQuery/jquery-ui-transitions-1.8.21.min.js"></script>
        <script type="text/javascript" src="/js/main.js"></script>

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>

    <body>

        <div id="main">
            <?php echo $content; ?>
        </div>

        <script type="text/javascript" src="//use.typekit.net/yho8kmm.js"></script>
        <script type="text/javascript">try {
                Typekit.load();
            } catch (e) {
            }</script>
    </body>
</html>