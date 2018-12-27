<?php

Layout()->appendOnce('head.css.cdn', 'magnific-popup');
Layout()->appendOnce('body.js.cdn', 'magnific-popup');
Layout()->appendOnce('body.js.code', <<<'JS'
$(document).ready(function() {
  $('.image-view').magnificPopup({
    closeOnContentClick: true,
    type:'image',
      mainClass: 'mfp-with-zoom', // this class is for CSS animation below
    
      zoom: {
        enabled: true, // By default it's false, so don't forget to enable it
    
        duration: 300, // duration of the effect, in milliseconds
        easing: 'ease-in-out', // CSS transition easing function
    
        // The "opener" function should return the element from which popup will be zoomed in
        // and to which popup will be scaled down
        // By defailt it looks for an image tag:
        opener: function(openerElement) {
          // openerElement is the element on which popup was initialized, in this case its <a> tag
          // you don't need to add "opener" option if this code matches your needs, it's defailt one.
          return openerElement.is('img') ? openerElement : openerElement.find('img');
        }
      }
  });
});
JS
);

Layout()->appendOnce('head.css.code', <<<'CSS'
.mfp-with-zoom .mfp-container,
.mfp-with-zoom.mfp-bg {
  opacity: 0;
  -webkit-backface-visibility: hidden;
  /* ideally, transition speed should match zoom duration */
  -webkit-transition: all 0.3s ease-out;
  -moz-transition: all 0.3s ease-out;
  -o-transition: all 0.3s ease-out;
  transition: all 0.3s ease-out;
}

.mfp-with-zoom.mfp-ready .mfp-container {
    opacity: 1;
}
.mfp-with-zoom.mfp-ready.mfp-bg {
    opacity: 0.8;
}

.mfp-with-zoom.mfp-removing .mfp-container,
.mfp-with-zoom.mfp-removing.mfp-bg {
  opacity: 0;
}
CSS
);