var app = angular.module("testApp", ['ngSanitize', 'textAngular']);
app.config(function ($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});