<?php
/**
 * Smarty function to parse structured tree array to html div with unordered lists for display with pure css method
 *
 * Available parameters:
 *   - data:         array with tree data (array, required)
 *   - ulclass:      optional class for the ul
 *   - currentclass: specifies the class to use for the selected menu option
 *   - iframe:       if set, the iframe shim of cssplay.co.uk will be applied
 *   - iehacks:      if set, IE6/7 hacks will be applied
 *   - assign:       if set, the results are assigned to the corresponding variable instead of printed out
 *
 * Example
 *   <!--[menucssplayprodrop ulclass="prodrop8" data=$menutree_content]-->
 *
 * Will generate unordered multi-level list with class prodrop8 for the UL.
 *
 * @author       Erik Spaan
 * @since        29/05/2008
 * @version      $Id: function.menucssplayprodrop.php 444 2009-10-10 17:44:38Z espaan $
 * @param        array       $params       All attributes passed to this function from the template
 * @param        object      &$smarty      Reference to the Smarty object
 * @param        string      $ulclass      UL class Optional
 * @param        string      $currentclass CSS class for the current link
 *                                         Default = 'selected'
 * @param        boolean     $iehacks      boolean to set the usage of the IE6,7 hacks for the pure css menu
 * @param        boolean     $iframe       boolean to set the usage of an iframe shim for IE6 (hovering over form elements)
 * @return       string      the results of the module function
 */
function smarty_function_menucssplayprodrop($params, &$smarty)
{
    extract($params);
    unset($params);

    // Set and check all the parameter values
    $treeArray = $data;
    if (!isset($ulclass)) {
        $ulclass = '';
    }
    if (!isset($currentclass)) {
        $currentclass = 'selected';
    }
    if (!isset($iehacks)) {
        $iehacks = true;
    }
    if (!isset($iframe)) {
        $iframe = true;
    }

    $html = '<ul' . ((!empty($ulclass))?' class="'.$ulclass.'"':'') . '>';
    foreach($treeArray as $option) {
        $html .= _htmlListCssplayprodrop($option, 0, $currentclass, $iehacks, $iframe);
    }
    $html .= '</ul>';

    if (isset($assign)) {
        $smarty->assign($assign, $html);
    } else {
        return $html;
    }
}

function _htmlListCssplayprodrop($tab, $level=0, $currentclass, $iehacks=true, $iframe=false)
{
    // The current requested URL stripped of domain and any subdirs
    $request = str_replace(pnGetBaseURI(), '', pnGetCurrentURI());
    $currentLink = str_replace(pnGetBaseURL(), '', $tab['item']['href']);
    if (substr($currentLink,0,1) != '/') { 
        $currentLink = '/'.$currentLink;
    }

    $html = '';
    if ($level==0) {
        $html .= '<li class="top' . (($currentLink == $request)?' '.$currentclass:'') . '">';
    } else {
        $html = '<li>';
    }
    $html .= '<a class="';
    if ($level==0) {
        $html .= 'top_link';
    } elseif (!empty($tab['nodes'])) {
        $html .= 'fly';
    }
    $html .= !empty($tab['item']['className']) ? ' '.$tab['item']['className'] : '';
    $html .= '"';

    $html .= ' href="'.DataUtil::formatForDisplay($tab['item']['href']).'"';
    $html .= !empty($tab['item']['title']) ? ' title="'.$tab['item']['title'].'"' : ' title=""';
    $html .= '>';
    if ($level == 0) {
        $html .= ((!empty($tab['nodes'])) ? '<span class="down">' : '<span>') . $tab['item']['name'] . '</span>';
    } else {
        $html .= $tab['item']['name'];
    }
    //check for submenu(s)
    if (!empty($tab['nodes'])) {
    	if ($level == 0) {
            /* at 1st level add iframe for IE6 menu over form display */
            if ($iehacks) {
                $html .= '<!--[if gte IE 7]><!--></a><!--<![endif]--><!--[if lte IE 6]><table><tr><td>';
                $html .= ($iframe) ? '<iframe frameborder="0"></iframe>' : '';
                $html .= '<![endif]-->';
            }
            $html .= '<ul class="drop">';
        } else {
            if ($iehacks) {
                $html .= '<!--[if gte IE 7]><!--></a><!--<![endif]--><!--[if lte IE 6]><table><tr><td><![endif]-->';
            }
            $html .= '<ul>';
        }
        foreach ($tab['nodes'] as $suboption) {
            /* Recursively render submenus */
            $html .= _htmlListCssplayprodrop($suboption, $level+1, $currentclass, $iehacks, $iframe);
        }
        $html .= '</ul>';
        $html .= '<!--[if lte IE 6]></td></tr></table></a><![endif]-->'; /* IE extras */
    } else {
         $html .= '</a>';
    }
    $html .= '</li>';
    return $html;
}
