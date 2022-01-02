app.factory('consultantCommentsService', ['$rootScope', '$window', 'confirm', 'notify', '$http', '$timeout',
function($rootScope, $window, $confirm, $notify, $http, $timeout) {
    var $do = function(action, data) {
        return $http.post("", {widget_data: data, widget_action: 'consultant.comments::' + action}, {responseType: 'json'});
    };
    
    var $scope = $rootScope.$new(true);
    var _list  = $window.partnerConsultantComments || [];
    var _source;

    var _items = function() {
        return _list;
    }

    var _addItem = function() {
        $scope.$emit('edit-item', {date: 'today'}, true);
    };

    var _editItem = function(item) {
        _source = item;
        $scope.$emit('edit-item', angular.copy(item));
    };

    var _removeItem = function(item) {
        var index = _list.indexOf(item);

        if (index > -1) {
            $confirm.confirm('Are you sure you want to delete this comment?').then(function() {
                $do('remove', {item: item, index: index}).then(function(response) {
                    _list.splice(index, 1);
                    $notify.success('Comment was deleted');
                }, function() {
                    $notify.warning('Comment was not deleted');
                });
            }, function() {
            });
        }
    };

    $scope.$on('update-item', function(event, item, onsuccess) {
        var index = _list.indexOf(_source);
        
        $do('update', {item: item, index: index}).then(function(response) {
            angular.copy(response.data.item, _source);
            
            if (typeof onsuccess == 'function') {
                onsuccess();
            }
            
            $notify.success('Comment has been updated');
        }, function() {
            $timeout(function(){
                $notify.warning('Comment was not updated');
            }, 1000);
        });
    });

    $scope.$on('add-item', function(event, item, onsuccess) {
        $do('add', {item: item}).then(function(response) {
            _list.unshift(response.data.item);
            
            if (typeof onsuccess == 'function') {
                onsuccess();
            }
            
            $notify.success('Comment added');
        }, function() {
            $timeout(function(){
                $notify.warning('Comment was not added');
            }, 1000);
        });
    });

    return {
        items : _items,
        addItem : _addItem,
        editItem : _editItem,
        removeItem : _removeItem,
        scope : $scope
    };
} ]);