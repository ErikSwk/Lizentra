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
                        <!-- Freischaltungs Tabelle für Mitarbeiter-->
                        <div class="table2" style="display: none;">
                            <div class="row">
                                <div class="container mt-5">
                                    <div class="card shadow">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4>Mitarbeiter zum Freischalten</h4>
                                        </div>
                                        <div class="card-body">
                                            <table id="freischaltungsTable" class="display table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Büro</th>
                                                        <th>SekretariatID</th>
                                                        <th>Aktion</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="freischaltenModal" tabindex="-1" role="dialog" aria-labelledby="freischaltenModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="freischaltenModalLabel">User freischalten</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="freischalten-form" method="post">
                                            <input type="hidden" id="freischalten-ID" name="ID">
                                            Sind sie sicher das sie diesen User freischalten möchten?
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                                        <button type="submit" class="btn btn-primary" form="freischalten-form">Freischalten</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!--User Tabelle-->
                        <div class="table1">
                            <div class="row">
                                <div class="container mt-5">
                                    <div class="card shadow">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4>Userverwaltung</h4>
                                            <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addModal">
                                                <i class="bi bi-database-add"></i> Hinzufügen
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <table id="UserTable" class="display table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Büro</th>
                                                        <th>SekretariatID</th>
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
                                                <h5 class="modal-title" id="addModalLabel">User hinzufügen</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="User-form" method="post">
                                                    <div class="row">
                                                        <div class="col-lg">
                                                            <label>Name</label>
                                                            <input type="text" name="Name" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg">
                                                            <label>Email</label>
                                                            <input type="email" name="Email" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg">
                                                            <label>Passwort</label>
                                                            <input type="password" name="password" id="password" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg">
                                                            <label>Password bestätigen</label>
                                                            <input type="password" name="password_confirmation" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg">
                                                            <label>Büro</label>
                                                            <input type="text" name="Buero" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg">
                                                            <label>SekretariatID</label>
                                                            <input type="text" name="SekretariatID" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                                                <button type="submit" class="btn btn-primary" form="User-form">Speichern</button>
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
                                    <h5 class="modal-title" id="editModalLabel">User bearbeiten</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="edit-User-form" method="post">
                                        <input type="hidden" id="edit-ID" name="ID">
                                        <div class="row">
                                            <div class="col-lg">
                                                <label>Name</label>
                                                <input type="text" id="edit-Name" name="Name" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg">
                                                <label>Email</label>
                                                <input type="email" id="edit-Email" name="Email" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg">
                                                <label>Passwort</label>
                                                <input type="password" name="password" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg">
                                                <label>Passwort</label>
                                                <input type="password" name="password_confirmation" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg">
                                                <label>Büro</label>
                                                <input type="text" id="edit-Buero" name="Buero" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg">
                                                <label>SekretariatID</label>
                                                <input type="text" id="edit-SekretariatID" name="SekretariatID" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg">
                                                <label for="edit-Status">Status</label>
                                                <select id="edit-Status" name="Status" class="form-control" required>
                                                    <option value='active'>Aktiv</option>
                                                    <option value='inactive'>Inaktiv</option>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                                    <button type="submit" class="btn btn-primary" form="edit-User-form">Bearbeiten</button>
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
            var table = $('#UserTable').DataTable({
                "ajax": {
                    "url": "{{ route('getAllUser') }}",
                    "type": "GET",
                    "dataType": "json",
                    "headers": {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    "dataSrc": function (response) {
                        if (response.status === 200) {
                            return response.User;
                        } else {
                            return [];
                        }
                    }
                },
                "columns": [
                    { "data": "name" },
                    { "data": "email" },
                    { "data": "buero" },
                    { "data": "SekretariatID" },
                    {
                        "data": null,
                        "render": function (data, type, row) {
                            return `
                                <a class="btn btn-sm btn-success edit-btn" data-id="${data.id}" data-name="${data.name}" data-email="${data.email}" data-buero="${data.buero}" data-SekretariatID="${data.SekretariatID}">Bearbeiten</a>
                                <a class="btn btn-sm btn-danger delete-btn" data-id="${data.id}">Löschen</a>
                            `;
                        }
                    }
                ]
            });

            // Edit-Button
            $(document).on('click', '.edit-btn', function () {
                var ID = $(this).data('id');
                var Name = $(this).data('name');
                var Email = $(this).data('email');
                var Buero = $(this).data('buero');
                var SekretariatID =  $(this).data('SekretariatID');

                $('#edit-ID').val(ID);
                $('#edit-Name').val(Name);
                $('#edit-Email').val(Email);
                $('#edit-Buero').val(Buero);
                $('#edit-SekretariatID').val(SekretariatID);

                $('#editModal').modal('show');
            });

            // Hinzufügen-Formular
            $('#User-form').submit(function (e) {
                e.preventDefault();
                const formData = new FormData(this);

                $.ajax({
                    url: '{{ route('storeUser') }}',
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
                            alert("User erfolgreich hinzugefügt.");
                            $('#User-form')[0].reset();
                            $('#addModal').modal('hide');
                            table.ajax.reload(null, false); // Tabelle neu laden
                        } else {
                            alert('Nicht erfolgreich hinzugefügt!');
                        }
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) { // Validierungsfehler
                            const errors = xhr.responseJSON.errors;
                            let errorMessage = 'Fehler:\n';
                            for (const key in errors) {
                                errorMessage += `${errors[key][0]}\n`; // Erste Fehlermeldung
                            }
                            alert(errorMessage); // Zeigt die Fehlermeldung an
                        } else {
                            alert('Ein unbekannter Fehler ist aufgetreten.');
                        }
                    }
                });
            });


            // Bearbeiten-Formular
            $('#edit-User-form').submit(function (e) {
                e.preventDefault();
                const formData = new FormData(this);

                $.ajax({
                    url: '{{ route('updateUser') }}',
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
                            alert("User erfolgreich aktualisiert.");
                            $('#edit-User-form')[0].reset();
                            $('#editModal').modal('hide');
                            table.ajax.reload(null, false); // Tabelle neu laden
                        } else {
                            alert('Nicht erfolgreich aktualisiert!');
                        }
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) { // Validierungsfehler
                            const errors = xhr.responseJSON.errors;
                            let errorMessage = 'Fehler:\n';
                            for (const key in errors) {
                                errorMessage += `${errors[key][0]}\n`;
                            }
                            alert(errorMessage); // Zeigt die Fehlermeldung an
                        } else {
                            alert('Ein unbekannter Fehler ist aufgetreten.');
                        }
                    }
                });
            });


            // Löschen-Button
            $(document).on('click', '.delete-btn', function () {
                var ID = $(this).data('id');

                if (confirm('Sind Sie sicher, dass Sie dieses User löschen möchten?')) {
                    $.ajax({
                        url: '{{ route('deleteUser') }}',
                        type: 'DELETE',
                        data: { id: ID },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.status === 200) {
                                alert("User erfolgreich gelöscht.");
                                table.ajax.reload(null, false);
                            } else {
                                alert('User nicht erfolgreich gelöscht!');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr);
                            alert('Fehler: ' + error);
                        }
                    });
                }
            });


            // DataTabel 2 für Freischalten initialisieren
            var table2 = $('#freischaltungsTable').DataTable({
                "ajax": {
                    "url": "{{ route('getAllUserZumFreischalten') }}",
                    "type": "GET",
                    "dataType": "json",
                    "headers": {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    "dataSrc": function (response) {
                        if (response.status === 200 && response.UserFreischalten.length > 0) {
                            $('.table2').show();
                            return response.UserFreischalten;
                        } else {
                            $('.table2').hide();
                            return [];
                        }
                    }
                },
                "columns": [
                    { "data": "name" },
                    { "data": "email" },
                    { "data": "buero" },
                    { "data": "SekretariatID" },
                    {
                        "data": null,
                        "render": function (data, type, row) {
                            return `
                                <a class="btn btn-sm btn-success freischalten-btn" data-id="${data.id}">Freischalten</a>
                                <a class="btn btn-sm btn-danger ablehnen-btn" data-id="${data.id}">Ablehnen</a>
                            `;
                        }
                    }
                ]
            });

                // Freischalten-Button
            $(document).on('click', '.freischalten-btn', function () { // Butotns hier drüber mit extra eigener Klasse versehen da Moal darüber geöffnet werdne.
                var ID = $(this).data('id');

                $('#freischalten-ID').val(ID);

                $('#freischaltenModal').modal('show');
            });

            // Freischalten-Formular
            $('#freischalten-form').submit(function (e) {
                e.preventDefault();
                const formData = new FormData(this);
                var ID = $(this).data('id');

                $.ajax({
                    url: '{{ route('freischaltenUser') }}',
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
                            $('#freischalten-form')[0].reset();
                            $('#freischaltenModal').modal('hide');
                            table2.ajax.reload(null, false);
                            table.ajax.reload(null, false);
                        } else {
                            alert('Nicht erfolgreich freigeschaltet!');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr);
                        alert('Fehler: ' + error);
                    }
                });
            });


            // Ablehnen
            $(document).on('click', '.ablehnen-btn', function () {
                var ID = $(this).data('id');

                if (confirm('Sind Sie sicher, dass Sie diesen Account ablehnen möchten dadurch wird dieses gelöscht?')) {
                    $.ajax({
                        url: '{{ route('deleteUser') }}',
                        type: 'DELETE',
                        data: { id: ID },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.status === 200) {
                                alert("User erfolgreich abgelehnt.");
                                table2.ajax.reload(null, false);
                                table1.ajax.reload(null, false);
                            } else {
                                alert(response.message);
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

