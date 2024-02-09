<?php

use App\Models\BankAccount;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->enum('type', [BankAccount::SAVINGS_ACCOUNT, BankAccount::CHECKING_ACCOUNT])->default(BankAccount::SAVINGS_ACCOUNT);
            $table->double('balance');
            $table->dateTime('opened_at');
            $table->boolean('withdrawal_in_progress')->default(false);
            $table->string('city_of_opening');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_accounts');
    }
}
