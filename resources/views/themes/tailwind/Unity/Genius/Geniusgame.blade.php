@extends('theme::layouts.app')

@section('content')
<style>
     #unity-container {
            position: relative;
            width: 100%;
            height: 100%;
            background: #231f20;
            overflow: hidden;
        }

        #unity-canvas {
            width: 100%;
            height: auto;
        }

        #unity-loading-bar {
            position: absolute;
            bottom: 10px;
            width: 100%;
        }

        #unity-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px 10px;
            color: #fff;
        }

        #unity-footer div {
            cursor: pointer;
        }
    </style>
</style>
<div class="pt-20 mx-auto prose text-center max-w-7xl">
    <div class="container text-light ">
        <div class="row">
            <div class="col-md-12 text-light">
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
                        <div id="unity-build-title">LampGenius</div>
                    </div>
                </div>
            </div>
        </div>



    </div>

</div>
<script>
    var canvas = document.querySelector("#unity-canvas");

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

    var buildUrl = "Games/Build";
    var loaderUrl = buildUrl + "/genius.loader.js";
    var config = {
      arguments: [],
      dataUrl: buildUrl + "/genius.data",
      frameworkUrl: buildUrl + "/genius.framework.js",
      codeUrl: buildUrl + "/genius.wasm",
      streamingAssetsUrl: "StreamingAssets",
      companyName: "DefaultCompany",
      productName: "LampGenius",
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
@endsection