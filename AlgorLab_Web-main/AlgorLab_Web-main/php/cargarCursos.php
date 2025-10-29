<?php
include_once './inc/session_start.php';
include_once './php/main.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php?vista=login');
    exit;
}

$pdo = conexion();
$usuario_id = $_SESSION['usuario_id'];

// Obtener cursos del usuario
$sql = "SELECT c.id, c.nombre
        FROM cursos c
        INNER JOIN usuarios_cursos uc ON c.id = uc.curso_id
        WHERE uc.usuario_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$usuario_id]);
$cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Comprobar si hay tareas pendientes en cada curso
$tareasPendientes = [];

$sqlPendientes = "
    SELECT COUNT(*) as cantidad
    FROM tareas t
    LEFT JOIN entregas e ON t.id = e.tarea_id AND e.alumno_id = ?
    WHERE t.curso_id = ? AND (e.id IS NULL OR e.estado = 'No corregida')
";

$stmtPendientes = $pdo->prepare($sqlPendientes);

foreach ($cursos as $curso) {
    $stmtPendientes->execute([$usuario_id, $curso['id']]);
    $resultado = $stmtPendientes->fetch(PDO::FETCH_ASSOC);
    $tareasPendientes[$curso['id']] = $resultado['cantidad'];
}
