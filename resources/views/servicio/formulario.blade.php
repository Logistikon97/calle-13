    <div style="display:flex; justify-content:space-between; flex-wrap: wrap; align-content: space-around;">
    <div class="mb-3">
        <label for="abonado" class="form-label">abonado</label>
        <input required type="text" class="form-control" id="abonado" name="abonado" aria-describedby="abonadoHelp" value="{{isset($datos->abonado)?$datos->abonado:''}}">
        <div id="abonadoHelp" class="form-text ">Algo como 86345828</div>
    </div>
    <div class="mb-3">
        <label for="liston" class="form-label">Listón</label>
        <input required type="text" class="form-control" id="liston" name="liston" aria-describedby="listonHelp" value="{{isset($datos)?$datos->liston:''}}">
        <div id="listonHelp" class="form-text">Algo como 0102-3</div>
    </div>
    @if (isset($datos))
    <div class="mb-3">
        <label for="puertos" class="form-label">Puertos</label>
        <input required type="text" class="form-control" id="puertos" name="puertos" value="{{isset($datos)?$datos->puertos:''}}">
    </div>
    @else
    <div class="mb-3">
        <label for="pots" class="form-label">POTS</label>
        <input required type="text" class="form-control" id="pots" name="pots">
    </div>
    <div class="mb-3">
        <label for="adsl" class="form-label">ADSL</label>
        <input required type="text" class="form-control" id="adsl" name="adsl">
    </div>
   
    </div>
    
    <div class="mb-3">
        <label for="dslam" class="form-label">DSLAM</label>
        <select class="form-select" name="dslam" id="dslam">
            <option selected disabled>Elige un dslam</option>
            <option value="19.2">10.33.19.2</option>
            <option value="19.6">10.33.19.6</option>
            <option value="19.22">10.33.19.22</option>
            <option value="19.34">10.33.19.34</option>
            <option value="19.54">10.33.19.54</option>
            <option value="19.66">10.33.19.66</option>
            <option value="14.131">10.34.14.131</option>
        </select>
    </div>
    @endif
    
    <div class="mb-3 ">
        <label for="tecnico" class="form-label">Técnico que atiende</label>
        <select class="form-select" name="tecnico" id="tecnico" required>
            <option value="1" selected>FABIAN FONSECA</option>
            <option value="2">DANIEL CHACÓN</option>
            <option value="3">DIEGO DELGADO</option>
            <option value="4">JHONY ULLOQUE</option>
            <option value="5">CARLOS ARAQUE</option>
            <option value="6">IVAN BARRERA</option>
        </select>
    </div>
    <div class="mb-3">
      <label for="comentarios" class="form-label">Comentarios</label>
      <textarea class="form-control" name="comentarios" id="comentarios" rows="3" placeholder="Escriba un comentario si es necesario" >{{isset($datos->comentarios)?$datos->comentarios:''}}</textarea>
    </div>
    <input type="hidden" name="islast" value="1">
    <div class="m-auto">
    <button type="submit" class="btn btn-primary ">Guardar</button>
    </div>