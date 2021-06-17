#!/bin/sh

export DB_HOST=nas-toby
export DB_PORT=3307
export DB_USERNAME=toby
export DB_DATABASE=elastic_cut_test
export DB_PASSWORD=jT0*FR7Zqf
php artisan test $@

