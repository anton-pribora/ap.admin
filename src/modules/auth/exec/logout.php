<?php

if (Identity()->valid()) {
    Identity()->logout();

    if (Identity()->isEmpty()) {
        Session()->destroy();
    }

    Redirect(ExpandUrl('@root'));
}
