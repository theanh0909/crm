
$(function() {
    $("#checkall").click(function() {
        var checkedStatus = this.checked;
        $("#listcheck tbody tr").find(":checkbox").each(function() {
            $(this).prop("checked", checkedStatus);
        });
    });
});

