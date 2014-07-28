$(document).ready(function() {
    var laravelLogViewerCollapse = $('div[id^="collapse-"]');
    laravelLogViewerCollapse.on('shown.bs.collapse', function () {
      laravelLogViewerCollapse.removeClass().addClass('panel-primary');
    })
    laravelLogViewerCollapse.collapse('show');

    $.ajax({
        url: laravelLogViewerURL,
        type: "GET",
        dataType: "html",
        timeout: 10000,
        success: function(data, status, xhr) {
            var area = $('#data');
            area.fadeOut(200, function() {
                area.html(data);
                area.fadeIn(200);
            });
        },
        error: function(xhr, status, error) {
            var area = $('#data');
            area.fadeOut(200, function() {
                area.html('<div id="log" class="well"><div class="alert alert-danger">There are no log entries within these constraints.</div></div>');
                area.fadeIn(200);
            });
        }
    });
});
