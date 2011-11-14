//SuckerTree Vertical Menu 1.1 (Nov 8th, 06)
//By Dynamic Drive: http://www.dynamicdrive.com/style/
var stvmenuids=[] //Enter id(s) of SuckerTree UL menus, seperated by commas, default empty
var subfoldericon="subfoldericon"
function stv_buildsubmenus(){
for (var i=0; i<stvmenuids.length; i++){
 var ultags=document.getElementById(stvmenuids[i]).getElementsByTagName("ul")
 for (var t=0; t<ultags.length; t++){
  ultags[t].parentNode.getElementsByTagName("a")[0].className=subfoldericon
  if (ultags[t].parentNode.parentNode.id==stvmenuids[i]) //if this is a first level submenu
   ultags[t].style.left=ultags[t].parentNode.offsetWidth+"px" //dynamically position first level submenus to be width of main menu item
  else //else if this is a sub level submenu (ul)
   ultags[t].style.left=ultags[t-1].getElementsByTagName("a")[0].offsetWidth+"px" //position menu to the right of menu item that activated it
  ultags[t].parentNode.onmouseover=function(){
   this.getElementsByTagName("ul")[0].style.display="block"
  }
  ultags[t].parentNode.onmouseout=function(){
   this.getElementsByTagName("ul")[0].style.display="none"
  }
 }
 for (var t=ultags.length-1; t>-1; t--){ //loop through all sub menus again, and use "display:none" to hide menus (to prevent possible page scrollbars)
  ultags[t].style.visibility="visible"
  ultags[t].style.display="none"
 }
}
}