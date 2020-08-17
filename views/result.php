<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Database.php';

$text = $_GET['text'];
$words = transform($text);
(new Database())->saveRequestToDatabase($_SERVER['REMOTE_ADDR'], $words);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>App</title>
</head>
<body>
<div class="container" style="margin-top:20px">

    <div class="row">
        <div class="col-sm-6" style="margin-top:20px">
            <span>You submited text:</span>
        </div>
        <div class="col-sm-6">
            <a href="/" class="btn btn-primary float-right">Submit another text</a>
        </div>
        <div class="col-sm-12 alert alert-secondary">
            <pre><?= $text ?></pre>
        </div>
    </div>

    <div class="row">

    </div>
    <div class="row">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Word</th>
                <th>Count</th>
                <th>Stars</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($words as $key => $value) { ?>
                <tr>
                    <td><?= ++$key ?></td>
                    <td><?= $value['word'] ?></td>
                    <td><?= $value['count'] ?></td>
                    <td><?= $value['stars'] ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>