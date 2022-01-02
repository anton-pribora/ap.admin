app.controller('consultantInformationViewController', ['$scope', 'consultantInformationService',
function($scope, service){
    $scope.consultant = service.data;
    
    $scope.edit = function() {
        service.editItem($scope.consultant);
    };
    
    $scope.editLogin = function() {
        service.editLogin($scope.consultant);
    };
    
    $scope.removePhoto = function() {
        service.removePhoto();
    };
    
    $scope.drop = function() {
        service.removeItem($scope.consultant);
    };
    
    $scope.upload = function(files, item) {
        service.uploadFiles(files, item);
    };
    
    service.scope.$on('item-remove', function(){
        location = '/consultant/profiles/';
    });
}]);