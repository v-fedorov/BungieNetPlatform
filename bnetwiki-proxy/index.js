var origins = [
	'http://destinydevs.github.io',
	'http://bnet.io'
];
var port = process.env.PORT || 5000;

var http = require('http');
var https = require('https');
var HttpProxyRules = require('http-proxy-rules');
var fs = require('fs');

var proxyRules = new HttpProxyRules({
	rules: {
		'/Reauth': 'https://www.bungie.net/en/User/SignIn',
		'/Platform': 'https://www.bungie.net/Platform'
	}
});

http.createServer(function (req, res) {
	var origin = origins.indexOf(req.headers.origin) != -1 ? req.headers.origin : req.headers.host;
	var target = proxyRules.match(req);
	console.log(req.method, target+req.url);

	if (req.method == 'OPTIONS') {
		var headers = {
			"Access-Control-Allow-Origin": origin,
			"Access-Control-Allow-Methods":  "POST, GET, OPTIONS",
			"Access-Control-Allow-Credentials": true,
			"Access-Control-Allow-Headers": "x-api-key, x-bungleatk, Content-Type",
			"Cache-Control": 'no-cache, no-store, must-revalidate'
		};
		res.writeHead(200, headers);
		res.end();
	}

	else if (target) {
		if (target == '/Platform' && !req.headers['x-api-key']) {
			res.writeHead(403, {});
			res.write('API Key required.');
			res.end();
			return;
		}
		var headers = {
			'Content-Length': req.headers['content-length'] ? req.headers['content-length'] : 0
		};
		if (req.headers['x-api-key']) headers['x-api-key'] = req.headers['x-api-key'];
		
		var cookies = [];
		if (req.headers['cookie']) cookies = req.headers['cookie'].split('; ');

		if (req.headers['x-bungleatk']) cookies.push('bungleatk='+req.headers['x-bungleatk']);
		if (cookies.length > 0) headers['cookie'] = cookies.join('; ');

		if (headers['cookie']) {
			var bungled = headers['cookie'].replace(/.*bungled=([^;]+);.*/i, '$1');
			if (bungled) headers['x-csrf'] = bungled;
			//console.log('bungled', bungled);
		}

		console.log('Request Headers', headers);

		var reqEx = https.request({
			hostname: 'www.bungie.net',
			method: req.method,
			port: 443,
			path: target+req.url,
			headers: headers
		}, function(resEx) {
			console.log(resEx.statusCode);
			console.log('Response Headers', resEx.headers);
			resEx.headers['access-control-allow-origin'] = origin;
			resEx.headers["Access-Control-Allow-Credentials"] = true;
			resEx.headers["Access-Control-Expose-Headers"] = 'x-status, location, Content-Type';
			resEx.headers['x-status'] = resEx.statusCode;
			resEx.headers['Cache-Control'] = 'no-cache, no-store, must-revalidate';
			if (resEx.headers['set-cookie']) {
				for (var i=0; i<resEx.headers['set-cookie'].length; i++) {
					resEx.headers['set-cookie'][i] = resEx.headers['set-cookie'][i]
						//.replace('; secure', '')
						.replace('; HttpOnly', '')
						;
				}
			}
			res.writeHead(200, resEx.headers);

			resEx.on('data', function(data) {
				res.write(data);
			});
			resEx.on('end', function() {
				res.end();
			});
		});
		if (req.method == 'POST') {
			req.on('data', function(data) {
				console.log('POST', data.toString('utf8'));
				reqEx.write(data);
			});
			req.on('end', function() {
				console.log('POST End');
				reqEx.end();
			});
		} else {
			reqEx.end();
		}
	}
	else {
		res.writeHead(200, {'Content-Type': 'text/plain'});
		var fileStream = fs.createReadStream('README.md');
		fileStream.pipe(res);
	}
}).listen(port, function() {
	console.log('Bungie.net Wiki proxy app is running on port', port);
});