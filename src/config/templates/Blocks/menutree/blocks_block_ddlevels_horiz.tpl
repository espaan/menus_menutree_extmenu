{pageaddvar name="javascript" value="config/javascript/menutree/ddlevelsmenu.js"}
{menuddlevels data=$menutree_content id='ddmenu'|cat:$blockinfo.bid class='ddlevelsmenu' subclass='ddlevelssubmenu'}
<script type="text/javascript">
/***********************************************
* All Levels Navigational Menu- (c) Dynamic Drive DHTML code library (http://www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/
// Set varaiables, see for details ddlevelsmenu.js
ddlevelsmenu.enableshim = true; //enable IFRAME IE6 shim
ddlevelsmenu.arrowpointers = {
  downarrow: ["config/images/menutree/ddlevels/arrow-down-light.gif",13,8], //[path_to_down_arrow, arrowwidth, arrowheight]
  rightarrow: ["config/images/menutree/ddlevels/arrow-right.gif",12,12], //[path_to_right_arrow, arrowwidth, arrowheight]
  showarrow: {toplevel:true,sublevel:true}
};
ddlevelsmenu.hideinterval = 250;
ddlevelsmenu.effects = {enableswipe: true, enablefade: true, duration: 125};
ddlevelsmenu.httpsiframesrc = "blank.htm";
//start the menu ddlevelsmenu.setup("mainmenuid", "topbar|sidebar")
ddlevelsmenu.setup("{{'ddmenu'|cat:$blockinfo.bid}}", "topbar"); 
</script>