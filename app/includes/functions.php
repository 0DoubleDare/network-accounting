<?php
/**
 * Функции для всего проекта
 */


$root_path = dirname(__DIR__, 2);
define('ROOT_PATH', $root_path);
require ROOT_PATH . '/config/db.php';


if (!function_exists('checkAuthorizedUser')) {
    function checkAuthorizedUser($pdo, $login, $password)
    {
        try {
            $sql = "SELECT id, login, password_hash, role FROM users WHERE login = :login";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':login', $login);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if (md5($password) == $user['password_hash']) {
                    return [
                        'user_id' => $user['id'],
                        'role' => $user['role'],
                        'login' => $login,
                    ];
                }
            }
            return null;
        } catch (PDOException $e) {
            error_log("checkAuthorizedUser error: " . $e->getMessage());
            return null;
        }
    }
}

// функция тимура - для сессии
if (!function_exists('getError')) {
    function getError()
    {
        if (isset($_SESSION['error'])) {
            $error = $_SESSION['error'];
            unset($_SESSION['error']);
            return $error;
        }
        return null;
    }
}

// функция тимура - для сессии
if (!function_exists('getMessage')) {
    function getMessage()
    {
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            unset($_SESSION['message']);
            return $message;
        }
        return null;
    }
}

// функция тимура - регистрация
if (!function_exists('checkUserExists')) {
    function checkUserExists($pdo, $login)
    {
        try {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE login = :login");
            $stmt->execute([':login' => $login]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("checkUserExists error: " . $e->getMessage());
            return false;
        }
    }
}

// функция тимура - регистрация
if (!function_exists('registerUser')) {
    function registerUser($pdo, $login, $password_hash)
    {
        try {
            $stmt = $pdo->prepare("INSERT INTO users (login, password_hash, role) VALUES (:login, :password_hash, 'operator')");
            $stmt->execute([
                ':login' => $login,
                ':password_hash' => $password_hash
            ]);
            return $response = [
                'id' => $pdo->lastInsertId(),
                'login' => $login,
                'role' => 'operator'
            ];
        } catch (PDOException $e) {
            error_log("Register error: " . $e->getMessage());
            return false;
        }
    }
}

//Таблица инвентарь 
function getAllInventory($pdo)
{
    try {
        $sql = "SELECT
            np.id,
            np.label,
            np.location,
            np.last_check,
            np.point_created_at,
            np.image_path,
            npt.display_name AS type,
            nps.display_name AS status
        FROM network_points np
                 LEFT JOIN network_point_type npt
                           ON np.type = npt.id
                 LEFT JOIN network_point_status nps
                           ON np.status = nps.id;
";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $points = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $points;
    } catch (PDOException $error) {
        error_log("Error: " . $error->getMessage());
    }
}

//Получение данные одной конкретной точки по её ID
function getIDDefects($pdo, $point_id)
{
    try {
        $sql = "
            SELECT
                network_points.*,
                network_point_status.display_name AS status_name
            FROM `network_points`
                     LEFT JOIN `network_point_status` ON network_points.status = network_point_status.id
            WHERE network_points.id = :point_id
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':point_id' => $point_id]);
        $point = $stmt->fetch(PDO::FETCH_ASSOC);
        return $point;
    } catch (PDOException $error) {
        error_log("Error: " . $error->getMessage());
        return null;
    }
}

//Для получения всех дефектов конкретной точки
function getAllDefects($pdo, $point_id)
{
    try {
        $sql = "
SELECT
            defects.id,
            defects.category,
            defects.severity,
            defects.description,
            defects.status,
            defects.created_by,
            defects.created_at,
            defects.image_path,
            users.login AS author,
            network_points.label AS point_label
        FROM defects
        LEFT JOIN users ON defects.created_by = users.id
        LEFT JOIN network_points ON defects.point_id = network_points.id
        WHERE defects.point_id = :point_id
        ORDER BY defects.created_at DESC
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':point_id' => $point_id]);
        $defects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $defects;
    } catch (PDOException $error) {
        error_log("Error: " . $error->getMessage());
        return [];
    }
}

// Запись лога в журнал действий
function addLog($pdo, $user_id, $action, $target_table, $target_id = null)
{
    try {
        $stmt = $pdo->prepare("INSERT INTO logs (user_id, action, target_table, target_id) VALUES (:user_id, :action, :target_table, :target_id)");
        $stmt->execute([
            ':user_id' => $user_id,
            ':action' => $action,
            ':target_table' => $target_table,
            ':target_id' => $target_id
        ]);
        return true;
    } catch (PDOException $e) {
        error_log("Log insert error: " . $e->getMessage());
        return false;
    }
}

