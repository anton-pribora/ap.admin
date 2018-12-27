<?php

if (isset($_COOKIE[session_name()])) {
    Session()->start();
    
    $lastActive = Session()->get('last_active', 0);
    
    if (time() - $lastActive > 30 * 60) {
        Session()->clear();
    }
    
    Session()->set('last_active', time());
}