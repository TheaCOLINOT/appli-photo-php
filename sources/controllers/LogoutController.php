<?php
class LogoutController {
    public static function index() {
        Session::start();
        Session::destroy();
        header("Location: /login");
        exit;
    }
}
