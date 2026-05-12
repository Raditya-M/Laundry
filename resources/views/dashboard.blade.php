<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

<h1 class="text-3xl font-bold mb-6">
    Dashboard Laundry POS
</h1>

<div class="grid grid-cols-3 gap-6">

    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-gray-500">Total Income</h2>

        <p
            id="income"
            class="text-2xl font-bold mt-2"
        >
            Loading...
        </p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-gray-500">Monthly Income</h2>

        <p
            id="monthly"
            class="text-2xl font-bold mt-2"
        >
            Loading...
        </p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-gray-500">Transactions</h2>

        <p
            id="transaction"
            class="text-2xl font-bold mt-2"
        >
            Loading...
        </p>
    </div>

</div>

<script>

async function loadDashboard()
{
    const token = localStorage.getItem('token');

    const response = await fetch(
        'http://172.16.0.101:8000/api/statistics',
        {
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            }
        }
    );

    const data = await response.json();

    document.getElementById('income')
        .innerText =
            'Rp ' + data.today_income;

    document.getElementById('monthly')
        .innerText =
            'Rp ' + data.monthly_income;

    document.getElementById('transaction')
        .innerText =
            data.total_transaction;
}

loadDashboard();

</script>

</body>
</html>