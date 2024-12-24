@extends('voyager::master') @section('page_title', 'Todo') @section('content')


<div class="page-content container-fluid">
    Configuración de referidos
   
    <div class="row  justify-center items-center">
        <div class="col-md-6 col-12 text-center ">
            @if(isset($configuracion_referidos['id_game']))
            <form action="{{route($configuracion_referidos['ruta'],['id'=>$configuracion_referidos['id_game']])}}" method="POST" class="p-4">
            @else
            <form action="{{route($configuracion_referidos['ruta'])}}" method="POST" class="p-4">
            @endif
           
                @csrf
                <div class="mb-3">
                    <h5>Formulario dinámico con <span id="nivelLabel">{{ $configuracion_referidos['nivel'] }}</span> niveles </h5>
                </div>
            
                <div class="mb-3">
                    <label for="nivel" class="form-label">Nivel</label>
                    <input type="number" class="form-control" id="nivel" name="nivel" value="{{ $configuracion_referidos['nivel'] }}" min="1">
                </div>
            
                <div id="inputsContainer">
                    @for ($i = 0; $i < $configuracion_referidos['nivel']; $i++)
                        <div class="mb-3">
                            <label for="input{{ $i }}" class="form-label">Valor de porcentaje en nivel {{ $i + 1 }}</label>
                            <input type="text" class="form-control" id="input{{ $i }}" name="parametros[]" value="{{ $configuracion_referidos['parametros'][$i] ?? 0 }}">
                        </div>
                    @endfor
                </div>
            
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
            
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const nivelInput = document.getElementById('nivel');
                    const inputsContainer = document.getElementById('inputsContainer');
                    const nivelLabel = document.getElementById('nivelLabel');
            
                    nivelInput.addEventListener('input', function () {
                        const nivel = parseInt(nivelInput.value);
                        nivelLabel.textContent = nivel;
            
                        // Limpiamos el contenedor de inputs
                        inputsContainer.innerHTML = '';
            
                        // Generamos los nuevos inputs según el valor de nivel
                        for (let i = 0; i < nivel; i++) {
                            const div = document.createElement('div');
                            div.classList.add('mb-3');
            
                            const label = document.createElement('label');
                            label.classList.add('form-label');
                            label.setAttribute('for', `input${i}`);
                            label.textContent = `Parámetro ${i + 1}`;
            
                            const input = document.createElement('input');
                            input.type = 'text';
                            input.classList.add('form-control');
                            input.id = `input${i}`;
                            input.name = 'parametros[]';
                            input.value = '0';
            
                            div.appendChild(label);
                            div.appendChild(input);
                            inputsContainer.appendChild(div);
                        }
                    });
                });
            </script>
        </div>
       
    </div>
</div>

@endsection