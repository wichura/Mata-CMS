window.icoCMS = window.icoCMS || {};
icoCMS.icoCMSClientFrontEndWidget = icoCMS.icoCMSClientFrontEndWidget || {};



icoCMS.icoCMSClientFrontEndWidget = {
    isPreviewMode : null, 
    cookieKeyPreviewMode : "cPm"
}

$(document).ready(function() {
    icoCMS.icoCMSClientFrontEndWidget.init()
});

icoCMS.icoCMSClientFrontEndWidget.init = function() {
    icoCMS.icoCMSClientFrontEndWidget.sideNavigator.init();
    icoCMS.icoCMSClientFrontEndWidget.markEditableSections();
    icoCMS.icoCMSClientFrontEndWidget.createSortableSections();
    
    
    icoCMS.icoCMSClientFrontEndWidget.isPreviewMode = $.cookie(icoCMS.icoCMSClientFrontEndWidget.cookieKeyPreviewMode) == null ? 
    true : $.cookie(icoCMS.icoCMSClientFrontEndWidget.cookieKeyPreviewMode);
    
    // Persist the state
    icoCMS.icoCMSClientFrontEndWidget.setPreviewMode(icoCMS.icoCMSClientFrontEndWidget.isPreviewMode);
    
}

icoCMS.icoCMSClientFrontEndWidget.createSortableSections = function() {
    
    $(".icoCMSSortableSection").each(function(i, elem) {
        $(elem).sortable({
            items: $(elem).attr("accept"),
            stop: function(event, ui) {
                var moduleId = $(this).attr("moduleId");
                var context = $(this).attr("context");
                var itemOrder = [];
            
                $(this).children().each(function(i, item) {
                    itemOrder[i] = $(item).attr("ref");
                })
            
                $.ajax({
                    url: "http://cms.icodesign.com/ItemOrder/reorder",
                    data: {
                        "items" : itemOrder,
                        "context" : context,
                        "moduleId" : moduleId
                    },
                    dataType: "jsonp" // required for cross-browser call
                })
            }
        })
    })
        
        
        
}

icoCMS.icoCMSClientFrontEndWidget.markEditableSections = function() {
    
    if ($(".icoCMSEditableSection").length > 0) {
        $(".icoCMSEditableSection").each(function(i, elem) {
        
            elem = $(elem);
        
            var marker; 
            if (elem.find(".icoCMSEditableSectionMarker").length > 0) {
                marker = $($(elem.find(".icoCMSEditableSectionMarker"))[0]);
            } else {
                
                if (elem.attr("action") != null) {
                    marker = $("<a/>").attr({
                        "class" : "icoCMSEditableSectionMarker btn btn-small btn-danger",
                    }).html("Remove");
                } else {
                    // generic edit marker
                    marker = $("<a/>").attr({
                        "class" : "icoCMSEditableSectionMarker btn btn-small btn-info",
                        "data-toggle"  : "modal",
                        "href" : "#icoCMSClientFrontEndModal"
                    }).html("Edit");
                }
                
                
                
            }
            
            marker.modal({
                backdrop: true,
                show: false,
                keyboard: false
            })
            
            //  reference to elem might change later on in the logic
            var containerElem = elem;
            
            marker.bind('click', function () {
                
                var module; 
                
                var classNames = containerElem.attr("class").split(" ");
                $(classNames).each(function(i, className) {
                    if (icoCMS.isValidModule(className)) 
                        module = className;
                });
                
                if (containerElem.attr("action") != null) {
                    var action = containerElem.attr("action");
                    $.ajax({
                        type: "POST",
                        dataType: 'jsonp',
                        data: {
                            "ajax" : "true"
                        },
                        url: "http://cms.icodesign.com" + action
                    })
                    
                    // Assume it works - could not hook on complete event
                    $(containerElem).fadeOut(500, function() {
                        $(containerElem).remove();
                    })
                    
                    console.log("http://cms.icodesign.com/" + module + "/" + module + "/update/id/" + containerElem.attr("ref"))
                    
                } else if (containerElem.attr("ref") != null) {
                    $($("#icoCMSClientFrontEndModal").find("iframe")[0]).attr("src", "http://cms.icodesign.com/" + module + "/" + module + "/update/id/" + containerElem.attr("ref"));
                } else {
                    alert("There has been a problem with the references - please forgive us!")
                }
            })
            
            
            /**
         * We need to check if the child element is floated. If it is, 
         * the logic of appending the marker is slightly different, as 
         * we are not able to fetch the offset accurately
         */
            if ($(elem.children()[0]).css("float") != "none") {
                elem = $(elem.children()[0]);
            }

            marker.css({
                display: "none",
                right: -3,
                top: 3 
            })
        
            elem.append(marker);
            
            marker.delay(20 * i).fadeIn(180);
        })
    }
    
    $(window).trigger({
        type:"icoCMSClient::frontEnd::editableSectionStateChanged",
        isOn:true
    });
}

icoCMS.isValidModule = function(moduleName) {
    if (moduleName == "contentBlock") 
        return true
    
    return false;
}


icoCMS.icoCMSClientFrontEndWidget.sideNavigator = function() {
    
    elem = null,
    viewportMarker = null,
    
    /**
 * Used to offset the marker top position against the elem height
 */
    viewportMarkerHeightInDecimal = null
}


