<?php
function g11_open_table_link($ot_rid) {
    ob_start();
    ?><div class="OTButton"><a href="http://www.opentable.com/single.aspx?rid=OT_RID&rtype=ism&restref=OT_RID" >Reserve Now</a></div>
    <?php
    return str_replace ('OT_RID', $ot_rid, ob_get_clean());
}