<?php

Layout()->appendOnce('head.css.code', <<<CSS
.widget-search {
    height: 22px;
    padding: 0px 10px;
    /* font-size: 12px; */
    /* line-height: 1.5; */
    border-radius: 3px;
}
.widgets .panel-heading { padding: 5px 10px !important; }
.widgets .panel-footer { padding: 5px 10px !important; }
.widget table {margin-bottom: 0px;}
.widget-body { min-height: 300px; }
.widget .panel-header {border-top-left-radius: 0px; border-top-right-radius: 0px;}
.widget.panel {border-top-left-radius: 0px; border-top-right-radius: 0px; border-top-width: 0px;}
.widget.panel label {font-weight: normal; margin: 0px 15px 0px 0px;}
CSS
);
