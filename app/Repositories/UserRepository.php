<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\BankAccount;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository
{
    public function getClientsWithTransactionCountByMonth(int $month, string $orderBy = 'asc', int $paginate = 10): LengthAwarePaginator
    {
        return User::withCount(['transactions' => function($query) use ($month){
            $query->whereMonth('date', $month);
        }])
        ->orderBy('transactions_count', $orderBy)
        ->paginate($paginate);

    }

    public function getClientsWithTransactionsOutsideOriginCity(string $transactionType, float $amount, int $paginate): LengthAwarePaginator
    {
        return User::whereHas('transactions', function($query) use($transactionType, $amount){
            $query->where('type', $transactionType)
                ->where('transaction_outside_origin_city', true)
                ->where('amount', '>', $amount);
        })->paginate($paginate);
    }
}