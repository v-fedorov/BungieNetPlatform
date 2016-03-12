# Bungie.net Wiki API Test
This is a web proxy designed to be used by developers to test the Bungie.net Platform APIs. It has been configured to only work from the Bungie.net Platform Wiki on GitHub.

## Making Requests

```javascript
$.get({
	url: "/Platform/Destiny/Manifest/",
	headers: {
		"x-api-key": "{your-api-key}"
	}
}, function(result) {
	console.log('GetManifest', result);
});
```

## Authenticated Requests
Authenticated requests require obtaining the "bungleatk" cookie from Bungie.net and using it to regenerate new session cookies.
Cookies are not tracked and only provide temporary access to your Bungie Account while using this proxy service. It cannot be used to log into your platform account (Playstation/Xbox) and will fail if the cookie is too old.

```javascript
$.get({
	url: "/Reauth/Psnid/",
	headers: {
		"x-bungleatk": "{a-valid-bungleatk-cookie}"
	}
}, function(result) {
	// You can now make authenticated requests.
});
```

## Response Codes
Because CORS restricts how JavaScript can make cross-origin requests, all responses will return HTTP 200 and their actual response codes will get output to the "x-status" header.

## Fair Warning
Please do not use this for anything other than testing purposes.

lowlines