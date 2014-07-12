<!-- // Mike Zhao, REMOVE -->

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
        var totalCost = 200;
        // make stuff happen if they've gone back to make changes
        if (sidloaded) {
            //alert("test");
            $('.sessionButtons').each(function(index) {
                if ($(this).is(":checked")) {
                    $(this).parent().parent().parent().addClass("selected");
                }
            });
            $('.sponCategory').hide();
            $('.regType').each(function(index) {
                if ($(this).is(":checked")) {
                    //alert($(this).val());
                    if ($(this).val() == "FULL") {
                        $('.sponCategory').show();
                    } else {
                        $('#' + $(this).attr('value')).show();
                    }
                }
            });
            totalCost = $('#totalcharged').val();
            calcCost();
            populateRegistrantSummary();
        }
        ////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////
        // show billing fields if checked
        $('#billing_check').click(function() {
            if ($(this).is(':checked')) {
                $('#billingInfo').slideDown(250);
            } else {

                $('#billingInfo').slideUp(250, function() {
                    $('#billingInfo .reqfield').val('');
                    $('#billingInfo .noreqfield').val('');
                    $('#billingInfo .errorfield').remove();
                });
            }
        });

        ////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////
        // remove errorfields once a text field has an entry 
        $('.reqfield').change(function() {
            if ($(this).parent().next().hasClass('errorfield')) {
                $(this).parent().next().slideUp(250, function() {
                    $(this).remove();
                });
            }
            // match nickname to name if left blank
            if ($(this).attr('name') == "fname" && $('#nickname').val() == "") {
                $('#nickname').val($(this).val());
                if ($('#nickname').parent().next().hasClass('errorfield')) {
                    $('#nickname').parent().next().slideUp(250, function() {
                        $(this).remove();
                    });
                }

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
                    if ($(this).attr('type') != "hidden" && $(this).is(":visible")) {
                        var nameval = $(this).attr('name');
                        if ($(this).val() == "") {
                            if (!$(this).parent().next().hasClass('errorfield')) {
                                $(this).parent().after("<p class=\"errorfield\" style=\"clear:left;\">value required</p>");
                                noSubmit = true;
                            }
                        }
                        if (nameval == "email" || nameval == "billing_email") {
                            if (!CyJS_Utils_IsEmailValid($(this).val())) {
                                if (!$(this).parent().next().hasClass('errorfield')) {
                                    $(this).parent().after("<p class=\"errorfield\" style=\"clear:left;\">email is invalid</p>");
                                    noSubmit = true;
                                }
                            }
                        }
                    }
                    ;
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
                    // no errors let them continue with payment options
                    populateRegistrantSummary();
                    $('#registration').delay(1250).show(0, function() {
                        $('#processingHolder').slideUp(250);
                        $('#processResponse').html("").slideUp(250);
                        $('#registrantSummary').slideDown(500);
                        $('#registrationType').slideDown(500);
                    });
                }
            }
        }

        ////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////
        //------------------EMAIL CHECK------------------------

        function CyJS_Utils_IsEmailValid(checkThisEmail) {
            var myEMailIsValid = true;
            var myAtSymbolAt = checkThisEmail.indexOf('@');
            var myLastDotAt = checkThisEmail.lastIndexOf('.');
            var mySpaceAt = checkThisEmail.indexOf(' ');
            var myLength = checkThisEmail.length;
            // at least one @ must be present and not before position 2
            // @yellow.com : NOT valid
            // x@yellow.com : VALID
            if (myAtSymbolAt < 1)
            {
                myEMailIsValid = false
            }
            // at least one . (dot) afer the @ is required
            // x@yellow : NOT valid
            // x.y@yellow : NOT valid
            // x@yellow.org : VALID
            if (myLastDotAt < myAtSymbolAt)
            {
                myEMailIsValid = false
            }
            // at least two characters [com, uk, fr, ...] must occur after the last . (dot)
            // x.y@yellow. : NOT valid
            // x.y@yellow.a : NOT valid
            // x.y@yellow.ca : VALID
            if (myLength - myLastDotAt <= 2)
            {
                myEMailIsValid = false
            }
            // no empty space " " is permitted (one may trim the email)
            // x.y@yell ow.com : NOT valid
            if (mySpaceAt != -1)
            {
                myEMailIsValid = false
            }
            // comment this out as we have another way of letting them know - Heidi
            //if (myEMailIsValid == false)
            // {alert("You have entered an invalid Email. Please try again.")}
            return myEMailIsValid
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
        $('#savechanges').click(function() {
            checkForm();
            $('#registerInfo').slideUp(500);
            $('#processingHolder').delay(500).slideDown(250);
            $('#processResponse').slideUp(250);
        });

        ////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////
        // bring form back for changes
        $('#makeChanges').click(function() {
            $('#processingResponse').slideUp(250);
            $('#registrantSummary').slideUp(250);
            $('#registrationType').slideUp(250, function() {
                $('.regType').removeAttr('checked');
            });
            $('#registerInfo').slideDown(250);
            $('.registrationCategories').slideUp(250, function() {
                $('.sessionButtons').removeAttr('checked');
                $('.sessionButtons').parent().parent().parent().removeClass("selected");
            });
        });
        $('#editRegistrant').click(function() {
            $('#processingResponse').slideUp(250);
            $('#registrantSummary').slideUp(250);
            //$('#registrationType').slideUp(250, function(){ $('.regType').removeAttr('checked'); });
            $('#registerInfo').slideDown(250);
            //$('.registrationCategories').slideUp(250, function(){ $('.sessionButtons').removeAttr('checked'); $('.sessionButtons').parent().parent().parent().removeClass("selected"); });
        });
        ////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////
        // create a summary for review 
        function populateRegistrantSummary() {
            $('#regName').html($('#sal').val() + " " + $('#fname').val() + " " + $('#lname').val());
            if ($('#fname').val() != $('#nickname').val()) {
                $('#regName').html($('#regName').html() + "<br /><b>Badge Name: </b>" + $('#nickname').val() + "<br />");
            }
            var thetitle = "";
            if ($('#title').val() != "") {
                thetitle = $('#title').val() + "<br />";
            }
            $('#regCompany').html(thetitle + $('#company').val());

            // assemble address1
            var theaddress = $('#address1').val();
            if ($('#address2').val() != "") {
                theaddress += "<br>" + $('#address2').val() + "<br />";
            } else {
                theaddress += "<br />";
            }
            theaddress += $('#city').val();
            if ($('#state').val() != "") {
                theaddress += ", " + $('#state').val();
            }
            theaddress += "<br />";
            theaddress += $('#country').val() + "&nbsp;&nbsp;" + $('#zip').val();
            $('#regAddress').html(theaddress);

            $('#regEmail').html($('#email').val());
            $('#regPhone').html($('#phone').val());

            if (!$('#billing_check').is(":checked")) {
                $('#registrantFields').css("width", "92%");
                $('#billingFields').hide();
            } else {
                $('#registrantFields').css("width", "40%");
                $('#billingFields').show();
                $('#billName').html($('#billing_sal').val() + " " + $('#billing_fname').val() + " " + $('#billing_lname').val());

                var billtitle = "";

                if ($('#billing_title').val() != "") {
                    billtitle = $('#billing_title').val() + "<br />";
                }
                $('#billCompany').html(billtitle + $('#billing_company').val());

                // assemble address1
                var theaddress = $('#billing_address1').val();
                if ($('#billing_address2').val() != "") {
                    theaddress += "<br />" + $('#billing_address2').val() + "<br />";
                } else {
                    theaddress += "<br />";
                }
                theaddress += $('#billing_city').val();
                if ($('#billing_state').val() != "") {
                    theaddress += ", " + $('#billing_state').val();
                }
                theaddress += "<br />";
                theaddress += $('#billing_country').val() + "&nbsp;&nbsp;" + $('#billing_zip').val();
                $('#billAddress').html(theaddress);

                $('#billEmail').html($('#billing_email').val());
                $('#billPhone').html($('#billing_phone').val());

            }
        }

        ////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////
        // registration type
        $('.regType').click(function() {
            var setDelay = 0;
            if ($(this).val() == "FULL") {
                var er = $('#step2').next();
                if (er.hasClass('errorfield')) {
                    er.slideUp(250, function() {
                        $(this).remove();
                    });
                }
                if ($('.registrationCategories').is(":visible") && !$('#thursday').is(":visible")) {
                    $('.registrationCategories').slideUp(500, function() {
                        $('.sponCategory').show();
                        setDelay = 500;
                        $('.registrationCategories .errorfield').remove();
                    });
                }
                $('.registrationCategories').delay(setDelay).slideDown(500);
                calcCost();
            } else {
                var selectedDay = $(this).val();
                if ($('.registrationCategories').is(":visible")) {
                    $('.sponCategory').each(function(index) {
                        if ($(this).attr('id') != selectedDay) {
                            $("#" + $(this).attr('id') + ' input[type=radio]').removeAttr('checked');
                            $("#" + $(this).attr('id') + ' input[type=radio]').parent().parent().parent().removeClass('selected');
                            $("#" + $(this).attr('id') + ' input[type=checkbox]').removeAttr('checked');

                        }
                    });
                    //$('.registrationCategories input[type=radio]').removeAttr('checked');
                    $('.registrationCategories').slideUp(500, function() {
                        $('.sponCategory').hide();
                        $('#' + selectedDay).show();
                        setDelay = 500;
                    });
                } else {
                    $('.sponCategory').hide();
                    $('#' + $(this).val()).show();
                }
                $('.registrationCategories').delay(setDelay).slideDown(500);
                calcCost();
            }
        });

        ////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////
        // recalculate cost when amazing walk is clicked
        $('#amazing').click(function() {
            calcCost();
        });

        ////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////
        // calculate cost
        function calcCost() {
            if ($("input:radio[name='regType']:checked").val() == "FULL") {
                $('#totalcharged').val(200);
            } else {
                $('#totalcharged').val(75);
            }
            if ($('#amazing').is(":checked")) {
                $('#totalcharged').val(parseInt($('#totalcharged').val()) + 30);
            }
            $('#costAmount').text($('#totalcharged').val() + ".00");
        }

        ////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////
        // highlight selections / check tutorial selections
        $('.sessionButtons').click(function() {
            // remove errorfields associated with clicked item
            var itemname = $(this).attr('name');
            if ($('#' + itemname).children().hasClass('errorfield')) {
                $('#' + itemname + ' .errorfield').slideUp(250, function() {
                    $(this).remove();
                });
            }
            if (itemname == "tutorialA" && $(this).val() == "TU1") {
                $('#tutorialB .errorfield').slideUp(250, function() {
                    $(this).remove();
                });
            }

            // add item highlight
            $('input:radio[name=' + $(this).attr('name') + ']').parent().parent().parent().removeClass("selected");
            $(this).parent().parent().parent().addClass("selected");
            if ($(this).val() == "TU1") {
                $('.tutorials').parent().parent().parent().removeClass("selected");
                $(this).parent().parent().parent().addClass("selected");
                $('input:radio[name="tutorialB"]').removeAttr("checked");
            }
            ;
            if (parseInt($(this).val().substr($(this).val().length - 1)) > 3 && $(this).val().substr(0, 1) == "T") {
                if ($("input:radio[name='tutorialA']:checked").val() == "TU1") {
                    //alert("test");
                    $('#TU1').parent().parent().parent().removeClass("selected");
                    $('#TU1').removeAttr("checked");
                }
            }
        });
        ////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////
        // check session selections for missing fields
        $('#continuebutton2').click(function() {
            var noSubmit = false;
            $('#processingHolder').slideDown(250);
            $('#processResponse').slideUp(250);
            $('#registrantSummary').slideUp(500);
            $('#registrationType').slideUp(500);
            $('.registrationCategories').slideUp(500);
            $('.registrationCategories .errorfield').remove();

            var regtype = $('input:radio[name="regType"]:checked').val();
            var obj = "";
            if (regtype != "FULL") {
                obj = '#' + regtype + ' .sessionButtons';
            } else {
                obj = '.sessionButtons';
            }
            $(obj).each(function(index) {
                if ($(this).attr('type') == "radio") {
                    var getitem = $(this).attr("name");
                    // find our reg type
                    if ($('input:radio[name=' + getitem + ']:checked').length == 0) { // if the radio button is not selected
                        if ((getitem == "tutorialB" && $('input:radio[name="tutorialA"]:checked').val() != "TU1" && regtype != "FULL") || (getitem == "tutorialA" && regtype != "FULL") || (getitem != "tutorialA" && getitem != "tutorialB")) {

                            if (!$('#' + getitem).children().hasClass('errorfield')) { // if no existing error for the column exists
                                $('#' + getitem).append("<p class=\"errorfield\" style=\"clear:left;text-align:center;width:100px;margin:5px auto;\">Select a session from this column</p>");
                                $('#processResponse').html("<p class=\"errorfield\">Please make sure every column in the session table has a selection. All tutorials/sessions listed are covered under your registration category.</p>").delay(250).slideDown(250);

                                noSubmit = true;
                            }

                        }

                    }
                }
            });
            if ($('#promoCode').val() != "") {
                if ($('input:radio[name="regType"]:checked').val() != "FULL") {
                    $('#processResponse').html("<p class=\"errorfield\">Promotional Codes entitle you to a full registration. Please select the full registration and complete all categories.</p>").delay(250).slideDown(250);
                    $('#step2').after("<p class=\"errorfield\">Please change your category to a full registration</p>");
                    noSubmit = true;
                }
            }
            if (noSubmit) {
                $('.errorfield').delay(500).slideDown(0);
                $('.registrationCategories').delay(500).slideDown(500);
                $('#registrationType').delay(500).slideDown(500);
                $('#registrantSummary').delay(500).slideDown(500);
                $('#processingHolder').delay(500).slideUp(250);
            } else {
                //alert('form is good send it off');

                $('#processingHolder').delay(500).slideUp(250, function() {
                    $('#registration').attr('action', 'showInvoice.php').submit();
                });

            }
        });



    });