<?php


require('../config.php');

$url       = required_param('url', PARAM_LOCALURL);
$newdevice = required_param('device', PARAM_TEXT);

require_sesskey();

core_useragent::set_user_device_type($newdevice);

redirect($url);
