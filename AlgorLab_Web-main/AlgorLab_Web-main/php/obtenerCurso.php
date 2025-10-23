<?php
/*
./php/obtenerCurso.php
*/
include_once './php/main.php';

function obtenerCurso($id) {
    $pdo = conexion();
    $stmt = $pdo->prepare("SELECT id, nombre FROM cursos WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function obtenerTareasPorCurso($curso_id) {
    $pdo = conexion();
    $alumno_id = $_SESSION['usuario_id'];

    $stmt = $pdo->prepare("
        SELECT t.id, t.titulo, t.descripcion, t.fecha_entrega,
               e.estado AS estado_entrega, e.url_archivo, e.observacion_profesor
        FROM tareas t
        LEFT JOIN entregas e ON e.tarea_id = t.id AND e.alumno_id = ?
        WHERE t.curso_id = ?
    ");
    $stmt->execute([$alumno_id, $curso_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}