{pageaddvar name="javascript" value="config/javascript/menutree/suckertreevert.js"}
<script type="text/javascript">
/***********************************************
* SuckerTree Vertical Menu 1.1 (Nov 8th, 06)
* By Dynamic Drive: http://www.dynamicdrive.com/style/
***********************************************/
//Add id to SuckerTree UL menu ids var
var stvmenuids = stvmenuids.concat(["{{'menu'|cat:$blockinfo.bid}}"])
if (window.addEventListener)
 window.addEventListener("load", stv_buildsubmenus, false)
else if (window.attachEvent)
 window.attachEvent("onload", stv_buildsubmenus)
</script>
<div class="st_vert">
{menutree data=$menutree_content id='menu'|cat:$blockinfo.bid}
</div>
{if $menutree_editlinks}
<p class="menutree_vertical_left_controls">
    <a href="{modurl modname=Blocks type=admin func=modify bid=$blockinfo.bid addurl=1}#menutree_tabs" title="{gt text='Add the current URL as new link in this block'}">{gt text='Add current URL'}</a><br />
    <a href="{modurl modname=Blocks type=admin func=modify bid=$blockinfo.bid fromblock=1}" title="{gt text='Edit this block'"}">{gt text='Edit this block'}</a>
</p>
{/if}
