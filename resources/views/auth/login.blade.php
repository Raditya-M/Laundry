<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="bg-white p-8 rounded-xl shadow w-96">

    <h1 class="text-2xl font-bold mb-6 text-center">
        Laundry POS Login
    </h1>

    <form id="loginForm">

        <input
            type="email"
            id="email"
            placeholder="Email"
            class="w-full border p-3 rounded mb-4"
        >

        <input
            type="password"
            id="password"
            placeholder="Password"
            class="w-full border p-3 rounded mb-4"
        >

        <button
            class="w-full bg-blue-500 text-white p-3 rounded"
        >
            Login
        </button>

    </form>

</div>

<script>

document.getElementById('loginForm')
.addEventListener('submit', async function(e) {

    e.preventDefault();

    const response = await fetch(
        'http://172.16.0.101:8000/api/login',
        {
            method: 'POST',

            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },

            body: JSON.stringify({
                email: document.getElementById('email').value,
                password: document.getElementById('password').value
            })
        }
    );

    const data = await response.json();

    if(data.success) {

        localStorage.setItem('token', data.token);

        alert('Login berhasil');

        window.location.href = '/dashboard';

    } else {

        alert('Login gagal');
    }

});

</script>

</body>
</html>