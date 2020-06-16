<?php
// No direct access
defined('_JEXEC') or die;
function isEdupack($educational_type){
    return strpos($educational_type, 'educational-') !== false;
}
function getEdupackInfo($educational_type)
{
    switch ($educational_type) {
        case 'educational-dog':
            $edupack_img_path = '/images/poster/edupack/dog/dog_edupack.jpg';
            $handbook_page_path = '/promotional-items#dog_handbook';
            $handbook_page_img_path = '/images/page/promotional_items/dog/dog_277_1.jpg';
            break;
        case 'educational-cat':
            $edupack_img_path = '/images/poster/edupack/cat/cat_edupack.jpg';
            $handbook_page_path = '/promotional-items#cat_handbook';
            $handbook_page_img_path = '/images/page/promotional_items/cat/cat_277_1.jpg';
            break;
    }
    return array(
        'edupack_img_path' => $edupack_img_path,
        'handbook_page_path' => $handbook_page_path,
        'handbook_page_img_path' => $handbook_page_img_path
    );
}
