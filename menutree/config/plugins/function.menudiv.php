<?php
/**
 * Smarty function to parse structured tree array to html div with unordered list and divs with submenus
 *
 * Available parameters:
 *   - data:        array with tree data (array, required)
 *   - id:          id for main DIV element containing the UL (string, required)
 *   - class:       class for main DIV element containing the UL (string, required)
 *   - subclass:  class for the submenu divs (string, required)
 *   - span:        if set, places the 1st level urls in a seperate span for css image effects (e.g. sliding doors)
 *   - assign:      if set, the results are assigned to the corresponding variable instead of printed out
 *
 * Example
 *  <!--[menudiv data=$menutree_content id='menuid' class='ddcolortabs' subclass='dropmenu' span=1]-->
 *
 * will generate unordered list inside a div with id "menuid" and class "ddcolortabs". The menutitles will be
 * placed in a seperate span. Submenus will be put in seperate divs with class "dropmenu"
 *
 * @author       Erik Spaan, original by Jusuff
 * @since        01/02/2007
 * @version      $Id$
 * @param        array       $params      All attributes passed to this function from the template
 * @param        object      &$smarty     Reference to the Smarty object
 * @return       string      div with unordered list and divs with submenus
 */
function smarty_function_menudiv($params, &$smarty)
{
    $treeArray = $params['data'];
    $treeId = $params['id'];
    $treeClass = $params['class'];
    $treeSubClass = $params['subclass'];
    $span = ($params['span']) ? true : false;

    $html = _htmlListDiv($treeArray, $treeId, $treeClass, $treeSubClass, $span);

    if (isset($params['assign'])) {
        $smarty->assign($params['assign'], $html);
    } else {
        return $html;
    }
}

function _htmlListDiv($tree,$treeId = '',$treeClass = '',$treeSubClass = '',$span=false)
{
    $html = '<div';
    $html .= !empty($treeId) ? ' id="'.$treeId.'"' : '';
    $html .= !empty($treeClass) ? ' class="'.$treeClass.'"' : '';
    $html .= '><ul>';

    // will contain optional Submenu(s)
    $html2 = '';

	// The current requested URL stripped of domain and any subdirs
	$request = str_replace(pnGetBaseURI(), '', pnGetCurrentURI());

    foreach ($tree as $tab) {
        $currentLink = str_replace(pnGetBaseURL(), '', $tab['item']['href']);
        if (substr($currentLink,0,1) != '/') { 
        	$currentLink = '/'.$currentLink;
        }
    	$html .= '<li';
        $html .= ($currentLink == $request) ? ' class="selected"' : '';
    	$html .= '>';
    	$html .= '<a href="'.DataUtil::formatForDisplay($tab['item']['href']).'"';
        $html .= !empty($tab['item']['className']) ? ' class="'.$tab['item']['className'].'"' : '';
        $html .= !empty($tab['item']['title']) ? ' title="'.$tab['item']['title'].'"' : '';
        if (!empty($tab['nodes'])) {
            $html .= ' rel="'.$treeId.$tab['item']['id'].'"';
            $html2 .= _htmlListDivSub($tab['nodes'], $treeId.$tab['item']['id'], $treeSubClass);
        }
        $html .= '>';
        $html .= $span ? '<span>'.$tab['item']['name'].'</span>' : $tab['item']['name'];
        $html .= '</a></li>';
    }
    $html .= '</ul></div>';

    // add submenus to the footer of the page
    if (!empty($html2)) {
        PageUtil::addVar('footer', $html2);
        //$html .= $html2;
    }
    return $html;
}

function _htmlListDivSub($tree,$treeId = '',$treeSubClass = '')
{
    $html = '<div';
    $html .= !empty($treeId) ? ' id="'.$treeId.'"' : '';
    $html .= !empty($treeSubClass) ? ' class="'.$treeSubClass.'"' : '';
    $html .= '>';

    // 2nd level Submenu(s)
    $html2 = '';

    foreach ($tree as $tab) {
        $html .= '<a href="'.DataUtil::formatForDisplay($tab['item']['href']).'"';
        $html .= !empty($tab['item']['title']) ? ' title="'.$tab['item']['title'].'"' : '';
        if (!empty($tab['nodes'])) {
            $html .= ' rel="' . $treeId . $tab['item']['id'].'"';
            $html2 .= _htmlListDivSub($tab['nodes'], $treeId . $tab['item']['id'], $treeSubClass);
        }
        $html .= '>'.$tab['item']['name'].'</a>';
    }
    $html .= '</div>';

    // add submenus to the content
    if (!empty($html2)) {
        $html .= $html2;
    }

    return $html;
}
