(function(angular) {
	'use strict';
	var myApp = angular.module('app', []);

	myApp.controller('main', [ '$scope', function($scope) {
		var uniqId = 100;
	}])
	.filter('namespace', function() {
		return function(input) {
			input = input || '';
			return input.replace(/\\?[^\\]+$/, '');
		};
	})
	.filter('class', function() {
		return function(input) {
			input = input || '';
			return input.replace(/^.*\\/, '');
		};
	})
	.filter('path', function() {
		return function(input) {
			input = input || '';
			return input.replace(/\\/g, '/');
		};
	});
})(window.angular);