<?php
session_start();

include('../config_include/connect.php');

if (isset($_GET['TokenID'])) {
    echo $_GET['TokenID'];
}

$closeit = date('Y-m-d');

//if($closeit > '2013-04-18'){
//	header( 'Location: closed.php' ) ;	
//}
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
        <script type="text/javascript" src="js/exEvalForm.php"></script>
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
                            <h2>Exhibitor Evaluation Form Key</h2>
                            <h1 class="red">&nbsp;</h1>
                            <div style="clear:left;"></div>
                            <?php $i = 1; ?>
                            <div class="leftCol required" style="width:90%;">
                                <h3><?php echo $i; ?>.	Of the 12 Pipeline Workshops that have been held, in Red Deer (1993), and in Banff from 1994 to 2013 is this the first that you have attended?</h3>
                                <p>&nbsp;</p>
                            </div>
                            <?php
                            $i++;
                            $checks = array(
                                "Steelmaker",
                                "Pipe Manufacturer",
                                "Pipeline Contractor",
                                "Vendor of Equipment/Services to the P/L Industry",
                                "Supplier/Applicator of Pipeline Coatings",
                                "Manufacturer of NDT Equipment",
                                "Inspection Company",
                                "Consultant",
                                "Other (specify)"
                            );
                            $checksL = sizeof($checks);
                            $col1 = ceil($checksL / 2);
                            $col2 = $checksL - $col1;
                            ?>
                            <div class="leftCol required" style="width:90%;">
                                <h3><?php echo $i; ?>.	Is your organization a:   (Please  ✔ all that apply)</h3>
                                <p>&nbsp;</p>
                            </div>
                            <div style="clear:left;"></div>
                            <?php $i++; ?>
                            <div class="leftCol required" style="width:90%;">
                                <h3><?php echo $i; ?>.	How did you hear about the Workshop?</h3>
                                <p>&nbsp;</p>
                            </div>
                            <?php $i++; ?>
                            <div class="leftCol required" style="width:90%;">
                                <h3><?php echo $i; ?>.	Exhibits. <br>
                                    What is the main objective of your organization in exhibiting at the Workshop?
                                </h3>
                                <p>&nbsp;						</p>
                                <p>
                                    <script>
                                        $(document).ready(function() {
                                            $('#question<?php echo $i; ?>objectives').limit('250', '#question<?php echo $i; ?>objectiveschar');
                                        });
                                    </script>
                                </p>
                                <h3>To what extent was this objective achieved?
                                </h3>
                                <p>&nbsp;						</p>
                                <p>
                                    <script>
                                        $(document).ready(function() {
                                            $('#question<?php echo $i; ?>achieved').limit('250', '#question<?php echo $i; ?>achievedchar');
                                        });
                                    </script>
                                </p>
                                <h3>Any comments on the role of exhibits at the Workshop?</h3>
                                <p>&nbsp;						</p>
                                <p>
                                    <script>
                                        $(document).ready(function() {
                                            $('#question<?php echo $i; ?>comments').limit('250', '#question<?php echo $i; ?>commentschar');
                                        });
                                    </script>
                                </p>
                                <p>&nbsp;</p>
                            </div>
                            <?php $i++; ?>
                            <div class="leftCol required" style="width:90%;">
                                <h3><?php echo $i; ?>.	Tutorials. <br>
                                    Did you attend any of the tutorials? </h3>
                                <p>&nbsp;</p>
                                <div id="tutorials" >
                                    <h3>If yes, which tutorial(s) did you attend?</h3>
                                    <p>&nbsp;						</p>
                                    <p>
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
                                    </p>
                                    <h3>Did the tutorial(s) that you attended provide useful information?</h3>
                                    <p>&nbsp;</p>
                                    <h3>Technical level of tutorial(s)</h3>
                                    <p>&nbsp;</p>
                                    <h3>Any comments about tutorial(s) that you attended?</h3>
                                    <p>&nbsp;						</p>
                                    <p>
                                        <script>
                                            $(document).ready(function() {
                                                $('#question<?php echo $i; ?>comments').limit('250', '#question<?php echo $i; ?>commentschar');
                                            });
                                        </script>
                                    </p>
                                </div>
                                <h3>Any suggestions for tutorial topics at future Workshops?</h3>
                                <p>&nbsp;						</p>
                                <p>
                                    <script>
                                        $(document).ready(function() {
                                            $('#question<?php echo $i; ?>commentsfuture').limit('250', '#question<?php echo $i; ?>commentsfuturechar');
                                        });
                                    </script>
                                </p>
                                <p>&nbsp;</p>
                            </div>
                            <?php $i++; ?>
                            <div class="leftCol required" style="width:90%;">
                                <h3><?php echo $i; ?>.	Working Groups. <br>
                                    Did you attend any of the Working Groups? </h3>
                                <p>&nbsp;</p>
                                <div id="workgroups" >
                                    <h3>If yes, which working group(s) did you attend?</h3>
                                    <p>&nbsp;						</p>
                                    <p>
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
                                    </p>
                                    <h3>Did the Working Groups that you attended meet your expectations?</h3>
                                    <p>&nbsp;</p>
                                    <h3>Technical level of Working Groups</h3>
                                    <p>&nbsp;</p>
                                    <h3>Any comments about working group(s) that you attended?</h3>
                                    <p>&nbsp;						</p>
                                    <p>
                                        <script>
                                            $(document).ready(function() {
                                                $('#question<?php echo $i; ?>comments').limit('250', '#question<?php echo $i; ?>commentschar');
                                            });
                                        </script>
                                    </p>
                                </div>
                            </div>
                            <?php $i++; ?>
                            <div class="leftCol required" style="width:90%;">
                                <h3><?php echo $i; ?>.	To what extent was your objective in attending the Workshop met? </h3>
                                <p>&nbsp;						</p>
                                <p>
                                    <script>
                                        $(document).ready(function() {
                                            $('#question<?php echo $i; ?>').limit('250', '#question<?php echo $i; ?>char');
                                        });
                                    </script>
                                </p>
                                <p>&nbsp;</p>
                            </div>
                            <?php $i++; ?>
                            <div class="leftCol required" style="width:90%;">
                                <h3><?php echo $i; ?>.	What is your most important “Take Home Item” from the Workshop; e.g., something you can use in your job? </h3>
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
                            </div>
                            <?php $i++; ?>
                        </div>
                        <!--//////////////////////////////////////////////////////////////////////////////////////////////////////--> 
                        <!--//////////////////////////////////////////////////////////////////////////////////////////////////////-->
                        <p>&nbsp;</p>
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
