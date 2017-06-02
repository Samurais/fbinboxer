function appendHtml(el, str) {
  var div = document.createElement('div');
  div.innerHTML = str;
  while (div.children.length > 0) {
    el.appendChild(div.children[0]);
  }
}
var html = '<div id="loadhere"></div>';
appendHtml(document.body, html);


		var website_code = document.querySelector("script#domain_fb_statnow").getAttribute("data-name");
		
		var xmlhttp=new XMLHttpRequest();
		
		xmlhttp.open("get", 'base_url_replace/js_controller/fb_chat_content_custom?website_code='+website_code);
		xmlhttp.onreadystatechange = function() {
		    if (xmlhttp.readyState == XMLHttpRequest.DONE) {
		        if(xmlhttp.status == 200){
		           var node = document.getElementById('loadhere');
					 node.innerHTML=xmlhttp.responseText;
		        }else{
		            console.log('Error: ' + xmlhttp.statusText )
		        }
		    }
		}
		
		xmlhttp.send();




//////

window.onload = function (){
	  var up_down_icon = document.getElementById("up_down_icon");
	  var button = document.getElementById("fb_chat_button_id");
	  button.addEventListener("click",function(e){
	    // var button = document.getElementById("fontawesome-icon-clo");
	    var current_class = document.querySelector("#live-chat").getAttribute("current-class");
	    var css_set = document.querySelector("#live-chat");
	    if(current_class=="imhide") 
	    {
	      document.querySelector("#live-chat").setAttribute("current-class","imshow");
	      css_set.style.display = "block";
	      up_down_icon.className = "fa fa-angle-down";   
	    }
	    else
	    {
	      document.querySelector("#live-chat").setAttribute("current-class","imhide");
	      css_set.style.display = "none";
	      up_down_icon.className = "fa fa-angle-up";
	    }
	  },false);
	}
