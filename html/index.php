<?php
if (
    isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
) {
    switch ($_POST['type']) {
        case 'edupack':
        case 'handbook':
            switch ($_POST['sku']) {
                case 'P12001':
                case 'P12002':
                    include dirname(__DIR__) . '/html/'.$_POST['type'].'/cats.php';
                    break;
                case 'P12003':
                case 'P12004':
                case 'P12005':
                    include dirname(__DIR__) . '/html/'.$_POST['type'].'/dogs.php';
                    break;
                default:
                    die();
            }
            break;
        default:
            die();
    }
}
