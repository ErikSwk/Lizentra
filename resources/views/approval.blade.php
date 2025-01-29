<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-white text-2xl font-bold">
                        <h4>Warten auf Freischaltung</h4>
                    </div>

                    <div class="card-body text-white">
                        <p>Bitte warte darauf, dass Ihr Account von einem Admin freigeschaltet wird. Bitte versuchen Sie es später erneut!</p>

                        <!-- Logout-Knopf -->
                        <div class="flex items-center justify-end mt-4">
                            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('logout') }}">
                                {{ __('Logout') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
