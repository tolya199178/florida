		<script type="text/javascript" src="http://maps.seatics.com/jquery_tn.js"></script>
		<script type="text/javascript" src="http://maps.seatics.com/swfobject_tn.js"></script>
		<script type="text/javascript" src="http://maps.seatics.com/maincontrol_0102_tn.js"></script>
		<link rel="Stylesheet" type="text/css" href="http://maps.seatics.com/ssc_venueMapStylesSample_0102_tn.css" />
		<script src="http://maps.seatics.com/mapTestData_0102_tn.js" type="text/javascript"></script>

<style>
<!--
SELECT.tn_event_dropdown  { height: 15px; border-color: #990000; border-top:1px solid; border-bottom:1px solid; border-left: 1px solid; border-right:1px solid; background-color: #FFFFFF; font-weight: normal; font-size: 10px; color: #007CAF; }

TABLE.tn_selevents_list  {  }
TD.tn_selevents_list { font-family: Verdana, Helvetica, Sans-Serif; font-size: 8pt; color: Gray;  }
.tn_selevents_list A:link { text-decoration: none; font-family: arial,helvetica,sans serif; font-size: 11px; color: #838383; }
.tn_selevents_list A:hover { text-decoration: none; font-family: arial,helvetica,sans serif; font-size: 11px; color: #838383; }
.tn_selevents_list A:visited { text-decoration: none; font-family: arial,helvetica,sans serif; font-size: 11px; color: #838383; }

IMG.tn_selevents_list_bullet { border-right: solid 4 white; width: 12; height: 12; }

TABLE.tn_selevents_feature_large { width: 100%  }

TD.tn_selevents_feature_large_image {  }
IMG.tn_selevents_feature_large_image { border: 0; }

TD.tn_selevents_feature_large_title {  }
.tn_selevents_feature_large_title A:link { text-decoration: underline; font-family: Verdana, Helvetica, Sans-Serif; font-size: 16pt; font-weight: bold; color: #007ACF; }
.tn_selevents_feature_large_title A:hover { text-decoration: underline; font-family: Verdana, Helvetica, Sans-Serif; font-size: 16pt; font-weight: bold; color: #007ACF; }
.tn_selevents_feature_large_title A:visited { text-decoration: underline; font-family: Verdana, Helvetica, Sans-Serif; font-size: 16pt; font-weight: bold; color: #007ACF; }
IMG.tn_selevents_feature_large_title { border: 0; width: 100; height: 13; }

TD.tn_selevents_feature_large_text { font-family: Verdana, Helvetica, Sans-Serif; font-size: 10pt; color: Gray;  }

TD.tn_selevents_feature_large_buynow { text-align: right;  }
IMG.tn_selevents_feature_large_buynow { border: 0; }

TABLE.tn_selevents_feature_small { width: 100%;  }
TD.tn_selevents_feature_small { text-align: center;  }
.tn_selevents_feature_small IMG { border: 0; }
.tn_selevents_feature_small A:link { text-decoration: underline; font-family: Verdana, Helvetica, Sans-Serif; font-size: 10pt; font-weight: bold; color: #007ACF; }
.tn_selevents_feature_small A:hover { text-decoration: underline; font-family: Verdana, Helvetica, Sans-Serif; font-size: 10pt; font-weight: bold; color: #007ACF; }
.tn_selevents_feature_small A:visited { text-decoration: underline; font-family: Verdana, Helvetica, Sans-Serif; font-size: 10pt; font-weight: bold; color: #007ACF; }

TABLE.tn_results_header { width: 695px; }
TABLE.tn_results_header TABLE { width: 695px; }
TD.tn_results_header_title { font-family: Verdana, Helvetica, Sans-Serif; font-size: 16pt; font-weight: bold; color: #2091C0;  }
TD.tn_results_header_title A:link { font-family: Verdana, Helvetica, Sans-Serif; font-size: 16pt; font-weight: bold; color: #2091C0;  }
TD.tn_results_header_title A:hover { font-family: Verdana, Helvetica, Sans-Serif; font-size: 16pt; font-weight: bold; color: #2091C0;  }
TD.tn_results_header_title A:visited { font-family: Verdana, Helvetica, Sans-Serif; font-size: 16pt; font-weight: bold; color: #2091C0;  }
TD.tn_results_header_subtitle { font-family: Verdana, Helvetica, Sans-Serif; font-size: 10pt; color: #2091C0;  }
TD.tn_results_header_subtitle A:link { font-family: Verdana, Helvetica, Sans-Serif; font-size: 10pt; color: #2091C0;  }
TD.tn_results_header_subtitle A:hover { font-family: Verdana, Helvetica, Sans-Serif; font-size: 10pt; color: #2091C0;  }
TD.tn_results_header_subtitle A:visited { font-family: Verdana, Helvetica, Sans-Serif; font-size: 10pt; color: #2091C0;  }
TD.tn_results_header_text { font-family: Verdana, Helvetica, Sans-Serif; font-size: 8pt; color: Gray;  }
TD.tn_results_header_venue { text-align: left; font-family: arial,helvetica,sans serif; font-size: 10pt; font-weight: bold; color: #2091C0;  }
TD.tn_results_header_datetime { text-align: center; font-family: arial,helvetica,sans serif; font-size: 10pt; font-weight: bold; color: #2091C0;  }
TD.tn_results_header_maplink { text-align: right; font-family: arial,helvetica,sans serif; font-size: 10pt; font-weight: bold; color: #2091C0;  }
TD.tn_results_header_maplink A:link { text-decoration: underline; font-family: arial,helvetica,sans serif; font-size: 10pt; font-weight: bold; color: #2091C0;  }
TD.tn_results_header_maplink A:hover { text-decoration: underline; font-family: arial,helvetica,sans serif; font-size: 10pt; font-weight: bold; color: #2091C0;  }
TD.tn_results_header_maplink A:visited { text-decoration: underline; font-family: arial,helvetica,sans serif; font-size: 10pt; font-weight: bold; color: #2091C0;  }

TR.tn_results_header_divider { height: 1px; }
TD.tn_results_header_divider { background-color: #CCCCCC; }

TABLE.tn_results_header_subhead {  }
TD.tn_results_header_subhead { }
TD.tn_results_header_subhead_caption { font-family: Verdana, Helvetica, Sans-Serif; font-size: 10pt; font-weight: bold; color: Gray; }
TD.tn_results_header_subhead_text { font-family: Verdana, Helvetica, Sans-Serif; font-size: 10pt; color: Gray; }
.tn_results_header_subhead_text A:link { text-decoration: underline; font-family: Verdana, Helvetica, Sans-Serif; font-size: 10pt; color: Gray;  }
.tn_results_header_subhead_text A:hover { text-decoration: underline; font-family: Verdana, Helvetica, Sans-Serif; font-size: 10pt; color: Gray;  }
.tn_results_header_subhead_text A:visited { text-decoration: underline; font-family: Verdana, Helvetica, Sans-Serif; font-size: 10pt; color: Gray;  }

TABLE.tn_results { width: 695px; }
TR.tn_results_colhead { height: 23px; }
TD.tn_results_colhead { text-align: center; background-image: url(images/results_header_background.gif); font-family: arial,helvetica,sans serif; font-weight: bold; font-size: 12px; color: #007CAF;  }
TD.tn_results_colhead A:link { text-decoration: underline; font-family: arial,helvetica,sans serif; font-weight: bold; font-size: 12px; color: #007CAF; }
TD.tn_results_colhead A:hover { text-decoration: underline; font-family: arial,helvetica,sans serif; font-weight: bold; font-size: 12px; color: #007CAF; }
TD.tn_results_colhead A:visited { text-decoration: underline; font-family: arial,helvetica,sans serif; font-weight: bold; font-size: 12px; color: #007CAF; }

A.tn_results_more_events:link { text-decoration: underline; font-family: Verdana, Helvetica, Sans-Serif; font-size: 10pt; color: Gray;  }
A.tn_results_more_events:hover { text-decoration: underline; font-family: Verdana, Helvetica, Sans-Serif; font-size: 10pt; color: Gray;  }
A.tn_results_more_events:visited { text-decoration: underline; font-family: Verdana, Helvetica, Sans-Serif; font-size: 10pt; color: Gray;  }

TR.tn_results_alternate_row { background-color: #F5F5F5; }
TR.tn_results_standard_row { background-color: #D9E9FB; }
TR.tn_results_divider { background-color: #9B9B9B; }
TD.tn_results_divider { }

TD.tn_results_event_text { width: 33%; text-align: left; font-family: arial,helvetica,sans serif; font-size: 12px; font-weight: bold; color: #007CAF; }
.tn_results_event_text A:link { text-decoration: underline; font-family: arial,helvetica,sans serif; font-size: 12px; font-weight: bold; color: #007CAF; }
.tn_results_event_text A:hover { text-decoration: underline; font-family: arial,helvetica,sans serif; font-size: 12px; font-weight: bold; color: #007CAF; }
.tn_results_event_text A:visited { text-decoration: underline; font-family: arial,helvetica,sans serif; font-size: 12px; font-weight: bold; color: #007CAF; }


TD.tn_results_venue_text { text-align: center; font-family: arial,helvetica,sans serif; font-size: 12px; font-weight: bold; color: #333333; }
.tn_results_venue_text A:link { text-decoration: underline; font-family: arial,helvetica,sans serif; font-size: 12px; font-weight: bold; color: #333333; }
.tn_results_venue_text A:hover { text-decoration: underline; font-family: arial,helvetica,sans serif; font-size: 12px; font-weight: bold; color: #333333; }
.tn_results_venue_text A:visited { text-decoration: underline; font-family: arial,helvetica,sans serif; font-size: 12px; font-weight: bold; color: #333333; }
.tn_results_location_text A:link { text-decoration: underline; font-family: arial,helvetica,sans serif; font-size: 12px; font-weight: normal; color: #666666; }
.tn_results_location_text A:hover { text-decoration: underline; font-family: arial,helvetica,sans serif; font-size: 12px; font-weight: normal; color: #666666; }
.tn_results_location_text A:visited { text-decoration: underline; font-family: arial,helvetica,sans serif; font-size: 12px; font-weight: normal; color: #666666; }


TD.tn_results_datetime_text { text-align: center; line-height: 13px; }
.tn_results_day_text { text-decoration: none; font-family: arial,helvetica,sans serif; font-size: 12px; font-weight: bold; color: #333333; }
.tn_results_date_text { text-decoration: none; font-family: arial,helvetica,sans serif; font-size: 12px; color: #333333; }
.tn_results_time_text { text-decoration: none; font-family: arial,helvetica,sans serif; font-size: 10px; color: #880303; }

TD.tn_results_tickets_text { text-align: center; }
.tn_results_tickets_text A:link { text-decoration: underline; font-family: arial,helvetica,sans serif; font-size: 12px; font-weight: normal; color: #333333; }
.tn_results_tickets_text A:hover { text-decoration: underline; font-family: arial,helvetica,sans serif; font-size: 12px; font-weight: normal; color: #333333; }
.tn_results_tickets_text A:visited { text-decoration: underline; font-family: arial,helvetica,sans serif; font-size: 12px; font-weight: normal; color: #333333; }

TABLE.tn_results_notfound { width: 100%; }
TR.tn_results_notfound { }
TD.tn_results_notfound { font-family: arial,helvetica,sans serif; font-size: 10pt; color: Gray; background-color: #FFFFCC; }
.tn_results_notfound_name { font-weight: bold; }
.tn_results_notfound_phone { font-weight: bold; }
.tn_results_notfound_email { font-weight: bold; }
A.tn_results_notfound_email:link { text-decoration: underline; font-family: arial,helvetica,sans serif; font-size: 10pt; color: Gray; font-weight: bold; }
A.tn_results_notfound_email:hover { text-decoration: underline; font-family: arial,helvetica,sans serif; font-size: 10pt; color: Gray; font-weight: bold; }
A.tn_results_notfound_email:visited { text-decoration: underline; font-family: arial,helvetica,sans serif; font-size: 10pt; color: Gray; font-weight: bold; }

TABLE.tn_results_notfound_form { width: 100%; }
TD.tn_results_notfound_form_text { font-family: arial,helvetica,sans serif; font-size: 8pt; color: Gray; font-weight: normal; }
TD.tn_results_notfound_form_caption { font-family: arial,helvetica,sans serif; font-size: 10pt; color: Gray; font-weight: bold; }
TD.tn_results_notfound_form_input { font-family: arial,helvetica,sans serif; font-size: 10pt; color: Gray; font-weight: normal; }

TD.tn_results_ticket_highlight { width: 10%; text-align: center; }
IMG.tn_results_ticket_highlight { border: none 0 black; }

TD.tn_results_ticket_sectionrow { width: 40%; text-align: center; }
TABLE.tn_results_ticket_sectionrow { width: 100% }
TD.tn_results_ticket_section { width: 50%; text-align: center; }
.tn_results_ticket_section_caption { font-family: arial,helvetica,sans serif; font-size: 12px; font-weight: bold; color: #333333; }
.tn_results_ticket_section_text { font-family: arial,helvetica,sans serif; font-size: 12px; font-weight: bold; color: #880303; }
TD.tn_results_ticket_row { width: 50%; text-align: center; }
.tn_results_ticket_row_caption { font-family: arial,helvetica,sans serif; font-size: 12px; font-weight: bold; color: #333333; }
.tn_results_ticket_row_text { font-family: arial,helvetica,sans serif; font-size: 12px; font-weight: bold; color: #880303; }
TD.tn_results_ticket_notes { font-family: arial,helvetica,sans serif; font-size: 11px; font-style: italic; color: #333333; }

TD.tn_results_ticket_face { width: 20%; text-align: center; font-family: arial,helvetica,sans serif; font-size: 12px; font-weight: bold; color: #880303; }
TD.tn_results_ticket_retail { width: 20%; text-align: center; font-family: arial,helvetica,sans serif; font-size: 12px; font-weight: bold; color: #880303; }
TD.tn_results_ticket_avail { width: 15%; text-align: center; }
TD.tn_results_ticket_purchase { width: 15%; text-align: center; }
.tn_results_ticket_purchase A:link { text-decoration: underline; font-family: arial,helvetica,sans serif; font-size: 10pt; color: Black; }
.tn_results_ticket_purchase A:hover { text-decoration: underline; font-family: arial,helvetica,sans serif; font-size: 10pt; color: Black; }
.tn_results_ticket_purchase A:visited { text-decoration: underline; font-family: arial,helvetica,sans serif; font-size: 10pt; color: Black; }

TABLE.tn_eventnames_header { width: 100%; }
TABLE.tn_eventnames_header TABLE { width: 100%; }
TD.tn_eventnames_header_title { padding: 6px 6px 6px 6px; text-align: center; font-family: Verdana, Helvetica, Sans-Serif; font-size: 16pt; font-weight: bold; color: #007ACF;  }
TD.tn_eventnames_header_text { font-family: Verdana, Helvetica, Sans-Serif; font-size: 8pt; color: Gray;  }
TD.tn_eventnames_subcategories { text-align: center; font-family: Verdana, Helvetica, Sans-Serif; font-size: 10pt; font-weight: bold; color: #007ACF;  }
TD.tn_eventnames_subcategories A:link { text-decoration: underline; font-family: Verdana, Helvetica, Sans-Serif; font-size: 10pt; font-weight: bold; color: #007ACF;  }
TD.tn_eventnames_subcategories A:hover { text-decoration: underline; font-family: Verdana, Helvetica, Sans-Serif; font-size: 10pt; font-weight: bold; color: #007ACF;  }
TD.tn_eventnames_subcategories A:visited { text-decoration: underline; font-family: Verdana, Helvetica, Sans-Serif; font-size: 10pt; font-weight: bold; color: #007ACF;  }

TR.tn_eventnames_header_divider { height: 1px; }
TD.tn_eventnames_header_divider { background-color: #CCCCCC; }
TD.tn_eventnames_vert_divider {  width: 2%; background-image: url(images/eventnames_vert_divider.gif); }

TD.tn_eventnames_nogroup_column { text-align: center; padding: 6px 6px 6px 6px; width: 49%; }
TD.tn_eventnames_nogroup_column A:link { text-decoration: none; font-family: Verdana, Helvetica, Sans-Serif; font-size: 8pt; color: Gray;  }
TD.tn_eventnames_nogroup_column A:hover { text-decoration: none; font-family: Verdana, Helvetica, Sans-Serif; font-size: 8pt; color: Gray;  }
TD.tn_eventnames_nogroup_column A:visited { text-decoration: none; font-family: Verdana, Helvetica, Sans-Serif; font-size: 8pt; color: Gray;  }

TD.tn_eventnames_grouped_column { width: 33%; text-align: center;  padding: 6px 6px 6px 6px; }
TD.tn_eventnames_grouped_column A:link { text-decoration: none; font-family: Verdana, Helvetica, Sans-Serif; font-size: 8pt; color: Gray;  }
TD.tn_eventnames_grouped_column A:hover { text-decoration: none; font-family: Verdana, Helvetica, Sans-Serif; font-size: 8pt; color: Gray;  }
TD.tn_eventnames_grouped_column A:visited { text-decoration: none; font-family: Verdana, Helvetica, Sans-Serif; font-size: 8pt; color: Gray;  }

.tn_eventnames_group_header { font-family: Verdana, Helvetica, Sans-Serif; font-size: 10pt; font-weight: bold; color: #007ACF;  }
.tn_eventnames_group_header A:link { text-decoration: underline; font-family: Verdana, Helvetica, Sans-Serif; font-size: 10pt; font-weight: bold; color: #007ACF;  }
.tn_eventnames_group_header A:hover { text-decoration: underline; font-family: Verdana, Helvetica, Sans-Serif; font-size: 10pt; font-weight: bold; color: #007ACF;  }
.tn_eventnames_group_header A:visited { text-decoration: underline; font-family: Verdana, Helvetica, Sans-Serif; font-size: 10pt; font-weight: bold; color: #007ACF;  }

TABLE.tn_featured_border_image { margin: 16px 8px 8px 8px; }
TABLE.tn_featured_border_html { margin: 16px 8px 8px 8px; border: solid 2 green; padding: 10px 10px 10px 10px }

TABLE.tn_event_calendar﻿  ﻿  ﻿  { width: 100%; }

TR.tn_event_calendar_title﻿  { background-color: LightYellow; }
TR.tn_event_calendar_title﻿  TD﻿  { text-align: center; color: #007ACF; font-size: 12pt; font-weight: bold; padding: 4px 4px 4px 4px; border: solid 1 #888888; }
TR.tn_event_calendar_header﻿  { background-color: White; }
TR.tn_event_calendar_header﻿  TD﻿  { text-align: center; color: #007ACF; font-size: 8pt; font-weight: bold; padding: 4px 4px 4px 4px; border: solid 1 #888888; }
TR.tn_event_calendar_days﻿  { background-color: White; }
TR.tn_event_calendar_days﻿  TD﻿  { height: 100px; text-align: left; color: Black; font-size: 8pt; font-weight: normal; padding: 4px 4px 4px 4px; border: solid 1 #888888; }
TD.tn_event_calendar_empty﻿  ﻿  { background-color: #EEEEEE; }

.tn_event_calendar_date﻿  ﻿  { color: #007ACF; font-size: 8pt; font-weight: bold; }
.tn_event_calendar_event﻿  { font-family: Arial, Helvetica, Sans-Serif; color: Black; font-size: 8pt; font-weight: normal; }
.tn_event_calendar_event﻿  A:link﻿  ﻿  { font-family: Arial, Helvetica, Sans-Serif; text-decoration: underline; color: Black; font-size: 8pt; font-weight: normal; }
.tn_event_calendar_event﻿  A:hover﻿  ﻿  { font-family: Arial, Helvetica, Sans-Serif; text-decoration: underline; color: Black; font-size: 8pt; font-weight: normal; }
.tn_event_calendar_event﻿  A:visited﻿  { font-family: Arial, Helvetica, Sans-Serif; text-decoration: underline; color: Black; font-size: 8pt; font-weight: normal; }
.tn_event_calendar_event﻿  A:active﻿  { font-family: Arial, Helvetica, Sans-Serif; text-decoration: underline; color: Black; font-size: 8pt; font-weight: normal; }

.tn_results_ticket_purchase IMG﻿  { border: 0; }
.tn_results_tickets_text IMG { border: 0; }

-->
</style>
<?php

// $local_list = City::model()->getListjson();

// $baseUrl = $this->createAbsoluteUrl('/');

// $neweventURL    = $baseUrl.'/calendar/calendar/newevent/';

// $bizAutoCompleteURL    = Yii::app()->createUrl('/business/business/autocompletelist');



print_r($eventItem);

$eventId                = $eventItem->external_event_id;
$venueMapUrl            = $eventItem->venue_url;
$venueInteractiveMapUrl = $eventItem->venue_interactive_url;

$tnconfigWebConfId      = Yii::app()->params['TN_SITECONFIG'];
$tnconfigBrokerId       = Yii::app()->params['TN_BROKERID'];
$tnconfigSiteNo         = Yii::app()->params['TN_SITENO'];


// "https://tickettransaction2.com/Checkout.aspx?brokerid={brokerid}&sitenumber={sitenumber}&tgid={tgid}&treq=1&evtID={evtID}&price={price}&SessionId={SessionId}",

$script = <<<EOD

    // ppcsrc
    var cookie_tn_ppc_src ='';
    var tn_cookies = '; '+document.cookie + ';';
    var cookie_ppc_src_start =tn_cookies.indexOf('; tn_ppc_src=') + 13;
    if(cookie_ppc_src_start != 12)
        cookie_tn_ppc_src = '&ppcsrc=' + tn_cookies.substring(cookie_ppc_src_start, tn_cookies.indexOf(';', cookie_ppc_src_start));
    var acct_start =tn_cookies.indexOf('; rcaid=') + 8;
    if(acct_start != 7)
        cookie_tn_ppc_src +='&rcaid=' +  tn_cookies.substring(acct_start, tn_cookies.indexOf(';', acct_start));


var webParms = {
    vfsEnable : 'hold',
    showStdSectionNames : true,
    swfMapURL : "{$venueInteractiveMapUrl}",
    staticMapURL : "{$venueMapUrl}",
    mapShellURL : "http://seatics.tickettransaction.com/mapshell_tn.swf "
};

    ssc.loadTgList(ticGrps, webParms);
    ssc.sortTgList('price', 'asc');
    // sort the list (before it's displayed!) in order of increasing price

        ssc.EH.buyTickets = function(buyObj) {

            var purchaseUrl = "https://tickettransaction2.com/Checkout.aspx?brokerid={$tnconfigBrokerId}&sitenumber={$tnconfigSiteNo}&tgid=" + buyObj.tgId + "&treq=1&evtID={$eventId}&price=" + buyObj.tgPrice + "&SessionId=" + makeGuid();
            if (typeof AppendToPurchaseUrl == "function") {
                try {
                    purchaseUrl = AppendToPurchaseUrl(purchaseUrl);
                } catch(e) {
                }
            }

             if (typeof PopupCheckOut == "function" && PopupCheckOut())
                 window.open(purchaseUrl, '_blank', 'location=no,scrollbars=yes,resizable=yes,menubar=yes,toolbar=yes');
             else
                 location.href = purchaseUrl;
        };

    function makeGuid() {
        var chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz';
        var guidLength = 5;
        var guid = '';
        for (var i = 0; i < guidLength; i++) {
            var rnum = Math.floor(Math.random() * chars.length);
            guid += chars.substring(rnum, rnum + 1);
        }
        return guid;
    }

EOD;

Yii::app()->clientScript->registerScript('my_event_list', $script, CClientScript::POS_READY);


?>


<style>
<!--
#mainpanel {
	background-color: white;
	text-align: left;
	position: fixed;
	top: 66px;
	bottom: 3px;
	/*   left: 0px; */
	width: 100%;
	padding-top: 10px;
	padding-right: 10px;
	padding-bottom: 10px;
	padding-left: 10px;
	box-shadow: #b0b0b0;
	z-index: 21;
	overflow-x: auto;
}
-->
</style>

<style>
#map_canvas {
	width: 600px;
	height: 500px;
}
</style>



    <div class='container'>
        <div class='row' id='mainpanel'>

			<div class="col-sm-12">
				<div id="ssc_listAndMapDiv"><!-- Booking content injected here --></div>
			</div>

        </div>
    </div>