
$(document).ready(function() {
    // set a default cost


    ////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////
    // remove errorfields once a text field has an entry 
    $('.reqfield').change(function() {
        if ($(this).parent().next().hasClass('errorfield')) {
            $(this).parent().next().slideUp(250, function() {
                $(this).remove();
            });
        }
        if ($(this).parent().parent().parent().parent().children().hasClass('errorfield')) {
            $(this).parent().parent().parent().parent().children('.errorfield').slideUp(250, function() {
                $(this).remove();
            });
        }
    });

    ////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////
    // check registrant info for missing fields 
    function checkForm(p_type) {
        // reset no submit variable
        var type = p_type;
        var noSubmit = false;
        // remove all previously flagged fields

        $('.errorfield').slideUp(250, function() {
            $(this).remove();
        });

        // if noSubmit has been change to true something is missing, report it
        $('#drawtype').val(type);
        //$('#result').attr('action','includes/processForm.php').submit();
        var_form_data = $('#registration').serialize();
        $.ajax({
            type: 'POST',
            url: 'includes/drawName.php',
            data: var_form_data,
            dataType: 'json',
            success: function(data) {
                if (data.error) {
                    // if any errors were reported or a decline was genereated
                    //alert("php error: "+data.msg);
                    $('#processingHolder').slideUp(500);
                    $('#processResponse').html("<div class=\"processError\">" + data.msg + "</div>").slideDown(250);
                    if (data.instructions != "killCart") {
                        $('#result').delay(250).slideDown(500);
                    }
                } else {
                    // everything was OK display processing confirmation
                    //alert("success: "+data.msg);
                    $('#processingHolder').slideUp(500);
                    $('#result').append("<hr><p><b>Winner from the " + type + " pool is:</b></p><p>" + data.first + " " + data.last + ", " + data.email + "<br />Company: " + data.company + "</p>").delay(500).slideDown(250);
                    $('#' + type + 'ids').val($('#' + type + 'ids').val() + data.id + "|");

                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                //alert("ajax error: "+errorThrown);
                $('#processResponse').html("<div class=\"processError\">ajax error: " + errorThrown + "</div>").slideDown(250);
                $('#result').delay(250).slideDown(500);
                $('#processingHolder').slideUp(500);
            }
        });
    }

    ////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////
    // hide the registrant info and check it 
    $('.draw').click(function() {
        checkForm($(this).attr('id'));
        $('#result').slideUp(500);
        $('#processingHolder').delay(500).slideDown(250);
        $('#processResponse').slideUp(250);
    });






});