icoCMS.icoCMSClientFrontEndWidget.sideNavigator.init = function() {
    icoCMS.icoCMSClientFrontEndWidget.sideNavigator.elem = $("#icoCMSEditableSectionSideNavigator");
    
    icoCMS.icoCMSClientFrontEndWidget.sideNavigator.viewportMarker = $(icoCMS.icoCMSClientFrontEndWidget.sideNavigator.elem.find(".viewportPosition")[0]);
    
    
    $(window).on("resize", function() {
        icoCMS.icoCMSClientFrontEndWidget.sideNavigator.setViewportMarkerSize()
    })
    
    $(window).on("scroll", function() {
        icoCMS.icoCMSClientFrontEndWidget.sideNavigator.setViewportMarkerPosition()
    });
    
    $(window).on("icoCMSClient::frontEnd::editableSectionStateChanged", function(e) {
        e.isOn == true ? icoCMS.icoCMSClientFrontEndWidget.sideNavigator.show() : icoCMS.icoCMSClientFrontEndWidget.sideNavigator.hide();
    })

    icoCMS.icoCMSClientFrontEndWidget.sideNavigator.setViewportMarkerSize()
    icoCMS.icoCMSClientFrontEndWidget.sideNavigator.setEditableRegionsMarkers();
}


icoCMS.icoCMSClientFrontEndWidget.sideNavigator.setViewportMarkerSize = function() {
    icoCMS.icoCMSClientFrontEndWidget.sideNavigator.viewportMarkerHeightInDecimal = $(window).height() / $(document).height()
    // set viewport marker height to height of the page
    icoCMS.icoCMSClientFrontEndWidget.sideNavigator.viewportMarker.css({
        height: parseInt(icoCMS.icoCMSClientFrontEndWidget.sideNavigator.viewportMarkerHeightInDecimal * 100) + "%"
    });
}


icoCMS.icoCMSClientFrontEndWidget.sideNavigator.setViewportMarkerPosition = function() {
    
    var w = $(window)
    var windowPositionInDecimal = (w.scrollTop()) / ($(document).height() - w.height());
    
    icoCMS.icoCMSClientFrontEndWidget.sideNavigator.viewportMarker.css({
        "top" : parseInt(Math.ceil((windowPositionInDecimal - 
            (windowPositionInDecimal * icoCMS.icoCMSClientFrontEndWidget.sideNavigator.viewportMarkerHeightInDecimal)) * 100))  + "%"
    });
}
    
    
icoCMS.icoCMSClientFrontEndWidget.sideNavigator.setEditableRegionsMarkers = function() {
    
    editableRegions = $(".icoCMSEditableSection");
    
    editableRegions.each(function(i, elem) {
        elem = $(elem)
        
        // Find contents for tooltip
        var contentsForTooltip = elem.find("h1, h2, h3, p");
        contentsForTooltip = contentsForTooltip.length > 0 ? $(contentsForTooltip[0]).html() : ""

        var marker = $("<div/>").attr({
            "class" : "marker",
            "rel" : "tooltip",
            "title" : contentsForTooltip
        });
        
        marker.css({
            top : parseInt(elem.offset().top / ($(document).height()) * 100) + "%"
        })
        
        // some breathing space so the element is not flushed to the top
        var marginFromTop = 15;
        
        
        marker.tooltip({
            placement: "right"
        })
        
        marker.on("click", function() {
            
            marker.tooltip('hide')
            
            $('body,html').animate({
                scrollTop: $(document).height() * ((elem.offset().top - elem.height() - marginFromTop) / $(document).height())
            }, {
                duration: 300
            });
        })
        
        icoCMS.icoCMSClientFrontEndWidget.sideNavigator.elem.append(marker);
    })
}

icoCMS.icoCMSClientFrontEndWidget.sideNavigator.show = function() {
    icoCMS.icoCMSClientFrontEndWidget.sideNavigator.elem.animate({
        left: 10
    })
}

icoCMS.icoCMSClientFrontEndWidget.sideNavigator.hide = function() {
    icoCMS.icoCMSClientFrontEndWidget.sideNavigator.elem.animate({
        left: icoCMS.icoCMSClientFrontEndWidget.sideNavigator.elem.width() * -1
    })
}
    
icoCMS.icoCMSClientFrontEndWidget.setPreviewMode = function(isPreview) {
    $.cookie(icoCMS.icoCMSClientFrontEndWidget.cookieKeyPreviewMode, isPreview);
    icoCMS.icoCMSClientFrontEndWidget.isPreviewMode = $.cookie(icoCMS.icoCMSClientFrontEndWidget.cookieKeyPreviewMode);
    
    if (icoCMS.icoCMSClientFrontEndWidget.getIsPreviewMode()) {
        $("#previewModeBtn").removeClass("active");
        $("#previewModeBtn").html("Preview mode");
    } else {
        $("#previewModeBtn").addClass("active");
        $("#previewModeBtn").html("Live mode");
    }
}

icoCMS.icoCMSClientFrontEndWidget.onPreviewBtnHover = function() {
    $("#previewModeBtn").html(icoCMS.icoCMSClientFrontEndWidget.getIsPreviewMode() ? "Live mode" : "Preview mode");
}

icoCMS.icoCMSClientFrontEndWidget.onPreviewBtnHoverOut = function() {
    icoCMS.icoCMSClientFrontEndWidget.setPreviewMode(icoCMS.icoCMSClientFrontEndWidget.getIsPreviewMode())
}


icoCMS.icoCMSClientFrontEndWidget.togglePreviewMode = function(refreshWindow) {
    icoCMS.icoCMSClientFrontEndWidget.setPreviewMode(icoCMS.icoCMSClientFrontEndWidget.getIsPreviewMode() ? "false" : "true");
    
    if (refreshWindow)
        window.location.reload();
}

icoCMS.icoCMSClientFrontEndWidget.getIsPreviewMode = function() {
    return icoCMS.icoCMSClientFrontEndWidget.isPreviewMode == "true";
}

