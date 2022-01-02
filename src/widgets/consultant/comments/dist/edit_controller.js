app.controller('consultantCommentsEditController', [ '$scope', 'jquery', 'consultantCommentsService',
function($scope, $, service) {
    var $dialog = $('#consultantCommentsEditDialog');
    var confirmDismiss;
    var close = function() { confirmDismiss = false; $dialog.modal('hide'); };
    
    $dialog.on('shown.bs.modal', function() {
        confirmDismiss = true;
        $scope.form.$setPristine();
        $scope.form.$setUntouched();
    });
    
    $dialog.on('hide.bs.modal', function (e) {
        if (e.target.className.match(/date/)) {
            // Изменилась дата
        } else if (confirmDismiss && $scope.form.$dirty) {
            if (!window.confirm("Some data has been changed, do you really want to close the form and discard changes?")) {
                e.preventDefault();
            }
        }
    });
    
    $scope.newItem = true;
    $scope.item = {};

    service.scope.$on('edit-item', function(event, item, newItem) {
        $scope.newItem = item == undefined || newItem;
        $scope.item = item || {};
        $dialog.modal('show');
    });
    
    $scope.submit = function() {
        if ($scope.newItem) {
            service.scope.$emit('add-item', $scope.item, close);
        } else {
            service.scope.$emit('update-item', $scope.item, close);
        }
    };
} ]);