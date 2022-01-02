app.controller('infoViewController', ['$scope', 'infoService', 'jquery',
function($scope, service, $){
    var $dialog = $('#infoViewDialog');
    
    $scope.loading = service.scope.loading;
    
    service.scope.$on('load.start', function(){
        $dialog.find('.modal-body .content').html('Загрузка...');
        $dialog.find('.modal-title').html('Загрузка...');
        $dialog.modal('show');
    });
    
    service.scope.$on('load.error', function(){
        $dialog.modal('hide');
    });
    
    service.scope.$on('load.success', function (event, response) {
        var data = response.data;
        
        if (data.large) {
            $dialog.find('.modal-dialog').addClass('modal-lg');
        } else {
            $dialog.find('.modal-dialog').removeClass('modal-lg');
        }
        
        $dialog.find('.modal-body .content').html(data.content);
        $dialog.find('.modal-title').html(data.title);
        $dialog.modal('show');
    });
}]);