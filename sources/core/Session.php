<?php
class Session {
    public static function start(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
            if (!isset($_SESSION)) { // En cas de problème, on force une initialisation
                $_SESSION = [];
            }
        }
    }

    public static function set(string $key, mixed $value): void {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key): mixed {
        return $_SESSION[$key] ?? null;
    }

    public static function destroy(): void {
        session_destroy();
    }

    public static function hasError(string $field): bool {
        return isset($_SESSION['errors'][$field]);
    }

    public static function getError(string $field): ?string {
        return $_SESSION['errors'][$field] ?? null;
    }

    public static function setErrors(array $errors): void {
        $_SESSION['errors'] = $errors;
    }

    public static function clearErrors(): void {
        unset($_SESSION['errors']);
    }

    public static function setOldInput(array $input): void {
        $_SESSION['old_input'] = $input;
    }

    public static function getOldInput(string $key): ?string {
        return $_SESSION['old_input'][$key] ?? null;
    }

    public static function setFlash(string $type, string $message): void {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
    }

    public static function getFlash(): ?array {
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        return $flash;
    }
}
