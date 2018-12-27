app.factory('infoService', ['$rootScope', '$http', '$timeout',
function($rootScope, $http, $timeout) {
    var $do = function(action, data) {
        return $http.post("", {widget_data: data, widget_action: 'info::' + action}, {responseType: 'json'});
    };
    
    var $scope = $rootScope.$new(true);
    $scope.loading = false;
    
    function _display(entity, data) {
        $scope.$emit('load.start');
        $do('display', {entity: entity, params: data}).then(function(response){
            $scope.$emit('load.success', response);
        }, function(response){
            $scope.$emit('load.error', response);
        });
    };

    return {
        scope: $scope,
        display: _display
    };
} ]);