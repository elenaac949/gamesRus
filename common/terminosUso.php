<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Términos y Condiciones - GamesRus</title>
    <link rel="stylesheet" href="/gamesRus/css/general.css">
    <style>
        body {
            font-family: "Poppins", sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: var(--color-fondo-claro);
            color: var(--color-violeta);
        }

        h1,
        h2 {
            color: var(--color-rosa);
        }

        h1 {
            font-size: 2.5em;
            text-align: center;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 1.8em;
            margin-top: 30px;
            margin-bottom: 10px;
        }

        p {
            font-size: 1em;
            margin-bottom: 15px;
        }

        a {
            color: var(--color-azul);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        a:hover {
            color: var(--color-celeste);
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: var(--color-texto-claro);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 0.9em;
            color: var(--color-violeta);
        }
    </style>
</head>

<body>
    <?php
    include './common/header.php';
    ?>
    <main class="container">
        <h1>Términos y Condiciones</h1>
        <p>Bienvenido a <strong>GamesRus</strong>. Al acceder y utilizar nuestro sitio web, aceptas cumplir con los siguientes términos y condiciones. Si no estás de acuerdo con alguno de estos términos, te recomendamos que no utilices nuestro sitio.</p>

        <h2>1. Uso del Sitio</h2>
        <p>El contenido de este sitio web es únicamente para fines informativos y de entretenimiento. No está permitido el uso comercial del contenido sin autorización previa por escrito de <strong>GamesRus</strong>.</p>

        <h2>2. Registro y Cuentas</h2>
        <p>Para acceder a ciertas funcionalidades del sitio, es posible que necesites registrarte y crear una cuenta. Eres responsable de mantener la confidencialidad de tu contraseña y de todas las actividades que ocurran bajo tu cuenta.</p>

        <h2>3. Propiedad Intelectual</h2>
        <p>Todos los derechos de propiedad intelectual del contenido del sitio (textos, imágenes, logotipos, diseño, etc.) son propiedad de <strong>GamesRus</strong> o de sus licenciantes. Queda prohibida la reproducción, distribución o modificación sin autorización expresa.</p>

        <h2>4. Compras y Pagos</h2>
        <p>Si realizas compras en nuestro sitio, aceptas proporcionar información precisa y completa. Nos reservamos el derecho de rechazar o cancelar pedidos en caso de errores en la información proporcionada.</p>

        <h2>5. Limitación de Responsabilidad</h2>
        <p><strong>GamesRus</strong> no se hace responsable de daños directos, indirectos, incidentales o consecuentes derivados del uso o la imposibilidad de uso del sitio web. El uso del sitio es bajo tu propio riesgo.</p>

        <h2>6. Enlaces a Terceros</h2>
        <p>Nuestro sitio puede contener enlaces a sitios web de terceros. No tenemos control sobre el contenido o las prácticas de privacidad de estos sitios y no asumimos responsabilidad por ellos.</p>

        <h2>7. Modificaciones</h2>
        <p>Nos reservamos el derecho de modificar estos términos y condiciones en cualquier momento. Los cambios entrarán en vigor inmediatamente después de su publicación en el sitio. Te recomendamos revisar periódicamente esta página para estar al tanto de las actualizaciones.</p>

        <h2>8. Ley Aplicable</h2>
        <p>Estos términos y condiciones se rigen por las leyes de [país o región]. Cualquier disputa relacionada con el uso de este sitio estará sujeta a la jurisdicción exclusiva de los tribunales de [ciudad o región].</p>

        <h2>9. Contacto</h2>
        <p>Si tienes alguna pregunta sobre estos términos y condiciones, puedes contactarnos a través de <a href="mailto:soporte@gamesrus.com">soporte@gamesrus.com</a>.</p>

        <div class="footer">
            <p>&copy; 2023 GamesRus. Todos los derechos reservados.</p>
        </div>
    </main>
    <?php
    include './common/footer.php';
    ?>
</body>

</html>