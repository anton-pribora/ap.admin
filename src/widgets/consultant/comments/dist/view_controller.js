app.controller('consultantCommentsViewController', ['$scope', 'consultantCommentsService', 'infoService',
function($scope, service, $info){
    $scope.list = service.items();
    
    $scope.pagination = {
        page: 0,
        limit: 5,
        total: {pages: 1, items: 0}
    };
    
    var recalcPages = function(newLength, oldLength) {
        $scope.pagination.total.pages = Math.ceil(($scope.list.length || 1) / $scope.pagination.limit);
        $scope.pagination.total.items = newLength;
        
        if ($scope.pagination.page >= $scope.pagination.total.pages) {
            $scope.pagination.page = $scope.pagination.total.pages - 1;
        }
        
        if ($scope.pagination.page < 0) {
            $scope.pagination.page = 0;
        }
    };
    
    $scope.$watch('list.length', recalcPages);
    
    $scope.add = function() {
        service.addItem();
    };
    
    $scope.edit = function(item) {
        service.editItem(item);
    };
    
    $scope.drop = function(item) {
        service.removeItem(item);
    };
    
    $scope.displayConsultantInfo = function(item) {
        $info.display('consultant', {consultantId: item.consultant.id});
    };
}]);