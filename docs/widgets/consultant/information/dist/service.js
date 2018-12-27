app.factory('consultantInformationService', ['$rootScope', '$window', 'confirm', 'notify', '$http', '$timeout', 'infoService',
function($rootScope, $window, $confirm, $notify, $http, $timeout, $infoService) {
    var $do = function(action, data) {
        return $http.post("", {widget_data: data, widget_action: 'consultant.information::' + action}, {responseType: 'json'});
    };
    
    var $scope = $rootScope.$new(true);
    var _consultant = $window.consultantInformation || {};
    var _source;

    var _editItem = function(item) {
        _source = item;
        $scope.$emit('edit-item', angular.copy(item));
    };
    
    var _uploadFiles = function(files, item) {
        var data = {
            widget_data: {item: item},
            widget_action: 'consultant.information::uploadPhoto' 
        };
        
        var upload = function(files) {
            $window.fileUploader.uploadFiles('', files, data, function(event){
                if (event.errors.length > 0) {
                   $notify.warning('Некоторые файлы были загружены с ошибками!');
                } else {
                   $notify.success('Все файлы были загружены!');
                }
                
                $scope.$emit('reload-item', item);
            });
        };
        
        if (files == undefined || files == false || files == null) {
            $window.fileUploader.pickFiles(function(files){
                upload(files);
            }, {
                'accept': "image/x-png,image/gif,image/jpeg",
                'multiple': null
            });
        } else if (files.length > 1) {
            $notify.warning('В профиль можно загружать только 1 файл');
        } else {
            upload(files);
        }
    };
    
    $scope.$on('reload-item', function(event, item, onsuccess) {
        $do('item', {item: item}).then(function(response) {
            angular.copy(response.data.item, _consultant);
            
            if (typeof onsuccess == 'function') {
                onsuccess();
            }
        }, function() {
            
        });
    });

    $scope.$on('update-item', function(event, item, onsuccess) {
        $do('update', {item: item}).then(function(response) {
            angular.copy(response.data.item, _consultant);
            
            if (typeof onsuccess == 'function') {
                onsuccess();
            }
            
            $notify.success('Данные обновлены');
        }, function() {
            $timeout(function(){
                $notify.warning('Не удалось обновить данные');
            }, 1000);
        });
    });

    var _editLogin = function(item) {
        _source = item;
        $scope.$emit('edit-login', angular.copy(item));
    };

    $scope.$on('update-login', function(event, item, onsuccess) {
        $do('updateLogin', {item: item}).then(function(response) {
            angular.copy(response.data.item, _consultant);
            
            if (typeof onsuccess == 'function') {
                onsuccess();
            }
            
            $notify.success('Данные обновлены');
        }, function() {
            $timeout(function(){
                $notify.warning('Не удалось обновить данные');
            }, 1000);
        });
    });
    
    var _removeItem = function(item) {
        if (window.consultantId == item.id) {
            $infoService.display('selfremove-warning', {});
            return;
        }
        
        $confirm.confirm('Вы действительно хотите удалить этого пользователя?').then(function() {
            $do('remove', {item: item}).then(function(response) {
                $notify.success('Пользователь был удалён');
                $scope.$emit('item-remove', item);
            }, function() {
                $notify.warning('Не удалось удалить пользователя');
            });
        }, function() {
        });
    };
    
    return {
        data : _consultant,
        editItem : _editItem,
        editLogin: _editLogin,
        removeItem: _removeItem,
        removePhoto: _removePhoto,
        uploadFiles : _uploadFiles,
        scope : $scope,
        _do: $do
    };
    
    function _removePhoto() {
        $confirm.confirm('Вы действительно хотите удалить фотографию?').then(function() {
            $do('removePhoto', {item: _consultant}).then(function(response) {
                angular.copy(response.data.item, _consultant);
                $notify.success('Файл был удалён');
            }, function() {
                $notify.warning('Не удалось удалить файл');
            });
        }, function() {
            
        });
    }
} ]);