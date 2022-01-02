<?php

if (Identity()->valid()) {
    if (Identity()->logout()) {
        $redirect = ExpandUrl('@root');
        
        if (Identity()->isEmpty()) {
            Session()->destroy();
        }
        
        Redirect($redirect);
    }
}