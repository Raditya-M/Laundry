<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — LaundryPOS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['DM Sans', 'sans-serif'],
                        display: ['Syne', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Syne:wght@600;700;800&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        .font-display { font-family: 'Syne', sans-serif; }
        .bg-mesh {
            background-color: #0d1f2d;
            background-image:
                radial-gradient(at 20% 30%, rgba(15,170,178,0.15) 0px, transparent 50%),
                radial-gradient(at 80% 70%, rgba(28,63,96,0.3) 0px, transparent 50%),
                radial-gradient(at 50% 50%, rgba(15,170,178,0.05) 0px, transparent 70%);
        }
        @keyframes fadeUp { from { opacity:0; transform: translateY(20px); } to { opacity:1; transform: translateY(0); } }
        .fade-up { animation: fadeUp 0.6s ease forwards; }
        .fade-up-delay { animation: fadeUp 0.6s ease 0.2s forwards; opacity: 0; }

        @keyframes float { 0%,100% { transform: translateY(0px); } 50% { transform: translateY(-10px); } }
        .float-anim { animation: float 5s ease-in-out infinite; }

        @keyframes spin-slow { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        .spin-slow { animation: spin-slow 12s linear infinite; }

        @keyframes bubble {
            0% { transform: translateY(0) scale(1); opacity: 0.7; }
            100% { transform: translateY(-40px) scale(1.3); opacity: 0; }
        }
        .bubble1 { animation: bubble 3s ease-in-out infinite; }
        .bubble2 { animation: bubble 3s ease-in-out 0.8s infinite; }
        .bubble3 { animation: bubble 3s ease-in-out 1.6s infinite; }

        input:focus { outline: none; }
        .input-field {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            color: white;
            transition: border-color 0.2s, background 0.2s;
        }
        .input-field:focus {
            border-color: rgba(15,170,178,0.7);
            background: rgba(255,255,255,0.09);
        }
        .input-field::placeholder { color: rgba(255,255,255,0.3); }
        .btn-primary {
            background: linear-gradient(135deg, #0FAAB2, #0d8f96);
            transition: all 0.2s;
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 8px 25px rgba(15,170,178,0.35); }
        .btn-primary:active { transform: translateY(0); }
    </style>
</head>
<body class="bg-mesh min-h-screen flex">

    <!-- Left Illustration Panel -->
    <div class="hidden lg:flex flex-1 relative overflow-hidden">

        <!-- Background Photo -->
        <img src="{{ asset('images/laundry.jpg') }}"
            alt="Laundry"
            class="absolute inset-0 w-full h-full object-cover">

        <!-- Dark overlay gradient -->
        <div class="absolute inset-0"
            style="background: linear-gradient(135deg, rgba(13,31,45,0.75) 0%, rgba(15,170,178,0.3) 100%);">
        </div>

        <!-- Noise texture overlay -->
        <div class="absolute inset-0 opacity-20"
            style="background-image: url('data:image/svg+xml,%3Csvg viewBox=%220 0 256 256%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22noise%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.9%22 numOctaves=%224%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23noise)%22/%3E%3C/svg%3E')">
        </div>

        <!-- Content -->
        <div class="relative z-10 flex flex-col justify-end p-12 w-full">

            <!-- Badge -->
            <div class="mb-4 inline-flex w-fit items-center gap-2 px-3 py-1.5 rounded-full border text-xs font-medium text-white/80"
                style="background:rgba(15,170,178,0.2); border-color:rgba(15,170,178,0.35)">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 inline-block"></span>
                Sistem Aktif
            </div>

            <h2 class="font-display text-4xl font-800 text-white mb-3 leading-tight">
                Fold & Wash<br>
                <span style="color:#0FAAB2">Admin Panel</span>
            </h2>
            <p class="text-white/60 text-sm max-w-xs leading-relaxed mb-8">
                Platform manajemen laundry modern. Kelola transaksi, pelanggan, dan laporan dalam satu tempat.
            </p>

            <!-- Feature pills -->
            <div class="flex flex-wrap gap-2">
                <span class="flex items-center gap-1.5 text-white/80 text-xs px-3 py-1.5 rounded-full border"
                    style="background:rgba(255,255,255,0.08); border-color:rgba(255,255,255,0.12)">
                    <i class="fa-solid fa-receipt text-[10px]" style="color:#0FAAB2"></i> Transaksi
                </span>
                <span class="flex items-center gap-1.5 text-white/80 text-xs px-3 py-1.5 rounded-full border"
                    style="background:rgba(255,255,255,0.08); border-color:rgba(255,255,255,0.12)">
                    <i class="fa-solid fa-users text-[10px]" style="color:#0FAAB2"></i> Pelanggan
                </span>
                <span class="flex items-center gap-1.5 text-white/80 text-xs px-3 py-1.5 rounded-full border"
                    style="background:rgba(255,255,255,0.08); border-color:rgba(255,255,255,0.12)">
                    <i class="fa-solid fa-chart-pie text-[10px]" style="color:#0FAAB2"></i> Laporan
                </span>
                <span class="flex items-center gap-1.5 text-white/80 text-xs px-3 py-1.5 rounded-full border"
                    style="background:rgba(255,255,255,0.08); border-color:rgba(255,255,255,0.12)">
                    <i class="fa-solid fa-shirt text-[10px]" style="color:#0FAAB2"></i> Layanan
                </span>
            </div>

        </div>
    </div>

    <!-- ───── Right Login Form ───── -->
    <div class="w-full lg:w-[420px] flex items-center justify-center p-8 bg-slate-900/50 border-l border-white/5">
        <div class="w-full max-w-sm fade-up-delay">

            <!-- Mobile logo -->
            <div class="lg:hidden flex justify-center mb-8">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center shadow-lg">
                    <i class="fa-solid fa-shirt text-white text-2xl"></i>
                </div>
            </div>

            <div class="mb-8">
                <h1 class="font-display text-2xl font-700 text-white mb-1">Selamat datang</h1>
                <p class="text-slate-400 text-sm">Masuk ke panel admin LaundryPOS</p>
            </div>

            <!-- Alert -->
            <div id="loginAlert" class="hidden mb-5 p-3.5 rounded-xl bg-red-500/15 border border-red-500/30 flex items-start gap-3">
                <i class="fa-solid fa-circle-exclamation text-red-400 mt-0.5 flex-shrink-0"></i>
                <p id="loginAlertMsg" class="text-red-300 text-sm"></p>
            </div>

            <form id="loginForm" class="space-y-4">
                <div>
                    <!-- DIUBAH: Label dari Email ke Nama / Username -->
                    <label class="block text-xs font-medium text-slate-400 mb-1.5">Nama / Username</label>
                    <div class="relative">
                        <!-- DIUBAH: Icon email (fa-envelope) diganti menjadi icon user (fa-user) -->
                        <i class="fa-solid fa-user absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                        <!-- DIUBAH: Type menjadi text, id menjadi loginName, dan placeholder disesuaikan -->
                        <input type="text" id="loginName" placeholder="Masukkan nama/username admin"
                            class="input-field w-full pl-10 pr-4 py-3 rounded-xl text-sm"
                            value="admin">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1.5">Password</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                        <input type="password" id="loginPassword" placeholder="••••••••"
                            class="input-field w-full pl-10 pr-10 py-3 rounded-xl text-sm"
                            value="password">
                        <button type="button" id="togglePassword" onclick="togglePass()" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300 text-sm">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" id="loginBtn"
                    class="btn-primary w-full py-3 rounded-xl text-white font-semibold text-sm flex items-center justify-center gap-2 mt-2">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    <span>Masuk ke Dashboard</span>
                </button>
            </form>

            <p class="text-center text-xs text-slate-600 mt-8">LaundryPOS &copy; {{ date('Y') }} — Admin Panel</p>
        </div>
    </div>

    <script>
        const API_BASE = 'http://172.16.0.65:8000/api';

        if (localStorage.getItem('laundry_token')) {
            window.location.href = '/dashboard';
        }

        function togglePass() {
            const input = document.getElementById('loginPassword');
            const icon = document.querySelector('#togglePassword i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fa-solid fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'fa-solid fa-eye';
            }
        }

        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = document.getElementById('loginBtn');
            const alert = document.getElementById('loginAlert');
            const alertMsg = document.getElementById('loginAlertMsg');

            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i><span>Memproses...</span>';
            alert.classList.add('hidden');

            try {
                const res = await fetch(`${API_BASE}/login`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify({
                        username: document.getElementById('loginName').value,
                        password: document.getElementById('loginPassword').value,
                    })
                });
                const data = await res.json();
                if (!res.ok) throw new Error(data.message || 'Login gagal');
                localStorage.setItem('laundry_token', data.token || data.data?.token);
                localStorage.setItem('laundry_user', JSON.stringify(data.user || data.data?.user || {}));
                window.location.href = '/dashboard';
            } catch (err) {
                alertMsg.textContent = err.message;
                alert.classList.remove('hidden');
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-right-to-bracket"></i><span>Masuk ke Dashboard</span>';
            }
        });
    </script>
</body>
</html>
