<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Abrir TronLink con botón</title>
</head>

<body>
  <button id="btnAbrirTronLink">Abrir TronLink</button>
  <script>
    document.getElementById("btnAbrirTronLink").addEventListener("click", function() {
      const params = {
        "url": "https://www.vitrix.io/", //target DApp
        "action": "open",
        "protocol": "tronlink",
        "version": "1.0"
      };


      const paramsbeta={
        "action": "open",
        "protocol": "tronlink",
        "version": "1.0"
      }
      const deepLink = "tronlinkoutside://pull.activity?param=" + encodeURIComponent(JSON.stringify(paramsbeta));
      window.location.href = deepLink;
    });
  </script>
</body>

</html>