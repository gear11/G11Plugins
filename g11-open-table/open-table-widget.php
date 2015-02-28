<?php
function g11_open_table_widget($ot_rid) {
    ob_start();
    ?><script type="text/javascript" src="https://secure.opentable.com/frontdoor/default.aspx?rid=OT_RID&restref=OT_RID&bgcolor=F6F6F3&titlecolor=0F0F0F&subtitlecolor=0F0F0F&btnbgimage=https://secure.opentable.com/frontdoor/img/ot_btn_red.png&otlink=FFFFFF&icon=light&mode=short&hover=1">
    // Derived from https://www.otrestaurant.com/marketing/ReservationWidget
</script>
<style>
    #OT_form * {
        -webkit-box-sizing: content-box;
        -moz-box-sizing: content-box;
        box-sizing: content-box;
    }
</style><?php
    return str_replace ('OT_RID', $ot_rid, ob_get_clean());
}
