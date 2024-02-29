<?php
mb_internal_encoding("UTF-8");

use Latecka\Config\config;
use Latecka\formWizard;
use Latecka\Utils\utils;

require_once 'vendor/autoload.php';
new config();
$fw = new formWizard();
?><!DOCTYPE html>
<html>
<head>
    <title>Formulářový generátor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/style.css?chks=<?= md5_file(__DIR__ . '\style.css') ?>">
    <script src="/js.js?chks=<?= md5_file(__DIR__ . '\js.js') ?>"></script>
</head>
<body>
    <div class="container" id="container">
        <div class="row">
            <div class="col-1" id="leftMenu">
                <!-- Vaše menu -->
            </div>
            <div class="col" id="content">

                <form id="formConfig" class="p-2 m-2 border border-1 rounded-3 bg-light" data-columname="">
                    <fieldset>
                        <legend>&nbsp;</legend>
                        <div class="row pb-1 g-3 align-items-center">
                            <div class="col-2 fs-6">
                                <label for="inputGroupClass" class="col-form-label">Input group class</label>
                            </div>
                            <div class="col-4">
                                <input type="text" id="inputGroupClass" name="inputGroupClass" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row pb-1 g-3 align-items-center">
                            <div class="col-2">
                                <label for="labelText" class="col-form-label">Label text</label>
                            </div>
                            <div class="col-4">
                                <input type="text" id="labelText" name="labelText" class="form-control form-control-sm">
                            </div>
                            <div class="col-2">
                                <label for="labelClass" class="col-form-label">Label class</label>
                            </div>
                            <div class="col-4">
                                <input type="text" id="labelClass" name="labelClass" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row mt-1 pb-1 g-3 align-items-center">
                            <div class="col-2">
                                <label for="inputEnvelopeClass" class="col-form-label">Input envelope class</label>
                            </div>
                            <div class="col-4">
                                <input type="text" id="inputEnvelopeClass" name="inputEnvelopeClass" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row pb-1 g-3 align-items-center">
                            <div class="col-2">
                                <label for="inputType" class="col-form-label">Input type</label>
                            </div>
                            <div class="col-4">
                                <input type="text" id="inputType" name="inputType" class="form-control form-control-sm">
                            </div>
                            <div class="col-2">
                                <label for="inputClass" class="col-form-label">Input class</label>
                            </div>
                            <div class="col-4">
                                <input type="text" id="inputClass" name="inputClass" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row g-3 align-items-center">
                            <div class="col-2">
                                <label for="inputPlaceholder" class="col-form-label">Input placeholder</label>
                            </div>
                            <div class="col-4">
                                <input type="text" id="inputPlaceholder" name="inputPlaceholder" class="form-control form-control-sm">
                            </div>
                        </div>
                    </fieldset>
                </form>

                <form id="formWizard" class="row p-2 m-2 border border-1 rounded-3">
                    <div class="col"></div> <!-- Div pro přetahované sloupce -->
                </form>
            </div>
            <div class="col-2" id="dbCols">

                <ul id="listDbCols" class="grab">
                    <?= $fw->getListDBColumns('app_role'); ?>
                </ul>
            </div>
        </div>
    </div>

</body>
</html>
