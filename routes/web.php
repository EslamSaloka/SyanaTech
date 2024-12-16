<?php

if (request()->is('*dashboard*')  && !request()->is('*api*')) {
    include "admin/admin.php";
}

if (!request()->is('*dashboard*') && !request()->is('*api*')) {
    include "front/web.php";
}