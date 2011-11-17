<div id="navcontainer_{$blockinfo.bid}" class="navcontainer_v">
<ul>
{foreach from=$menuitems item=item}
{if $item.name != '' && $item.url != ''}
  <li{if $item.url|replace:$baseurl:'' eq $currenturi|urldecode} class="selected"{/if}>
    <a href="{$item.url|pnvarprepfordisplay}" title="{$item.title}">{if $item.image != ''}<img src="{$item.image}" alt="{$item.title}" />{/if}{$item.name}</a>
  </li>
{else}
  <li>{$item.name}</li>
{/if}
{/foreach}
{if $access_edit}
    <li><a href="{modurl modname='Blocks' type='admin' func='modify' bid=$blockinfo.bid addurl=1}#editmenu" title="{gt text='Add the current URL as a new link in this block' domain='zikula'}"><em>*{gt text='Add current URL' domain='zikula'}</em></a></li>
    <li><a href="{modurl modname='Blocks' type='admin' func='modify' bid=$blockinfo.bid fromblock=1}" title="{gt text='Edit this block' domain='zikula'}"><em>*{gt text='Edit this block' domain='zikula'}</em></a></li>
{/if}
</ul>
</div>
