<?php
// filepath: Config.php
class Config {
    private static $settings = [
        'app.base_url' => 'http://localhost'
    ];

    public static function get($key) {
        return isset(self::$settings[$key]) ? self::$settings[$key] : null;
    }
}