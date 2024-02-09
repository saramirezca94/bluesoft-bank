<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <select id="month_select" name="statement_month"
                        class="p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @foreach ($months as $month)
                            <option value="{{ $loop->index + 1 }}">{{ $month }}</option>
                        @endforeach
                    </select>
                    <button id="transactions-button"
                        class="mt-2 inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button">Clients Transactions
                    </button>
                    <a href="{{ route('clients-withdrawals') }}"
                        class="mt-2 inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Clients withdrawals
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    const selectElement = document.getElementById("month_select");
    const transactionsButton = document.querySelector("#transactions-button");

    transactionsButton.addEventListener("click", (event) => {
        const month = selectElement.options[selectElement.selectedIndex].value;
        window.location.href = '/clients-transactions/' + month;
    });
</script>
