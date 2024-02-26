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

        #listDbCols.grab li.used, #listDbCols.grabbing li.used { 
            cursor: initial;
            font-style: italic;
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

                <form id="formConfig" class="p-2 m-2 border border-1 rounded-3" data-colname="">
                    <div class="row pb-2 g-3 align-items-center">
                        <div class="col-2">
                            <label for="inputGroupClass" class="col-form-label">Input group class</label>
                        </div>
                        <div class="col-4">
                            <input type="text" id="inputGroupClass" name="inputGroupClass" class="form-control">
                        </div>
                        <div class="col-2">
                            <label for="labelClass" class="col-form-label">Label class</label>
                        </div>
                        <div class="col-4">
                            <input type="text" id="labelClass" name="labelClass" class="form-control">
                        </div>
                    </div>
                    <div class="row g-3 align-items-center">
                        <div class="col-2">
                            <label for="inputType" class="col-form-label">Input type</label>
                        </div>
                        <div class="col-4">
                            <input type="text" id="inputType" name="inputType" class="form-control">
                        </div>
                        <div class="col-2">
                            <label for="inputClass" class="col-form-label">Input class</label>
                        </div>
                        <div class="col-4">
                            <input type="text" id="inputClass" name="inputClass" class="form-control">
                        </div>
                    </div>
                </form>

                <form id="formWizard" class="row p-2 m-2 border border-1 rounded-3">
                    <div class="col"></div> <!-- Div pro přetahované sloupce -->
                </form>
            </div>
            <div class="col-2" id="dbCols">
                <ul id="listDbCols" class="grab">
                    <li class="sloupec_1">sloupec_1</li>
                    <li class="sloupec_2">sloupec_2</li>
                </ul>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        $(function() {
            initDraggable();

            function refreshDroppables() {
                $("#formWizard .col").droppable({
                    accept: "#listDbCols li:not(.used)",
                    drop: function(event, ui) {
                        createInput(ui, this, true);
                        refreshDroppables();
                        saveForm();
                    },
                    greedy: false
                });

                $(".formGroup").droppable({
                    accept: "#listDbCols li:not(.used)",
                    drop: function(event, ui) {
                        createInput(ui, this, false);
                        saveForm();
                    },
                    greedy: true
                });
            }

            refreshDroppables();
        });

        function initDraggable() {
            $( "#listDbCols li").draggable();
            $( "#listDbCols li" ).draggable( "destroy" );
            $("#listDbCols li:not(.used)").draggable({
                helper: "clone",
                start: function() {
                    $('#listDbCols').addClass('grabbing');
                    $('#listDbCols').removeClass('grab');
                },
                stop: function() {
                    $('#listDbCols').removeClass('grabbing');
                    $('#listDbCols').addClass('grab');
                    $(this).addClass('used');
                    initDraggable();
                }
            });
        }

        function bindClickEvent(element) {
            var input;
            $(element).unbind('click').on('click', function(){
                if (element.is('[data-inputGroup]')) {
                    $('#formConfig').attr('data-colname', $(this).attr('data-inputGroup'));
                    $('#inputGroupClass').val($(this).attr('class'));
                    $('#labelClass').val($('label', this).attr('class'));
                    input = $('input', this);
                    inputType = input.attr('type');
                    if (typeof(inputType) == 'undefined') {
                        input = $('textarea', this);
                        inputType = 'textarea';
                    }
                    $('#inputType').val(inputType);
                    $('#inputClass').val(input.attr('class'));
                }
                
                return false;
            });
        }

        function createInput(ui, el, bFormGroup = true) {
            var columnName = ui.helper.text();
            envRow = $('<div>').addClass('row py-2');
            envCol = $('<div>').attr('data-inputGroup', columnName).addClass('col-12');
            var formGroup = $('<div>').addClass('row p2 my-2 border border-1 rounded formGroup');
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
