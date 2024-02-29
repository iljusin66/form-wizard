var dbColname = '';
$('document').ready(function() {
    initDraggable();

    function refreshDroppables() {
        $("#formWizard .col").droppable({
            accept: "#listDbCols li:not(.disabled)",
            drop: function(event, ui) {
                createInput(ui, this, true);
                refreshDroppables();
                saveForm();
            },
            greedy: false
        });

        $(".formGroup").droppable({
            accept: "#listDbCols li:not(.disabled)",
            drop: function(event, ui) {
                createInput(ui, this, false);
                saveForm();
            },
            greedy: true
        });
    }

    refreshDroppables();

    initConfigForm();
});

const initConfigForm = () => {
    
    changeConfigInpuGroup();
    changeConfigLabel();
    changeConfigEnvelopeInput();
    changeConfigInput();
}

const getColnameFromForm = () => {
    dbColname = $('#formConfig').attr('data-columname');
}

const changeConfigInpuGroup = () => {
    $('#inputGroupClass').change(function(){
        getColnameFromForm();
        var element = $('#formWizard div[data-inputgroup="' + dbColname + '"] ');
        changeAttr(element, 'class', $(this).val());
    });
}

const changeConfigLabel = () => {
    $('#labelClass').change(function(){
        getColnameFromForm();
        var element = $('#formWizard div[data-inputgroup="' + dbColname + '"] label');
        changeAttr(element, 'class', $(this).val());
    });

    $('#labelText').change(function(){
        getColnameFromForm();
        var element = $('#formWizard div[data-inputgroup="' + dbColname + '"] label');
        element.text($(this).val());
    });
}


const changeConfigEnvelopeInput = () => {
    $('#inputEnvelopeClass').change(function(){
        getColnameFromForm();
        var element = $('#formWizard div[data-inputgroup="' + dbColname + '"] div[data-name="inputEnvelope"]');
        changeAttr(element, 'class', $(this).val());
    });
}


const changeConfigInput = () => {
    $('#inputClass').change(function(){
        getColnameFromForm();
        var element = $('#formWizard div[data-inputgroup="' + dbColname + '"] div [data-name="input"]');
        changeAttr(element, 'class', $(this).val());
    });

    $('#inputPlaceholder').change(function(){
        getColnameFromForm();
        var element = $('#formWizard div[data-inputgroup="' + dbColname + '"] div [data-name="input"]');
        changeAttr(element, 'placeholder', $(this).val());
    });
}

const changeAttr = function (el, attr, val) {
    el.attr(attr, val);
}

const initDraggable = () => {
    //$("#listDbCols li").draggable();
    //$("#listDbCols li").draggable("destroy");
    $("#listDbCols li:not(.disabled)").draggable({
        helper: "clone",
        start: function () {
            $('#listDbCols').addClass('grabbing');
            $('#listDbCols').removeClass('grab');
        },
        stop: function () {
            $('#listDbCols').removeClass('grabbing');
            $('#listDbCols').addClass('grab');
            initDraggable();
        }
    });
}

const bindClickEvent = (element) => {
    var input;
    $('a.removeInputGroup', element).unbind('click').on('click', function () {
        removeinpuGroup(element);
        resetConfigForm(element);
    });
    $(element).unbind('click').on('click', function () {
        if (element.is('[data-inputGroup]')) {
            dbColname = $(this).attr('data-inputGroup');
            $('#formConfig legend').text('Sloupec: ' + dbColname);
            $('#formConfig').attr('data-columname', dbColname);
            $('#inputGroupClass').val($(this).attr('class'));
            
            $('#labelText').val($('label', this).text());
            $('#labelClass').val($('label', this).attr('class'));

            $('#inputEnvelopeClass').val($('div[data-name="inputEnvelope"]', this).attr('class'));

            input = $('input', this);
            inputType = input.attr('type');
            if (typeof (inputType) == 'undefined') {
                input = $('textarea', this);
                inputType = 'textarea';
            }
            $('#inputType').val(inputType);
            $('#inputClass').val(input.attr('class'));
            $('#inputPlaceholder').val(input.attr('placeholder'));
        }

        return false;
    });
}

const resetConfigForm = (element) => {
    if ($('#formConfig fieldset legend').text() == 'Sloupec: ' + element.attr('data-inputgroup')) {
        $('#formConfig').trigger("reset");
        $('#formConfig fieldset legend').html('&nbsp;');
    }
}

const removeinpuGroup = (el) => {
    
    var parentDiv = el.parent('div');
    var columnName = el.attr('data-inputgroup');
    console.log('columnName: ' + columnName);
    if (!confirm('Skutečně chceš smazat pole ' + columnName + '?')) { return; }
    el.remove();
    if (parentDiv.html() == '') {
        parentDiv.remove();
    }
    $('#listDbCols li[data-columname="' + columnName + '"]').removeClass('disabled');

}

const createInput = (ui, el, bFormGroup = true) => {
    var columnName = ui.helper.attr('data-columname');
    envRow = $('<div>').addClass('row py-2 rowInputGroup');
    envCol = $('<div>').attr('data-inputGroup', columnName).addClass('col-12');
    remove = $('<a>').attr('href', '#').addClass('text-danger fs-5 bi bi-x-circle-fill position-absolute removeInputGroup');
    envRow
    var formGroup = $('<div>').addClass('row p2 my-2 border border-1 rounded formGroup');
    var label = $('<label>').attr('for', columnName).addClass('col-sm-2 col-form-label text-end').text(columnName);
    var inputDiv = $('<div>').attr('data-name', "inputEnvelope").addClass('col-sm');
    var input = $('<input>').attr('type', 'text').attr('data-name', 'input').attr('name', columnName).attr('id', columnName).addClass('form-control');
    inputDiv.append(input);
    envRow.append(remove).append(label).append(inputDiv);
    envCol.append(envRow);
    envCol.append(envRow);
    if (bFormGroup) {
        formGroup.append(envCol);
        $(el).append(formGroup);
    } else {
        $(el).append(envCol);
    }

    $('#listDbCols li[data-columname="' + columnName + '"]').addClass('disabled');
    bindClickEvent(envCol);

}

const saveForm = () => {
    var formArray = $("#formWizard").serializeArray();
    var json = JSON.stringify(formArray);
    // uložte JSON do konfiguračního souboru
}