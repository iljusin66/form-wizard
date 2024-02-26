<!DOCTYPE html>
<html>
<head>
    <title>Formulářový generátor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <style>
        #container {
            width: 100%;
            max-width: 100%;
        }
        #formWizard {
            min-height: 600px;
        }

        #listDbCols.grabbing li {
            cursor: grabbing;
        }
        #listDbCols.grab li {
            cursor: grab;
        }
    </style>
</head>
<body>
    <div class="container" id="container">
        <div class="row">
            <div class="col-1" id="leftMenu">
                <!-- Vaše menu -->
            </div>
            <div class="col" id="content">

                <form id="formConfig" class="p-2 m-2 border border-1 rounded-3">
                <div class="row g-3 align-items-center">
                    <h3>Input group</h3>
                    <div class="col-auto">
                        <label for="inputGroupClass" class="col-form-label">class</label>
                    </div>
                    <div class="col-auto">
                        <input type="text" id="inputGroupClass" name="inputGroupClass" class="form-control">
                    </div>
                    <div class="col-auto">
                        <span id="inputGroupHelp" class="form-text">
                        Obalovací prvek pro label+input
                        </span>
                    </div>
                    </div>
                </form>

                <form id="formWizard" class="row p-2 border border-1">
                    <div class="col"></div> <!-- Div pro přetahované sloupce -->
                </form>
            </div>
            <div class="col-2" id="dbCols">
                <ul id="listDbCols" class="grab">
                    <li>sloupec_1</li>
                    <li>sloupec_2</li>
                </ul>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        $(function() {
            $("#listDbCols li").draggable({
                helper: "clone",
                start: function() {
                    $('#listDbCols').addClass('grabbing');
                    $('#listDbCols').removeClass('grab');
                },
                stop: function() {
                    $('#listDbCols').removeClass('grabbing');
                    $('#listDbCols').addClass('grab');
                }
            });

            function refreshDroppables() {
                $("#formWizard .col").droppable({
                    accept: "#listDbCols li",
                    drop: function(event, ui) {
                        createInput(ui, this, true);
                        refreshDroppables();
                        saveForm();
                    },
                    greedy: false
                });

                $(".formGroup").droppable({
                    accept: "#listDbCols li",
                    drop: function(event, ui) {
                        createInput(ui, this, false);
                        saveForm();
                    },
                    greedy: true
                });
            }

            refreshDroppables();
        });

        function bindClickEvent(element) {
            $(element).unbind('click').on('click', function(){
                if (element.is('[data-inputGroup]')) {
                    console.log('test: ' + $(this).attr('data-inputGroup'));
                }
                
                return false;
            });
        }

        function createInput(ui, el, bFormGroup = true) {
            var columnName = ui.helper.text();
            envRow = $('<div>').addClass('row');
            envCol = $('<div>').attr('data-inputGroup', columnName).addClass('col-12 inputGroup-' + columnName);
            var formGroup = $('<div>').addClass('row m-2 border border-1 formGroup');
            var label = $('<label>').attr('for', columnName).addClass('col-sm-2 col-form-label').text(columnName);
            var inputDiv = $('<div>').addClass('col-sm-10');
            var input = $('<input>').attr('type', 'text').attr('name', columnName).attr('id', columnName).addClass('form-control');
            inputDiv.append(input);

            if (bFormGroup) {
                envRow.append(label).append(inputDiv);
                envCol.append(envRow);
                formGroup.append(envCol);
                $(el).append(formGroup);
            }else{
                envRow.append(label).append(inputDiv);
                envCol.append(envRow);
                $(el).append(envCol);
            }
            
            bindClickEvent(envCol);
        }

        function saveForm() {
            var formArray = $("#formWizard").serializeArray();
            var json = JSON.stringify(formArray);
            // uložte JSON do konfiguračního souboru
        }

    </script>
</body>
</html>
