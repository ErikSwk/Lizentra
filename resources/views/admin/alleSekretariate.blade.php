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
                            <i class="lni lni-dashboard-square-1"></i>
                            <span>Computer</span>
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

                        <!--Sekretariat Tabelle-->
                        <div class="table1">
                            <div class="row">
                                <div class="container mt-5">
                                    <div class="card shadow">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4>Sekretariatverwaltung</h4>
                                            <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addModal">
                                                <i class="bi bi-database-add"></i> Hinzufügen
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <table id="SekretariatTable" class="display table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>SekretariatID</th>
                                                        <th>Lehrstuhl</th>
                                                        <th>Email</th>
                                                        <th>Fakultät</th>
                                                        <th>Aktion</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <!-- Modal -->
                            <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addModalLabel">Sekretariat hinzufügen</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="Sekretariat-form" method="post">
                                                    <div class="row">
                                                        <div class="col-lg">
                                                            <label>SekretariatID</label>
                                                            <input type="text" name="SekretariatID" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg">
                                                            <label>Lehrstuhl</label>
                                                            <input type="text" name="Lehrstuhl" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg">
                                                            <label>Email</label>
                                                            <input type="text" name="Email" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg">
                                                            <label>Fakultät</label>
                                                            <input type="text" name="Fakultät" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                                                <button type="submit" class="btn btn-primary" form="Sekretariat-form">Speichern</button>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal fürs Bear -->
                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">Sekretariat bearbeiten</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="edit-Sekretariat-form" method="post">
                                        <input type="hidden" id="edit-ID" name="ID">
                                        <div class="row">
                                            <div class="col-lg">
                                                <label>SekretariatID</label>
                                                <input type="text" id="edit-SekretariatID" name="SekretariatID" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg">
                                                <label>Lehrstuhl</label>
                                                <input type="text" id="edit-Lehrstuhl" name="Lehrstuhl" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg">
                                                <label>Email</label>
                                                <input type="text" id="edit-Email" name="Email" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg">
                                                <label>Fakultät</label>
                                                <input type="text" id="edit-Fakultät" name="Fakultät" class="form-control" required>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                                    <button type="submit" class="btn btn-primary" form="edit-Sekretariat-form">Bearbeiten</button>
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
            var table = $('#SekretariatTable').DataTable({
                "ajax": {
                    "url": "{{ route('getAllSekretariate') }}",
                    "type": "GET",
                    "dataType": "json",
                    "headers": {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    "dataSrc": function (response) {
                        if (response.status === 200) {
                            return response.sekretariate;
                        } else {
                            return [];
                        }
                    }
                },
                "columns": [
                    { "data": "SekretariatID" },
                    { "data": "Lehrstuhl" },
                    { "data": "Email" },
                    { "data": "Fakultät" },
                    {
                        "data": null,
                        "render": function (data, type, row) {
                            return `
                                <a href="/lizenzen/${data.SekretariatID}" class="btn btn-sm btn-info">Lizenzen</a>
                                <a href="/Computer/${data.SekretariatID}" class="btn btn-sm btn-info">Computer</a>
                                <a class="btn btn-sm btn-success edit-btn" data-SekretariatID="${data.SekretariatID}" data-Lehrstuhl="${data.Lehrstuhl}" data-Email="${data.Email}" data-Fakultät="${data.Fakultät}">Bearbeiten</a>
                                <a class="btn btn-sm btn-danger delete-btn" data-SekretariatID="${data.SekretariatID}">Löschen</a>
                            `;
                        }
                    }
                ]
            });

            // Edit-Button
            $(document).on('click', '.edit-btn', function () {
            var SekretariatID = $(this).data('sekretariatid');
            var Lehrstuhl = $(this).data('lehrstuhl');
            var Email = $(this).data('email');
            var Fakultät = $(this).data('fakultät');

            // Werte in die Modal-Felder eintragen
            $('#edit-SekretariatID').val(SekretariatID);
            $('#edit-Lehrstuhl').val(Lehrstuhl);
            $('#edit-Email').val(Email);
            $('#edit-Fakultät').val(Fakultät);

            // Modal anzeigen
            $('#editModal').modal('show');
        });


            // Hinzufügen-Formular
            $('#Sekretariat-form').submit(function (e) {
                e.preventDefault();
                const formData = new FormData(this);

                $.ajax({
                    url: '{{ route('storeSekretariat') }}',
                    method: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status === 200) {
                            alert("Sekretariat erfolgreich hinzugefügt.");
                            $('#Sekretariat-form')[0].reset();
                            $('#addModal').modal('hide');
                            table.ajax.reload(null, false);
                        } else {
                            alert('Nicht erfolgreich hinzugefügt!');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr);
                        alert('Fehler: ' + error);
                    }
                });
            });

            // Bearbeiten-Formular
            $('#edit-Sekretariat-form').submit(function (e) {
                e.preventDefault();
                const formData = new FormData(this);

                $.ajax({
                    url: '{{ route('updateSekretariat') }}',
                    method: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status === 200) {
                            alert("Sekretariat erfolgreich aktualisiert.");
                            $('#edit-Sekretariat-form')[0].reset();
                            $('#editModal').modal('hide');
                            table.ajax.reload(null, false);
                        } else {
                            alert('Nicht erfolgreich aktualisert!');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr);
                        alert('Fehler: ' + error);
                    }
                });
            });


            // Löschen-Button
            $(document).on('click', '.delete-btn', function () {
                var SekretariatID = $(this).data('sekretariatid'); // Kleinbuchstaben verwenden

                if (confirm('Sind Sie sicher, dass Sie dieses Sekretariat löschen möchten?')) {
                    $.ajax({
                        url: '{{ route('deleteSekretariat') }}',
                        type: 'DELETE',
                        data: { SekretariatID: SekretariatID }, // Korrekt übergeben
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.status === 200) {
                                alert("Sekretariat erfolgreich gelöscht.");
                                table.ajax.reload(null, false);
                            } else {
                                alert('Sekretariat nicht erfolgreich gelöscht!');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr);
                            if (xhr.status === 422) {
                                alert(xhr.responseJSON.message); // Zeigt die Fehlermeldung des Servers
                            } else {
                                alert('Fehler: ' + error);
                            }
                        }
                    });
                }
            });

        });
    </script>


<script src="{{ asset('js/script.js') }}"></script>

</body>

</html>

