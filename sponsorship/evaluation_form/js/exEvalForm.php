<?php
header("Content-type: text/javascript");
session_start();
// generate a random string for verification
include_once('../../func_include/randomString.php');

$veristring = genRandomString(20);
//put $veristring in a session variable for tracking
$_SESSION['tempSessCheckoutId'] = $veristring;
// create a salt from the string
$verisalt = substr($veristring, 0, 1) . substr($veristring, round((strlen($veristring) - 1) / 2), 1) . substr($veristring, 9, 1);
// hash the value to pass through Ajax
$verihash = sha1($veristring . $verisalt);
?>
// <script>

    $(document).ready(function() {
        // set a default cost
        var totalCost = 0;
        var patronAmount = 5000;
        var sponsorAmount = 3000;
        var amazingWalkCost = 30;


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
        function checkForm() {
            // reset no submit variable
            var noSubmit = false;
            // remove all previously flagged fields

            $('.errorfield').slideUp(250, function() {
                $(this).remove();
            });
            var checkdelay = setInterval(checkfields, 300);
            function checkfields() {
                clearInterval(checkdelay);

                $('.reqfield').each(function(index) {
                    // check all input fields with reqfield class
                    //if($(this).val()=="" && ($(this).is(":visible") || $(this).attr('type')=="hidden")){ 
                    //alert($(this).attr('name')+": "+$(this).val());
                    if ($(this).attr('type') != "hidden" && ($(this).is(":visible") && !$(this).is(":disabled"))) {
                        //if(!$(this).is(":disabled")){ alert($(this).attr('name')); }
                        var nameval = $(this).attr('name');
                        if ($(this).val() == "") {
                            if (!$(this).parent().next().hasClass('errorfield')) {
                                $(this).parent().after("<p class=\"errorfield\" style=\"clear:left;\">value required</p>");
                                noSubmit = true;
                            }
                        }
                    }
                    ;
                    if ($(this).attr('type') == "radio" && $(this).is(":visible")) {
                        var getitem = $(this).attr("name");
                        if ($('input:radio[name=' + getitem + ']:checked').length == 0) {
                            if (!$(this).parent().parent().parent().parent().children().hasClass('errorfield')) {
                                $(this).parent().parent().parent().parent().append("<p class=\"errorfield\" style=\"clear:left;\">value required</p>");
                                noSubmit = true;
                            }
                        }
                    }
                    if ($(this).attr('type') == "checkbox" && $(this).is(":visible")) {
                        var getitem = $(this).attr("name");
                        if ($('input:checkbox[name=' + getitem + ']:checked').length == 0) {
                            if (!$(this).parent().parent().parent().parent().children().hasClass('errorfield')) {
                                $(this).parent().parent().parent().parent().append("<p class=\"errorfield\" style=\"clear:left;\">value required</p>");
                                noSubmit = true;
                            }
                        }
                    }
                });
                // if noSubmit has been change to true something is missing, report it
                if (noSubmit) {
                    $('#registration').delay(1500).show(0, function() {
                        $('#processingHolder').slideUp(250);
                        $('#processResponse').html("<p class=\"errorfield\">Your registration cannot be submitted as we are missing some of the required fields. Missing fields have been highlighted.</p>").delay(250).slideDown(250);
                        $('#registerInfo').delay(250).slideDown(500);
                        $('.errorfield').show();
                    });
                } else {
                    $('#checkoutId').val('<?php echo $verihash; ?>');
                    //$('#registration').attr('action','includes/processForm.php').submit();
                    var_form_data = $('#registration').serialize();
                    $.ajax({
                        type: 'POST',
                        url: 'includes/exhibitorProcessForm.php',
                        data: var_form_data,
                        dataType: 'json',
                        success: function(data) {
                            if (data.error) {
                                // if any errors were reported or a decline was genereated
                                //alert("php error: "+data.msg);
                                $('#processingHolder').slideUp(500);
                                $('#processResponse').html("<div class=\"processError\">" + data.msg + "</div>").slideDown(250);
                                if (data.instructions != "killCart") {
                                    $('#registerInfo').delay(250).slideDown(500);
                                }
                            } else {
                                // everything was OK display processing confirmation
                                //alert("success: "+data.msg);
                                $('#processingHolder').slideUp(500);
                                $('#processResponse').html("<div>" + data.msg + "</div><div>" + data.instructions + "</div>").slideDown(250);

                            }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            //alert("ajax error: "+errorThrown);
                            $('#processResponse').html("<div class=\"processError\">ajax error: " + errorThrown + "</div>").slideDown(250);
                            $('#registerInfo').delay(250).slideDown(500);
                            $('#processingHolder').slideUp(500);
                        }
                    });
                }
            }
        }

        ////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////
        // hide the registrant info and check it 
        $('#continuebutton').click(function() {
            checkForm();
            $('#registerInfo').slideUp(500);
            $('#processingHolder').delay(500).slideDown(250);
            $('#processResponse').slideUp(250);
        });






    });