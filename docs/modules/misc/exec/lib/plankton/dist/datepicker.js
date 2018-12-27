app.directive("ngDatepicker", ['jquery', function($) {
    return {
        restrict : 'AC',
        require : 'ngModel',
        scope : {
            ngModel: '='
        },
        link : function(scope, element, attrs, ngModel) {
            var $picker = $(element).datepicker({
                language: "en",
                autoclose: true,
                keepEmptyValues: true
            });
            
            $picker.on('changeDate', function(e){
                ngModel.$setViewValue(e.format());
            });
            
            scope.$watch('ngModel', function(n,o) {
                $picker.datepicker('update', n);
            });
        }
    };
} ]);