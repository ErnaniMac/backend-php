<?php

namespace Source\Controllers;

class Trigger
{
    private const TRIGGER = "trigger";

    public const ACCEPT = "accept";
    public const WARNING = "warning";
    public const ERROR = "error";

    /** @var string */
    private static $message;
    /** @var mixed|string */
    private static $errorType;
    /** @var string */
    private static $error;


    /**
     * @param string $message
     * @param string|null $errorType
     * @return void
     */
    public static function show(string $message, ?string $errorType = null): void
    {
        self::setError($message, $errorType);
        echo self::$error;
    }

    /**
     * @param string $message
     * @param string|null $errorType
     * @return string
     */
    public static function push(string $message, ?string $errorType = null): string
    {
        self::setError($message, $errorType);
        return self::$error;
    }


    /**
     * @param string $message
     * @param string|null $errorType
     * @return void
     */
    private static function setError(string $message, ?string $errorType): void
    {
        $reflection = new \ReflectionClass(__CLASS__);
        $ArrayErrorTypes = $reflection->getConstants();

        self::$message = $message;
        self::$errorType = (in_array($errorType, $ArrayErrorTypes) ? " {$errorType}" : "");
        self::$error = "<p class='" . self::TRIGGER . self::$errorType . "'>" . self::$message . "</p>";
    }
}