<?php

foreach (PopAlerts() as list($alert, $type)) {
    Layout()->append('body.alerts', $alert, $type);
}