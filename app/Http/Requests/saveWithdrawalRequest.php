<?php

namespace App\Http\Requests;

use App\Models\BankAccount;
use App\Repositories\BankAccountRepository;
use Illuminate\Foundation\Http\FormRequest;

class saveWithdrawalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'withdraw_account_id' => 'required|numeric|exists:bank_accounts,id',
            'withdraw_amount' => 'required|numeric|gt:0'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $accountId = $validator->getData()['withdraw_account_id'] ?? '';
            $withdrawAmount = $validator->getData()['withdraw_amount'] ?? '';

            $bankAccountRepository = new BankAccountRepository();

            $account = $bankAccountRepository->getBankAccountById($accountId);

            if ($withdrawAmount > $account->balance) {
                $validator->errors()->add('withdraw_amount', 'Not enough funds to withdraw');
            }
                        
            return $validator;

        });
    }
}
