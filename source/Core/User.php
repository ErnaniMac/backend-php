<?php

namespace Source\Core;

class User
{
    /** @var string */
    private $firstName;
    /** @var string */
    private $lastName;

    /**
     * @param string $firstName
     * @param string $lastName
     */
    public function __construct(string $firstName, string $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    /**
     * @param mixed $key
     * @param mixed $value
     */
    public function __set($key, $value)
    {
    }

    /**
     * @param mixed $key
     * @return string|null
     */
    public function __get($key): ?string
    {
        return ($this->$key ?? null);
    }
}