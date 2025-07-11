<!DOCTYPE html>
<html lang="en-us">

<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Vitrix Cars</title>

  <link rel="stylesheet" href="{{ asset('Games/Cars/TemplateData/favicon.ico') }}">
  <link rel="stylesheet" href="{{ asset('Games/Cars/TemplateData/style.css') }}">
</head>

<body>
  <div id="unity-container" class="unity-desktop">
    <canvas id="unity-canvas" width=960 height=600 tabindex="-1"></canvas>
    <div id="unity-loading-bar">
      <div id="unity-logo"></div>
      <div id="unity-progress-bar-empty">
        <div id="unity-progress-bar-full"></div>
      </div>
    </div>
    <div id="unity-warning"> </div>
    <div id="unity-footer">
      <div id="unity-logo-title-footer"></div>
      <div id="unity-fullscreen-button"></div>
      <div id="unity-build-title">New Unity Project</div>
    </div>
  </div>
  <script>
    var canvas = document.querySelector("#unity-canvas");
      const token = @json($token);
      const nickname = @json($nickname);
      const base_url = @json($base_url);
      const name_sala = @json($name_sala);
      const id_user = @json($userId);
      const id_sala = @json($id);
      const token_sala = @json($hash);
      
     
      const data = JSON.stringify({ token, nickname, name_sala, base_url,id_user,id_sala,token_sala});
      console.log(data);
      
      // Shows a temporary message banner/ribbon for a few seconds, or
      // a permanent error message on top of the canvas if type=='error'.
      // If type=='warning', a yellow highlight color is used.
      // Modify or remove this function to customize the visually presented
      // way that non-critical warnings and error messages are presented to the
      // user.
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

      var buildUrl = "{{ asset('Games/Cars/Build') }}";
      var loaderUrl = buildUrl + "/Cars.loader.js";
      var config = {
        arguments: [],
        dataUrl: buildUrl + "/Cars.data",
        frameworkUrl: buildUrl + "/Cars.framework.js",
        codeUrl: buildUrl + "/Cars.wasm",
        streamingAssetsUrl: "StreamingAssets",
        companyName: "DefaultCompany",
        productName: "New Unity Project",
        productVersion: "2.0.2-preview",
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
            // Hacer la instancia accesible globalmente
              window.unityInstance = unityInstance;
                unityInstance.SendMessage('Scripts', 'ReceiveToken', data);
                document.querySelector("#unity-loading-bar").style.display = "none";
                document.querySelector("#unity-fullscreen-button").onclick = () => {
                  unityInstance.SetFullscreen(1);
                };

              }).catch((message) => {
                alert(message);
              });
            };

            // Unity llamará esto desde C#
function unityReady() {
  console.log("Unity called unityReady()");
  if (window.unityInstance) {
    window.unityInstance.SendMessage('Scripts', 'ReceiveToken', data);
  } else {
    console.error("Unity instance not ready.");
  }
  
}
function cerrarVentanaJuego() {
        window.close();
    }

      document.body.appendChild(script);

  </script>
</body>

</html>