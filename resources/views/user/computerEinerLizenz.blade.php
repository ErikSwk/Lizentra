<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lizenzenverwaltung</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" /> -->
    <link rel="stylesheet" href="{{ asset('css/adminsekretariate/dataTables.dataTables.css') }}">
    <link href="https://cdn.lineicons.com/5.0/lineicons.css" rel="stylesheet" />
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="{{ asset('css/adminsekretariate/bootstrap.min.css') }}">

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
                        <i class="lni lni-monitor-mac"></i>
                        <span>Computer</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('viewLizenzen', ['id' => $sek_id]) }}" class="sidebar-link">
                        <i class="lni lni-certificate-badge-1"></i>
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

                        <div class="table1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card mt-4 shadow">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4>Computer dieser Lizenz</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive" style="overflow-x:auto">
                                                <table id="myTable" class="table table-striped table-bordered display">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">PCID</th>
                                                            <th class="text-center">Büronummer</th>
                                                            <th class="text-center">Aktion</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Data wird dynamisch durch DataTables geladen -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </main>
        </div>
    </div>

        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
        <script src="{{ asset('js/adminsekretariate/jquery.min.js') }}"></script>
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script> -->
        <script src="{{ asset('js/adminsekretariate/bootstrap.min.js') }}"></script>
        <!-- <script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script> -->
        <script src="{{ asset('js/adminsekretariate/dataTables.js') }}"></script>


    <script>
        $(document).ready(function () {
            var table = $('#myTable').DataTable({
                "ajax": {
                    "url": "{{ route('getComputerEinerLizenz', ['Lizenzschluessel' => $Lizenzschluessel]) }}",
                    "type": "GET",
                    "dataType": "json",
                    "headers": {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    "dataSrc": function (response) {
                        console.log(response);
                        if (response.status === 200) {
                            return response.computers;
                        } else {
                            return [];
                        }
                    }
                },
                "columns": [
                    { "data": "PCID" },
                    { "data": "Büronummer" },
                    {
                        "data": null,
                        "render": function (data, type, row) {
                            return `<a class="btn btn-sm btn-danger delete-btn" data-id="${data.id}">Entfernen</a>`;
                        }
                    }
                ]
            });

            //Entfernen
            $(document).on('click', '.delete-btn', function () {
                const Pid = $(this).data('id'); // Holen der PCID (Primärschlüssel) aus dem Button

                if (confirm('Sind Sie sicher, dass Sie diese Lizenz von diesem Computer entfernen wollen?')) {
                    $.ajax({
                        url: `/entfComputerLizenz/${Pid}/{{$Lizenzschluessel}}`,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.status === 200) {
                                //alert(response.message);
                                table.ajax.reload(null, false); // Tabelle neu laden
                            } else {
                                alert('Nicht entfernt');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr);
                            alert('Fehler: ' + error);
                        }
                    });
                }
            });
        });


    </script>

<script src="{{ asset('js/script.js') }}"></script>

</body>

</html>

