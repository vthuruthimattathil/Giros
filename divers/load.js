$(document).ready(function() {
    dispMenu(".MAINTENANCE");
    if ($("#eleTable").length) {
        $("#eleTable").tablesorter({
            headerTemplate: '{content}{icon}'
        });
    }
    ;
});