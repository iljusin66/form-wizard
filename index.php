<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            // Inicializace přetažení
            $("#listDbCols li").draggable({
                helper: "clone"
            });

            // Nastavení přijímání přetažených prvků
            $("#formWizard").droppable({
                accept: "#listDbCols li",
                drop: function (event, ui) {
                    var columnName = ui.helper.text().trim();
                    addFormField(columnName);
                    saveFormConfiguration();
                }
            });

            // Funkce pro přidání formulářového pole
            function addFormField(columnName) {
                var label = $("<label>").addClass("form-label").text(columnName);
                var input = $("<input>").attr({
                    type: "text",
                    name: "input_" + columnName,
                    class: "form-control"
                });

                var formGroup = $("<div>").addClass("form-group").append(label, input);
                $("#formWizard").append(formGroup);
            }

            // Funkce pro uložení konfigurace do JSON souboru
            function saveFormConfiguration() {
                var formConfiguration = [];

                $("#formWizard .form-group").each(function () {
                    var label = $(this).find("label").text();
                    var inputName = $(this).find("input").attr("name");

                    formConfiguration.push({
                        label: label,
                        inputName: inputName
                    });
                });

                // Převod na JSON a uložení do souboru nebo jiného úložiště
                var jsonString = JSON.stringify(formConfiguration);
                console.log(jsonString); // Zde můžete provést další kroky, např. odeslat na server
            }
        });
    </script>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3" id="leftMenu">
                <!-- Vaše menu -->
            </div>
            <div class="col-md-6" id="content">
                <form id="formWizard">
                    <!-- Zde budou přidávány formulářové prvky -->
                </form>
            </div>
            <div class="col-md-3" id="dbCols">
                <ul id="listDbCols">
                    <li>Sloupec1</li>
                    <li>Sloupec2</li>
                    <!-- Další sloupce z MySQL tabulky -->
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
