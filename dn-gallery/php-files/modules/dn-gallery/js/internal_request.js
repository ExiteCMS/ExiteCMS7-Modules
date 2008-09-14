
var displayElement = "";
function createRequestObject(){
	var request_o; //declare the variable to hold the object.
	var browser = navigator.appName; //find the browser name
	if(browser == "Microsoft Internet Explorer"){
		request_o = new ActiveXObject("Microsoft.XMLHTTP");
	}else{
		request_o = new XMLHttpRequest();
	}
	return request_o; 

}

function getRequest(evt,request,element){
	var http_obj = createRequestObject(); 
	if (evt != null)
	{
		var keyCode = evt.keyCode;
	}
	displayElement = element;
	if (document.getElementById("LoadingPopup") != null)
	{
		if( typeof( window.pageYOffset ) == 'number' ) {
			document.getElementById("LoadingPopup").style.top = (window.pageYOffset + 2) + "px";
		} 

		document.getElementById("LoadingPopup").style.display="block";
		document.getElementById("LoadingPopup").style.visibility="visible";
	}
	http_obj.open('get', request);
	http_obj.onreadystatechange =	function handleRequest(){
										if(http_obj.readyState == 4){ 
											var response = http_obj.responseText;
											if (displayElement == null)
											{
												eval(response);
											}
											else if (displayElement == "")
											{
												eval(response);
											} 
											else {
												document.getElementById(displayElement).innerHTML = response;
											}
											if (document.getElementById("LoadingPopup") != null)
											{
												document.getElementById("LoadingPopup").style.display="none";
												document.getElementById("LoadingPopup").style.visibility="hidden";
											}
										}
									}
	http_obj.send(null);
}

function getRequestParent(evt,request,element){
	var http_obj = createRequestObject(); 
	if (evt != null)
	{
		var keyCode = evt.keyCode;
	}
	displayElement = element;
	http_obj.open('get', request);
	http_obj.onreadystatechange =	function handleRequest(){
										if(http_obj.readyState == 4){ 
											var response = http_obj.responseText;
											if (displayElement == null)
											{
												eval(response);
											}
											else if (displayElement == "")
											{
												eval(response);
											} 
											else {
												parent.document.getElementById(displayElement).innerHTML = response;
											}
										}
									}
	http_obj.send(null);
}


function checkKey(evt,tempInput) {
	var keyCode = evt.keyCode;
	if (keyCode == 40) {
		if (document.getElementById(displayElement).innerHTML != "") {
			eval('var aInput=document.forms["formApps1"].'+tempInput+';')
			aInput.focus();
		}
	}
}

function doPost(obj,action,element) {
	var getstr = "";
	for (i=0; i<obj.length; i++) {
		if (obj.elements[i].tagName == "INPUT") {
			if (obj.elements[i].type == "text") {
				getstr += obj.elements[i].name + "=" + obj.elements[i].value + "&";
			}
			if (obj.elements[i].type == "password") {
				getstr += obj.elements[i].name + "=" + obj.elements[i].value + "&";
			}
			if (obj.elements[i].type == "hidden") {
				getstr += obj.elements[i].name + "=" + obj.elements[i].value + "&";
			}
			if (obj.elements[i].type == "checkbox") {
				if (obj.elements[i].checked) {
					getstr += obj.elements[i].name + "=" + obj.elements[i].value + "&";
				} else {
					getstr += obj.elements[i].name + "=&";
				}
			}
			if (obj.elements[i].type == "radio") {
				if (obj.elements[i].checked) {
					getstr += obj.elements[i].name + "=" + obj.elements[i].value + "&";
				}
			}
		}   
		if (obj.elements[i].tagName == "SELECT") {
			var sel = obj.elements[i];
			getstr += sel.name + "=" + sel.options[sel.selectedIndex].value + "&";
		}	
		if (obj.elements[i].tagName == "TEXTAREA") {
			getstr += obj.elements[i].name + "=" + obj.elements[i].value + "&";
		}	
	}
	getRequest(null,action + "&" + getstr,element);
}

var http = createRequestObject(); 