<!DOCTYPE html>
<html lang="en" class="bg-neutral-950 text-neutral-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Rango Tour</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-neutral-950 flex items-center justify-center min-h-screen px-4">

    <div class="max-w-md w-full bg-neutral-900 border border-neutral-800 rounded-3xl p-8 shadow-2xl relative">
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-1.5 mb-2">
                <span class="text-3xl font-black text-emerald-400">RANGO</span>
                <span class="text-xl font-black text-white tracking-widest">TOUR</span>
            </div>
            <p class="text-xs font-bold uppercase tracking-wider text-neutral-400">Admin Control Panel</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-3.5 bg-emerald-950/80 border border-emerald-700 text-emerald-300 rounded-xl text-xs font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-3.5 bg-rose-950/80 border border-rose-800 text-rose-300 rounded-xl text-xs font-semibold">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-bold text-neutral-300 mb-1.5 uppercase tracking-wider">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@rangotour.com" 
                       class="w-full bg-neutral-950 text-white border border-neutral-700 rounded-xl p-3.5 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-neutral-300 mb-1.5 uppercase tracking-wider">Password</label>
                <input type="password" name="password" required placeholder="••••••••" 
                       class="w-full bg-neutral-950 text-white border border-neutral-700 rounded-xl p-3.5 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 cursor-pointer select-none text-neutral-400 hover:text-white">
                    <input type="checkbox" name="remember" class="w-4 h-4 text-emerald-600 bg-neutral-950 border-neutral-700 rounded">
                    Remember Me
                </label>
                <a href="{{ route('home') }}" class="text-neutral-500 hover:text-emerald-400">Back to Website</a>
            </div>

            <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-400 text-neutral-950 font-black uppercase tracking-wider py-4 px-4 rounded-xl text-xs shadow-lg shadow-emerald-500/20 hover:scale-[1.02] transition duration-200">
                Sign In to Dashboard
            </button>
        </form>
    </div>

</body>
</html>