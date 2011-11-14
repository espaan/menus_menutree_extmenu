<?php
/**
 * Smarty function to parse structured tree array to html div with unordered lists for display with pure css method
 *
 * Available parameters:
 *   - data:         array with tree data (array, required)
 *   - ulclass:      optional class for the ul
 *   - currentclass: specifies the class to use for the selected menu option
 *   - span:         if set, places the 1st level urls in a seperate span for css image effects (e.g. sliding doors)
 *   - iframe:       if set, the iframe shim of cssplay.co.uk will be applied
 *   - iehacks:      if set, IE6/7 hacks will be applied
 *   - assign:       if set, the results are assigned to the corresponding variable instead of printed out
 *
 * Example
 *   <!--[menucssplay data=$menutree_content ulclass="cssplay_drop"]-->
 *
 * Will generate unordered multi-level list with class cssplay_drop for the UL.
 *
 * @author       Erik Spaan
 * @since        29/05/2008
 * @version      $Id$
 * @param        array       $params       All attributes passed to this function from the template
 * @param        object      &$smarty      Reference to the Smarty object
 * @param        string      $ulclass      UL class Optional
 * @param        string      $dropclass    LI class for 1st level drop
 * @param        string      $flyclass     LI class for n level drop
 * @param        string      $currentclass CSS class for the current link
 *                                         Default = 'selected'
 * @param        boolean     $iehacks      boolean to set the usage of the IE6,7 hacks for the pure css menu
 * @param        string      $startli      LI class first item in drop list (border stuff)
 *                                         Default = 'enclose'
 * @param        string      $stopli       LI class last item in drop list (border stuff)
 *                                         Default = 'enclose'
 * @return       string      the results of the module function
 */
function smarty_function_menucssplay($params, &$smarty)
{
    extract($params);
    unset($params);

    // Set and check all the parameter values
    $treeArray = $data;
    if (!isset($ulclass)) {
        $ulclass = '';
    }
    if (!isset($topclass)) {
        $topclass = 'toplink';
    }
    if (!isset($dropclass)) {
        $dropclass = 'drop';
    }
    if (!isset($flyclass)) {
        $flyclass = 'fly';
    }
    if (!isset($currentclass)) {
        $currentclass = 'selected';
    }
    if (!isset($iehacks)) {
        $iehacks = true;
    }
    if (!isset($startli)) {
        $enclose = true;
    }
    if (!isset($stopli)) {
        $enclose = true;
    }

    $html = '<ul' . ((!empty($ulclass))?' class="'.$ulclass.'"':'') . '>';

    // switched from foreach to for loop for optionally enabling class statement on the first and last LI
    $keys = array_keys($treeArray);
    for ($i = 0; $i < count($keys); $i++) {
        $html .= _htmlListCssplay($treeArray[$keys[$i]], 0, $i==count($keys)-1, $currentclass, $iehacks, $topclass, $dropclass, $flyclass);
    }
    $html .= '</ul>';

    if (isset($assign)) {
        $smarty->assign($assign, $html);
    } else {
        return $html;
    }
}

function _htmlListCssplay($tab, $level=0, $enclose, $currentclass, $iehacks, $topclass, $dropclass, $flyclass)
{
    // The current requested URL stripped of domain and any subdirs
    $request = str_replace(pnGetBaseURI(), '', pnGetCurrentURI());
    $currentLink = str_replace(pnGetBaseURL(), '', $tab['item']['href']);
    if (substr($currentLink,0,1) != '/') { 
        $currentLink = '/'.$currentLink;
    }

    $html = '';
    if (!empty($tab['nodes'])) {
        $html .= '<li class="' . ($level==0 ? "$topclass $dropclass " : $flyclass) . ($currentLink == $request ? $currentclass : '') .'">';
    } else {
        $html .= '<li class="' . ($level==0 ? "$topclass " : '') . ($currentLink == $request ? $currentclass : '') .'">';
    }

    $html .= '<a';
    if ($enclose || !empty($tab['item']['className'])) {
        $html .= ' class="' . ($enclose ? 'enclose' : '');
        $html .= !empty($tab['item']['className']) ? ' '.$tab['item']['className'] : '';
        $html .= '"';
    }
    $html .= ' href="'.DataUtil::formatForDisplay($tab['item']['href']).'"';
    $html .= !empty($tab['item']['title']) ? ' title="'.$tab['item']['title'].'"' : ' title=""';
    $html .= '>' . $tab['item']['name'];
    // check for submenu(s)
    if (!empty($tab['nodes'])) {
		if ($iehacks) {
			$html .= '<!--[if IE 7]><!--></a><!--<![endif]--><!--[if lte IE 6]><table><tr><td><![endif]-->';
		}
		$html .= '<ul>';
        $enclose = true;
        foreach ($tab['nodes'] as $suboption) {
            /* Recursively render submenus */
            $html .= _htmlListCssplay($suboption, $level+1, $enclose, $currentclass, $iehacks, $topclass, $dropclass, $flyclass);
            $enclose = false; /* Only first item is supplied with enclose */
        }
        $html .= '</ul>';
		if ($iehacks) {
	        $html .= '<!--[if lte IE 6]></td></tr></table></a><![endif]-->'; /* IE extras */
	    }
    } else {
         $html .= '</a>';
    }
    $html .= '</li>';
    return $html;
}
