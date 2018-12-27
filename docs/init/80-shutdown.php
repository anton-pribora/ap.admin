<?php

register_shutdown_function(function (){
    Logger()->info();
});