<?php
// Tell the browser that this is CSS instead of HTML
header("Content-type: text/css");

// Get the color generating code
include_once("../func_include/csscolor.php");
include_once("../config_include/eventColours.php");

// Set the error handing for csscolor.
// If an error occurs, print the error
// within a CSS comment so we can see
// it in the CSS file.
//PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, 'errorHandler');
//function errorHandler($err) {
//    echo("/* ERROR " . $err->getMessage() . " */");
//}
// Trigger an error just to see what happens
// $trigger = new CSS_Color('');
//$color3 = new CSS_Color('C0DE74');
//$color4 = new CSS_Color('808080');
//$errorColour = new CSS_Color('CC0000');
//$white = new CSS_Color('FFFFFF');
?>
@charset "UTF-8";
/* CSS Document */

.selectType {
width: 30%
}

.leftCol {
float: left;
width: auto;
margin: 0px 15px 10px 0px;
-moz-border-radius: 8px;
-webkit-border-radius: 8px;
border-radius: 8px;
white-space: nowrap;
background-color: #<?php echo $color3->bg['+3']; ?>;
}
.leftCol p {
font-size: 80%;
white-space: normal;
}
.required {
color: #<?php echo $color1->bg['0']; ?>;
border: 2px solid #<?php echo $color3->bg['0']; ?>;
padding: 3px 8px;
background-color: #<?php echo $color3->bg['+3']; ?>;
border: 2px solid #<?php echo $color1->bg['0']; ?>;
}
.required input[text], .required select, .requiredMarker {
color: #<?php echo $color1->bg['0']; ?>;
border: 2px solid #<?php echo $color1->bg['0']; ?>;
}
.required select{
border: 1px solid #<?php echo $color1->bg['0']; ?>;
}
.reqfield {
border: none;
}
.notRequired {
font-size: 18px;
color: #<?php echo $color1->bg['0']; ?>;
border: 2px solid #<?php echo $color3->bg['0']; ?>;
padding: 3px 8px;
}
.notRequired input[text], .notRequired select {
color: #<?php echo $color1->bg['0']; ?>;
background-color: #<?php echo $white->bg['+4']; ?>;
border: 2px solid #<?php echo $color3->bg['0']; ?>;
}
.errorfield, .processError {
background:red;
padding:5px 10px;
width: auto;
color: #ffffff;
display: none;
-moz-border-radius: 15px;
-webkit-border-radius: 15px;
border-radius: 15px;
margin-left:10px;
}
#processResponse{
margin: 5px 0px;
}
.processError {
display: block;
width: 90%;
margin-bottom: 10px;
}
.processError h1, .processError h2, .processError h3, .processError p {
margin: 0px;
}
.transformButtonStyle {
/* restyle buttons */
font-size: 115%;
border: 2px solid #<?php echo $color1->bg['0']; ?>;
background-color: #<?php echo $color1->bg['0']; ?>;
font-weight: bold;
color: #<?php echo $white->bg['0']; ?>;
width: auto;
text-decoration: none;
-moz-border-radius: 15px;
-webkit-border-radius: 15px;
border-radius: 15px;
margin-top: 3px;
margin-right: 0px;
margin-bottom: 3px;
margin-left: 0px;
padding-top: 3px;
padding-right: 8px;
padding-bottom: 3px;
padding-left: 8px;
white-space: nowrap;
display: inline-block;
}
.transformButtonStyle:hover {
border: 2px solid #<?php echo $color2->bg['0']; ?>;
background-color: #<?php echo $color2->bg['0']; ?>;
color: #<?php echo $white->bg['0']; ?>;
cursor: pointer;
}

