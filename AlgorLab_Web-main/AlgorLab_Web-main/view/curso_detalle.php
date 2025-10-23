<?php

// Recoger el parámetro 'curso' de la URL
$curso = $_GET['curso'] ?? 'java'; // Por defecto java si no hay parámetro

// Definimos los datos de cada curso en un array asociativo
$cursos = [
    'java' => [
        'titulo' => 'Curso de Java',
        'descripcion' => 'Aprende Java desde cero y construye aplicaciones robustas, móviles y empresariales.',
        'imagen' => 'img/curso-java.jpg',
        'temario' => [
            'Introducción a Java y entorno de desarrollo',
            'Variables, tipos de datos y operadores',
            'Estructuras de control (if, switch, loops)',
            'Programación orientada a objetos: clases, objetos, herencia',
            'Manejo de excepciones y colecciones',
            'Introducción a la programación concurrente y multihilo',
        ],
        'aprendizaje' => 'Dominarás la sintaxis básica y avanzada de Java, la programación orientada a objetos, y la creación de aplicaciones escalables y eficientes.',
    ],
    'csharp' => [
        'titulo' => 'Curso de C#',
        'descripcion' => 'Domina el desarrollo de aplicaciones de escritorio y videojuegos con C# y .NET.',
        'imagen' => 'img/curso-csharp.jpg',
        'temario' => [
            'Introducción a C# y Visual Studio',
            'Tipos de datos y estructuras básicas',
            'Programación orientada a objetos en C#',
            'Windows Forms y desarrollo de interfaces',
            'Acceso a bases de datos con Entity Framework',
            'Desarrollo de videojuegos con Unity',
        ],
        'aprendizaje' => 'Aprenderás a crear aplicaciones y videojuegos profesionales usando C# y la plataforma .NET.',
    ],
    'php' => [
        'titulo' => 'Curso de PHP',
        'descripcion' => 'Crea sitios web dinámicos y potentes con PHP y bases de datos MySQL.',
        'imagen' => 'img/curso-php.jpg',
        'temario' => [
            'Introducción a PHP y configuración del servidor',
            'Sintaxis básica y estructuras de control',
            'Programación orientada a objetos en PHP',
            'Manejo de formularios y validación',
            'Bases de datos MySQL con PDO',
            'Construcción de aplicaciones web completas',
        ],
        'aprendizaje' => 'Sabrás desarrollar sitios web dinámicos y seguros con PHP y bases de datos.',
    ],
];

// Si no existe el curso solicitado, mostramos un error o redirigimos
if (!array_key_exists($curso, $cursos)) {
    echo "<p>Curso no encontrado.</p>";
    exit;
}

// Sacamos los datos del curso
$data = $cursos[$curso];
?>

<section class="container py-5">

    <!-- Botón para volver a cursos -->
    <div class="mb-4">
        <a href="index.php?vista=cursos" class="btn btn-outline-primary">
            Volver a cursos
        </a>
    </div>

    <div class="text-center mb-5">
        <h2 class="fw-bold"><?php echo htmlspecialchars($data['titulo']); ?></h2>
        <p class="text-primary"><?php echo htmlspecialchars($data['descripcion']); ?></p>
    </div>

    <div class="row g-4 align-items-center">
        <div class="col-md-6">
            <img src="<?php echo htmlspecialchars($data['imagen']); ?>" alt="<?php echo htmlspecialchars($data['titulo']); ?>" class="img-fluid rounded shadow">
        </div>
        <div class="col-md-6">
            <h3>Temario del curso</h3>
            <ul class="list-group list-group-flush mb-4">
                <?php foreach ($data['temario'] as $tema): ?>
                    <li class="list-group-item"><?php echo htmlspecialchars($tema); ?></li>
                <?php endforeach; ?>
            </ul>

            <h3>¿Qué aprenderás?</h3>
            <p><?php echo htmlspecialchars($data['aprendizaje']); ?></p>

            <div class="text-center">
                <a href="index.php?vista=contacta" class="btn btn-primary btn-lg">Solicitar Información</a>
            </div>
        </div>
    </div>
</section>