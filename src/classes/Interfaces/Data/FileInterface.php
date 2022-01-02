<?php

namespace Interfaces\Data;

interface FileInterface extends ItemInterface
{
    function guid();
    function downloadUrl();
    function date();
    function dropAttachment();
}