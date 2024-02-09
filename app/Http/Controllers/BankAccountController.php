<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Helpers;
use App\Repositories\BankAccountRepository;

class BankAccountController extends Controller
{
    private $bankAccountRepository;

    public function __construct()
    {
        $this->bankAccountRepository = new BankAccountRepository();
    }

    public function show(int $id): View
    {
        $account = $this->bankAccountRepository->getBankAccountById($id);
        $months = Helpers::getMonthsList();

        return view('bank_accounts.show', compact('account', 'months'));
    }

}
