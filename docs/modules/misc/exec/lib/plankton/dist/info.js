app.factory('info', ['jquery', '$q', '$filter', '$sce', function($, $q, $filter, $sce) {
    var $dialog = $('#infoDialog');
    var deferred;
    
    $dialog.on('click', '.close', function(){
        $dialog.modal('hide');
        deferred.resolve();
    });
    
    var _display = function(html, preformat) {
        deferred = $q.defer();
        
        if (preformat == undefined) {
            preformat = true;
        }
        
        if (html.length > 800) {
            $dialog.find('.modal-dialog').addClass('modal-lg');
        } else {
            $dialog.find('.modal-dialog').removeClass('modal-lg');
        }
        
        if (preformat) {
            html = $sce.getTrustedHtml($filter('linky')(html))
        }
        
        $dialog.find('.modal-body').html(html).css('white-space', preformat ? 'pre-wrap' : 'normal');
        $dialog.modal('show');
        
        return deferred.promise;
    };
    
    return {
        display: _display
    };
}]);