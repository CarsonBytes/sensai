<?php
if (
    isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
) {
    switch ($_POST['type']) {
        case 'edupack':
            switch ($_POST['sku']) {
                case 'P12001':
                case 'P12002':
                    include dirname(__DIR__) . '/html/edupack/cats.php';
                case 'P12003':
                case 'P12004':
                case 'P12005':
                    include dirname(__DIR__) . '/html/edupack/dogs.php';
                default:
                    die();
            }
        default:
            die();
    }
}
