<?php

function makeRandStr($length) {
    $str = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z'));
    $r_str = null;
    for ($i = 0; $i < $length; $i++) {
        $r_str .= $str[rand(0, count($str) - 1)];
    }
    return $r_str;
}

if ($_FILES && $_FILES['file']) {

    $uploaddir = 'upload/';
    $uploadfile = $uploaddir . makeRandStr(16) . '.' . pathinfo($_FILES['file']['name'])['extension'];

    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
        print('<img src="' . htmlspecialchars($uploadfile, ENT_COMPAT) . '"/>');
    } else {
        print('error.');
    }

}
