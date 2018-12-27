app.directive("ngSelect2", ['$timeout', 'jquery', function($timeout, $) {
    return {
        restrict : 'AC',
        require : 'ngModel',
        scope : {
            ngModel: '='
        },
        link : function(scope, element, attrs, ngModel) {
            var $e = $(element);
            var innercall;
            
            $e.select2();
            
            $e.on('change', function(e){
                if (!innercall) {
                    ngModel.$setViewValue($e.val());
                }
            });
            
            scope.$watch('ngModel', function(n,o) {
                $timeout(function(){
                    innercall = true;
                    $e.val(n).trigger('change');
                    innercall = false;
                });
            });
        }
    };
} ]);