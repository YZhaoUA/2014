<?php
header("Content-type: text/javascript");
session_start();
// generate a random string for verification
include_once('../func_include/randomString.php');

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
        var coffeeBreakAmount = 2500;
        
        //----HQ---- no amazing walk cost
        //var amazingWalkCost = 30;

        // make stuff happen if they've gone back to make changes
        if (sidloaded) {
            $('.sessionButtons').each(function(index) {
                if ($(this).is(":checked")) {
                    $(this).parent().parent().parent().addClass("selected");
                }
            });
            $('.sponCategory').hide();
            $('.regType').each(function(index) {
                if ($(this).is(":checked")) {
                    $('#' + $(this).attr('value')).show();
                }
            });
            totalCost = $('#totalcharged').val();
            calcCost();
            populateRegistrantSummary();
        }
        ////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////
        // show billing fields if checked

//----HQ---- no billing_check here         
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

                            if ($(this).val() != $('#confirmemail').val()) {
                                if (!$(this).parent().next().hasClass('errorfield')) {
                                    $(this).parent().after("<p class=\"errorfield\" style=\"clear:left;\">confirm email should be the same</p>");
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
            hideConditions();
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
            $('#regName').html(/*$('#sal').val() + " " + */$('#fname').val() + " " + $('#lname').val());
//            if ($('#fname').val() != $('#nickname').val()) {
//                $('#regName').html($('#regName').html() + "<br /><b>Badge Name: </b>" + $('#nickname').val() + "<br />");
//            }
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
//----HQ---- no billing fields
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
            $('.errorfield').remove();
            
            var setDelay = 0;

            var selectedDay = $(this).val();

            if ($('.registrationCategories').is(":visible")) 
            {
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
                hideConditions();
            } else {
                $('.sponCategory').hide();
                $('#' + $(this).val()).show();
            }
            $('.registrationCategories').delay(setDelay).slideDown(500, showConditions());

            if (selectedDay == 'PTRN')
            {
                $('#choicePTRN').attr('checked', 'checked');
            }
            else if (selectedDay == 'CBRK')
            {
                if ($('#choiceCBMA').length)
                {
                    $('#choiceCBMA').attr('checked', 'checked');
                }
                else if ($('#choiceCBMP').length)
                {
                    $('#choiceCBMP').attr('checked', 'checked');
                }
                else if ($('#choiceCBTA').length)
                {
                    $('#choiceCBTA').attr('checked', 'checked');
                }
                else if ($('#choiceCBTP').length)
                {
                    $('#choiceCBTP').attr('checked', 'checked');
                }
                else if ($('#choiceCBWA').length)
                {
                    $('#choiceCBWA').attr('checked', 'checked');
                }
                else if ($('#choiceCBWP').length)
                {
                    $('#choiceCBWP').attr('checked', 'checked');
                }
            }

            calcCost();
        });

        ////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////
        // recalculate cost when amazing walk is clicked
        // recalculate cost when sponsor category choice is changed
        $('#choicePTRN').click(function() {
            $('.errorfield').remove();
            calcCost();
        });
        $('#choicePTRM').click(function() {
            calcCost();
        });
                
        $('#patronAmount').click(function() {
            $('#choicePTRM').prop('checked', true);
        });

        $('#patronAmount').blur(function() {
//            if ($('#patronAmount').val() < 5000) {
//                $('#patronAmount').val(5000);
//
//            }
            calcCost();
            if($('#choicePTRM').is(':checked'))
            {
                CheckFormOnContinueButton2();
            }
        });

        $('#patronAmount').keyup(function() {
            calcCost();
        });
        $('#patronAmount').click(function() {
            calcCost();
        });


        ////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////
        // calculate cost
        function calcCost() {
            if ($("input:radio[name='regType']:checked").val() == "PTRN") {
                $('#totalcharged').val(patronAmount);            
                if ($('#choicePTRM').is(":checked")) {
                    $('#totalcharged').val($('#patronAmount').val());
                }
            } else if ($("input:radio[name='regType']:checked").val() == "SPNS") {
                $('#totalcharged').val(sponsorAmount);
            } else if ($("input:radio[name='regType']:checked").val() == "CBRK") {
                $('#totalcharged').val(coffeeBreakAmount);
            } else {
                $('#totalcharged').val(0);
            }
            
            $('#costAmount').text("$" + ($('#totalcharged').val() | 0) + ".00" <?php if(!0.00 == 0) echo "+ \" + GST\""; ?>);
        }

        ////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////
        // highlight selections / check tutorial selections
        $('.sessionButtons').click(function() {
            // remove errorfields associated with clicked item
            var itemvalue = $(this).value();

            if (itemvalue == "defaultPatron") {
                $('#choicePTRM').removeAttr("checked");
                $('#choicePTRM').parent().parent().parent().removeClass("selected");
                calcCost();
            }

            if (itemvalue == "customPatron") {
                $('#choicePTRN').removeAttr("checked");
                $('#choicePTRN').parent().parent().parent().removeClass("selected");
                calcCost();

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
            $('#processingHolder').slideDown(250);
            $('#processResponse').slideUp(250);
            $('#registrantSummary').slideUp(500);
            $('#registrationType').slideUp(500);
            $('.registrationCategories').slideUp(500);
            $('.registrationCategories .errorfield').remove();
            hideConditions();
            
            var noSubmit = CheckFormOnContinueButton2();
            
            if (!noSubmit) {
                //alert('form is good send it off');
                // process all the comment fields to prepare for sending
                $('.combinedfields').each(function(index) {
                    var wg = $(this).parent().attr('id');
                    var wgv = $('#' + wg + ' .wgselection').val();
                    var wgcv = $('#' + wg + ' .comment').val();

                    var divider = "*|*";
                    if (wgv != "" && wgcv != "") {
                        $(this).val(wgv + divider + wgcv);
                    }
                    //alert($(this).val());
                });

                $('#processingHolder').delay(500).slideUp(250, function() {
                    $('#registration').attr('action', 'payment.php').submit();
                });

            }
        });
        
        function isInteger(n) {
            var isInt = n % 1 === 0;
            return isInt;
        }

        function CheckFormOnContinueButton2()
        {
            $('.errorfield').remove();
            var noSubmit = false;
            var regtype = $('input:radio[name="regType"]:checked').val();
            var obj = "";
            obj = '#' + regtype + ' .sessionButtons';

            $(obj).each(function(index) {
                if ($(this).attr('type') == "radio") {
                    var getitem = $(this).attr("name");
                    // find our reg type
                    if ($('input:radio[name=' + getitem + ']:checked').length == 0) { // if the radio button is not selected
                        // additional check to see if the full day tutorial was selected, not to display the error or proceed with checking if the current button being checked is not the full day tutorial
                        if (getitem == "tutorialB") {
                            if (!$('#' + getitem).children().hasClass('errorfield')) { // if no existing error for the column exists
                                $('#' + getitem).append("<p class=\"errorfield\" style=\"clear:left;text-align:center;width:100px;margin:5px auto;\">Selct a amount</p>");
                                $('#processResponse').html("<p class=\"errorfield\">Please make sure your sponsorship category has a selection.</p>").delay(250).slideDown(250);

                                noSubmit = true;
                            }

                        }

                    }
                }
            });

            if (regtype == "CBRK") {
                if ($('#CBRK input').length == 0) {
                    $('#CBRK h3').first().append("<p class=\"errorfield\">All days have been sponsored</p>");
                    //$('#processResponse').html("<p class=\"errorfield\">You can not sponsor Coffee Break anymore, because all the three days are sponsored.</p>").delay(250).slideDown(250);

                    noSubmit = true;
                }
            }

            var isCustomPatron = $('input:radio[value="customPatron"]').prop("checked");
            var invalidPatronAmount = $('#patronAmount').val() < 5000;
            if ((isCustomPatron == true) && (invalidPatronAmount == true)) {
                //$('#processResponse').html("<p class=\"errorfield\">Patron sponsor amount is wrong, it must be higher than $5000</p>").delay(250).slideDown(250);
                $('#step2').after("<p class=\"errorfield\">Patron sponsor amount must be higher than $5000</p>");
                noSubmit = true;
            }
            
            var isCustomPatron = $('input:radio[value="customPatron"]').prop("checked");
            var isNum = $.isNumeric($('#patronAmount').val());
            var isInt = isInteger($('#patronAmount').val());
            if ((isCustomPatron == true) && (isNum == false || isInt == false)) {
                //$('#processResponse').html("<p class=\"errorfield\">Then Patron Sponsor Amount is wrong, it must be a valid number</p>").delay(250).slideDown(250);
                $('#step2').after("<p class=\"errorfield\">Patron sponsor amount must be a valid number</p>");
                noSubmit = true;
            } else if ((isCustomPatron == true) && ($('#patronAmount').val().indexOf(".")!=-1)) {
                var number = $('#patronAmount').val();
                $('#patronAmount').val(number | 0);
            }
//
//            $('.wgselection').each(function(index) {
//                var objnum = $(this).attr('id').replace('wg', '');
//                if ($(this).val() != "" && $('#wgc' + objnum).val() == "") {
//                    noSubmit = true;
//                    if (objnum > 1) {
//                        $(this).parent().parent().prepend("<p class=\"errorfield\">Please fill in a comment or remove this comment field.</p>");
//                    } else {
//                        $(this).parent().parent().prepend("<p class=\"errorfield\">Please fill in a comment or deselect the working group selection.</p>");
//                    }
//                    $('#processResponse').html($('#processResponse').html() + "<p class=\"errorfield\">Promotional Codes entitle you to a full registration. Please select the full registration and complete all categories.</p>").delay(250).slideDown(250);
//                }
//            });

            if (noSubmit) {
                $('.errorfield').delay(500).slideDown(0);
                $('.registrationCategories').delay(500).slideDown(500);
                $('#registrationType').delay(500).slideDown(500);
                $('#registrantSummary').delay(500).slideDown(500, showConditions());
                $('#processingHolder').delay(500).slideUp(250);
            }
            
            return noSubmit;
        }

        function showConditions() {
            $('#conditions').delay(500).slideDown(0);
            //alert('show');
        }
        function hideConditions() {
            $('#conditions').delay(0).slideUp(250);
            //alert('hide');
        }
        $('#addField').click(function() {
            var htmlinput = "<div id=\"wgdiv~\" class=\"leftCol commentField\" style=\"width:90%; background-color:#F2F2F2; margin-left:10px;\"><input name=\"wgcommentfield~\" type=\"hidden\" id=\"wgcommentfield~\" class=\"combinedfields\"\><p><input name=\"wgr~\" type=\"button\" class=\"transformButtonStyle wgremove\" id=\"wgr~\" value=\"Remove\" style=\"float:right; font-size:80%;\"></p><p>Working Group</p><p><select name=\"wg~\" id=\"wg~\" style=\"width:auto;\" class=\"wgselection\"><option value=\"\">Select a Work Group</option><option value=\"1\">1: Issues for Managers</option><option value=\"2\">2: Regulatory &amp; Standards Developments</option><option value=\"3\">3: Upstream Pipelines: Inspection, Corrosion &amp; Integrity Management</option><option value=\"4\">4: Asset Management - Aging Infrastructure</option><option value=\"5\">5: Environmental Assisted Cracking</option><option value=\"6\">6: Human Factors</option><option value=\"7\">7: Pipeline Risk Management</option><option value=\"8\">8: Inspection Tools &amp; NDE</option><option value=\"9\">9: External Corrosion &amp; Coatings</option><option value=\"10\">10: Internal Corrosion</option><option value=\"11\">11: Managing Geotechnical Hazards</option><option value=\"12\">12: Emergency Preparedness &amp; Respsonse</option></select></p><div id=\"wgf~\" style=\"display:none;\"><p>Question/Issue</p><p><textarea name=\"wgc~\" cols=\"60\" rows=\"6\" id=\"wgc~\" class=\"comment\"></textarea><br>250 characters maximum. You have <span id=\"wgchar~\"></span> charcters left. </p></div></div>";
            var currnum = parseInt($('#commentNum').val());
            var nextnum = parseInt($('#commentNum').val()) + 1;
            var inserthtml = htmlinput.replace(/~/g, nextnum);
            $('#wgdiv' + currnum).after(inserthtml);
            $('#wgc' + nextnum).limit('250', '#wgchar' + nextnum);
            $('#commentNum').val(nextnum);
            $('#wgr' + nextnum).click(function() {
                var n = $('#commentNum').val();
                $('#commentNum').val(n - 1);
                if ($('#commentNum').val() < 12) {
                    $('#addField').show();
                }
                $(this).parent().parent().remove();
            });
            $('.wgselection').change(function() {
                var thisobj = $(this);
                var thisnum = thisobj.attr('id').replace("wg", '');
                if (thisobj.val() != "") {
                    $('#wgf' + thisnum).slideDown(250);
                    $('#wgc' + thisnum).focus();
                } else {
                    $('#wgf' + thisnum).slideUp(250);
                    $("#wgc" + thisnum).val('');
                    if ($(this).parent().parent().children().hasClass('errorfield')) {
                        $(this).parent().parent().children('.errorfield').slideUp(250, function() {
                            $(this).remove();
                        });
                        //alert($(this).parent().parent().parent());
                    }
                }
                $('.wgselection').each(function(index) {
                    //alert($(this).attr('id')+ "      "+thisobj.attr('id'));
                    if ($(this).val() == thisobj.val() && $(this).attr('id') != thisobj.attr('id') && thisobj.val() != "") {
                        alert("You have already added a comment for \nWorking Group " + thisobj.find(":selected").text() + "\n\nPlease remove the comment field or select a different working group.");
                        thisobj.val('');
                        $("#wgf" + thisnum).slideUp(250);
                        $("#wgc" + thisnum).val('');
                        if (thisobj.parent().parent().children().hasClass('errorfield')) {
                            thisobj.parent().parent().children('.errorfield').slideUp(250, function() {
                                $(this).remove();
                            });
                            //alert($(this).parent().parent().parent());
                        }
                    }
                });
                //alert($(this).val());
            });
            $('.comment').change(function() {
                if ($(this).parent().parent().parent().children().hasClass('errorfield')) {
                    $(this).parent().parent().parent().children('.errorfield').slideUp(250, function() {
                        $(this).remove();
                    });
                    //alert($(this).parent().parent().parent());
                }
            });
            if (nextnum == 12) {
                $('#addField').hide();
            }
        });
       // $('#wgc1').limit('250', '#wgchar1'); // initiates first instance of comment field character limiter

        $('.wgselection').change(function() {
            var thisobj = $(this);
            var thisnum = thisobj.attr('id').replace("wg", '');
            if (thisobj.val() != "") {
                $('#wgf' + thisnum).slideDown(250);
                $('#wgc' + thisnum).focus();
            } else {
                if ($(this).parent().parent().children().hasClass('errorfield')) {
                    $(this).parent().parent().children('.errorfield').slideUp(250, function() {
                        $(this).remove();
                    });
                    //alert($(this).parent().parent().parent());
                }
                $('#wgf' + thisnum).slideUp(250);
                $("#wgc" + thisnum).val('');
            }
        });
        $('.comment').change(function() {
            if ($(this).parent().parent().parent().children().hasClass('errorfield')) {
                $(this).parent().parent().parent().children('.errorfield').slideUp(250, function() {
                    $(this).remove();
                });
                //alert($(this).parent().parent().parent());
            }
        });
        $('.wgremove').click(function() {
            var n = $('#commentNum').val();
            $('#commentNum').val(n - 1);
            if ($('#commentNum').val() < 12) {
                $('#addField').show();
            }
            $(this).parent().parent().remove();
        });


    });