// Simple Persona JS module
var Persona = (function () {
	var self = {};

	self.init = function(loginUrl, logoutUrl, currentUser) {
		self.currentUser = (currentUser === "") ? null : currentUser;
		self.loginUrl = loginUrl;
		self.logoutUrl = logoutUrl;

		// Initialize watcher
		navigator.id.watch({
			loggedInUser: self.currentUser,
			onlogin: self.verifyAssertion,
			onlogout: self.signoutUser
		});
	};

	self.verifyAssertion = function (assertion) {
		// Your backend must return JSON object with 'status':'success' to indicate successful
		// verification of user's email address and it must arrange for the binding
		// of currentUser to said address when the page is reloaded or redirected.
		var xhr = new XMLHttpRequest();
		xhr.open("POST", self.loginUrl, true);
		var param = "assert="+assertion;
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.setRequestHeader("Content-length", param.length);
		xhr.setRequestHeader("Connection", "close");
		xhr.send(param); // for verification by your backend

		xhr.onreadystatechange = simpleXhrSentinel(xhr);
	};

	self.signoutUser = function() {
		// Your backend must return JSON object with 'status':'success' to indicate successful
		// sign out (usually the resetting of one or more session variables) and
		// it must arrange for the binding of currentUser to 'null' when the page
		// is reloaded or redirected.
		var xhr = new XMLHttpRequest();
		xhr.open("GET", self.logoutUrl, true);
		xhr.send(null);
		xhr.onreadystatechange = simpleXhrSentinel(xhr);
	};

	function simpleXhrSentinel (xhr) {
		return function() {
			if (xhr.readyState == 4) {
				response = eval("(" + xhr.response + ")");
				if (response.status == "success") {
					// Assert success
					if (typeof response.redirect !== "undefined") {
						// If there's redirect set, redirect
						window.location = response.redirect;
					} else {
						// reload page to reflect new login state
						window.location.reload();
					}
				} else if (response.status == "failure") {
					// Assert failed
					navigator.id.logout();
				} else {
					// Error, invalid response
					alert("XMLHttpRequest error: " + xhr.status);
				}
			}
		};
	}

	return self;
}());
