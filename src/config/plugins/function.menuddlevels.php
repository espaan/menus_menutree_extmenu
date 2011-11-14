<?php
/**
 * Smarty function to parse structured tree array to html div with unordered list and divs with submenus
 *
 * Available parameters:
 *   - data:     array with tree data (array, required)
 *   - id:       id for main DIV element containing the UL (string, required)
 *   - class:    class for main DIV element containing the UL (string, required)
 *   - subclass: class for the submenu div (string, required)
 *   - span:     if set, places the 1st level urls in a seperate span for css image effects (e.g. sliding doors)
 *   - assign:   if set, the results are assigned to the corresponding variable instead of printed out
 *
 * Example
 *  <!--[menuddlevels data=$menutree_content id='menuid' class='ddlevelsmenu' subclass='ddlevelssubmenu' span='1']-->
 *
 * will generate unordered list inside a div with id "menuid" and class "ddlevelsmenu". The menutitles will be
 * placed in a seperate span. Nested submenus will be put in a seperate div with class "ddlevelssubmenu"
 *
 * @author       Erik Spaan, original by Jusuff
 * @since        03/09/2010
 * @version      $Id: $
 * @param        array       $params      All attributes passed to this function from the template
 * @param        object      &$smarty     Reference to the Smarty object
 * @return       string      div with unordered list and divs with submenus
 */
function smarty_function_menuddlevels($params, &$smarty)
{
    $treeArray = $params['data'];
    $treeId = $params['id'];
    $treeClass = $params['class'];
    $treeSubClass = $params['subclass'];
    $span = ($params['span']) ? true : false;

    $html = _htmlListTopdiv($treeArray, $treeId, $treeClass, $treeSubClass, $span);

    if (isset($params['assign'])) {
        $smarty->assign($params['assign'], $html);
    } else {
        return $html;
    }
}

function _htmlListTopdiv($tree,$treeId = '',$treeClass = '',$treeSubClass = '',$span=false)
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
    	$html .= '<li' . (($currentLink == $request) ? ' class="selected"' : '') . '>';
    	$html .= '<a href="'.DataUtil::formatForDisplay($tab['item']['href']).'"';
        $html .= !empty($tab['item']['className']) ? ' class="'.$tab['item']['className'].'"' : '';
        $html .= !empty($tab['item']['title']) ? ' title="'.$tab['item']['title'].'"' : '';
        if (!empty($tab['nodes'])) {
            $html .= ' rel="'.$treeId.$tab['item']['id'].'"';
            $html2 .= _htmlListDDLsub($tab['nodes'], $treeId.$tab['item']['id'], $treeSubClass);
        }
        $html .= '>';
        $html .= $span ? '<span>'.$tab['item']['name'].'</span>' : $tab['item']['name'];
        $html .= '</a></li>';
    }
    $html .= '</ul></div>';

    // add submenus to the content after the main div
    if (!empty($html2)) {
        PageUtil::addVar('footer', $html2);
    }
    return $html;
}

function _htmlListDDLsub($tree,$treeId = '',$treeSubClass = '')
{
    $html = '<ul';
    $html .= !empty($treeId) ? ' id="'.$treeId.'"' : '';
    $html .= !empty($treeSubClass) ? ' class="'.$treeSubClass.'"' : '';
    $html .= '>';

    foreach ($tree as $tab) {
        $html .= '<li><a href="'.DataUtil::formatForDisplay($tab['item']['href']).'"';
        $html .= !empty($tab['item']['title']) ? ' title="'.$tab['item']['title'].'"' : '';
        // if more levels are present
        $html .= '>'.$tab['item']['name'].'</a>';
        if (!empty($tab['nodes'])) {
            $html .= _htmlListDDLsub($tab['nodes']);
        }
        $html .= '</li>';
    }
    $html .= '</ul>';

    return $html;
}
