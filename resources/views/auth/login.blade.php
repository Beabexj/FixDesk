<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>เข้าสู่ระบบ - FixDesk ระบบจัดการงานซ่อม</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Prompt', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }
    </style>
</head>
<body class="bg-slate-100/70 text-slate-800 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md space-y-6">
        <!-- Logo & Header -->
        <div class="text-center space-y-2">
            <div class="inline-flex w-14 h-14 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 items-center justify-center text-white shadow-lg shadow-blue-500/25">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">FixDesk</h1>
            <p class="text-xs text-slate-500">ระบบจัดการงานซ่อมคอมพิวเตอร์และอุปกรณ์ไอที</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xl shadow-slate-200/50 p-7 space-y-5">
            <div>
                <h2 class="text-base font-bold text-slate-800">เข้าสู่ระบบ</h2>
                <p class="text-xs text-slate-400 mt-0.5">กรอกอีเมลและรหัสผ่านเพื่อเข้าใช้งานระบบ</p>
            </div>

            <!-- Flash Alerts -->
            @if(session('success'))
                <div class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
                    @foreach($errors->all() as $error)
                        <div class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $error }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                        อีเมลผู้ใช้งาน
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email', 'admin@fixdesk.local') }}" required autofocus
                           class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-hidden focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all"
                           placeholder="your-email@example.com">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label for="password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            รหัสผ่าน
                        </label>
                    </div>
                    <div class="relative">
                        <input type="password" id="password" name="password" value="password" required
                               class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-hidden focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all pr-10"
                               placeholder="••••••••">
                        <button type="button" onclick="togglePasswordVisibility()" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600 text-xs">
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded-sm border-slate-300 text-blue-600 focus:ring-blue-500" checked>
                        <span class="text-xs text-slate-600">จดจำการเข้าสู่ระบบ</span>
                    </label>
                    <span class="text-xs text-slate-400">FixDesk v1.0</span>
                </div>

                <button type="submit"
                        class="w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white rounded-xl text-sm font-semibold transition-all shadow-md shadow-blue-500/20">
                    เข้าสู่ระบบ
                </button>
            </form>

            <!-- Quick Demo Accounts -->
            <div class="pt-4 border-t border-slate-100">
                <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider text-center mb-2.5">
                    คลิกเพื่อทดสอบบัญชีตัวอย่าง (Demo Accounts)
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <button type="button" onclick="fillAccount('admin@fixdesk.local', 'password')"
                            class="p-2 rounded-xl bg-purple-50 hover:bg-purple-100 text-purple-700 text-xs font-semibold text-center transition-colors border border-purple-100">
                        ผู้ดูแลระบบ<br><span class="text-[10px] font-normal opacity-80">(Admin)</span>
                    </button>
                    <button type="button" onclick="fillAccount('somchai.tech@fixdesk.local', 'password')"
                            class="p-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-semibold text-center transition-colors border border-blue-100">
                        ช่างสมชาย<br><span class="text-[10px] font-normal opacity-80">(ช่างซ่อม)</span>
                    </button>
                    <button type="button" onclick="fillAccount('wichai.tech@fixdesk.local', 'password')"
                            class="p-2 rounded-xl bg-teal-50 hover:bg-teal-100 text-teal-700 text-xs font-semibold text-center transition-colors border border-teal-100">
                        ช่างวิชัย<br><span class="text-[10px] font-normal opacity-80">(ช่างซ่อม)</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="text-center text-xs text-slate-400">
            &copy; 2026 FixDesk Workshop System. สงวนลิขสิทธิ์
        </div>
    </div>

    <script>
        function fillAccount(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        }
    </script>
</body>
</html>
