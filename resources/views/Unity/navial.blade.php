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
  
      
        function unityShowBanner(msg, type) {
          var warningBanner = document.querySelector("#unity-warning");
          function updateBannerVisibility() {
            warningBanner.style.display = warningBanner.children.length ? 'block' : 'none';
          }
          var div = document.createElement('div');
          div.innerHTML = msg;
          warningBanner.appendChild(div);
          if (type == 'error') div.style = 'background: red; padding: 10px;';
          else {
            if (type == 'warning') div.style = 'background: yellow; padding: 10px;';
            setTimeout(function() {
              warningBanner.removeChild(div);
              updateBannerVisibility();
            }, 5000);
          }
          updateBannerVisibility();
        }
  
        var buildUrl = "Games/Navial/Build";
        var loaderUrl = buildUrl + "/naves.loader.js";
        var config = {
          arguments: [],
          dataUrl: buildUrl + "/naves.data.br",
          frameworkUrl: buildUrl + "/naves.framework.js.br",
          codeUrl: buildUrl + "/naves.wasm.br",
          streamingAssetsUrl: "StreamingAssets",
          companyName: "DefaultCompany",
          productName: "navejitana",
          productVersion: "1.0",
          showBanner: unityShowBanner,
        };
  
        // By default, Unity keeps WebGL canvas render target size matched with
        // the DOM size of the canvas element (scaled by window.devicePixelRatio)
        // Set this to false if you want to decouple this synchronization from
        // happening inside the engine, and you would instead like to size up
        // the canvas DOM size and WebGL render target sizes yourself.
        // config.matchWebGLToCanvasSize = false;
  
        if (/iPhone|iPad|iPod|Android/i.test(navigator.userAgent)) {
          // Mobile device style: fill the whole browser client area with the game canvas:
  
          var meta = document.createElement('meta');
          meta.name = 'viewport';
          meta.content = 'width=device-width, height=device-height, initial-scale=1.0, user-scalable=no, shrink-to-fit=yes';
          document.getElementsByTagName('head')[0].appendChild(meta);
          document.querySelector("#unity-container").className = "unity-mobile";
          canvas.className = "unity-mobile";
  
          // To lower canvas resolution on mobile devices to gain some
          // performance, uncomment the following line:
          // config.devicePixelRatio = 1;
  
  
        } else {
          // Desktop style: Render the game canvas in a window that can be maximized to fullscreen:
          canvas.style.width = "960px";
          canvas.style.height = "600px";
        }
  
        document.querySelector("#unity-loading-bar").style.display = "block";
  
        var script = document.createElement("script");
        script.src = loaderUrl;
        script.onload = () => {
          createUnityInstance(canvas, config, (progress) => {
            document.querySelector("#unity-progress-bar-full").style.width = 100 * progress + "%";
                }).then((unityInstance) => {
                  document.querySelector("#unity-loading-bar").style.display = "none";
                  document.querySelector("#unity-fullscreen-button").onclick = () => {
                    unityInstance.SetFullscreen(1);
                  };
  
                }).catch((message) => {
                  alert(message);
                });
              };
  
        document.body.appendChild(script);
  
      </script>
  </body>
</html>
