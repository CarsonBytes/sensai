<?php
switch ($_GET['type']) {
    case 'handbook':
        switch ($_GET['sku']) {
            case 'P12001':
            case 'P12002':
                header("Location: /files/handbooks/cats.pdf");
            break;
            case 'P12003':
            case 'P12004':
            case 'P12005':
                header("Location: /files/handbooks/dogs.pdf");      
            break;
            default:
                die();
        }
    default:
        die();
}
