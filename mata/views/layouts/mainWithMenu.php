<?php $this->beginContent('/layouts/main'); ?>

<div id="side-menu-container">
    <div id="side-menu">
        <ul>
            <li id="side-menu-dashboard"><a onclick="hideSubmenu()" href='/mata/dashboard'><img src='/images/layout/icons/map-icon.png' /></a></li>
            <!--<li id="side-menu-content"><a href='javascript:void(0)' onclick="showSideMenu('content')"><img src='/images/layout/icons/note-icon.png' /></a></li>-->
            <li id="side-menu-profiles"><a href='javascript:void(0)' onclick="showSideMenu('profiles')"><img src='/images/layout/icons/user-<?php echo $this->user->Sex ?>-icon.png' /></a></li>
            <!--<li id="side-menu-forms"><a href='#'><img src='/images/layout/icons/texting-icon.png' /></a></li>-->
            <li id="side-menu-settings"><a href='javascript:void(0)' onclick="showSideMenu('settings')"><img src='/images/layout/icons/settings-icon.png' /></a></li>
            <!--<li id="side-menu-help"><a href='#'><img src='/images/layout/icons/loudspeaker-icon.png' /></a></li>-->
        </ul>

        <footer>
            <a id="project-name" href='javascript:void(0)' onclick='mata.switchProject()'><?php echo $this->user->project->Name ?></a>
            <a href="/user/logout">You are <?php echo $this->user->FirstName . " " . $this->user->LastName ?></a>
        </footer>
    </div>
    <div id="sub-menu-profiles" class="sub-menu">
        <h2>Accounts</h2>
        <p>Lorem ipsum dolor sit amet, consectuter adupiscig dig.</p>
        <ul>
            <li><a href='/user/admin/update/id/<?php echo $this->user->getId() ?>'><img src="/images/layout/icons/creditcard-icon.png" />Your account</a></li>
            <li><a href='/user/admin'><img src="/images/layout/icons/world-icon.png" />Manage others</a></li>
        </ul>

    </div>
    <div id="sub-menu-content" class="sub-menu">
        <h2>Content</h2>
        <p>Lorem ipsum dolor sit amet, consectuter adupiscig dig.</p>
        <ul>
            <li><a href='/user/admin/update/id/<?php echo $this->user->getId() ?>'><img src="/images/layout/icons/creditcard-icon.png" />Content Blocks</a></li>
            <li><a href='/user/admin'><img src="/images/layout/icons/world-icon.png" />Forms</a></li>
            
            <li><a href='/user/admin'><img src="/images/layout/icons/world-icon.png" />Posts</a></li>

        </ul>

    </div>
    <div id="sub-menu-settings" class="sub-menu">
        <h2>Settings</h2>
        <p>Lorem ipsum dolor sit amet, consectuter adupiscig dig.</p>
        <ul>
            <li><a href='/client/client'><img src="/images/layout/icons/case-icon.png" />Clients</a></li>
            <li><a href='/contentBlock/contentBlock'><img src="/images/layout/icons/new-window-icon.png" />Content block</a></li>
            <li><a href='/project/project'><img src="/images/layout/icons/macbook-icon.png" />Projects</a></li>
            <li><a href='/media/media'><img src="/images/layout/icons/image-icon.png" />Media</a></li>
        </ul>

    </div>
</div>

<iframe frameborder="0" id='content-container'>
</iframe>

<?php
$this->widget("application.modules.touchstone.widgets.touchstoneWidget.TouchstoneWidget", array(
    "scenario" => "User module testing"
));
?>


<script>

                $(window).ready(function() {
                    $("#side-menu-dashboard a").trigger("click");
                    // Requires jQuery!

                    jQuery.ajax({
                        url: "http://jira.qi-interactive.com/s/en_UKevdmcy-418945332/812/4/1.2.7/_/download/batch/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector-embededjs/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector-embededjs.js?collectorId=c33a832b",
                        type: "get",
                        cache: true,
                        dataType: "script"
                    });

                })
                $("#side-menu-container").find("li a").bind("click", function() {


                    $("#content-container").attr("src", $(this).attr("href"));
                    $(this).parents("ul").first().find(".active").removeClass("active")
                    $(this).parent().first().addClass("active")

                    return false;
                })

                function showSideMenu(section) {
                    hideSubmenu()
                    $("#sub-menu-" + section).transition({
                        left: 100
                    }).addClass("active");

                    $("#side-menu-" + section).addClass("active")

                    $("#content-container").transition({
                        "margin-left": 321
                    });

                    $(window).bind("keyup.sub-menu", function(e) {
                        if (e.keyCode == 27) {
                            hideSubmenu();
                            e.stopPropagation();
                        }

                    });
                }

                function hideSubmenu() {
                    $(".sub-menu.active").transition({
                        left: -121
                    }).removeClass("active")

                    $("#content-container").transition({
                        "margin-left": 100
                    });

                    $(window).unbind("keyup.sub-menu");
                }
</script>

<?php $this->endContent(); ?>