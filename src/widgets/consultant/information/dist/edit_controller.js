app.controller('consultantInformationEditController', [ '$scope', 'jquery', 'consultantInformationService',
function($scope, $, service) {
    var $dialog = $('#consultantInformationEditDialog');
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
            if (!window.confirm("Некоторые данные были изменены, вы действительно хотите закрыть форму и отменить изменения?")) {
                e.preventDefault();
            }
        }
    });
    
    service.scope.$on('edit-item', function(event, consultant) {
        $scope.consultant = consultant;
        $dialog.modal('show');
    });
    
    $scope.submit = function() {
        service.scope.$emit('update-item', $scope.consultant, close);
    };
} ]);