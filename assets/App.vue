<template xmlns="http://www.w3.org/1999/html">

  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Ella4Life</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01"
              aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
        <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked="">
        <label class="btn btn-outline-light" for="btnradio1">Tryb jasny</label>
        <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off" checked="">
        <label class="btn btn-outline-light" for="btnradio2">Tryb ciemny</label>
        <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off" checked="">
        <label class="btn btn-outline-light" for="btnradio3">Tryb kontrastowy</label>
      </div>
    </div>

  </nav>

  <div class="row">
    <div class="col-lg-11 mx-auto">
      <form>
        <div class="row mt-3">
          <div class="form-group col-lg-3">
            <h5 class="mb-2">Wybór pacjenta:</h5>
            <select class="form-select" id="exampleSelect1">
              <option>Imię Nazwisko</option>
              <option>Jan Kowalski</option>
              <option>Janina Kowalska</option>
              <option>Jan Nowak</option>
              <option>Janina Nowak</option>
              <option>Jan Wiśniewski</option>
            </select>
          </div>

          <div class="form-group col-lg-3">
            <div class="form-check">
              <h5 class="mb-1">Wybór rodzaju maty:</h5>
              <input class="form-check-input" type="radio" name="optionsRadios" id="optionsRadios1" value="option1"
                     checked="">
              <label class="form-check-label" for="optionsRadios1">
                eKrzesło
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
              <label class="form-check-label" for="optionsRadios2">
                eWanna
              </label>
            </div>
          </div>

          <div class="form-group col-lg-3">
            <h5 class="mb-2">Analiza danych od:</h5>
            <div class="row">
              <div class="col-lg-6">
                <input type="date" class="form-control" placeholder="Default input" id="inputDefault">
              </div>
              <div class="col-lg-6">
                <input type="time" class="form-control" placeholder="Default input" id="inputDefault">
              </div>
            </div>
          </div>

          <div class="form-group col-lg-3">
            <h5 class="mb-2">Analiza danych do:</h5>
            <div class="row">
              <div class="col-lg-6">
                <input type="date" class="form-control" placeholder="Default input" id="inputDefault">
              </div>
              <div class="col-lg-6">
                <input type="time" class="form-control" placeholder="Default input" id="inputDefault">
              </div>
            </div>
          </div>

        </div>
      </form>

      <div class="row">
        <form>
          <div class="row mt-5">
            <div class="form-group col-lg-3 mx-auto">
              <div class="card text-white bg-info mb-3" style="max-width: 14rem;">
                <div class="card-header text-center h5">Aktualne tętno</div>
                <div class="card-body">
                  <h4 class="card-title text-center">80</h4>
                </div>
              </div>
            </div>

            <div class="form-group col-lg-3 mx-auto">
              <div class="card text-white bg-info mb-3" style="max-width: 14rem;">
                <div class="card-header text-center h5">Maksymalne tętno</div>
                <div class="card-body">
                  <h4 class="card-title text text-center">90</h4>
                </div>
              </div>
            </div>

            <div class="form-group col-lg-3 mx-auto">
              <div class="card text-white bg-info mb-3" style="max-width: 14rem;">
                <div class="card-header text-center h5">Minimalne tętno</div>
                <div class="card-body">
                  <h4 class="card-title text-center">60</h4>
                </div>
              </div>
            </div>

            <div class="form-group col-lg-3 mx-auto">
              <div class="card text-white bg-info mb-3" style="max-width: 14rem;">
                <div class="card-header text-center h5">Średnie tętno</div>
                <div class="card-body">
                  <h4 class="card-title text-center">70</h4>
                </div>
              </div>
            </div>

          </div>
        </form>
      </div>
    </div>
  </div>

</template>

<script>
export default {
  name: "App"
}

</script>