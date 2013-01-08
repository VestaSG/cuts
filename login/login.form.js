// Auto-focus
addHandler(
	window,
	"load",
	function() {
		var inputs = document.getElementsByTagName("input");
		if (inputs.length > 0) if (inputs[0].type.toLowerCase() == "text") inputs[0].focus();
		var forms = document.getElementsByTagName("form");
		if (forms.length > 0) addHandler(
			forms[0],
			"submit",
			function(e) {checkLogin(e, forms[0]);}
		);
	}
);

// Check login-form
function checkLogin(evt, form) {
	evt = evt || window.event;
	if (form.log.value.length < 1 || form.pass.value.length < 1) {
		if (evt.preventDefault) evt.preventDefault();
		evt.returnValue = false;
		alert("Не заполнены поля 'Логин' или 'Пароль'");
	}
}

// Resize lodin
function globalResize(ie) {
	if (!ie) return;
	var minW = 800, maxW = false;
	var div;
	if (div = document.body) {
		// Min-width
		if (minW) {
			if (screenSize().w <= minW) div.style.width = minW + "px";
			else div.style.width = "auto";
		}
		// Max-width
		if (maxW) {
			if (screenSize().w >= maxW) div.style.width = maxW + "px";
			else div.style.width = "auto";
		}
	}
}

addHandler(
	window,
	"load",
	function() {
		globalResize(/*@cc_on 1@*/);
	}
);
addHandler(
	window,
	"resize",	
	function() {
		globalResize(/*@cc_on 1@*/);
	}
);
