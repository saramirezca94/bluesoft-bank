<?php

namespace App\Http\Controllers;

use Exception;
use App\Helpers;
use Illuminate\View\View;
use Illuminate\Http\{Request, RedirectResponse};
use Illuminate\Support\Facades\{DB, Auth};
use App\Http\Requests\{saveDepositRequest, saveWithdrawalRequest};
use App\Repositories\{BankAccountRepository, TransactionRepository};

class TransactionController extends Controller
{
    private $transactionRepository;
    private $bankAccountRepository;

    public function __construct()
    {
        $this->transactionRepository = new TransactionRepository();
        $this->bankAccountRepository = new BankAccountRepository();
    }

    public function saveDeposit(saveDepositRequest $request): RedirectResponse
    {
        if($this->transactionRepository->persistDeposit($request->validated(), Auth::id()))
        {
            return redirect()->back()->withSuccess('Deposit saved');
        }

        return redirect()->back()->withErrors('Unable to save deposit');
    }

    public function saveWithdrawal(saveWithdrawalRequest $request): RedirectResponse
    {
        if($this->transactionRepository->persistWithdrawal($request->validated(), Auth::id()))
        {
            return redirect()->back()->withSuccess('Withdrawal success');
        }

        return redirect()->back()->withErrors('Unable to save the info');
    }

    public function getStatement(int $accountId, int $month): View
    {
        $statementMonth = Helpers::getMonthsList()[$month - 1];
        $transactions = $this->transactionRepository->getTransactionByMonthAndBankAccount($accountId, $month);
        $account = $this->bankAccountRepository->getBankAccountById($accountId);

        return view('bank_accounts.statement', compact('transactions', 'account', 'statementMonth'));
    }

    public function getLatestTransactions(int $accountId): View
    {
        $latestTransactions = $this->transactionRepository->getLatestTransactionsByBankId($accountId);

        return view('bank_accounts.latest_transactions', compact('latestTransactions', 'accountId'));
    }

}
