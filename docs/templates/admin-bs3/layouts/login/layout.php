<?php 

$public = Asset('@layout/public/');

Layout()->append('body.js.code', <<<JS
jQuery(document).ready(function() {
    $.backstretch("{$public}img/backgrounds/1.jpg");
    
    $('.login-form input[type="text"], .login-form input[type="password"], .login-form textarea').on('focus', function() {
    	$(this).removeClass('input-error');
    });
    
    $('.login-form').on('submit', function(e) {
    	$(this).find('input[type="text"], input[type="password"], textarea').each(function(){
    		if( $(this).val() == "" ) {
    			e.preventDefault();
    			$(this).addClass('input-error');
    		}
    		else {
    			$(this).removeClass('input-error');
    		}
    	});
    });
});
JS
);

Layout()->prepend('head.css.links', 'https://fonts.googleapis.com/css?family=Roboto:400,100,300,500"');

Layout()->append('head.css.links', $public .'form-elements.css');
Layout()->append('head.css.links', $public .'style.css');

Layout()->append('body.js.links' , $public .'jquery.backstretch.min.js');

?>
<!DOCTYPE html>
<html>
<head>
<?php echo Layout()->renderIfNotEmpty('head.title')?>
<?php echo Layout()->renderIfNotEmpty('head.metas')?>
<?php echo Layout()->renderIfNotEmpty('head.html')?>
<?php echo Layout()->renderIfNotEmpty('head.css.cdn')?>
<?php echo Layout()->renderIfNotEmpty('head.css.links')?>
<?php echo Layout()->renderIfNotEmpty('head.js.cdn')?>
<?php echo Layout()->renderIfNotEmpty('head.js.links')?>
<?php echo Layout()->renderIfNotEmpty('head.css.code')?>
<?php echo Layout()->renderIfNotEmpty('head.js.code')?>
</head>

<body>
<?php echo Layout()->renderIfNotEmpty('body.css.code')?>

        <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Please Sign In</h3>
                            		<p>Enter login and password:</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-key"></i>
                        		</div>
                            </div>
                            <div class="form-bottom">
                    			<?php echo Layout()->renderIfNotEmpty('body.alerts')?>
			                    <form role="form" action="" method="post" class="login-form">
			                    	<div class="form-group">
			                    		<label class="sr-only" for="form-username">Логин</label>
			                        	<input type="text" name="login" placeholder="Login..." 
			                        		class="form-username form-control" id="form-username" value="<?php echo Html(Layout()->getVar('login'))?>">
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">Пароль</label>
			                        	<input type="password" name="password" placeholder="Password..." class="form-password form-control" id="form-password">
			                        </div>
			                        <button type="submit" class="btn">Sign In</button>
			                    </form>
		                    </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

<?php echo Layout()->renderIfNotEmpty('body.js.cdn')?>    
<?php echo Layout()->renderIfNotEmpty('body.js.links')?>
<?php echo Layout()->renderIfNotEmpty('body.js.code')?>

    </body>

</html>