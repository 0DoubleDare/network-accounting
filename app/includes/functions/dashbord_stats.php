<?php

function getDefectCountWithCategories($pdo)
{
    $sql = "SELECT dc.display_name, COUNT(d.id) as defect_count 
        FROM defect_category dc
        LEFT JOIN defects d ON dc.id = d.category
        GROUP BY dc.id, dc.display_name
        HAVING defect_count > 0";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    // Категории и количество дефектов нужно разнести по разным таблицам
    return [
        'categories' => array_keys($data),
        'count' => array_map('intval', array_values($data))
    ];
}

function getMaterialsCountWithCategories($pdo)
{
    $sql = "
            SELECT mt.display_name, COUNT(m.id) as material_count
            FROM material_type mt
            LEFT JOIN materials m ON mt.id = m.type
            GROUP BY mt.id, mt.display_name
            HAVING material_count > 0;
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    return [
        'categories' => array_keys($data),
        'count' => array_map('intval', array_values($data))
    ];
}