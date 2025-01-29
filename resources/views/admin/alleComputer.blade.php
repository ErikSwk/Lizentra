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
                            <i class="lni lni-layout"></i>
                            <span>Computer</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('viewLizenzen', ['id' => $id]) }}" class="sidebar-link">
                            <i class="lni lni-layout"></i>
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

                        <!--Erste Tabelle-->

                         <div class="table1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card mt-4 shadow">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4>Computerverwaltung</h4>
                                            <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <i class="bi bi-database-add"></i> Hinzufügen
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive" style="overflow-x:auto">
                                                <table id="myTable" class="display">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-black text-center">PCID</th>
                                                            <th class="text-black text-center">Büronummer</th>
                                                            <th class="text-black text-center">SekretariatID</th>
                                                            <th class="text-black text-center">Aktion</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Hinzufügen</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="computer-form" method="post">

                                                <div class="row">
                                                    <div class="col-lg">
                                                        <label>PC-ID</label>
                                                        <input type="text" name="PCID" id="PCID" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg">
                                                        <label>Büronummer</label>
                                                        <input type="text" name="Büronummer" id="Büronummer" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg">
                                                        <label>SekretariatID</label>
                                                        <input type="text" name="sekretariat_id" id="sekretariat_id" class="form-control">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                                            <button type="submit" class="btn btn-primary" form="computer-form">Speichern</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Computer bearbeiten</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="edit-form" method="post">
                                                <input type="hidden" id="edit-id" name="id">
                                                <div class="row">
                                                    <div class="col-lg">
                                                        <label>PC-ID</label>
                                                        <input type="text" id="edit-PCID" name="PCID" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg">
                                                        <label>Büronummer</label>
                                                        <input type="text" id="edit-Büronummer" name="Büronummer" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg">
                                                        <label>SekretariatID</label>
                                                        <input type="text" id="edit-sekretariat_id" name="sekretariat_id" class="form-control">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                                            <button type="submit" class="btn btn-primary" form="edit-form">Bearbeiten</button>
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
            // DataTables initialisieren
            var table = $('#myTable').DataTable({
                "ajax": {
                    "url": "{{ route('getAlleComputer') }}",
                    "type": "GET",
                    "dataType": "json",
                    "headers": {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    "dataSrc": function (response) {
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
                    { "data": "sekretariat_id"},
                    {
                        "data": null,
                        "render": function (data, type, row) {
                            return `
                                <a class="btn btn-sm btn-success edit-btn" data-id="${data.id}" data-pcid="${data.PCID}" data-büronummer="${data.Büronummer}" data-sekretariat_id="${data.sekretariat_id}">Bearbeiten</a>
                                <a class="btn btn-sm btn-danger delete-btn" data-id="${data.id}" data-PCID="${data.PCID}" data-sekretariat_id="${data.sekretariat_id}">Löschen</a>
                                <a href="/licenses/view/${data.sekretariat_id}/${data.id}" class="btn btn-sm btn-info">Lizenzen</a>
                            `;
                        }
                    }
                ]

            });

            //Für Edit

            $(document).on('click', '.edit-btn', function () {
                var PCID = $(this).data('pcid'); // Holen des PCID Werts
                var idPrim = $(this).data('id');
                var Büronummer = $(this).data('büronummer'); // Holen der Büronummer
                var sekretariat_id = $(this).data('sekretariat_id');

                $('#edit-id').val(idPrim);
                $('#edit-PCID').val(PCID);
                $('#edit-Büronummer').val(Büronummer);
                $('#edit-sekretariat_id').val(sekretariat_id);
                $('#editModal').modal('show');
            });


            // Event-Listener für das Hinzufügen-Formular
            $('#computer-form').submit(function (e) {
                e.preventDefault();
                const computerdata = new FormData(this);

                $.ajax({
                    url: '{{ route('storeBeiAlleComputer') }}',
                    method: 'POST',
                    data: computerdata,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status == 200) {
                            //alert("Erfolgreich gespeichert!");
                            $('#computer-form')[0].reset();
                            $('#exampleModal').modal('hide');
                            table.ajax.reload(null, false); // Tabelle neu laden
                        } else {
                            alert('Nicht erfolgreich gespeichert!');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr);
                        alert('Fehler: ' + error);
                    }
                });
            });

            // Event-Listener für das Edit-Formular
            $('#edit-form').submit(function (e) {
                e.preventDefault();
                const computerdata = new FormData(this);

                $.ajax({
                    url: '{{ route('update') }}',
                    method: 'POST',
                    data: computerdata,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status === 200) {
                            //alert('Computer erfolgreich bearbeitet!');
                            $('#edit-form')[0].reset();
                            $('#editModal').modal('hide');
                            table.ajax.reload(null, false); // Tabelle neu laden
                        } else {
                            alert('Computer nicht bearbeitet!');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr);
                        alert('Fehler: ' + error);
                    }
                });
            });


            //Delete

            $(document).on('click', '.delete-btn', function () {
                const Pid = $(this).data('id'); // Holen der PCID (Primärschlüssel) aus dem Button

                if (confirm('Sind Sie sicher, dass Sie diesen Computer löschen wollen?')) {
                    $.ajax({
                        url: `/employee/delete/${Pid}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.status === 200) {
                                //alert(response.message);
                                table.ajax.reload(null, false); // Tabelle neu laden
                            } else {
                                alert('Nicht gelöscht!');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr);
                            alert('Fehler: ' + error);
                        }
                    });
                }
            });

/*             $(document).on('click', '.show-btn', function (e) {
            e.preventDefault();

            const PCID = $(this).data('pcid'); // Holen der PCID aus dem Button

            // AJAX-Anfrage, um Lizenzen zu laden
            $.ajax({
                url: `/licenses/pc/${PCID}`, // API-Route, um Lizenzen abzurufen
                type: 'GET',
                success: function (response) {
                    if (response.status === 200) {
                        // Tabelle mit den gefilterten Lizenzen aktualisieren
                        $('#licenseTable').DataTable().clear().rows.add(response.licenses).draw();
                        alert(`Lizenzen für PC ${PCID} angezeigt.`);
                    } else {
                        alert('Keine Lizenzen für diesen PC gefunden.');
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr);
                    alert('Fehler beim Abrufen der Lizenzen.');
                }
            });
        }); */

     });

    </script>

<script src="{{ asset('js/script.js') }}"></script>

</body>

</html>

