app.factory('myHttpInterceptor', [ 'notify', '$q', '$httpParamSerializerJQLike', function($notify, $q, $serializer) {
    return {
        'request' : function(config) {
            config.headers['Content-Type'] = 'application/x-www-form-urlencoded';
            config.data = $serializer(config.data);
            return config;
        },
        
        'response' : function(config) {
            if (config.data.error != undefined) {
                $notify.error('Error ' + config.data.error.code + ': ' + config.data.error.description);
                return $q.reject(config);
            }
            
            return config;
        },
        
        'requestError' : function(rejection) {
            $notify.error('Request error: ' + angular.toJson(rejection));

            return $q.reject(rejection);
        },

        'responseError' : function(rejection) {
            $notify.error('Response error: ' + rejection.config.method + ' ' + rejection.config.url + ': ' + rejection.status + ' ' + rejection.statusText);

            return $q.reject(rejection);
        }
    };
} ]);

app.config([ '$httpProvider', function($httpProvider) {
    $httpProvider.interceptors.push('myHttpInterceptor');
} ]);