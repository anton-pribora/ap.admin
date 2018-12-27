app.filter('money_ru', ['$filter', 
function($filter){
    return function(value) {
        return $filter('number')(value, 2).replace(/,/g, ' ').replace(/\.00$/, '').replace(/\./, ',');
    };
}]);