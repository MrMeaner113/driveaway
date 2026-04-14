<x-layouts::auth title="Account Pending Approval">
    <div class="flex flex-col items-center justify-center gap-4 text-center">
        <div class="flex flex-col items-center gap-2">
            <x-app-logo />
            <h1 class="text-2xl font-bold">Account Pending Approval</h1>
            <p class="text-zinc-500 dark:text-zinc-400 max-w-sm">
                Thank you for registering! Your account is currently pending approval.
                You will receive an email once your account has been activated.
            </p>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300 underline">
                Sign out
            </button>
        </form>
    </div>
</x-layouts::auth>