<?php

require('../config.php');

$id = required_param('id', PARAM_INT);

redirect(new moodle_url('/enrol/index.php', array('id'=>$id)));
