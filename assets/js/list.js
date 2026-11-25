function update_list(targetid, baseurl, id) {
    var dt1 = baseurl.split("?");

    $.ajax({
        type: "GET",
        url: dt1[0],
        data: dt1[1],
        success: function(msg) {
            eval(msg);

            var select = $(targetid);
            if (select) {
                if (select.prop) {
                    var options = select.prop('options');
                } else {
                    var options = select.attr('options');
                }
                $('option', select).remove();
                $.each(newOptions, function(val, text) {
                    options[options.length] = new Option(text, val);
                });
            }
            if (id != '0') $(targetid).val(id);
            // $(targetid).selectpicker('refresh');
        }
    });
}

function resetsel(target) {
    var select = $(target);
    if (select) {
        if (select.prop) {
            var options = select.prop('options');
        } else {
            var options = select.attr('options');
        }
        var fopt = options[0];
        $('option', select).remove();

        options[0] = fopt;
    }
}