// Запись лога о входе в систему
function addLoginLog($pdo, $user_id, $role)
{
    return addLog($pdo, $user_id, 'Вход в систему (роль: ' . $role . ')', 'users', $user_id);
}

// Запись лога о регистрации
function addRegistrationLog($pdo, $user_id)
{
    return addLog($pdo, $user_id, 'Регистрация нового пользователя (роль: operator)', 'users', $user_id);
}

function uploudImage($image, $uploadDir = '..\public\storage\network_points')
{
    $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
    $filename = uniqid('', true) . '.' . $extension;
    $fullPath = $uploadDir . $filename;

    move_uploaded_file($image['tmp_name'], $fullPath);

    return $filename;
}


function insertNetvorkPoint($pdo, $label, $type, $location, $status, $file)
{
    $image_path = uploudImage($file);
    $sql = "INSERT INTO network_points (`label`, `type`, `location`, `status`, `image_path`) VALUES (:label, :type, :location, :status, :image_path)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'label' => $label,
        'type' => $type,
        'location' => $location,
        'status' => $status,
        'image_path' => $image_path
    ]);
    $response = [
        'id' => $pdo->lastInsertId(),
        'image_path' => $image_path
    ];
    return $response;
}

function deleteNetworkPoint($pdo, $id)
{
    $sql = "DELETE FROM `network_points` WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
}

function updateNetworkPoint($pdo, $id, $label, $type, $location, $status, $file)
{
    $image_path = uploudImage($file);
    $sql = "UPDATE `network_points` SET label=:label, type=:type, location=:location, status=:status, image_path=:image_path WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        'id' => $id,
        'label' => $label,
        'type' => $type,
        'location' => $location,
        'status' => $status,
        'image_path' => $image_path]);
}

