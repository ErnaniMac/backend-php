<?php

namespace Source\Core;

use Source\Controllers\Trigger;

class BankATM
{
    /** @var Account */
    private $accountLoggedIn;
    /** @var array */
    private static $accounts;

    /**
     * @param string $accountLoggedIn
     */
    public function __construct(string $accountLoggedIn)
    {
        if ($this->checkAccount($accountLoggedIn)) {
            $this->accountLoggedIn = $this->findAccount($accountLoggedIn);
            Trigger::show("Conta {$accountLoggedIn} logada com sucesso!", "accept");
        } else {
            Trigger::show("A conta {$accountLoggedIn} não existe! Tente novamente com uma conta válida.", "error");
        }
    }

    public function __set($key, $value)
    {
    }

    public function __get($name)
    {
    }

    /**
     * @param Account $account
     * @return void
     */
    public static function addAccountToList(Account &$account): void
    {
        static::$accounts[] = $account;
    }

    /**
     * @return array|null
     */
    public static function getAccountsList(): ?array
    {
        return static::$accounts;
    }

    /**
     * @param string $account
     * @return Account|null
     */
    public function findAccount(string $account): ?Account
    {
        foreach (static::$accounts as $accountObj) {
            if ($accountObj->account == $account) {
                return $accountObj;
            }
        }
        return null;
    }

    /**
     * @param mixed $account
     * @return bool
     */
    public static function checkAccount($account): bool
    {
        foreach (static::$accounts as $accountObj) {
            if ($accountObj->account == $account) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return void
     */
    public function extract(): void
    {
        if (isset($this->accountLoggedIn)) {
            $this->accountLoggedIn->extract();
        }
    }

    /**
     * @param float $value
     * @return void
     */
    public function deposit(float $value): void
    {
        if (isset($this->accountLoggedIn)) {
            $this->accountLoggedIn->deposit($value);
            Trigger::show("Depósito de {$this->accountLoggedIn->toBiteris($value)} efetuado com sucesso!", "accept");
        } else {
            Trigger::show("Conta inválida!", "error");
        }
    }

    /**
     * @param float $value
     * @return void
     */
    public function withdrawal(float $value): void
    {
        if (isset($this->accountLoggedIn)) {
            $message = $this->accountLoggedIn->withdrawal($value);
            Trigger::show($message, "error");
        } else {
            Trigger::show("Conta inválida!", "error");
        }
    }

    /**
     * @param string $destinationAcc
     * @param float $value
     * @return void
     */
    public function transfer(string $destinationAcc, float $value): void
    {
        if ($this->checkAccount($destinationAcc) && isset($this->accountLoggedIn) && $destinationAcc != $this->accountLoggedIn->account) {
            $message = $this->accountLoggedIn->withdrawal($value, false, 0);
            if (!$message) {
                $destinationAccObj = $this->findAccount($destinationAcc);
                $destinationAccObj->deposit($value);
                Trigger::show("Transferência de {$this->accountLoggedIn->toBiteris($value)} realizada com sucesso!", "warning");
            } else {
                Trigger::show($message, "error");
            }
        } else {
            Trigger::show(isset($this->accountLoggedIn) ? "Erro na transferência! Conta de destino inválida!" : "Conta inválida!", "error");
        }
    }
}
