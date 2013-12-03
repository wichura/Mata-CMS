<div id="icoCMSClientFrontEndHeader" class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a href="#" onclick="navigate(this, '/desktop/welcome')" class="brand"><?php echo Yii::app()->name ?></a>
            <div class="nav-collapse">
                <ul class="nav" id="topMenu">
                    <li onclick="icoCMS.icoCMSClientFrontEndWidget.markEditableSections()">Show sections</li>
                    <li onmouseout="icoCMS.icoCMSClientFrontEndWidget.onPreviewBtnHoverOut()" onmouseover="icoCMS.icoCMSClientFrontEndWidget.onPreviewBtnHover()" onclick="icoCMS.icoCMSClientFrontEndWidget.togglePreviewMode(true)" id="previewModeBtn" onclick="icoCMS.icoCMSClientFrontEndWidget.togglePreviewMode()"></li>
                </ul>
                <p class="navbar-text pull-right">Logged in as <a href="http://cms.icodesign.com/login/logout"><?php echo IcoCMSClient::$cmsUserName ?></a></p>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>

<div class="modal hide fade" id="icoCMSClientFrontEndModal" style="display: none;">
    <div class="modal-header">
        <a data-dismiss="modal" class="icoCMSClientFrontEndClose">×</a>
        <h3><?php echo Yii::app()->name ?> CMS</h3>
    </div>
    <div class="modal-body">
        <iframe></iframe>
    </div>
</div>

<div id="icoCMSEditableSectionSideNavigator">
    <div class="viewportPosition"></div>
</div>