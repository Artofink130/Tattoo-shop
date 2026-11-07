<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="robots" content="noindex"><title>Admin sign in</title><link rel="icon" type="image/png" href="/img/favicon.png"><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-neutral-950 text-neutral-200 min-h-screen flex items-center justify-center p-4"><form method="POST" action="{{ route('admin.login') }}" class="w-full max-w-sm space-y-4 p-6 rounded-lg bg-neutral-900 border border-neutral-800">@csrf
<img src="/img/logo.png" alt="Logo" class="h-20 w-20 mx-auto"><h1 class="text-xl font-bold text-white tracking-widest text-center">ADMIN SIGN IN</h1>@include('layouts.alerts')
<x-field name="email" label="Email" type="email" required /><x-field name="password" label="Password" type="password" required />
<label class="text-sm"><input type="checkbox" name="remember" value="1"> Remember me</label>
<button class="w-full px-4 py-2 bg-amber-500 text-black font-semibold rounded">Sign in</button></form></body></html>
