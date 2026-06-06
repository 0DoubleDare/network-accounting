<?php
/**
 * Экспорт данных в CSV
 */

session_start();

require '../config/db.php';
require '../app/includes/functions.php';

$type = $_GET['type'];

// Разрешённые типы экспорта
$allowedTypes = ['materials', 'logs', 'network_points', 'material_usage'];

/**
 * ЭКСПОРТ МАТЕРИАЛОВ
 */
if ($type === 'materials') {
    $query = "SELECT 
                materials.id, 
                materials.name, 
                material_type.display_name AS type_name,
                materials.unit,
                CASE 
                    WHEN materials.unit = 'm' THEN 'метров'
                    WHEN materials.unit = 'pcs' THEN 'штук'
                    ELSE materials.unit
                END AS unit_rus
            FROM materials
            LEFT JOIN material_type ON materials.type = material_type.id
            ORDER BY materials.id";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $headers = ['ID', 'Название материала', 'Тип материала', 'Единица измерения'];
    
    $data = [];
    foreach ($result as $row) {
        $data[] = [
            $row['id'],
            $row['name'],
            $row['type_name'] ?? 'Не указан',
            $row['unit_rus']
        ];
    }
    
    exportToCSV($data, $headers, 'materials');
}

/**
 * ЭКСПОРТ ЛОГОВ
 */
if ($type === 'logs') {
    $query = "SELECT 
                logs.id,
                logs.action,
                logs.target_table,
                logs.target_id,
                logs.created_at,
                users.login AS user_login,
                users.role AS user_role
            FROM logs
            LEFT JOIN users ON logs.user_id = users.id
            ORDER BY logs.created_at DESC";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $headers = ['ID', 'Пользователь', 'Роль', 'Действие', 'Таблица', 'ID записи', 'Дата и время'];
    
    $data = [];
    foreach ($result as $row) {
        $data[] = [
            $row['id'],
            $row['user_login'] ?? 'Система',
            $row['user_role'] ?? '-',
            $row['action'],
            $row['target_table'] ?? '-',
            $row['target_id'] ?? '-',
            date('d.m.Y H:i:s', strtotime($row['created_at']))
        ];
    }
    
    exportToCSV($data, $headers, 'logs');
}

/**
 * ЭКСПОРТ СЕТЕВЫХ ТОЧЕК (ОБОРУДОВАНИЕ)
 */
if ($type === 'network_points') {
    $query = "SELECT 
                network_points.id,
                network_points.label,
                network_point_type.display_name AS type_name,
                network_points.location,
                network_point_status.display_name AS status_name,
                network_points.last_check,
                network_points.point_created_at,
                network_points.image_name
            FROM network_points
            LEFT JOIN network_point_type ON network_points.type = network_point_type.id
            LEFT JOIN network_point_status ON network_points.status = network_point_status.id
            ORDER BY network_points.id";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $headers = ['ID', 'Метка', 'Тип', 'Расположение', 'Статус', 'Последняя проверка', 'Дата создания', 'Изображение'];
    
    $data = [];
    foreach ($result as $row) {
        $data[] = [
            $row['id'],
            $row['label'],
            $row['type_name'] ?? 'Не указан',
            $row['location'] ?? 'Не указано',
            $row['status_name'] ?? 'Не указан',
            $row['last_check'] ?? 'Не проверялось',
            date('d.m.Y H:i:s', strtotime($row['point_created_at'])),
            $row['image_name'] ?? '-'
        ];
    }
    
    exportToCSV($data, $headers, 'network_points');
}

/**
 * ЭКСПОРТ РАСХОДА МАТЕРИАЛОВ
 */
if ($type === 'material_usage') {
    $query = "SELECT 
                material_usage.id,
                materials.name AS material_name,
                material_type.display_name AS material_type,
                material_usage.quantity,
                materials.unit,
                network_points.label AS point_label,
                network_points.location AS point_location,
                users.login AS used_by_login,
                material_usage.used_at,
                material_usage.comment,
                defects.id AS defect_id,
                defects.description AS defect_description,
                defects.status AS defect_status
            FROM material_usage
            LEFT JOIN materials ON material_usage.material_id = materials.id
            LEFT JOIN material_type ON materials.type = material_type.id
            LEFT JOIN network_points ON material_usage.point_id = network_points.id
            LEFT JOIN users ON material_usage.used_by = users.id
            LEFT JOIN defects ON material_usage.defect_id = defects.id
            ORDER BY material_usage.used_at DESC";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $headers = [
        'ID расхода',
        'Материал',
        'Тип материала',
        'Количество',
        'Единица измерения',
        'Точка сети',
        'Локация точки',
        'Кто использовал',
        'Дата использования',
        'Комментарий',
        'ID дефекта',
        'Описание дефекта',
        'Статус дефекта'
    ];
    
    $data = [];
    foreach ($result as $row) {
        $unit_rus = ($row['unit'] == 'm') ? 'метров' : 'штук';
        
        $defectStatusMap = [
            'open' => 'Открыт',
            'in_progress' => 'В работе',
            'closed' => 'Закрыт'
        ];
        
        $data[] = [
            $row['id'],
            $row['material_name'] ?? 'Не указан',
            $row['material_type'] ?? '-',
            $row['quantity'],
            $unit_rus,
            $row['point_label'] ?? '-',
            $row['point_location'] ?? '-',
            $row['used_by_login'] ?? 'Система',
            date('d.m.Y H:i:s', strtotime($row['used_at'])),
            $row['comment'] ?? '-',
            $row['defect_id'] ?? '-',
            $row['defect_description'] ? mb_substr($row['defect_description'], 0, 100) . (mb_strlen($row['defect_description']) > 100 ? '...' : '') : '-',
            $defectStatusMap[$row['defect_status']] ?? '-'
        ];
    }
    
    exportToCSV($data, $headers, 'material_usage');
}
?>