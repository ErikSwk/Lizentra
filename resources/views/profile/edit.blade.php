<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lizenzenverwaltung</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <link href="https://cdn.lineicons.com/5.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!--google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">


    <!--google material icon-->
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">

    <!--Custom-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Tabelle.css') }}">
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="lni lni-dashboard-square-1"></i>
                </button>
                <div class="sidebar-logo"></div>
            </div>
            <ul class="sidebar-nav">

                <!-- Hier die Dashboard einträge für die User-->
                @if(Auth::user()->role === 'user')
                    <li class="sidebar-item">
                        <a href="{{ route('home') }}" class="sidebar-link">
                            <i class="lni lni-agenda"></i>
                            <span>Computer</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('viewLizenzen', ['id' => $sek_id]) }}" class="sidebar-link">
                            <i class="lni lni-agenda"></i>
                            <span>Lizenzen</span>
                        </a>
                    </li>
                @endif

                <!--Hier Dashboard für Admins-->
                @if(Auth::user()->role === 'admin')

                <li class="sidebar-item">
                    <a href="{{ route('viewAlleSekretariate') }}" class="sidebar-link">
                    <i class="lni lni-layout-9"></i>
                    <span>Sekretariate</span>
                    </a>
                </li>

                    <li class="sidebar-item">
                        <a href="{{ route('home') }}" class="sidebar-link">
                        <i class="lni lni-user-multiple-4"></i>
                        <span>User</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('viewAlleComputer') }}" class="sidebar-link">
                        <i class="lni lni-monitor-mac"></i>
                        <span>Alle Computer</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a href="{{ route('viewAlleLizenzen') }}" class="sidebar-link">
                        <i class="lni lni-certificate-badge-1"></i>
                        <span>Alle Lizenzen</span>
                        </a>
                    </li>
                @endif

                <!-- Einträge für alle Profil -->
                <li class="sidebar-item">
                    <a href="{{ route('profile.edit') }}" class="sidebar-link">
                        <i class="lni lni-user-4"></i>
                        <span>Profil</span>
                    </a>
                </li>
            </ul>
            </ul>
            <div class="sidebar-footer">
                <a href="{{ route('logout') }}" class="sidebar-link">
                    <i class="lni lni-exit"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <div class="main">

            <nav class="navbar navbar-expand px-4 py-3">

            </nav>

            <main class="content px-3 py-4">

                <div class="container-fluid">
                    <div class="mb-3">
                        <x-slot name="header">
                            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                {{ __('Profile') }}
                            </h2>
                        </x-slot>

                        <div class="py-12">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                                    <div class="max-w-xl">
                                        @include('profile.partials.update-profile-information-form')
                                    </div>
                                </div>

                                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                                    <div class="max-w-xl">
                                        @include('profile.partials.update-password-form')
                                    </div>
                                </div>

                                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                                    <div class="max-w-xl">
                                        @include('profile.partials.delete-user-form')
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


<script src="{{ asset('js/script.js') }}"></script>

</body>

</html>
