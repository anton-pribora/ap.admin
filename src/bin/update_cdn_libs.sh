#!/bin/bash

cd "$(dirname "$0")"
cd ../web_docroot/cdn

ls -1 */download.txt | xargs -I% bash %
