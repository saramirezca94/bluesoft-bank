<?php

namespace App\Repositories;

use App\Models\BankAccount;

class BankAccountRepository
{
    public function getBankAccountById(int $id): BankAccount
    {
        return BankAccount::whereId($id)->first();
    }
}