<!DOCTYPE html>
<html lang="en-us">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Cars</title>
   
    <link rel="shortcut icon" href="{{asset('Games/Cars/TemplateData/favicon.ico')}}">
    <link rel="stylesheet" href="{{asset('Games/Cars/TemplateData/style.css')}}">
    <script src="{{asset('Games/Cars/TemplateData/UnityProgress.js')}}"></script>
    <script src="{{asset('Games/Cars/Build/UnityLoader.js')}}"></script>
    <script>
      var unityInstance = UnityLoader.instantiate("unityContainer", "{{asset('Games/Cars/Build/Cars.json')}}", {onProgress: UnityProgress});
    </script>

<script>
  const token = @json($token);
  const nickname = @json($nickname);
  const base_url = @json($base_url);
  const name_sala = @json($name_sala);
  const data = JSON.stringify({ token, nickname, name_sala, base_url });

  function unityReady() {
    console.log("Unity is ready, sending data...");
    unityInstance.SendMessage('Scripts', 'ReceiveToken', data);
  }
</script>
  </head>
  <body>
    <div class="webgl-content">
      <div id="unityContainer" style="width: 960px; height: 600px"></div>
    
    </div>
  </body>
</html>
