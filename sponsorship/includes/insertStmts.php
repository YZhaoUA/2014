<?php

for ($i = 0; $i < $insertArrayL; $i++) {
    // pull details for insert array
    $sel = "select * from $conference where funccode='" . $insertArray[$i] . "'";
    $res = mysql_query($sel) or die("There was a problem retrieving the session data.<br>" . mysql_error() . "<br>$sel");

    $item = mysql_fetch_array($res);

    // insert item into confdetail
    $insert = "insert into $tabledetailname (vid, funccode, funcid, charged) values ('$vid', '" . $item['funccode'] . "', '" . $item['id'] . "', '" . $item['funccost'] . "')";
    //echo "<p>$insert</p>";
    $inres = mysql_query($insert) or die("There was an error inserting the session record.<br>" . mysql_query() . "<br>$insert");
}
?>