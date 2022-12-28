<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\SessionException;

class Session implements Contracts\SessionInterface
{

    public function __construct(private readonly array $options)
    {
    }

    public function start(): void
    {
        if ($this->isActive()) {
            throw new \RuntimeException("Session has already started!");
        }

        if (headers_sent($filename, $line)) {
            throw new \RuntimeException("Headers already sent");
        }
        session_set_cookie_params([
            'secure' => $this->options['secure'] ?? true,
            'httponly' => $this->options['httponly'] ?? true,
            'samesite' => $this->options['samesite'] ?? 'lax'
        ]);

        session_name($this->options['name'] ?? 'app');

        if (!session_start()) {
            throw new SessionException('Unable to start the session');
        }
    }

    public function save(): void
    {
        session_write_close();
    }

    public function isActive(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->has($key) ? $_SESSION[$key] : $default;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $_SESSION);
    }

    public function regenerate(): bool
    {
        return session_regenerate_id();
    }

    public function put(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function forget(string $key): void
    {
        unset($_SESSION[$key]);
    }
    public function flash(string $key, array $messages): void
    {
        $_SESSION[$this->options['flashName']][$key] = $messages;
    }

    public function getFlash(string $key): array
    {
        $messages = $_SESSION[$this->options['flashName']][$key] ?? [];

        unset($_SESSION[$this->options['flashName']][$key]);

        return $messages;
    }

}