//SuckerTree Horizontal Menu (Sept 14th, 06)
//By Dynamic Drive: http://www.dynamicdrive.com/style/
var sthmenuids=[] //Enter id(s) of SuckerTree UL menus, separated by commas, empty by default
var mainfoldericon="mainfoldericon"
var subfoldericon="subfoldericon"
function sth_buildsubmenus(){
for (var i=0; i<sthmenuids.length; i++){
 var ultags=document.getElementById(sthmenuids[i]).getElementsByTagName("ul")
 for (var t=0; t<ultags.length; t++){
  if (ultags[t].parentNode.parentNode.id==sthmenuids[i]){ //if this is a first level submenu
   ultags[t].style.top=ultags[t].parentNode.offsetHeight+"px" //dynamically position first level submenus to be height of main menu item
   ultags[t].parentNode.getElementsByTagName("a")[0].className=mainfoldericon
  }else{ //else if this is a sub level menu (ul)
   ultags[t].style.left=ultags[t-1].getElementsByTagName("a")[0].offsetWidth+"px" //position menu to the right of menu item that activated it
   ultags[t].parentNode.getElementsByTagName("a")[0].className=subfoldericon
  }
  ultags[t].parentNode.onmouseover=function(){
   this.getElementsByTagName("ul")[0].style.visibility="visible"
  }
  ultags[t].parentNode.onmouseout=function(){
   this.getElementsByTagName("ul")[0].style.visibility="hidden"
  }
 }
}
}
