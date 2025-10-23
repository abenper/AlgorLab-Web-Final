<?php
// ./php/subirEntrega.php

function subirTarea()
{
    include_once './inc/session_start.php';
    include_once './php/main.php';
    $pdo = conexion();

    if (!isset($_SESSION['usuario_id'])) {
        header('Location: index.php?vista=login');
        exit;
    }

    $alumno_id = $_SESSION['usuario_id'];

    if (!isset($_POST['tarea_id']) || !is_numeric($_POST['tarea_id'])) {
        die('ID de tarea inválido.');
    }

    if (!isset($_FILES['archivo']) || $_FILES['archivo']['error'] !== UPLOAD_ERR_OK) {
        die('Error al subir el archivo.');
    }

    $tarea_id = intval($_POST['tarea_id']);
    $archivo = $_FILES['archivo'];
    $tipo = mime_content_type($archivo['tmp_name']);

    if ($tipo !== 'application/pdf') {
        die('Solo se permiten archivos PDF.');
    }

    $carpeta = __DIR__ . '/../entregas/';
    if (!is_dir($carpeta)) {
        mkdir($carpeta, 0775, true);
    }

    $nombreArchivo = 'entrega_' . $alumno_id . '_' . $tarea_id . '_' . time() . '.pdf';
    $rutaDestino = $carpeta . $nombreArchivo;

    if (!move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
        die('No se pudo guardar el archivo.');
    }

    try {
        $stmt = $pdo->prepare("
            INSERT INTO entregas (tarea_id, alumno_id, fecha_entrega, url_archivo)
            VALUES (:tarea_id, :alumno_id, NOW(), :url_archivo)
            ON DUPLICATE KEY UPDATE 
                fecha_entrega = NOW(),
                url_archivo = VALUES(url_archivo),
                estado = 'No corregida',
                observacion_profesor = NULL
        ");

        $stmt->execute([
            ':tarea_id' => $tarea_id,
            ':alumno_id' => $alumno_id,
            ':url_archivo' => 'entregas/' . $nombreArchivo
        ]);

        // Redirigir al curso tras entregar
        $stmtCurso = $pdo->prepare("SELECT curso_id FROM tareas WHERE id = :id");
        $stmtCurso->execute([':id' => $tarea_id]);
        $curso_id = $stmtCurso->fetchColumn();

        if (!$curso_id) {
            die("No se pudo obtener el curso.");
        }

        header("Location: index.php?vista=asignatura&id=$curso_id");
        exit;
    } catch (PDOException $e) {
        die('Error al guardar en la base de datos: ' . $e->getMessage());
    }
}