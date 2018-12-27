app.directive('ngFileUploadFunc', [function() {
  return {
    scope: {
        func: '&ngFileUploadFunc',
        arg: '=ngFileUploadArg'
    },
    link: function(scope, element, attr) {
        var counter = 0;
        
        function stopPropagation(event) {
            event.stopPropagation();
            event.preventDefault();
        }
        
        element.on('dragover', stopPropagation);
        
        element.on('dragenter', function(event) {
            event.preventDefault();
            counter++;
            element.addClass('file-upload-in');
        });
        
        element.on('dragleave', function(event) {
            counter--;
            if (counter === 0) { 
                element.removeClass('file-upload-in');
            }
        })
        
        element.on('drop', function(event) {
            stopPropagation(event);
            
            $(this).removeClass('file-upload-in');
            counter = 0;
            
            if (event.dataTransfer.files.length > 0) {
                scope.func()(event.dataTransfer.files, scope.arg);
            }
        });
    }
  };
}]);