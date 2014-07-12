<?php
session_start();

include('../config_include/connect.php');

if (isset($_GET['TokenID'])) {
    echo $_GET['TokenID'];
}

$closeit = date('Y-m-d');

if ($closeit > '2013-04-18') {
    header('Location: closed.php');
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Banff/2013 Pipeline Workshop Sponsor Registration</title>
        <link href="../css/asmebanffstyles.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="../jquery/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="../jquery/jquery.limit-1.2.source.js"></script>
        <script type="text/javascript" src="../jquery/colorbox/jquery.colorbox-min.js"></script>
        <script type="text/javascript" src="js/evalForm.php"></script>
        <link href="../jquery/colorbox/colorbox.css" rel="stylesheet" type="text/css">
        <link href="../css/regform.css" rel="stylesheet" type="text/css">
        <link href="css/evalForm.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="wrapper">
            <?php include('includes/header.php'); ?>
            <div id="content">
                <h3>April 13 – 16, 2015 at
                    The Banff Centre, 
                    Banff, Alberta, Canada</h3>
                <div id="processResponse"> </div>
                <div id="processingHolder" style="display: none; float:left;">
                    <h3>Please wait . . . <br>
                        <img src="../images/ajax-loader.gif" title="Loader" alt="Loader" /></h3>
                </div>
                <form name="registration" id="registration" method="post" action="">
                    <input name="checkoutId" type="hidden" id="checkoutId">
                    <div id="registerInfo"> 
                        <!--//////////////////////////////////////////////////////////////////////////////////////////////////////--> 
                        <!--//////////////////////////////////////////////////////////////////////////////////////////////////////-->
                        <div id="registrantInfo" class="formBlock" style="clear:left; width:100%;">
                            <h2>Workshop Evaluation Form</h2>
                            <h1 class="red"><em>If you attended the Tutorials and/or Workshops at the Banff/2015 Pipeline Workshop<br>
                                    please complete this form.
                                </em></h1>
                            <p><strong>Complete the evaluation form before April 18 to be entered into a draw for 1 of 4 $50 American Express Prepaid Gift Cards!</strong></p>
                            <div style="clear:left;"></div>
                            <?php $i = 1; ?>
                            <div class="leftCol required" style="width:90%;">
                                <h3><?php echo $i; ?>.	Of the 12 Pipeline Workshops that have been held, in Red Deer (1993), and in Banff from 1994 to 2013 is this the first that you have attended?</h3>
                                <div class="leftCol notRequired" style="width:97%;">
                                    <div class="leftCol">
                                        <h4>
                                            <label>
                                                <input  type="radio" name="question<?php echo $i; ?>" id="question<?php echo $i; ?>1" class="reqfield" value="YES">
                                                Yes</label>
                                        </h4>
                                    </div>
                                    <div class="leftCol">
                                        <h4>
                                            <label>
                                                <input type="radio" name="question<?php echo $i; ?>" id="question<?php echo $i; ?>2" class="reqfield" value="NO">
                                                No</label>
                                        </h4>
                                    </div>
                                </div>
                                <p>&nbsp;</p>
                            </div>
                            <?php
                            $i++;
                            $checks = array(
                                "Steelmaker",
                                "Pipe Manufacturer",
                                "Pipeline Contractor",
                                "Oil and Gas Producer",
                                "Pipeline Owner/Operator",
                                "Vendor of Equipment/Services to the P/L Industry",
                                "Supplier/Applicator of Pipeline Coatings",
                                "Industry Association",
                                "University",
                                "Consultant",
                                "Regulatory Agency",
                                "Inspection Company",
                                "Research Organization",
                                "Institute of Technology",
                                "Transmission Company",
                                "Manufacturer of NDT Equipment",
                                "Other (specify)"
                            );
                            $checksL = sizeof($checks);
                            $col1 = ceil($checksL / 2);
                            $col2 = $checksL - $col1;
                            ?>
                            <div class="leftCol required" style="width:90%;">
                                <h3><?php echo $i; ?>.	Is your organization a:   (Please  ✔ all that apply)</h3>
                                <div class="leftCol notRequired" style="width:97%">
                                    <div class="leftCol" >
                                        <?php for ($j = 0; $j < $col1; $j++) { ?>
                                            <label>
                                                <h4>
                                                    <input name="question<?php echo $i; ?>[]" type="checkbox" class="reqfield" id="question<?php echo $i, "-", $j; ?>" value="<?php echo $checks[$j]; ?>">
                                                    <?php echo $checks[$j]; ?> </h4>
                                            </label>
                                        <?php } ?>
                                    </div>
                                    <div class="leftCol" >
                                        <?php for ($j = $col1; $j < $checksL; $j++) { ?>
                                            <label>
                                                <h4>
                                                    <input name="question<?php echo $i; ?>[]" type="checkbox" class="reqfield" id="question<?php echo $i, "-", $j; ?>" value="<?php echo $checks[$j]; ?>">
                                                    <?php echo $checks[$j]; ?> </h4>
                                            </label>
                                            <?php
                                            $k = $j;
                                        }
                                        ?>
                                        <label><input name="question<?php echo $i; ?>other" type="text"   id="question<?php echo $i; ?>other" class="reqfield"></label>
                                        <script>
                                            $(document).ready(function() {
                                                $('#question<?php echo $i; ?>other').attr('disabled', 'disabled').fadeTo(0, '.5');
                                                $('#question<?php echo $i, "-", $k; ?>').click(function() {
                                                    if ($(this).is(':checked')) {
                                                        $('#question<?php echo $i; ?>other').removeAttr('disabled');
                                                        $('#question<?php echo $i; ?>other').fadeTo('fast', '1');
                                                    } else {
                                                        $('#question<?php echo $i; ?>other').attr('disabled', 'disabled');
                                                        $('#question<?php echo $i; ?>other').val('');
                                                        $('#question<?php echo $i; ?>other').fadeTo('fast', '.5');
                                                    }
                                                });
                                            });
                                        </script> 
                                    </div>
                                </div>
                                <p>&nbsp;</p>
                            </div>
                            <div style="clear:left;"></div>
                            <?php $i++; ?>
                            <div class="leftCol required" style="width:90%;">
                                <h3><?php echo $i; ?>.	How did you hear about the Workshop?</h3>
                                <div class="leftCol notRequired" style="width:97%;margin-right:20px;">
                                    <div class="leftCol" style="width:40%;margin-right:20px;">
                                        <label>
                                            <h4>
                                                <input  type="radio" name="question<?php echo $i; ?>" id="question<?php echo $i; ?>1" class="reqfield question<?php echo $i; ?>" value="Invitation sent to you directly">
                                                Invitation sent to you directly </h4>
                                        </label>
                                        <label>
                                            <h4>
                                                <input  type="radio" name="question<?php echo $i; ?>" id="question<?php echo $i; ?>2" class="reqfield " value="Website">
                                                Website
                                                (specify website)<br>
                                                <input name="question<?php echo $i; ?>other2" type="text"   id="question<?php echo $i; ?>other2" class="reqfield question<?php echo $i; ?>other">
                                            </h4>
                                        </label>
                                        <br>
                                    </div>
                                    <div class="leftCol" style="width:40%;">
                                        <label>
                                            <h4>
                                                <input  type="radio" name="question<?php echo $i; ?>" id="question<?php echo $i; ?>3" class="reqfield question<?php echo $i; ?>" value="A colleague or friendy">
                                                A colleague or friend</h4>
                                        </label>
                                        <label>
                                            <h4>
                                                <input  type="radio" name="question<?php echo $i; ?>" id="question<?php echo $i; ?>4" class="reqfield" value="Other">
                                                Other
                                                (specify)<br>
                                                <input name="question<?php echo $i; ?>other4" type="text" id="question<?php echo $i; ?>other4" class="reqfield question<?php echo $i; ?>other">
                                            </h4>
                                        </label>
                                        <br>
                                    </div>
                                    <script>
                                        $(document).ready(function() {
                                            $('#question<?php echo $i; ?>other2').attr('disabled', 'disabled').fadeTo(0, '.5');
                                            $('#question<?php echo $i; ?>other4').attr('disabled', 'disabled').fadeTo(0, '.5');
                                            $('.question<?php echo $i; ?>').click(function() {
                                                $('.question<?php echo $i; ?>other').attr('disabled', 'disabled');
                                                $('.question<?php echo $i; ?>other').val('');
                                                $('.question<?php echo $i; ?>other').fadeTo('fast', '.5');
                                            });
                                            $('#question<?php echo $i; ?>2').click(function() {
                                                $(this).parent().children(':last-child').removeAttr('disabled');
                                                $(this).parent().children(':last-child').fadeTo(0, 1);
                                                $('#question<?php echo $i; ?>other4').val('').attr('disabled', 'disabled').fadeTo('fast', '0.5');
                                            });
                                            $('#question<?php echo $i; ?>4').click(function() {
                                                $(this).parent().children(':last-child').removeAttr('disabled');
                                                $(this).parent().children(':last-child').fadeTo(0, 1);
                                                $('#question<?php echo $i; ?>other2').val('').attr('disabled', 'disabled').fadeTo('fast', '0.5');
                                            });
                                        });
                                    </script> 
                                </div>
                                <p>&nbsp;</p>
                            </div>
                            <?php $i++; ?>
                            <div class="leftCol required" style="width:90%;">
                                <h3><?php echo $i; ?>.	Exhibits. <br>
                                    Is your organization an exhibitor at the Workshop? </h3>
                                <div class="leftCol notRequired" style="width:97%;">
                                    <div class="leftCol">
                                        <h4>
                                            <label>
                                                <input  type="radio" name="question<?php echo $i; ?>" id="question<?php echo $i; ?>1" class="reqfield" value="YES">
                                                Yes</label>
                                        </h4>
                                    </div>
                                    <div class="leftCol">
                                        <h4>
                                            <label>
                                                <input type="radio" name="question<?php echo $i; ?>" id="question<?php echo $i; ?>2" class="reqfield" value="NO">
                                                No</label>
                                        </h4>
                                    </div>
                                </div>
                                <h3>Any comments on the role of exhibits at the Workshop?
                                </h3>
                                <div class="leftCol notRequired" style="width:97%;">
                                    <p>
                                        <textarea name="question<?php echo $i; ?>comments" cols="60" rows="6" id="question<?php echo $i; ?>comments" class="comment" style="width:97%;"></textarea>
                                        <br>
                                        250 characters maximum. You have <span id="question<?php echo $i; ?>commentschar"></span> charcters left. </p>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('#question<?php echo $i; ?>comments').limit('250', '#question<?php echo $i; ?>commentschar');
                                    });
                                </script>
                                <p>&nbsp;</p>
                            </div>
                            <?php $i++; ?>
                            <div class="leftCol required" style="width:90%;">
                                <h3><?php echo $i; ?>.	Opening Speakers. <br>
                                    Were the presentations by the Opening Speakers relevant to your interests? </h3>
                                <div class="leftCol notRequired" style="width:97%;">
                                    <div class="leftCol">
                                        <h4>
                                            <label>
                                                <input  type="radio" name="question<?php echo $i; ?>" id="question<?php echo $i; ?>1" class="reqfield" value="YES">
                                                Yes</label>
                                        </h4>
                                    </div>
                                    <div class="leftCol">
                                        <h4>
                                            <label>
                                                <input type="radio" name="question<?php echo $i; ?>" id="question<?php echo $i; ?>2" class="reqfield" value="NO">
                                                No</label>
                                        </h4>
                                    </div>
                                </div>
                                <h3>Do you have any comments about it?
                                </h3>
                                <div class="leftCol notRequired" style="width:97%;">
                                    <p>
                                        <textarea name="question<?php echo $i; ?>comments" cols="60" rows="6" id="question<?php echo $i; ?>comments" class="comment" style="width:97%;"></textarea>
                                        <br>
                                        250 characters maximum. You have <span id="question<?php echo $i; ?>commentschar"></span> charcters left. </p>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('#question<?php echo $i; ?>comments').limit('250', '#question<?php echo $i; ?>commentschar');
                                    });
                                </script>
                                <p>&nbsp;</p>
                            </div>
                            <?php $i++; ?>
                            <div class="leftCol required" style="width:90%;">
                                <h3><?php echo $i; ?>.	Tutorials. <br>
                                    Did you attend any of the tutorials? </h3>
                                <div class="leftCol notRequired" style="width:97%;">
                                    <div class="leftCol">
                                        <h4>
                                            <label>
                                                <input  type="radio" name="question<?php echo $i; ?>" id="question<?php echo $i; ?>1" class="reqfield question<?php echo $i; ?>" value="YES">
                                                Yes</label>
                                        </h4>
                                    </div>
                                    <div class="leftCol">
                                        <h4>
                                            <label>
                                                <input type="radio" name="question<?php echo $i; ?>" id="question<?php echo $i; ?>2" class="reqfield question<?php echo $i; ?>" value="NO">
                                                No</label>
                                        </h4>
                                    </div>
                                </div>
                                <div id="tutorials" style="display:none;">
                                    <h3>If yes, which tutorial(s) did you attend?</h3>
                                    <div class="leftCol notRequired" style="width:97%;">
                                        <p>
                                            <textarea name="question<?php echo $i; ?>tutorials" cols="60" rows="6" id="question<?php echo $i; ?>tutorials" class="reqfield comment" style="width:97%;"></textarea>
                                            <br>
                                            250 characters maximum. You have <span id="question<?php echo $i; ?>tutorialschar"></span> charcters left. </p>
                                    </div>
                                    <script>
                                        $(document).ready(function() {

                                            $('.question<?php echo $i; ?>').click(function() {
                                                if ($(this).val() == "YES") {
                                                    $('#tutorials').show(250);
                                                } else {
                                                    $('#tutorials').hide(250);
                                                    $('#question<?php echo $i; ?>tutorials').val('');
                                                    $('#tutorials .errorfield').remove();
                                                }
                                            });
                                            $('#question<?php echo $i; ?>tutorials').limit('250', '#question<?php echo $i; ?>tutorialschar');
                                        });
                                    </script>
                                    <h3>Did the tutorial(s) that you attended provide useful information?</h3>
                                    <div class="leftCol notRequired" style="width:97%;">
                                        <div class="leftCol">
                                            <h4>
                                                <label>
                                                    <input  type="radio" name="question<?php echo $i; ?>a" id="question<?php echo $i; ?>a-1" class="reqfield" value="YES">
                                                    Yes</label>
                                            </h4>
                                        </div>
                                        <div class="leftCol">
                                            <h4>
                                                <label>
                                                    <input type="radio" name="question<?php echo $i; ?>a" id="question<?php echo $i; ?>a-2" class="reqfield" value="NO">
                                                    No</label>
                                            </h4>
                                        </div>
                                    </div>
                                    <h3>Technical level of tutorial(s)</h3>
                                    <div class="leftCol notRequired" style="width:97%;">
                                        <div class="leftCol">
                                            <h4>
                                                <label>
                                                    <input  type="radio" name="question<?php echo $i; ?>b" id="question<?php echo $i; ?>b-1" class="reqfield" value="TOO HIGH">
                                                    Too High</label>
                                            </h4>
                                        </div>
                                        <div class="leftCol">
                                            <h4>
                                                <label>
                                                    <input type="radio" name="question<?php echo $i; ?>b" id="question<?php echo $i; ?>b-2" class="reqfield" value="ABOUT RIGHT">
                                                    About Right</label>
                                            </h4>
                                        </div>
                                        <div class="leftCol">
                                            <h4>
                                                <label>
                                                    <input type="radio" name="question<?php echo $i; ?>b" id="question<?php echo $i; ?>b-3" class="reqfield" value="TOO LOW">
                                                    Too Low</label>
                                            </h4>
                                        </div>
                                    </div>
                                    <h3>Any comments about tutorial(s) that you attended?</h3>
                                    <div class="leftCol notRequired" style="width:97%;">
                                        <p>
                                            <textarea name="question<?php echo $i; ?>comments" cols="60" rows="6" id="question<?php echo $i; ?>comments" class="comment" style="width:97%;"></textarea>
                                            <br>
                                            250 characters maximum. You have <span id="question<?php echo $i; ?>commentschar"></span> charcters left. </p>
                                    </div>
                                    <script>
                                        $(document).ready(function() {
                                            $('#question<?php echo $i; ?>comments').limit('250', '#question<?php echo $i; ?>commentschar');
                                        });
                                    </script>
                                </div>
                                <h3>Any suggestions for tutorial topics at future Workshops?</h3>
                                <div class="leftCol notRequired" style="width:97%;">
                                    <p>
                                        <textarea name="question<?php echo $i; ?>commentsfuture" cols="60" rows="6" id="question<?php echo $i; ?>commentsfuture" class="comment" style="width:97%;"></textarea>
                                        <br>
                                        250 characters maximum. You have <span id="question<?php echo $i; ?>commentsfuturechar"></span> charcters left. </p>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('#question<?php echo $i; ?>commentsfuture').limit('250', '#question<?php echo $i; ?>commentsfuturechar');
                                    });
                                </script>
                                <p>&nbsp;</p>
                            </div>
                            <?php $i++; ?>
                            <div class="leftCol required" style="width:90%;">
                                <h3><?php echo $i; ?>.	Working Groups. <br>
                                    Did you attend any of the Working Groups? </h3>
                                <div class="leftCol notRequired" style="width:97%;">
                                    <div class="leftCol">
                                        <h4>
                                            <label>
                                                <input  type="radio" name="question<?php echo $i; ?>" id="question<?php echo $i; ?>1" class="reqfield question<?php echo $i; ?>" value="YES">
                                                Yes</label>
                                        </h4>
                                    </div>
                                    <div class="leftCol">
                                        <h4>
                                            <label>
                                                <input type="radio" name="question<?php echo $i; ?>" id="question<?php echo $i; ?>2" class="reqfield question<?php echo $i; ?>" value="NO">
                                                No</label>
                                        </h4>
                                    </div>
                                </div>
                                <div id="workgroups" style="display:none;">
                                    <h3>If yes, which working group(s) did you attend?</h3>
                                    <div class="leftCol notRequired" style="width:97%;">
                                        <p>
                                            <textarea name="question<?php echo $i; ?>workgroups" cols="60" rows="6" id="question<?php echo $i; ?>workgroups" class="reqfield comment" style="width:97%;"></textarea>
                                            <br>
                                            250 characters maximum. You have <span id="question<?php echo $i; ?>workgroupschar"></span> charcters left. </p>
                                    </div>
                                    <script>
                                        $(document).ready(function() {

                                            $('.question<?php echo $i; ?>').click(function() {
                                                if ($(this).val() == "YES") {
                                                    $('#workgroups').show(250);
                                                } else {
                                                    $('#workgroups').hide(250);
                                                    $('#question<?php echo $i; ?>workgroups').val('');
                                                    $('#workgroups .errorfield').remove();
                                                }
                                            });
                                            $('#question<?php echo $i; ?>workgroups').limit('250', '#question<?php echo $i; ?>workgroupschar');
                                        });
                                    </script>
                                    <h3>Did the Working Groups that you attended meet your expectations?</h3>
                                    <div class="leftCol notRequired" style="width:97%;">
                                        <div class="leftCol">
                                            <h4>
                                                <label>
                                                    <input  type="radio" name="question<?php echo $i; ?>a" id="question<?php echo $i; ?>a-1" class="reqfield" value="YES">
                                                    Yes</label>
                                            </h4>
                                        </div>
                                        <div class="leftCol">
                                            <h4>
                                                <label>
                                                    <input type="radio" name="question<?php echo $i; ?>a" id="question<?php echo $i; ?>a-2" class="reqfield" value="NO">
                                                    No</label>
                                            </h4>
                                        </div>
                                    </div>
                                    <h3>Technical level of Working Groups</h3>
                                    <div class="leftCol notRequired" style="width:97%;">
                                        <div class="leftCol">
                                            <h4>
                                                <label>
                                                    <input  type="radio" name="question<?php echo $i; ?>b" id="question<?php echo $i; ?>b-1" class="reqfield" value="TOO HIGH">
                                                    Too High</label>
                                            </h4>
                                        </div>
                                        <div class="leftCol">
                                            <h4>
                                                <label>
                                                    <input type="radio" name="question<?php echo $i; ?>b" id="question<?php echo $i; ?>b-2" class="reqfield" value="ABOUT RIGHT">
                                                    About Right</label>
                                            </h4>
                                        </div>
                                        <div class="leftCol">
                                            <h4>
                                                <label>
                                                    <input type="radio" name="question<?php echo $i; ?>b" id="question<?php echo $i; ?>b-3" class="reqfield" value="TOO LOW">
                                                    Too Low</label>
                                            </h4>
                                        </div>
                                    </div>
                                    <h3>Any comments about working group(s) that you attended?</h3>
                                    <div class="leftCol notRequired" style="width:97%;">
                                        <p>
                                            <textarea name="question<?php echo $i; ?>comments" cols="60" rows="6" id="question<?php echo $i; ?>comments" class="comment" style="width:97%;"></textarea>
                                            <br>
                                            250 characters maximum. You have <span id="question<?php echo $i; ?>commentschar"></span> charcters left. </p>
                                    </div>
                                    <script>
                                        $(document).ready(function() {
                                            $('#question<?php echo $i; ?>comments').limit('250', '#question<?php echo $i; ?>commentschar');
                                        });
                                    </script>
                                </div>
                            </div>
                            <?php $i++; ?>
                            <div class="leftCol required" style="width:90%;">
                                <h3><?php echo $i; ?>.	Technology<br>
                                    What did you think of the ability to comment digitally? </h3>
                                <div class="leftCol notRequired" style="width:97%;">
                                    <p>
                                        <textarea name="question<?php echo $i; ?>" cols="60" rows="6" id="question<?php echo $i; ?>" class="comment" style="width:97%;"></textarea>
                                        <br>
                                        250 characters maximum. You have <span id="question<?php echo $i; ?>char"></span> charcters left. </p>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('#question<?php echo $i; ?>').limit('250', '#question<?php echo $i; ?>char');
                                    });
                                </script>
                                <p>&nbsp;</p>
                            </div>
                            <?php $i++; ?>
                            <div class="leftCol required" style="width:90%;">
                                <h3><?php echo $i; ?>.	What is your most important “Take Home Item” from the Workshop; e.g., something you can use in your job? </h3>
                                <div class="leftCol notRequired" style="width:97%;">
                                    <p>
                                        <textarea name="question<?php echo $i; ?>" cols="60" rows="6" id="question<?php echo $i; ?>" class="comment" style="width:97%;"></textarea>
                                        <br>
                                        250 characters maximum. You have <span id="question<?php echo $i; ?>char"></span> charcters left. </p>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('#question<?php echo $i; ?>').limit('250', '#question<?php echo $i; ?>char');
                                    });
                                </script>
                                <p>&nbsp;</p>
                            </div>
                            <?php $i++; ?>
                            <div class="leftCol required" style="width:90%;">
                                <h3><?php echo $i; ?>.	What did you like most about the Workshop? </h3>
                                <div class="leftCol notRequired" style="width:97%;">
                                    <p>
                                        <textarea name="question<?php echo $i; ?>" cols="60" rows="6" id="question<?php echo $i; ?>" class="comment" style="width:97%;"></textarea>
                                        <br>
                                        250 characters maximum. You have <span id="question<?php echo $i; ?>char"></span> charcters left. </p>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('#question<?php echo $i; ?>').limit('250', '#question<?php echo $i; ?>char');
                                    });
                                </script>
                                <p>&nbsp;</p>
                            </div>
                            <?php $i++; ?>
                            <div class="leftCol required" style="width:90%;">
                                <h3><?php echo $i; ?>.	What did you like least about the Workshop? </h3>
                                <div class="leftCol notRequired" style="width:97%;">
                                    <p>
                                        <textarea name="question<?php echo $i; ?>" cols="60" rows="6" id="question<?php echo $i; ?>" class="comment" style="width:97%;"></textarea>
                                        <br>
                                        250 characters maximum. You have <span id="question<?php echo $i; ?>char"></span> charcters left. </p>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('#question<?php echo $i; ?>').limit('250', '#question<?php echo $i; ?>char');
                                    });
                                </script>
                                <p>&nbsp;</p>
                            </div>
                            <?php $i++; ?>
                            <div class="leftCol required" style="width:90%;">
                                <h3><?php echo $i; ?>.	Do you have any suggestions on how this Workshop could be improved for future Workshops</h3>
                                <p>(e.g., topics discussed, plenary sessions at beginning and end of Workshop, working groups, time available for discussion, exhibits, etc.)? </p>
                                <div class="leftCol notRequired" style="width:97%;">
                                    <p>
                                        <textarea name="question<?php echo $i; ?>" cols="60" rows="6" id="question<?php echo $i; ?>" class="comment" style="width:97%;"></textarea>
                                        <br>
                                        250 characters maximum. You have <span id="question<?php echo $i; ?>char"></span> charcters left. </p>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('#question<?php echo $i; ?>').limit('250', '#question<?php echo $i; ?>char');
                                    });
                                </script>
                                <p>&nbsp;</p>
                            </div>
                            <?php $i++; ?>
                            <div class="leftCol required" style="width:90%;">
                                <h3><?php echo $i; ?>.	Other comments</h3>
                                <p> (e.g., on the Workshop format and structure, tutorials, pipeline integrity, new technologies, pipeline R&D, location at the Banff Centre, exhibits, etc.) </p>
                                <div class="leftCol notRequired" style="width:97%;">
                                    <p>
                                        <textarea name="question<?php echo $i; ?>" cols="60" rows="6" id="question<?php echo $i; ?>" class="comment" style="width:97%;"></textarea>
                                        <br>
                                        250 characters maximum. You have <span id="question<?php echo $i; ?>char"></span> charcters left. </p>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('#question<?php echo $i; ?>').limit('250', '#question<?php echo $i; ?>char');
                                    });
                                </script>
                                <p>&nbsp;</p>
                            </div>
                            <?php $i++; ?>
                            <div class="leftCol required" style="width:90%;">
                                <h3><?php echo $i; ?>.	Would you like to participate in the organization of the next Workshop or be involved actively in it either in the tutorials or the working groups?  </h3>
                                <p>If so, please describe, and please be sure to list your name and contact information in 15 below.</p>
                                <div class="leftCol notRequired" style="width:97%;">
                                    <p>
                                        <textarea name="question<?php echo $i; ?>" cols="60" rows="6" id="question<?php echo $i; ?>" class="comment" style="width:97%;"></textarea>
                                        <br>
                                        250 characters maximum. You have <span id="question<?php echo $i; ?>char"></span> charcters left. </p>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('#question<?php echo $i; ?>').limit('250', '#question<?php echo $i; ?>char');
                                    });
                                </script>
                                <p>&nbsp;</p>
                            </div>
                            <?php $i++; ?>
                            <div class="leftCol required" style="width:90%;">
                                <h3><?php echo $i; ?>.	Please complete this section to be entered into the draw:</h3>
                                <div class="leftCol notRequired" style="width:97%;">
                                    <div class="leftCol" style="width:46%;">
                                        <p>First Name
                                        </p>
                                        <p>
                                            <input name="fname" type="text" class="reqfield" id="fname" value="" maxlength="100"  />
                                        </p>
                                    </div>
                                    <div class="leftCol" style="width:46%;">
                                        <p>Last Name											 </p>
                                        <p>
                                            <input name="lname" type="text" class="reqfield" id="lname" value="" maxlength="100"/>
                                        </p>
                                    </div>
                                    <div class="leftCol" style="width:97%;">
                                        <p>Email</p>
                                        <p>
                                            <input name="email" type="text" id="email" value="" maxlength="50"  class="reqfield"/>
                                        </p>
                                    </div>
                                    <div class="leftCol" style="width:97%;">
                                        <p>Company Name (Maximum 50 characters)</p>
                                        <p>
                                            <input name="company" type="text" id="company" value="" maxlength="50"  class=""/>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php $i++; ?>
                        </div>
                        <!--//////////////////////////////////////////////////////////////////////////////////////////////////////--> 
                        <!--//////////////////////////////////////////////////////////////////////////////////////////////////////-->
                        <p>
                            <input name="continuebutton" type="button" class="transformButtonStyle" id="continuebutton" value="Continue" style="width:auto;">
                        </p>
                        </p>
                    </div>
                </form>
            </div>
            <div id="footer">&nbsp; </div>
        </div>
        <script>
            $(document).ready(function() {
                var num = <?php echo $i; ?>;
                for (a = 1; a <= num; a++) {
                    var limitTarget = '#question' + a + 'char';
                    $('#question' + a).limit('250', limitTarget);
                }
            });
        </script>
    </body>
</html>
