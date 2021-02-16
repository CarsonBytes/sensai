<?php
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

define('_JEXEC', 1);

require_once(dirname(__DIR__) . DS . 'init.php');

$filename = "calc data - categories2.csv";

defined('FILE_PATH') or define('FILE_PATH', __DIR__ . DS . $filename);

define('POSTER_ROOT_ALIAS', 'poster');

if (file_exists(FILE_PATH)) {

    $file = fopen($filename, "r");
    $i = 0;
    $level_ids = array(0 => 1); //root level => root id 
    $level_alias = array();

    while (!feof($file)) {
        $line[$i] = fgetcsv($file);
        if ($i == 1) {
            $level_index = array_search('level', $line[$i]);
            $title_index = array_search('title', $line[$i]);
            $alias_index = array_search('alias', $line[$i]);
        } else if ($i > 1) {
            echo $line[$i][$level_index] . '<br />';
            echo $line[$i][$title_index] . '<br />';
            echo $line[$i][$alias_index] . '<br />';

            $transformed_alias = transformAlias($line[$i][$alias_index]);

            if ($line[$i][$level_index] == 0) { //it's root id = 1
                continue;
            } else {
                if ($line[$i][$level_index] == 1) { //this is poster root
                    $level_alias = array(POSTER_ROOT_ALIAS);
                }
                $level_alias[$line[$i][$level_index] - 1] = $transformed_alias;
                for ($j = $line[$i][$level_index]; $j < count($level_alias); $j++) {
                    unset($level_alias[$j]);
                }

                $category_data['parent_id'] = $level_ids[(int)$line[$i][$level_index] - 1];
                $category_data['title'] = $line[$i][$title_index];
                $category_data['alias'] = $transformed_alias;
                $category_data['path'] = implode('/', $level_alias);
                echo '<pre>';
                var_dump($category_data['path']);
                echo '</pre>';


                $category_id = createCategory($category_data);

                if ($category_id === false) {
                    echo "category {$category_data['title']} already existed!"  . '<br />';
                    $db = JFactory::getDBO();
                    $query = "SELECT id from h1232_categories where published = 1 and path = " . $db->quote($category_data['path']);
                    $db->setQuery($query);
                    $level_ids[(int)$line[$i][$level_index]] = $db->loadResult();
                } else {
                    echo "added new category {$category_data['title']}"  . '<br />';
                    $level_ids[(int)$line[$i][$level_index]] = $category_id;
                }
                echo '<pre>';
                var_dump($level_ids);
                echo '</pre>';
            }
        }
        $i++;
    }
}


function createCategory($data)
{
    $data['rules'] = array(
        'core.edit.state' => array(),
        'core.edit.delete' => array(),
        'core.edit.edit' => array(),
        'core.edit.state' => array(),
        'core.edit.own' => array(1 => true)
    );

    //$category_data['id'] = 0;
    $data['extension'] = 'com_content';
    $data['published'] = 1;
    $data['language'] = '*';
    $data['params'] = array('category_layout' => '', 'image' => '');
    $data['metadata'] = array('author' => '', 'robots' => '');

    $basePath = JPATH_ADMINISTRATOR . '/components/com_categories';
    require_once $basePath . '/models/category.php';
    $config  = array('table_path' => $basePath . '/tables');
    $category_model = new CategoriesModelCategory($config);
    if (!$category_model->save($data)) {
        $err_msg = $category_model->getError();
        return false;
    } else {
        $id = $category_model->getItem()->id;
        return $id;
    }
}

function transformAlias($alias)
{
    return str_replace(' ', '-', trim(strtolower($alias)));
}
