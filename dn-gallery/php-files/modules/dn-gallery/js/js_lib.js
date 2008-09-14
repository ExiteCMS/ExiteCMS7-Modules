
//var popUpWidth = Math.round(screen.width / 2) + 150;
//var popUpHeight = Math.round(screen.height / 2) + 150;

var popUpWidth = 800;
var popUpHeight = 600;

var leftPos = Math.round(screen.width / 2) - Math.round(popUpWidth / 2);
var topPos =  Math.round(screen.height / 2) - Math.round(popUpHeight / 2);


function Trim(TRIM_VALUE){
	if(TRIM_VALUE.length < 1){
		return"";
	}
	TRIM_VALUE = RTrim(TRIM_VALUE);
	TRIM_VALUE = LTrim(TRIM_VALUE);
	if(TRIM_VALUE==""){
		return "";
	}
	else{
		return TRIM_VALUE;
	}
} //End Function

function RTrim(VALUE){
	var w_space = String.fromCharCode(32);
	var v_length = VALUE.length;
	var strTemp = "";
	if(v_length < 0){
		return"";
	}
	var iTemp = v_length -1;

	while(iTemp > -1){
		if(VALUE.charAt(iTemp) == w_space){
		}
		else{
			strTemp = VALUE.substring(0,iTemp +1);
			break;
		}
		iTemp = iTemp-1;

	} //End While
	return strTemp;

} //End Function

function LTrim(VALUE){
	var w_space = String.fromCharCode(32);
	if(v_length < 1){
		return"";
	}
	var v_length = VALUE.length;
	var strTemp = "";

	var iTemp = 0;

	while(iTemp < v_length){
		if(VALUE.charAt(iTemp) == w_space){
		}
		else{
			strTemp = VALUE.substring(iTemp,v_length);
			break;
		}
		iTemp = iTemp + 1;
	} //End While
	return strTemp;
} //End Function


array_search = function (array, value) {

   var results = -1;

   for (var i = 0; i < array.length; i++) {
      if (array[i] == value) { results = i; }
   }
   return results;

}
/*** Copy Right Information ***
  * Please do not remove following information.
  * Modal Popup v1.0
  * Author: John J Kim
  * Email: john@frontendframework.com
  * URL: www.FrontEndFramework.com
  * 
  * You are welcome to modify the codes as long as you include this copyright information.
 *****************************/
 
//With the window size & the element size functions built-in
ModalPopup = function (elem,options) {
	
	//option default settings
	options = options || {};
	var HasBackground = (options.HasBackground!=null)?options.HasBackground:true;
	var BackgroundColor = options.BackgroundColor || '#000000';
	var BackgroundOpacity = options.BackgroundOpacity || 60; // 1-100
	BackgroundOpacity = (BackgroundOpacity > 0) ? BackgroundOpacity : 1;
	var BackgroundOnClick = options.BackgroundOnClick || function(){};
	var BackgroundCursorStyle = options.BackgroundCursorStyle || "default";
	var Zindex = options.Zindex || 90000;
	var AddLeft = options.AddLeft || 0; //in px
	var AddTop = options.AddTop || 0; //in px
	
	AddTop = AddTop + document.documentElement.scrollTop;
	function _Convert(val) {
		if (!val) {return;}
		val = val.replace("px","");
		if (isNaN(val)) {return 0;}
		return parseInt(val);
	}
	var popup = document.getElementById(elem);
	if (!popup) {return;}
	//set the popup layer styles
	var winW = (document.layers||(document.getElementById&&!document.all)) ? window.outerWidth : (document.all ? document.body.clientWidth : 0);
	var winH = screen.height;
	//display the popup layer
	popup.style.display = "block";
	popup.style.visibility = "visible";
	var currentStyle;
	if (popup.currentStyle)	{ 
		currentStyle = popup.currentStyle; 
	}
	else if (window.getComputedStyle) {
		currentStyle = document.defaultView.getComputedStyle(popup, null);
	} else {
		currentStyle = popup.style;
	}

	var elemW = popup.offsetWidth -
		_Convert(currentStyle.marginLeft) -
		_Convert(currentStyle.marginRight) -
		_Convert(currentStyle.borderLeftWidth) -
		_Convert(currentStyle.borderRightWidth);

	var elemH = popup.offsetHeight -
		_Convert(currentStyle.marginTop) -
		_Convert(currentStyle.marginBottom) -
		_Convert(currentStyle.borderTopWidth) -
		_Convert(currentStyle.borderBottomWidth);

	popup.style.left = (winW/2 - elemW/2 + AddLeft - 10) + "px";
	popup.style.top = (winH/2 - elemH/2 + AddTop - 10 - 100) + "px";
	popup.style.position = "absolute";
	popup.style.zIndex = Zindex + 1;

	/*if (winH > document.body.clientHeight  + AddTop)
	{
		BackgroundHeight = winH;
	}
	else {*/
		BackgroundHeight = document.body.clientHeight  + AddTop;
	//}
	
	if (HasBackground) {	
		if (!ModalPopup._BackgroundDiv) {
			addDiv = false;
			var browser=navigator.appName;
			if (!document.getElementById("BackGroundDiv") || browser=="Microsoft Internet Explorer")
			{
				addDiv = true;
				ModalPopup._BackgroundDiv = document.createElement('div');
			}
			else {
				ModalPopup._BackgroundDiv = document.getElementById("BackGroundDiv");
			}
			ModalPopup._BackgroundDiv.style.display = "none";
			ModalPopup._BackgroundDiv.style.width = document.body.clientWidth + "px";
			ModalPopup._BackgroundDiv.style.height = BackgroundHeight + "px";
			ModalPopup._BackgroundDiv.style.position = "absolute";
			ModalPopup._BackgroundDiv.style.top = "0px";
			ModalPopup._BackgroundDiv.style.left = "0px";
			if (addDiv)
			{
				document.body.appendChild(ModalPopup._BackgroundDiv);
			}
		}
		ModalPopup._BackgroundDiv.onclick =  BackgroundOnClick;
		ModalPopup._BackgroundDiv.style.background = BackgroundColor;	
		ModalPopup._BackgroundDiv.style.height = BackgroundHeight + "px";
		ModalPopup._BackgroundDiv.style.filter = "progid:DXImageTransform.Microsoft.Alpha(opacity=" + BackgroundOpacity +")";
		ModalPopup._BackgroundDiv.style.MozOpacity = BackgroundOpacity / 100;
		ModalPopup._BackgroundDiv.style.opacity = BackgroundOpacity / 100;
		ModalPopup._BackgroundDiv.style.zIndex = Zindex;
		ModalPopup._BackgroundDiv.style.cursor = BackgroundCursorStyle;

		//Display the background
		ModalPopup._BackgroundDiv.style.display = "block";
		ModalPopup._BackgroundDiv.style.visibility = "visible";
	}

}

ModalPopup.Close = function(id) {
	if (id) {
		document.getElementById(id).style.display = "none";
		document.getElementById(id).style.visibility = "hidden";
	} 
	if  (ModalPopup._BackgroundDiv) {
		ModalPopup._BackgroundDiv.style.display = "none";
		ModalPopup._BackgroundDiv.style.visibility = "hidden";
	}
}

var GlobalModalPopup = this.ModalPopup;
