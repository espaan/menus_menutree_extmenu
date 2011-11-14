{pageaddvar name="rawtext" value=$smarty.ldelim|cat:'if IE 7]><style type="text/css">.cssplay_fly li {float:left;}</style><![endif'|cat:$smarty.rdelim}
<!-- http://www.cssplay.co.uk/menus/flyout_4level.html -->
<div class="cssplay_fly">
{menucssplay data=$menutree_content ulclass="" dropclass="sub" flyclass="sub"}
</div>
{if $menutree_editlinks}
<p class="menutree_vertical_left_controls">
    <a href="{modurl modname=Blocks type=admin func=modify bid=$blockinfo.bid addurl=1}#menutree_tabs" title="{gt text='Add the current URL as new link in this block'}">{gt text='Add current URL'}</a><br />
    <a href="{modurl modname=Blocks type=admin func=modify bid=$blockinfo.bid fromblock=1}" title="{gt text='Edit this block'"}">{gt text='Edit this block'}</a>
</p>
{/if}
