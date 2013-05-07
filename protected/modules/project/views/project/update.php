<h1>Update <?php echo $model->getLabel(); ?></h1>
<div class='versioning'>
    <a href='#'>Versions</a>
</div>


<div class="dialog-box" id="project-selector" style="padding: 20px; opacity: 1; margin-left: -245px; margin-top: -15px;"><h2>Previous Versions</h2>
    <div id="yw0">

        <div class="multioption-container multioption-list">

            <div class="multioption-element " data-project-id="7">
                <a href="javascript:void(0)">Published 7th May 2013 by Wichura</a>
            </div>
            <div class="multioption-element " data-project-id="8">
                <a href="javascript:void(0)">Drafted 1st April 2013 by doivoid</a>
            </div>
            <div class="multioption-element " data-project-id="9">
                <a href="javascript:void(0)">Published 30th March 2013 by will.heaverman</a>
            </div>
        </div>
    </div>

    <script>
        mata.widget.projectSelector = {};

        var container = $("#yw0");

        container.on("click", ".multioption-element", function() {
            $(this).toggleClass("active");
            $(this).find("input[type=hidden]").val($(this).hasClass("active") ? 1 : 0)
        })

    </script></div>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>