<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    const SAVINGS_ACCOUNT = "Savings Account";
    const CHECKING_ACCOUNT = "Checking Account";
}
