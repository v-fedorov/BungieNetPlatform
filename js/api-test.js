angular.module('api-test', [])
	.directive('apiTest', function() {
		return {
			templateUrl: '../templates/api-test.html'
		};
	})
	.directive('syntaxHighlight', function($compile, $timeout) {
		return {
			scope: {
				syntaxHighlight: '='
			},
			transclude: true,
			link: function(scope, elem, attrs) {
				scope.$watch('syntaxHighlight', function() {
					elem.empty();

					console.log(scope.syntaxHighlight);

					if (scope.syntaxHighlight) {
						var code = JSON.stringify(scope.syntaxHighlight, null, 4);
						elem.append('<code class="'+attrs.language+'">'+code+'</code>');
						$compile(elem.contents())(scope);
						var codeElem = elem[0].querySelector('code');
						hljs.highlightBlock(codeElem);
						$timeout(function() {
							$(codeElem).codeFolding();
						}, 100);
					}
				}, true);
			}
		};
	})
	.controller('ApiCtrl', function($scope, $http, $httpParamSerializer) {
		console.log('loaded');

		$scope.proxies = [
			{id: "bnetwikiProxy", name: "bnetwiki-proxy.herokuapp.com (Requires API Key)", url: "https://bnetwiki-proxy.herokuapp.com", apiKeyRequired: true},
			//{id: "bungieProxy", name: "bungie-proxy.herokuapp.com", url: "https://bungie-proxy.herokuapp.com", apiKeyRequired: false}
		];
		$scope.proxy = $scope.proxies[0];

		$scope.endpoints = [];
		for (var serviceName in apiData) {
			for (var i=0; i<apiData[serviceName].length; i++) {
				var endpoint = apiData[serviceName][i];
				endpoint.service = serviceName;
				$scope.endpoints.push(endpoint);
			}
		}
		//$scope.endpoint = $scope.endpoints[0];
		for (var i=0; i<$scope.endpoints.length; i++) {
			var endpoint = $scope.endpoints[i];
			if (endpoint.name == 'GetBungieAccount' && endpoint.service == 'UserService') {
				$scope.endpoint = endpoint;
				break;
			}
		}

		$scope.reauthPlatform = 'Psnid';

		$scope.reauthValid = {};
		for (var i=0; i<$scope.proxies.length; i++) {
			var proxy = $scope.proxies[i];
			var apiAuth = localStorage.getItem(proxy.id);
			apiAuth = apiAuth ? parseInt(apiAuth) : 0;
			$scope.reauthValid[proxy.id] = new Date().getTime() < apiAuth;
		}


		$scope.apiKey = '';
		$scope.pathData = {};
		$scope.queryData = {};
		$scope.postData = {};

		$scope.isReauth = false;
		$scope.isRequesting = false;

		$scope.reauth = function() {
			console.log('Reauth', $scope.proxy);
			var proxyUrl = $scope.proxy.url;
			//proxyUrl = 'http://localhost:5000';
			$scope.isReauth = true;
			$http({
				method: 'GET',
				url: proxyUrl+'/Reauth/'+$scope.reauthPlatform+'/',
				withCredentials: true,
				headers: {
					'x-bungleatk': $scope.bungleatk
				}
			}).then(function(response) {
				console.log(response, response.headers());
				$scope.isReauth = false;
				if (response.headers('x-status') == '200') {
					localStorage.setItem($scope.proxy.id, new Date().getTime()+(14*24*60*60*1000));
					$scope.reauthValid[$scope.proxy.id] = true;
				}
			});
		};

		$scope.request = function() {
			var proxyUrl = $scope.proxy.url;
			var headers = {};
			if ($scope.apiKey) headers['x-api-key'] = $scope.apiKey;

			var params = {
				path: $scope.pathData,
				query: $scope.queryData,
				post: $scope.postData
			};

			console.log(params);

			var url = proxyUrl+'/Platform'+$scope.endpoint.endpoint;
			for (var key in params.path) {
				url = url.replace('{'+key+'}', params.path[key]);
			}
			var query = $httpParamSerializer(params.query);
			if (query) url += '?'+query;

			var options = {
				method: $scope.endpoint.method,
				url: url,
				withCredentials: true,
				headers: headers
			};

			if (Object.keys($scope.postData).length > 0) options.data = $scope.postData;

			console.log(options);

			$scope.test = {
				request: options,
				response: null
			};

			$scope.isRequesting = true;
			$http(options).then(function(response) {
				console.log(response, response.headers());
				$scope.isRequesting = false;
				$scope.test.response = response.data;
			});
		};

		$scope.fieldOptions = function(link) {
			var options = [];
			link = link.split('#');
			switch(link[0]) {
				case 'Enums':
					if (apiEnums[link[1]]) {
						options = apiEnums[link[1]];
					}
					break;
			}
			//console.log(link, options);
			return options;
		};

		$scope.hasParams = function(params) {
			if (params == null) return 0;
			return Object.keys(params).length;
		}
	})
;