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

                        <!-- Lizenz-Tabelle -->
                        <div class="table2">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card mt-4 shadow">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4>Lizenzen dieses Computers</h4>

                                            <div class="button-group d-flex gap-2">
                                                <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addExLicenseModal">
                                                    <i class="bi bi-database-add"></i> Bestehende Lizenz hinzufügen
                                                </button>

                                                <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addLicenseModal">
                                                    <i class="bi bi-database-add"></i> Neue Lizenz hinzufügen
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                        <div class="table-responsive" style="overflow-x:auto">
                                            <table id="licenseTable" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Lizenzschlüssel</th>
                                                        <th class="text-center">Maximale Anzahl</th>
                                                        <th class="text-center">belegt</th>
                                                        <th class="text-center">Lizenzbeginn</th>
                                                        <th class="text-center">Lizenzende</th>
                                                        <th class="text-center">Software</th>
                                                        <th class="text-center">Lizenzstatus</th>
                                                        <th class="text-center">Verbleibende Zeit</th>
                                                        <th class="text-center">Rechnung</th>
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

                        <!-- Modal: Neue Lizenz hinzufügen -->
                        <div class="modal fade" id="addLicenseModal" tabindex="-1" role="dialog" aria-labelledby="addLicenseLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addLicenseLabel">Lizenz hinzufügen</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="add-license-form" method="post" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-lg">
                                                    <label>Lizenzschlüssel</label>
                                                    <input type="text" name="Lizenzschluessel" id="Lizenzschluessel" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg">
                                                    <label>Anzahl an Computern</label>
                                                    <input type="number" name="MaxAnzahl" id="MaxAnzahl" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg">
                                                    <label>Lizenzbeginn</label>
                                                    <input type="date" name="Lizenzbeginn" id="Lizenzbeginn" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg">
                                                    <label>Lizenzende</label>
                                                    <input type="date" name="Lizenzende" id="Lizenzende" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg">
                                                    <label>Software</label>
                                                    <input type="text" name="Software" id="Software" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg">
                                                    <label>Lizenzstatus</label>
                                                    <select name="Lizenzstatus" id="Lizenzstatus" class="form-control" required>
                                                        <option value="Aktiv">Aktiv</option>
                                                        <option value="Inaktiv">Inaktiv</option>
                                                        <option value="expired">Abgelaufen</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg">
                                                    <label>Rechnung (optional)</label>
                                                    <input type="file" name="Rechnung" id="Rechnung" class="form-control" accept=".pdf,.jpeg,.jpg,.png" >
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                                        <button type="submit" class="btn btn-primary" form="add-license-form">Speichern</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Modal: Bestehende Lizenz hinzufügen -->
                        <div class="modal fade" id="addExLicenseModal" tabindex="-1" role="dialog" aria-labelledby="addExLicenseLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addLicenseLabel">Lizenz hinzufügen</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="add-ex-license-form" method="post" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-lg">
                                                    <label>Lizenzschlüssel</label>
                                                    <input type="text" name="Lizenzschluessel" id="Lizenzschluessel" class="form-control" required>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                                        <button type="submit" class="btn btn-primary" form="add-ex-license-form">Speichern</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal: Lizenz bearbeiten -->
                        <div class="modal fade" id="editLicenseModal" tabindex="-1" role="dialog" aria-labelledby="editLicenseLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editLicenseLabel">Lizenz bearbeiten</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="edit-license-form">
                                            <input type="hidden" name="LizenzschluesselAlt" id="edit-LizenzschluesselAlt">
                                            <div class="row">
                                                <div class="col-lg">
                                                    <label>Lizenzschluessel</label>
                                                    <input type="text" name="Lizenzschluessel" id="edit-Lizenzschluessel" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg">
                                                    <label>Anzahl an Computern</label>
                                                    <input type="number" name="MaxAnzahl" id="edit-MaxAnzahl" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg">
                                                    <label>Lizenzbeginn</label>
                                                    <input type="date" name="Lizenzbeginn" id="edit-Lizenzbeginn" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg">
                                                    <label>Lizenzende</label>
                                                    <input type="date" name="Lizenzende" id="edit-Lizenzende" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg">
                                                    <label>Software</label>
                                                    <input type="text" name="Software" id="edit-Software" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg">
                                                    <label>Lizenzstatus</label>
                                                    <select name="Lizenzstatus" id="edit-Lizenzstatus" class="form-control" required>
                                                        <option value="Aktiv">Aktiv</option>
                                                        <option value="Inaktiv">Inaktiv</option>
                                                        <option value="Abgelaufen">Abgelaufen</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg">
                                                    <label>Rechnung (optional)</label>
                                                    <input type="file" name="Rechnung" id="edit-Rechnung" class="form-control" accept=".pdf,.jpeg,.jpg,.png" >
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                                        <button type="submit" class="btn btn-primary" form="edit-license-form">Bearbeiten</button>
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
            var table = $('#licenseTable').DataTable({
                "ajax": {
                    "url": `/licenses/pc/{{ $PCID }}`,
                    "type": "GET",
                    "dataType": "json",
                    "headers": {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    "dataSrc": function (response) {
                        if (response.status === 200) {
                            return response.licenses;
                        } else {
                            return [];
                        }
                    }
                },
                "columns": [
                    { "data": "Lizenzschluessel" },
                    { "data": "MaxAnzahl" },
                    { "data": "Anzahl" },      // LizenzID anzeigen
                    { "data": "Lizenzbeginn",
                        "render": function (data) {
                            if (data) {
                                let date = new Date(data);
                                return date.toLocaleDateString('de-DE'); // Konvertiert in DD.MM.YYYY
                            }
                            return data;
                        }
                     },  // Lizenzbeginn anzeigen
                    { "data": "Lizenzende",
                        "render": function (data) {
                            if (data) {
                                let date = new Date(data);
                                return date.toLocaleDateString('de-DE'); // Konvertiert in DD.MM.YYYY
                            }
                        return data;
                        }
                    },
                    { "data": "Software" },      // Software anzeigen
                    { "data": "Lizenzstatus" },  // Lizenzstatus anzeigen
                    {
                        "data": "Lizenzende",
                        "render": function (data) { // Verbleibende Zeit berechnen
                            let today = new Date();
                            let endDate = new Date(data);
                            let diffTime = endDate - today;
                            if (diffTime > 0) {
                                let daysLeft = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                                return `${daysLeft} Tage verbleiben`;
                            } else {
                                return "Abgelaufen";
                            }
                        }
                    },
                    {
                        "data": "Rechnungs_Pfad",
                        "render": function (data, type, row) {
                            // Überprüft, ob der Rechnungs_Pfad existiert
                            return data ? `<a href="/lizenzen/rechnung/${row.Lizenzschluessel}" target="_blank" class="btn btn-sm btn-info">Rechnung</a>` : "Keine Rechnung";
                        }
                    },
                    {
                        "data": null,
                        "render": function (data, type, row) { // Aktionen (Edit / Delete)
                            return `
                                <a class="btn btn-sm btn-success edit-btn" data-Lizenzschluessel="${data.Lizenzschluessel}" data-MaxAnzahl="${data.MaxAnzahl}" data-Lizenzbeginn="${data.Lizenzbeginn}" data-Lizenzende="${data.Lizenzende}" data-Software="${data.Software}" data-Lizenzstatus="${data.Lizenzstatus}">Bearbeiten</a>
                                <a class="btn btn-sm btn-danger delete-btn" data-Lizenzschluessel="${data.Lizenzschluessel}">Entfernen</a>
                            `;
                        }
                    }
                ]
            });


            // Neu Lizenz hinzufügen
            $('#add-license-form').submit(function (e) {
                e.preventDefault(); // Standard-Formularaktion verhindern

                const formData = new FormData(this);

                var file = document.getElementById('Rechnung').files[0];

                if (file) {
                    formData.append('Rechnung', file);

                }

                $.ajax({
                    url: '{{ route('licenses.store', ['sek_id' => $sek_id, 'PCID' => $PCID]) }}',
                    method: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (response) {
                        //alert(response.message); // Erfolgsmeldung anzeigen
                        $('#add-license-form')[0].reset();
                        $('#addLicenseModal').modal('hide'); // Modal schließen

                        // DataTable neu laden
                        $('#licenseTable').DataTable().ajax.reload(null, false);
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        alert('Fehler beim Hinzufügen der Lizenz.');
                    }
                });
            });

            // Bestehende Lizenz hinzufügen
            $('#add-ex-license-form').submit(function (e) {
                e.preventDefault(); // Standard-Formularaktion verhindern

                const formData = new FormData(this);

                $.ajax({
                    url: '{{ route('licenses.ex.store', ['sek_id' => $sek_id, 'PCID' => $PCID]) }}',
                    method: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (response) {
                        //alert(response.message); // Erfolgsmeldung anzeigen
                        $('#add-ex-license-form')[0].reset();
                        $('#addExLicenseModal').modal('hide'); // Modal schließen

                        // DataTable neu laden
                        $('#licenseTable').DataTable().ajax.reload(null, false);
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        alert('Fehler beim Hinzufügen der Lizenz.');
                    }
                });
            });

            // Bearbeiten neu: damit Daten im Formualr stehen
            $(document).on('click', '.edit-btn', function () {
                //var id = $(this).data('id');
                var Lizenzschluessel = $(this).data('lizenzschluessel');
                var MaxAnzahl= $(this).data('maxanzahl');
                var Lizenzbeginn = $(this).data('lizenzbeginn');
                var Lizenzende = $(this).data('lizenzende');
                var Software = $(this).data('software');
                var Lizenzstatus = $(this).data('lizenzstatus');

                $('#edit-LizenzschluesselAlt').val(Lizenzschluessel); // der alte Prim SChlüssel falls der bearbeitet wird

                $('#edit-Lizenzschluessel').val(Lizenzschluessel);
                $('#edit-MaxAnzahl').val(MaxAnzahl);
                $('#edit-Lizenzbeginn').val(Lizenzbeginn);
                $('#edit-Lizenzende').val(Lizenzende);
                $('#edit-Software').val(Software);
                $('#edit-Lizenzstatus').val(Lizenzstatus);

                $('#editLicenseModal').modal('show');
            });


            // Lizenz aktualisieren
            $('#edit-license-form').submit(function (e) {
                e.preventDefault(); // Standard-Formularaktion verhindern

                const formData = new FormData(this);

                var file = document.getElementById('Rechnung').files[0];

                if (file) {
                    formData.append('Rechnung', file);

                }

                $.ajax({
                    url: '{{ route('licenses.update') }}',
                    method: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (response) {
                        //alert(response.message); // Zeigt Erfolgsmeldung an
                        $('#editLicenseModal').modal('hide'); // Schließt das Modal
                        $('#edit-license-form')[0].reset();
                        table.ajax.reload(null, false); // DataTable neu laden
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        alert('Fehler beim Aktualisieren der Lizenz.');
                    },
                });
            });

            // Lizenz löschen
            $(document).on('click', '.delete-btn', function () {
                var Lizenzschluessel = $(this).data('lizenzschluessel');
                if (confirm('Sind Sie sicher, dass Sie diese Lizenz löschen wollen?')) {
                    $.ajax({
                        url: `/licenses/${Lizenzschluessel}/{{$PCID}}/delete`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            //alert(response.message);
                            table.ajax.reload(null, false);
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                            alert('Fehler beim Löschen der Lizenz.');
                        }
                    });
                }
            });
        });
    </script>

<script src="{{ asset('js/script.js') }}"></script>

</body>

</html>

