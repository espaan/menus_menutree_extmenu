{pageaddvar name="javascript" value="config/javascript/menutree/suckertreehoriz.js"}
<script type="text/javascript">
/***********************************************
* SuckerTree Horizontal Menu (Sept 14th, 06)
* By Dynamic Drive: http://www.dynamicdrive.com/style/
***********************************************/
//Add the id to the SuckerTree UL menus ids var
var sthmenuids = sthmenuids.concat(["{{'menu'|cat:$blockinfo.bid}}"] )
if (window.addEventListener)
 window.addEventListener("load", sth_buildsubmenus, false)
else if (window.attachEvent)
 window.attachEvent("onload", sth_buildsubmenus)
</script>
<div class="st_horiz">
{menutree data=$menutree_content id='menu'|cat:$blockinfo.bid}
</div>