<?php

function materialstId($pdo)
{
    $sql = "SELECT * FROM materials";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function pointId($pdo)
{
    $sql = "SELECT * FROM network_points";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function usedBy($pdo)
{
    $sql = "SELECT * FROM users";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertUsageMaterials($pdo, $material_id, $quantity, $point_id, $used_by, $comment)
{
    $sql = "INSERT INTO material_usage (material_id, quantity, point_id, used_by, comment) 
                VALUES (:material_id, :quantity, :point_id, :used_by, :comment)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'material_id' => $material_id,
        'quantity' => $quantity,
        'point_id' => $point_id,
        'used_by' => $used_by,
        'comment' => $comment
    ]);
    return ['id' => $pdo->lastInsertId()];
}

function checkMaterialIsUse($pdo, $material_id)
{
    $sql = "SELECT * FROM material_usage WHERE material_id = :material_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['material_id' => $material_id]);

    return $stmt->rowCount() > 0;
}