function networkPointInfo($pdo, $id)
{
    $sql = "SELECT * FROM `network_points` WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// функция плагинации для логов
function getAllLogsFiltered($pdo, $page = 1, $perPage = 20, $filters = [])
{
    $offset = ($page - 1) * $perPage;
    $where = [];
    $params = [];
    // Фильтр по ID пользователя
    if (!empty($filters['user_id'])) {
        $where[] = "logs.user_id = :user_id";
        $params[':user_id'] = $filters['user_id'];
    }
    // Фильтр по роли
    if (!empty($filters['role'])) {
        $where[] = "users.role = :role";
        $params[':role'] = $filters['role'];
    }
    // Фильтр по действию (поиск по части строки)
    if (!empty($filters['action'])) {
        $where[] = "logs.action LIKE :action";
        $params[':action'] = '%' . $filters['action'] . '%';
    }
    // Фильтр по названию таблицы
    if (!empty($filters['target_table'])) {
        $where[] = "logs.target_table = :target_table";
        $params[':target_table'] = $filters['target_table'];
    }
    // Фильтр по дате (с какой даты)
    if (!empty($filters['date_from'])) {
        $where[] = "DATE(logs.created_at) >= :date_from";
        $params[':date_from'] = $filters['date_from'];
    }
    // Фильтр по дате (по какую дату)
    if (!empty($filters['date_to'])) {
        $where[] = "DATE(logs.created_at) <= :date_to";
        $params[':date_to'] = $filters['date_to'];
    }
    $whereClause = $where ? "WHERE " . implode(" AND ", $where) : "";
    // Подсчёт общего количества записей (для пагинации)
    $countSql = "SELECT COUNT(*) FROM logs $whereClause";
    $countStmt = $pdo->prepare($countSql);
    $countStmt->execute($params);
    $total = $countStmt->fetchColumn();

    $sql = "SELECT logs.*, users.login, users.role 
            FROM logs 
            LEFT JOIN users ON logs.user_id = users.id 
            $whereClause
            ORDER BY logs.created_at DESC 
            LIMIT $offset, $perPage";

    $stmt = $pdo->prepare($sql);

    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->execute();
    return [
        'logs' => $stmt->fetchAll(),           // Список логов
        'total' => $total,                      // Всего записей
        'page' => $page,                        // Текущая страница
        'perPage' => $perPage,                  // Записей на странице
        'totalPages' => ceil($total / $perPage) // Всего страниц
    ];
}

// Функция получения списка пользователей для фильтра
function getLogUsers($pdo)
{
    $sql = "SELECT DISTINCT users.id, users.login 
            FROM logs 
            LEFT JOIN users ON logs.user_id = users.id 
            WHERE users.id IS NOT NULL 
            ORDER BY users.login";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Функция получения списка действий для фильтра
function getLogActions($pdo)
{
    $sql = "SELECT DISTINCT action FROM logs ORDER BY action";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

// Функция получения списка таблиц для фильтра
function getLogTables($pdo)
{
    $sql = "SELECT DISTINCT target_table FROM logs WHERE target_table IS NOT NULL ORDER BY target_table";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

// Функция получения списка ролей для фильтра
function getLogRoles($pdo)
{
    $sql = "SELECT DISTINCT users.role 
            FROM logs 
            LEFT JOIN users ON logs.user_id = users.id 
            WHERE users.role IS NOT NULL 
            ORDER BY users.role";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

//Фильтрация для defect
function getDefectsWithFilter($pdo, $point_id, $filter, $limit, $offset) {
    $sql = "SELECT
        defects.id,
        defects.category,
        defects.severity,
        defects.description,
        defects.status,
        defects.created_by,
        defects.created_at,
        defects.image_path,
        users.login AS author,
        network_points.label AS point_label
    FROM defects
    LEFT JOIN users ON defects.created_by = users.id
    LEFT JOIN network_points ON defects.point_id = network_points.id
    WHERE defects.point_id = $point_id $filter
    ORDER BY defects.created_at DESC
    LIMIT $limit OFFSET $offset";
}

/**
 * Получение списка типов материала
 */
function getMaterialTypeList($pdo)
{
    $sql = "SELECT * FROM material_type";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Получение списка статусов сетевой точки
 */
function getNetworkPointStatusList($pdo)
{
    $sql = "SELECT * FROM network_point_status";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Получение списка типов сетевой точки
 */
function getNetworkPointTypeList($pdo)
{
    $sql = "SELECT * FROM network_point_type";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllMaterials($pdo)
{
    try {
        $sql = "SELECT m.*, mt.display_name as type_name 
                FROM materials m 
                LEFT JOIN material_type mt ON m.type = mt.id 
                ORDER BY m.id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("getAllMaterials error: " . $e->getMessage());
        return [];
    }
}
// функция фильтрации для материалов
function getMaterialUnits($pdo)
{
    try {
        $sql = "SELECT DISTINCT unit FROM materials ORDER BY unit";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    } catch (PDOException $e) {
        error_log("getMaterialUnits error: " . $e->getMessage());
        return [];
    }
}
// функция плагинации для материалов
function getAllMaterialsFiltered($pdo, $page = 1, $perPage = 10, $filters = [])
{
    $offset = ($page - 1) * $perPage;
    $where = [];
    $params = [];
    // Фильтр по названию (поиск)
    if (!empty($filters['name'])) {
        $where[] = "m.name LIKE :name";
        $params[':name'] = '%' . $filters['name'] . '%';
    }
    // Фильтр по типу
    if (!empty($filters['type'])) {
        $where[] = "m.type = :type";
        $params[':type'] = $filters['type'];
    }
    // Фильтр по единице измерения
    if (!empty($filters['unit'])) {
        $where[] = "m.unit = :unit";
        $params[':unit'] = $filters['unit'];
    }

    $whereClause = $where ? "WHERE " . implode(" AND ", $where) : "";
    // Подсчёт общего количества записей
    $countSql = "SELECT COUNT(*) FROM materials m $whereClause";
    $countStmt = $pdo->prepare($countSql);
    
    foreach ($params as $key => $value) {
        $countStmt->bindValue($key, $value);
    }
    $countStmt->execute();
    $total = $countStmt->fetchColumn();
    // Основной запрос
    $sql = "SELECT m.*, mt.display_name as type_name 
            FROM materials m 
            LEFT JOIN material_type mt ON m.type = mt.id 
            $whereClause
            ORDER BY m.id 
            LIMIT $offset, $perPage";

    $stmt = $pdo->prepare($sql);

    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->execute();
    return [
        'materials' => $stmt->fetchAll(),
        'total' => $total,
        'page' => $page,
        'perPage' => $perPage,
        'totalPages' => ceil($total / $perPage)
    ];
}
?>