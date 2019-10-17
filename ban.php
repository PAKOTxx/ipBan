<?php
function ban()
{
    global $db;
    $have_ban = false;
    $ip_checkedIP = ip2long($_SERVER['REMOTE_ADDR']);
    $db->query('SELECT * FROM ban WHERE ip=' . $ip_checkedIP);
    while ($db->next_record()) {
        $ban_end = $db->f('time') + $db->f('period') + 0;
        $ban_ip = $db->f('ip');
        if (($ip_checkedIP == $ban_ip) and time() < $ban_end) {
            $have_ban = true;
        } elseif (time() > $ban_end) {
            $db->query("DELETE FROM ban WHERE ip=$ban_ip");
            break;
        }
    }
    if ($have_ban)
        die("Banned");
}