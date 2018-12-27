app.filter('linky', ['$sce', function($sce) {
  var linkyMinErr = angular.$$minErr('linky');
  var isDefined = angular.isDefined;
  var isFunction = angular.isFunction;
  var isObject = angular.isObject;
  var isString = angular.isString;
  
  var re = [];
  
  re.push('(?:(?:ftp|https?):\\/\\/|(?:www\\.))\\S+[^\\s.;,(){}<>"\\u201d\\u2019]');  // urls
  re.push('[A-Za-z0-9._%+-]+@\\S+[^\\s.;,(){}<>"\\u201d\\u2019]');                    // mails
  
  var phones = [
      '\\+?\\d\\D?\\D?\\d\\d\\d\\D?\\D?\\d\\d\\d\\D?\\d\\d\\D?\\d\\d',  // +1 (123) 123 45 67
      '\\+?\\d\\D?\\D?\\d\\d\\d\\D?\\D?\\d\\d\\D?\\d\\d\\d\\D?\\d\\d',  // +1 (123) 12 345 67
      '\\+?\\d\\D?\\D?\\d\\d\\d\\D?\\D?\\d\\d\\D?\\d\\d\\D?\\d\\d\\d'   // +1 (123) 12 34 567 
  ];
  
  re.push('(?:' + phones.join(')|(?:') + ')');
  
  var ex = new RegExp('(' + re.join(')|(') + ')', 'i');

  return function(text, target, attributes) {
    if (text == null || text === '') {
        return text;
    }
    
    if (!isString(text)) {
        throw linkyMinErr('notstring', 'Expected string but received: {0}', text);
    }

    if (false) { // Unused function
        var attributesFn = isFunction(attributes) ? attributes : isObject(attributes) ? function getAttributesObject() {return attributes;} : function getEmptyAttributesObject() {return {};};
    }

    var match;
    var raw  = text;
    var html = [];
    
    while((match = raw.match(ex))) {
        addText(raw.substr(0, match.index));
        raw = raw.substring(match.index + match[0].length);

        if (match[1] !== undefined) {
            addLink(match[1].match(/^http/) ? match[1] : 'http://' + match[1], match[1], target ? target : '_blank');
        } else if (match[2] !== undefined) {
            addLink('mailto:' + match[2], match[2]);
        } else if (match[3] !== undefined) {
            addLink('tel:' + match[3].replace(/[^\d+]/g, '').replace(/^\+?8/, '+7'), match[3]);
        } else {
            addText(match[0]);
        }
    }
    
    addText(raw);
    
    return $sce.trustAsHtml(html.join(''));
    
    function sanitizeText(string) {
      var entityMap = {
        "&": "&amp;",
        "<": "&lt;",
        ">": "&gt;",
        '"': '&quot;',
        "'": '&#39;',
        "/": '&#x2F;'
      };

      return String(string).replace(/[&<>"'\/]/g, function (s) {
        return entityMap[s];
      });
    }
    
    function truncate(str, n, useWordBoundary) {
        var singular, tooLong = str.length > n;
        useWordBoundary = useWordBoundary || true;
    
        // Edge case where someone enters a ridiculously long string.
        str = tooLong ? str.substr(0, n-1) : str;
    
        singular = (str.search(/\s/) === -1) ? true : false;
        if(!singular) {
          str = useWordBoundary && tooLong ? str.substr(0, str.lastIndexOf(' ')) : str;
        }
    
        return  tooLong ? sanitizeText(str) + '&hellip;' : sanitizeText(str);
    }

    function addText(text) {
      if (!text) {
        return;
      }
      html.push(sanitizeText(text));
    }

    function addLink(url, text, target) {
      html.push('<a ');
      html.push('title="', sanitizeText(url), '" ');
      
      if (target) {
          html.push('target="'+ target +'" ');
      }
      
      html.push('href="', sanitizeText(url), '">');
      html.push(truncate(text, 40));
      html.push('</a>');
    }
  };
}]);
