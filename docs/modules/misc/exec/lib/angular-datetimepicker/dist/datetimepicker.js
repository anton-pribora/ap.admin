app.directive("ngDatetimepicker", [ 
    '$timeout', 'jquery',
    function($timeout, $) {
    return {
        restrict : 'AC',
        require : 'ngModel',
        scope : {
            ngModel: '='
        },
        link : function($scope, $element, $attrs, ngModel) {
            $($element).datetimepicker({
                allowInputToggle: true
            });
            
            var $picker = $($element).data('DateTimePicker');
            
            var isDateEqual = function (d1, d2) {
                return moment.isMoment(d1) && moment.isMoment(d2) && d1.valueOf() === d2.valueOf();
            };
            
            $($element).on('dp.change', function (e) {
                if (!isDateEqual(e.date, ngModel.$viewValue)) {
                    var newValue = e.date === false ? null : e.date;
                    ngModel.$setViewValue(newValue.toString());
                }
            });
            
            ngModel.$render = function () {
                // if value is undefined/null do not do anything, unless some date was set before
                var currentDate = $picker.date();
                if (!ngModel.$viewValue && currentDate) {
                    // $picker.clear();
                } else if (ngModel.$viewValue) {
                    // otherwise make sure it is moment object
                    if (typeof ngModel.$viewValue == "string") {
                        ngModel.$setViewValue(new Date(ngModel.$viewValue));
                    }
                    $picker.date(ngModel.$viewValue);
                }
            };
        }
    };
} ]);
