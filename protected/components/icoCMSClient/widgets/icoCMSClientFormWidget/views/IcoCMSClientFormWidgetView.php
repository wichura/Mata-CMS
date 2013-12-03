<?php
$form = $this->beginWidget('CActiveForm', $this->formOptions);
$validators = array();
?>

<?php
foreach ($this->attributes as $attributeName => $attributeOptions):

    if (isset($attributeOptions["rules"])) {
        if (is_array($attributeOptions["rules"])) {
            $attributeOptions["rules"] = implode(",", $attributeOptions["rules"]);
        }
        $validators[$attributeName] = $attributeOptions["rules"];
    }
    ?>



    <?php
    $htmlOptions = isset($attributeOptions["htmlOptions"]) ? $attributeOptions["htmlOptions"] : array();

    $elementName = $this->id . "[" . $attributeName . "]";

    if (isset($attributeOptions["label"]) == false || $attributeOptions["label"] != false) {
        $label = "<label class='" . $attributeOptions["type"] . "'>" . (isset($attributeOptions["label"]) ? $attributeOptions["label"] : CHtml::label($attributeName, $attributeName));

        // treat as required if rules are present
        if (isset($attributeOptions["rules"]))
            $label .= $this->requiredCharacter;
        $label .= "</label>";
    } else {
        $label = "";
    }

    if (isset($validationErrors[$attributeName])) {
        $error = "<div id='error-" . $attributeName . "' class='error-message'>" . $validationErrors[$attributeName]["message"] . "</div>";
    } else {
        $error = "";
    }

    // Get param from request, if not the one from config, if not the default
    $elementValue = isset($_POST[$this->id][$attributeName]) ? $_POST[$this->id][$attributeName] : (isset($htmlOptions["value"]) ? $htmlOptions["value"] : "");
    $elementHTML;
    switch ($attributeOptions["type"]) {
        case "text":
            $elementHTML = "<div id='form-" . $attributeName . "' class='elementWrapper input'>" . CHtml::textField($elementName, $elementValue, $htmlOptions) . "</div>";
            break;
        case "textarea":
            $elementHTML = "<div id='form-" . $attributeName . "'  class='elementWrapper textarea'>" . CHtml::textArea($elementName, $elementValue, $htmlOptions) . "</div>";
            break;
        case "dropdown":

            $values = array();
            foreach ($attributeOptions["values"] as $key => &$value) {
                if (is_numeric($key)) {
                    $values[$value] = $value;
                } else {
                    $values[$key] = $value;
                }
            }

            $elementHTML = "<div id='form-" . $attributeName . "'  class='elementWrapper input'>" . CHtml::dropDownList($elementName, $elementValue, $values, $htmlOptions) . "</div>";
            break;
        case "checkbox":
            $elementHTML = "<div id='form-" . $attributeName . "'  class='elementWrapper checkbox'>" . CHtml::checkBox(null, null, $htmlOptions);

            if (isset($elementValue) == false || $elementValue == null)
                $elementValue = 'No';

            $elementHTML .= CHtml::hiddenField($elementName, $elementValue) . "</div>";
            break;
        case "static":
            $elementHTML = $attributeOptions["value"];
            $attributeOptions["template"] = isset($attributeOptions["template"]) ? $attributeOptions["template"] : "{element}";
            break;

        case "clear":
            $attributeOptions["template"] = "{element}";
            $elementHTML = "<div class='core-clear'></div>";
            break;
        default:
            throw new Exception("Type not recognised " . $attributeName);
            break;
    }


    if (isset($attributeOptions["template"])) {
        $elemToRender = str_ireplace("{label}", $label, $attributeOptions["template"]);
        $elemToRender = str_ireplace("{error}", $error, $elemToRender);
        $elemToRender = str_ireplace("{element}", $elementHTML, $elemToRender);
        echo $elemToRender;
    } else {
        $errorClass = isset($validationErrors[$attributeName]) ? "error" : "";
        echo '<div id="row-' . $attributeName . '" for="' . $attributeName . '" class="row ' . $errorClass . '">' . $label . $error . $elementHTML . "</div>";
    }
    ?>

    <?php
endforeach;

Yii::app()->session[$this->id . "[validators]"] = $validators;
?>

<input type="hidden" value="<?php echo $this->CMSFormName ?>" name="<?php echo $this->id ?>[CMSFormName]" />

<div class="row buttons">
    <?php
    echo CHtml::submitButton($this->submitButtonText)
    ?>
</div>

<?php $this->endWidget(); ?>

<?php if ($this->isAjax): ?>
    <script type="text/javascript">
        $("#<?php echo $this->id ?>").submit(function() {

            $(this).ajaxSubmit({
                "url": "<?php echo $this->ajaxProcessURL ?>",
                success: function(d) {
                    console.log(2222)
                    $("#<?php echo $this->id ?>").find(".row").each(function(i, elem) {
                        $(elem).removeClass("error")

                        $("#<?php echo $this->id ?>").find(".error-message").each(function(i, elem) {
                            $(elem).remove();
                        })

                    })

                    console.log(d)

                    if (d != null && d.length == undefined) {

                        console.log(222)
                        jQuery.each(d, function(name, value) {

                            var row = $($("#<?php echo $this->id ?>").find(".row[for='" + name + "']")[0]);
                            if (row.find(".error-message").length > 0) {
                                $(row.find(".error-message")[0]).html("").html(value.message)
                            } else {
                                $(row.find("label")[0]).after($("<div id='error-" + name + "' class='error-message'/>").html(value.message))
                            }
                            row.addClass("error")

                        });
                    } else {
                        $("#<?php echo $this->id ?>").trigger("icoCMSFormClient::formProcessed")
                    }
                },
                error: function() {
                    alert("22")
                }
            })

            return false
        })




        /**
         *  Becuase unticked checkboxes don't send any value to the server, we need to 
         *  replace it with hidden element that plugs into the checkbox
         */

        $("#<?php echo $this->id ?>").find(".elementWrapper.checkbox").each(function(i, elem) {
            elem = $(elem)

            var checkbox = $(elem.find("input[type='checkbox']")[0])
            var hidden = $(elem.find("input[type='hidden']")[0])

            checkbox.change(function() {
                hidden.val(checkbox.is("::checked") ? 'Yes' : 'No')
            })
        })
    </script>

<?php endif; ?>
