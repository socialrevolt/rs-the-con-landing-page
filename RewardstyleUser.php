<?php

class RewardstyleUser {

    // ****************************************************
    // helper methods to determine if the user has access
    // ****************************************************

    public static function get_logged_in() {
        $c = self::get_cookie_values();
        if (!$c) {
            return false;
        }
        if (!self::get_status_by_id($c['id'])
                || self::get_user_hash($c['id']) != $c['hash']
                || time() > $c['expires']) {
            $_COOKIE['l'] = null;
            return false;
        } else {
            return $c['id'];
        }
    }

    public static function get_cookie_values($value=null) {
        $l = $_COOKIE['l'];
        if (substr_count($l, '|') != 5) {
            return null;
        }
        list($c['id'], $c['type'], $c['expires'], $c['timeout'], $c['hash'], $c['status']) = explode('|', $l);
        return $value ? $c[$value] : $c;
    }

    public static function get_status_by_id($user_id=false) {
        if (!$user_id) return false;
        $status = RewardstyleDB::execute("SELECT status FROM Users WHERE id = ? LIMIT 1", array($user_id));
        return $status['status'];
    }

    public static function get_user_hash($user_id=false) {
        if (!$user_id) return false;
        $pw_salt = "3'sg5th3MamM";
        $password = RewardstyleDB::execute("SELECT password FROM Users WHERE id = ? LIMIT 1", array($user_id));
        $hash = sha1($password['password'] . $pw_salt);
        return $hash;
    }
}
