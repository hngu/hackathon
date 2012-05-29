var fctb_tool = null;
var username;
function ToolBarInit(t) {
    fctb_tool = t;
	start(fctb_tool);
}

function start(fctb_tool) {
	try {
		username = fctb_tool.parseUrlVars('%username');
		if('www.amazon.com' != document.location.host) {
			return;
		}
		if(username == '') {
			return;
		} else {
			var toolid = fctb_tool.toolid,
				userid = fctb_tool.parseUrlVars('%userid');
		}
		if(null === document.getElementById('btAsinTitle')) {
			return;
		} else {
			var prod_url = document.location.href, 
				prod_name = document.getElementById('btAsinTitle').textContent, 
				prod_price = document.getElementById('actualPriceValue').getElementsByClassName('priceLarge')[0].textContent, 
				prod_available = document.getElementsByClassName('availGreen')[0].textContent, 
				prod_image = document.getElementById('prodImageCell').getElementsByTagName('img')[0].src;
			fctb_tool.SetVariable("prod_url", prod_url, false);
			fctb_tool.SetVariable("prod_name", prod_name, false);
			fctb_tool.SetVariable("prod_price", prod_price, false);
			fctb_tool.SetVariable("prod_available", prod_available, false);
			fctb_tool.SetVariable("prod_image", prod_image, false);
			var add_button = document.createElement("input");
			add_button.setAttribute("type", "button");
			add_button.setAttribute("value", "Add to iWishlist");
			add_button.setAttribute("onclick", "addWishList();");
			var view_button = document.createElement("input");
			view_button.setAttribute("type", "button");
			view_button.setAttribute("value", "View iWishlist");
			view_button.setAttribute("onclick", "viewWishList(username);");
			var title = document.getElementById('btAsinTitle').parentNode;
			title.appendChild(add_button);
			title.appendChild(view_button);
		}
    }catch(e){document.parentWindow.console.log(e);}
}

function addWishList() {
	fctb_tool.ShowPopup("http://shopping.i-wishlist.dev:3000", 1, 1, "top-right", "", 10, 10, "");
}

function viewWishList(username) {
	//	fctb_tool.ShowPopup("http://shopping.i-wishlist.dev:3000/view?username=" + username, 200, 200, "top", "", 86400, 10, "");
	window.open("http://shopping.i-wishlist.dev:3000/view?username=" + username);
}