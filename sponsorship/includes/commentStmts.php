<?php

for ($i = 0; $i < $commentArrayL; $i++) {
    $a = explode("*|*", $commentArray[$i]);
    $wg = $a[0];
    $wgc = $a[1];
    // insert item into confdetail
    $insert = "insert into $tablecomments (invoice, workgroup, comments) values ('$vid', '" . mysql_real_escape_string($wg) . "', '" . mysql_real_escape_string($wgc) . "')";
    //echo "<p>$insert</p>";
    $inres = mysql_query($insert) or die("There was an error inserting the session record.<br>" . mysql_query() . "<br>$insert");
}
?>