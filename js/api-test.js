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

					//console.log(scope.syntaxHighlight);

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
		$scope.apiKey = '';
		$scope.pathData = {};
		$scope.queryData = {};
		$scope.postData = {};

		$scope.isReauth = false;
		$scope.isRequesting = false;

		$scope.proxies = [
			{id: "bnetwikiProxy", name: "bnetwiki-proxy.herokuapp.com (Requires API Key)", url: "https://bnetwiki-proxy.herokuapp.com", apiKeyRequired: true},
			//{id: "bungieProxy", name: "bungie-proxy.herokuapp.com", url: "https://bungie-proxy.herokuapp.com", apiKeyRequired: false}
		];
		$scope.proxy = $scope.proxies[0];

		$scope.endpoints = [];
		$scope.services = [];
		for (var serviceName in apiData) {
			$scope.services.push(serviceName);
		}
		$scope.services.sort();

		for (var serviceName in apiData) {
			var service = apiData[serviceName];
			for (var i=0; i<service.length; i++) {
				var endpoint = service[i];
				if (endpoint.name == 'GetDestinyManifest' && serviceName == 'DestinyService') {
					$scope.service = serviceName;
					$scope.endpoint = endpoint;
					break;
				}
			}
		}

		$scope.$watch('service', function(service) {
			//console.log('Changed Service', service);
			if (service == undefined) return;

			$scope.endpoints = [];
			for (var i=0; i<apiData[service].length; i++) {
				apiData[service][i].service = service;
				$scope.endpoints.push(apiData[service][i]);
			}
			if ($scope.endpoints.indexOf($scope.endpoint) == -1) {
				$scope.endpoint = $scope.endpoints[0];
			}
		});

		$scope.$watch('endpoint', function(endpoint) {
			//console.log('Changed Endpoint', endpoint);
			if (endpoint == undefined) return;

			$scope.pathData = {};
			$scope.queryData = {};
			$scope.postData = {};

			/*if ($scope.service != endpoint.service) {
				defaultEndpoint = endpoint;
				$scope.service = endpoint.service;
			}*/
		});

		$scope.reauthPlatform = 'Psnid';

		$scope.reauthValid = {};
		for (var i=0; i<$scope.proxies.length; i++) {
			var proxy = $scope.proxies[i];
			var apiAuth = localStorage.getItem(proxy.id);
			apiAuth = apiAuth ? parseInt(apiAuth) : 0;
			$scope.reauthValid[proxy.id] = new Date().getTime() < apiAuth;
		}

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
				//console.log(response, response.headers());
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

			//console.log(params);

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

			console.log('Request', options);

			$scope.test = {
				request: options,
				response: null
			};

			$scope.isRequesting = true;
			$http(options).then(function(response) {
				//console.log(response, response.headers());
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