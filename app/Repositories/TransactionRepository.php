<?php

namespace App\Repositories;

use Exception;
use App\Helpers;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TransactionRepository
{
    private $bankAccountRepository;

    public function __construct()
    {
        $this->bankAccountRepository = new BankAccountRepository();
    }

    public function persistDeposit(array $data, int $userId): bool
    {
        try {
            DB::beginTransaction();
            $account = $this->bankAccountRepository->getBankAccountById($data['deposit_account_id']);
            $transactionCity = Helpers::getRandomCity();

            $transaction = New Transaction();
            $transaction->user_id = $userId;
            $transaction->bank_account_id = $data['deposit_account_id'];
            $transaction->date = now();
            $transaction->amount = $data['deposit_amount'];
            $transaction->city = $transactionCity;
            $transaction->type = Transaction::DEPOSIT;
            $transaction->transaction_outside_origin_city = ($transactionCity === $account->city_of_opening) ? false : true;
            $transaction->save();


            $account->increment('balance', $data['deposit_amount']);
            $account->push();
            
            DB::commit();

            return true;

        } catch (Exception $ex) {
            DB::rollback();
            return false;
        }
    }

    public function persistWithdrawal(array $data, int $userId)
    {
        try {
            DB::beginTransaction();

            $account = $this->bankAccountRepository->getBankAccountById($data['withdraw_account_id']);
            $account->withdrawal_in_progress = true;
            $account->push();

            //Para este test se usa una ciudad aleatoria para simular retiros en diferentes ciudades
            $transactionCity = Helpers::getRandomCity();

            $transaction = New Transaction();
            $transaction->user_id = $userId;
            $transaction->bank_account_id = $data['withdraw_account_id'];
            $transaction->date = now();
            $transaction->amount = $data['withdraw_amount'];
            $transaction->city = $transactionCity;
            $transaction->type = Transaction::WITHDRAWAL;
            $transaction->transaction_outside_origin_city = ($transactionCity === $account->city_of_opening) ? false : true;
            $transaction->save();

            $account->decrement('balance', $data['withdraw_amount']);
            $account->push();
            
            DB::commit();

            $account->withdrawal_in_progress = false;

            return true;

        } catch (Exception $ex) {
            DB::rollback();
            return false;
        }
    }

    public function getTransactionByMonthAndBankAccount(int $bankAccountId, int $month, int $paginate = 10, string $orderBy = 'asc'): LengthAwarePaginator
    {
        return Transaction::where('bank_account_id', $bankAccountId)->whereMonth('date', $month)->orderBy('created_at', $orderBy)->paginate($paginate);
    }

    public function getLatestTransactionsByBankId(int $bankId, int $limit = 5): Collection
    {
        return Transaction::where('bank_account_id', $bankId)->latest()->limit($limit)->get();
    }

}