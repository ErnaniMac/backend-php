<?php

require __DIR__ . '/theme/basicView.php';

namePage("Biteris Bank from Planet Cyber");

require __DIR__ . "/vendor/autoload.php";

use Source\Core\User;
use Source\Models\AccountSaving;
use Source\Models\AccountCurrent;
use Source\Core\BankATM;



################################################
## Criando usuários e suas respectivas contas ##
################################################

$client0 = new User("Robson", "Leite");
$client1 = new User("Ernani", "Maciel");
$client2 = new User("Bianca", "Clavé");


$saving0 = new AccountSaving(
    "001",
    "2333-7",
    $client0,
    "0"
);

$saving1 = new AccountCurrent(
    "002",
    "1222-8",
    $client1,
    "0"
);

$saving2 = new AccountCurrent(
    "002",
    "1555-9",
    $client2,
    "0"
);




nameSession("Acessando o caixa eletrônico", __LINE__);

$account0 = new BankATM("1233-8");

$account1 = new BankATM("1222-8");




nameSession("Iniciando operações", __LINE__);

$account1->deposit(800);
$account1->withdrawal(200);

// Tentando transferir paraminha propria conta
$account1->transfer("1222-8", 700);

// Transferir para outra conta
$account1->transfer("1555-9", 700);
$account1->transfer("1555-9", 550);

$account1->extract();



var_dump([
    "allAccounts" => BankATM::getAccountsList(),
    "accountLoggedIn" => $saving2
]);


