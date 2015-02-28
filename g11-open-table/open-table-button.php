<?php
function g11_open_table_button($ot_rid) {
    ob_start();
    ?><div class="OTButton"><script type="text/javascript" src="https://secure.opentable.com/ism/link.aspx?rid=OT_RID&restref=OT_RID&bgimage=https://secure.opentable.com/img/frontDoor/ot_btn_red.png&hover=1"></script><noscript id="OT_noscript"><a href="http://www.opentable.com/single.aspx?rid=OT_RID&rtype=ism&restref=OT_RID" >Reserve Now On OpenTable.com</a></noscript></div>
    <?php
    return str_replace ('OT_RID', $ot_rid, ob_get_clean());
}