<?php

namespace App\Core;

class Validator
{
    private array $errors = [];

    public function required(?string $value, string $field, string $message): static
    {
        if ($value === null || trim($value) === "") {
            $this->errors[$field] = $message;
        }

        return $this;
    }

    public function minLength(?string $value, string $field, int $length, string $message): static
    {
        if ($value !== null && isset($this->errors[$field])) {
            return $this;
        }

        if ($value !== null && mb_strlen($value) < $length) {
            $this->errors[$field] = $message;
        }

        return $this;
    }

    public function maxLength(?string $value, string $field, int $length, string $message): static
    {
        if ($value !== null && isset($this->errors[$field])) {
            return $this;
        }

        if ($value !== null && mb_strlen($value) > $length) {
            $this->errors[$field] = $message;
        }

        return $this;
    }

    public function numeric($value, string $field, string $message): static
    {
        if (isset($this->errors[$field])) {
            return $this;
        }

        if ($value === null || $value === "" || !is_numeric($value)) {
            $this->errors[$field] = $message;
        }

        return $this;
    }

    public function min($value, string $field, float $min, string $message): static
    {
        if (isset($this->errors[$field])) {
            return $this;
        }

        if ($value === null || $value === "" || (float) $value < $min) {
            $this->errors[$field] = $message;
        }

        return $this;
    }

    public function max($value, string $field, float $max, string $message): static
    {
        if (isset($this->errors[$field])) {
            return $this;
        }

        if ($value !== null && $value !== "" && (float) $value > $max) {
            $this->errors[$field] = $message;
        }

        return $this;
    }

    public function inArray($value, string $field, array $allowed, string $message): static
    {
        if (isset($this->errors[$field])) {
            return $this;
        }

        if (!in_array($value, $allowed, true)) {
            $this->errors[$field] = $message;
        }

        return $this;
    }

    public function fails(): bool
    {
        return count($this->errors) > 0;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function firstError(): string
    {
        return $this->errors ? array_values($this->errors)[0] : "";
    }
}
