<?php

namespace Source\Core;

use Source\Controllers\Trigger;
use Source\Core\User;

abstract class Account
{
    /** @var string */
    protected $branch;
    /** @var string */
    public $account;
    /** @var User*/
    protected $client;
    /** @var string */
    protected $balance;

    /**
     * @param string $branch
     * @param string $account
     * @param User $client
     * @param float $balance
     */
    protected function __construct(string $branch, string $account, User $client, float $balance)
    {
        $this->branch = $branch;
        $this->account = $account;
        $this->client = $client;
        $this->balance = $balance;
        
        BankATM::addAccountToList($this);
    }

    public function __set($name, $value)
    { 
    }

    public function __get($name)
    { 
    }

    /**
     * @return void
     */
    public function extract(): void
    {
        $extract = ($this->balance >= 1 ? Trigger::ACCEPT : Trigger::ERROR);
        Trigger::show("EXTRATO: Saldo atual: {$this->toBiteris($this->balance)}", $extract);
    }

    /**
     * @param mixed $value
     * @return string
     */
    public function toBiteris($value): string
    {
        return "B$ " . number_format($value, "2", ",", ".");
    }

    abstract public function deposit(float $value): void;

    abstract public function withdrawal(float $value): string;
}