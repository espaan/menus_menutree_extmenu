{pageaddvar name="javascript" value="config/javascript/menutree/dropdowntabs.js"}
{menudiv data=$menutree_content id='ddmenu'|cat:$blockinfo.bid class='ddcolortabs' subclass='dropmenudiv_ddct' span=1}
<div class="ddcolortabsline">&nbsp;</div>
<script type="text/javascript">
/***********************************************
* Drop Down Tabs Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/
tabdropdown.init("{{'ddmenu'|cat:$blockinfo.bid}}")
</script>