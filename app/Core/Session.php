<?php

namespace App\Core;

class Session {
    private static $instance = null;
    private static $started = false;

    private function __construct() {
        $this->start();
    }

    private function start() {
        if (!self::$started && session_status() === PHP_SESSION_NONE) {
            // Проверяем, не было ли уже отправлено заголовков
            if (!headers_sent()) {
                session_start();
                self::$started = true;
            } else {
                trigger_error('Невозможно запустить сессию - заголовки уже были отправлены', E_USER_WARNING);
            }
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Инициализация сессии перед использованием
    public static function init() {
        self::getInstance();
    }

    public function set($key, $value) {
        $this->start();
        $_SESSION[$key] = $value;
    }

    public function get($key, $default = null) {
        $this->start();
        return $_SESSION[$key] ?? $default;
    }

    public function remove($key) {
        $this->start();
        unset($_SESSION[$key]);
    }

    public function getFlashdata($key) {
        $this->start();
        if (isset($_SESSION['_flash'][$key])) {
            $value = $_SESSION['_flash'][$key];
            unset($_SESSION['_flash'][$key]);
            return $value;
        }
        return null;
    }

    public function setFlashdata($key, $value) {
        $this->start();
        $_SESSION['_flash'][$key] = $value;
    }

    public function destroy() {
        $this->start();
        session_destroy();
        self::$started = false;
    }
}
