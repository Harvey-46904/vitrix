<!DOCTYPE html>
<html lang="en-us">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Unity WebGL Player | New Unity Project</title>
    <link rel="shortcut icon" href="Games/Cars/TemplateData/favicon.ico">
    <link rel="stylesheet" href="Games/Cars/TemplateData/style.css">
    <script src="Games/Cars/TemplateData/UnityProgress.js"></script>
    <script src="Games/Cars/Build/UnityLoader.js"></script>
    <script>
      var unityInstance = UnityLoader.instantiate("unityContainer", "Games/Cars/Build/Cars.json", {onProgress: UnityProgress});
    </script>
  </head>
  <body>
    <div class="webgl-content">
      <div id="unityContainer" style="width: 960px; height: 600px"></div>
    
    </div>
  </body>
</html>
