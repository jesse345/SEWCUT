<?php

function flash($name, $result = '', $message = '') {
    if (!empty($message)) {
        $_SESSION[$name]['result'] = $result;
        $_SESSION[$name]['message'] = $message;
        return;
    }

    if (isset($_SESSION[$name]['message'])) {
        $result = $_SESSION[$name]['result'];
        $message = $_SESSION[$name]['message'];
        unset($_SESSION[$name]['message']);
        unset($_SESSION[$name]['result']);
        return array('result' => $result, 'message' => $message);
    }

    return array('result' => '', 'message' => '');
}
