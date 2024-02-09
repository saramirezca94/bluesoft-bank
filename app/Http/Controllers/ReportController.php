<?php

namespace App\Http\Controllers;

use App\Helpers;
use Illuminate\View\View;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;

class ReportController extends Controller
{
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function index(): View
    {
        $months = Helpers::getMonthsList();
        return view('reports.index', compact('months'));
    }

    public function getClientTransactionsCount(int $month): View
    {
        $users = $this->userRepository->getClientsWithTransactionCountByMonth($month, 'desc', 10);
        return view('reports.transactions_count', compact('users'));
    }

    public function getWithdrawalsOutOfCity(): View
    {
        $users = $this->userRepository->getClientsWithTransactionsOutsideOriginCity(Transaction::WITHDRAWAL, 100, 10);
        return view('reports.client_withdrawals', compact('users'));
    } 
}
