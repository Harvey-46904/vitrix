<!DOCTYPE html>
<html lang="en-us">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Vitrix | Navial</title>
    <link rel="shortcut icon" href="TemplateData/favicon.ico">
    <link rel="stylesheet" href="Games/Navial/TemplateData/style.css">
    <style>
      body {
        margin: 0;
        overflow: hidden;
        font-family: Arial, sans-serif;
        background-color: #231f20; /* Fondo oscuro */
      }
      #loading-screen {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #231f20; /* Fondo oscuro */
        color: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 9999;
      }
      #loading-screen h1 {
        font-size: 2rem;
        margin: 20px 0;
      }
      #loading-screen p {
        font-size: 1.2rem;
        margin-bottom: 20px;
      }
      #loading-screen .spinner {
        width: 50px;
        height: 50px;
        border: 5px solid rgba(255, 255, 255, 0.3);
        border-top-color: white;
        border-radius: 50%;
        animation: spin 1s linear infinite;
      }
      @keyframes spin {
        to {
          transform: rotate(360deg);
        }
      }
    </style>
  </head>
  <body>

    <!-- Pantalla de carga personalizada -->
    <div id="loading-screen">
      <h1>Cargando el Juego...</h1>
      <p>Vitrix esta preparando todo para ti.</p>
      <div class="spinner"></div>
    </div>

    <!-- Contenedor del juego Unity -->
    <div id="unity-container" class="unity-desktop">
      <canvas id="unity-canvas" width=960 height=600 tabindex="-1"></canvas>
      <div id="unity-loading-bar">
        <div id="unity-logo"></div>
        <div id="unity-progress-bar-empty">
          <div id="unity-progress-bar-full"></div>
        </div>
      </div>
      <div id="unity-warning"></div>
    </div>

    <script>
        var canvas = document.querySelector("#unity-canvas");
        const loadingScreen = document.getElementById("loading-screen");
        const unityContainer = document.getElementById("unity-container");


        var buildUrl = "Games/Navial/Build";
        var loaderUrl = buildUrl + "/naves.loader.js";
        var config = {
          arguments: [],
          dataUrl: buildUrl + "/naves.data",
          frameworkUrl: buildUrl + "/naves.framework.js",
          codeUrl: buildUrl + "/naves.wasm",
          streamingAssetsUrl: "StreamingAssets",
          companyName: "DefaultCompany",
          productName: "navejitana",
          productVersion: "1.0",
          showBanner: unityShowBanner,
        };
        
        function unityShowBanner(msg, type) {
        const warningBanner = document.querySelector("#unity-warning");
        const div = document.createElement("div");
        div.innerHTML = msg;
        warningBanner.appendChild(div);
        if (type === "error") div.style = "background: red; padding: 10px;";
        else if (type === "warning") div.style = "background: yellow; padding: 10px;";
        setTimeout(() => {
          warningBanner.removeChild(div);
        }, 5000);
      }

      document.querySelector("#unity-loading-bar").style.display = "block";

      const script = document.createElement("script");
      script.src = loaderUrl;
      script.onload = () => {
        createUnityInstance(canvas, config, (progress) => {
          document.querySelector("#unity-progress-bar-full").style.width = 100 * progress + "%";
        })
          .then((unityInstance) => {
            document.querySelector("#unity-loading-bar").style.display = "none";
            loadingScreen.style.display = "none"; // Ocultar pantalla de carga personalizada
            unityContainer.style.display = "block"; // Mostrar Unity
            unityInstance.SetFullscreen(1);
          })
          .catch((message) => {
            alert(message);
          });
      };
      document.body.appendChild(script);
      </script>
  </body>
</html>
