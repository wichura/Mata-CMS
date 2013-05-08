/* NAMESPACES */
window.mata = {};
mata.widget = {};

mata.switchProject = function() {
    mata.dialogBox.renderView("Switch Project", "/mata/home/getProjectsSelector", function() {
        var projectId = $(this).attr("data-project-id");
        $.ajax("/mata/home/setProject", {
            data: {
                projectId: projectId
            }
        }).success(function(data) {
            $("#project-name").html(data.Name);
            mata.dialogBox.hide()
        });
    })
}