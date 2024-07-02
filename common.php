<?php
$array = [
  ['id' => 1, 'date' => "12.01.2020", 'name' => "test1"],
  ['id' => 2, 'date' => "02.05.2020", 'name' => "test2"],
  ['id' => 4, 'date' => "08.03.2020", 'name' => "test4"],
  ['id' => 1, 'date' => "22.01.2020", 'name' => "test1"],
  ['id' => 2, 'date' => "11.11.2020", 'name' => "test4"],
  ['id' => 3, 'date' => "06.06.2020", 'name' => "test3"],
];


//1 задача.
// выделить уникальные записи (убрать дубли) в отдельный массив. в конечном массиве не должно быть элементов с одинаковым id.
$uniqIdArray = [];
array_walk($array, function ($el) use (&$uniqIdArray) {
    if (!isset($uniqIdArray[$el['id']])) {
        $uniqIdArray[$el['id']] = $el;
    }
});

$array = array_values($uniqIdArray);
print_r($array);



//2 задача.
// отсортировать многомерный массив по ключу (любому)
//сортирую по id
usort($array, function ($a, $b) {
    return $a['id'] <=> $b['id'];
});
print_r($array);



//3 задача.
// вернуть из массива только элементы, удовлетворяющие внешним условиям (например элементы с определенным id)
//ищу с id = 1
$array_filter = array_filter($array, function ($el) {
    if ($el['id'] === 1) {
        return true;
    }
});
print_r($array_filter);




//4 задача.
// изменить в массиве значения и ключи (использовать name => id в качестве пары ключ => значение)
$ids = array_column($array, 'id');
$name = array_column($array, 'name');
$array = array_combine($name, $ids);
print_r($array);



//5 задача
//В базе данных имеется таблица с товарами goods (id INTEGER, name TEXT), таблица с тегами tags (id INTEGER, name TEXT) и таблица связи товаров и тегов goods_tags (tag_id INTEGER, goods_id INTEGER, UNIQUE(tag_id, goods_id)). Выведите id и названия всех товаров, которые имеют все возможные теги в этой базе.

$sql = "SELECT g.id, g.name
            FROM goods g
            JOIN goods_tags g_t ON g.id = g_t.goods_id
            GROUP BY g.id
            HAVING count(g_t.tag_id) = (SELECT count(t.id) FROM tags t)
            ";



//6 задача
//Выбрать без join-ов и подзапросов все департаменты, в которых есть мужчины, и все они (каждый) поставили высокую оценку (строго выше 5).
$sql = "SELECT department_id,
                MIN(value) as min_value
        FROM evaluations
        WHERE gender = 1
        GROUP BY department_id 
        HAVING min_value > 5
        ";