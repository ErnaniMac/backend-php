<?php

namespace Source\Models;

use Source\Core\Account;
use Source\Core\User;

class AccountSaving extends Account
{
    /** @var float */
    private $totalWithdrawal;

    /**
     * @param string $branch
     * @param string $account
     * @param User $client
     * @param string $balance
     */
    public function __construct(string $branch, string $account, User $client, string $balance)
    {
        parent::__construct($branch, $account, $client, $balance);
        $this->totalWithdrawal = 0;
    }

    /**
     * @param float $value
     * @return void
     */
    public function deposit(float $value): void
    {
        $value = abs($value);
        $this->balance += $value;
    }

    /**
     * @param float $value
     * @param int $withdrawalLimit
     * @param float $operatingFee
     * @return string
     */
    public function withdrawal(float $value, $withdrawalLimit = 1000, float $operatingFee = 0.80): string
    {
        $value = abs($value);
        if ($value <= $this->balance) {
            if (($this->totalWithdrawal + $value) <= $withdrawalLimit || !$withdrawalLimit) {
                $this->balance -= ($value + $operatingFee);
                $this->totalWithdrawal += $value;
                return $withdrawalLimit 
                ? "Saque de {$this->toBiteris($value)} realizado com sucesso!"
                : "0";
            } else {
                $releasedAmount = $withdrawalLimit - $this->totalWithdrawal;
                return "Não foi possível concluir a operação! <br>O valor liberado para saque é de {$this->toBiteris($releasedAmount)}";
            }
        } else {
            return "Saldo insuficiente, você tem {$this->toBiteris($this->balance)}";
        }
    }
}
