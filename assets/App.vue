<template xmlns="http://www.w3.org/1999/html">
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid col-lg-12 mx-auto position">
        <a class="navbar-brand" id="ella" href="#">Ella4Life</a>
      <button type="button" id="btn1" class="btn btn-primary btn-lg">
        <a class="navbar-brand" id="ella" href="/logout">Wyloguj się</a>
      </button>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01"
                aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
    </div>
  </nav>

  <div class="row">
    <div class="col-lg-11 mx-auto">
      <form>
        <div class="row mt-3">

          <fieldset class="form-group col-lg-3" @input="handlePatientIdInput">
            <div class="form-group">
              <legend>Wybór pacjenta:</legend>
              <select class="form-select" id="exampleSelect1">
                <option> Imię Nazwisko </option>
                <option v-for="patient in patients" :value="patient.id">
                       {{ patient.name }} {{ patient.surname }}
                </option>
              </select>
            </div>
          </fieldset>

          <fieldset class="form-group col-lg-3" @input="handleMatInput">
            <div class="form-group">
              <legend>Wybór maty:</legend>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="optionsRadios" id="optionsRadios1" value="chair">
                <label class="form-check-label" for="optionsRadios1">
                  eKrzesło
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="optionsRadios" id="optionsRadios2" value="bathtub">
                <label class="form-check-label" for="optionsRadios2">
                  eWanna
                </label>
              </div>
            </div>
          </fieldset>

          <div class="form-group col-lg-3">
            <fieldset class="form-group">
              <legend>Analiza danych od:</legend>
              <div class="row">
                <div class="col-lg-6">
                  <input type="date" class="form-control" placeholder="Default input" id="inputDefault1" value="fromDay" @input="handleFromDayInput">
                </div>
                <div class="col-lg-6">
                  <input type="time" class="form-control" placeholder="Default input" id="inputDefault2" value="fromHour" @input="handleFromHourInput">
                </div>
              </div>
            </fieldset>
          </div>

          <div class="form-group col-lg-3">
            <fieldset class="form-group">
              <legend>Analiza danych do:</legend>
              <div class="row">
                <div class="col-lg-6">
                  <input type="date" class="form-control" placeholder="Default input" id="inputDefault3" value="toDay" @input="handleToDayInput">
                </div>
                <div class="col-lg-6">
                  <input type="time" class="form-control" placeholder="Default input" id="inputDefault4" value="toHour" @input="handleToHourInput">
                </div>
              </div>
            </fieldset>
          </div>
        </div>
      </form>


      <div class="row mt-4 mb-3">
        <div class="col-lg-3 mx-auto">
          <button type="button" v-on:click="analyse(); chartsHR.methods.showChart();" id="btn1" class="btn btn-primary btn-lg">Przeprowadź analizę danych</button>
        </div>
      </div>


      <div class="row mt-5">
        <form>
          <div class="row mb-3">
          <legend>WARTOŚĆ RYTMU SERCA:</legend>
          </div>
          <div class="row">
            <div class="form-group col-lg-3 mx-auto">
              <legend>Aktualna:</legend>
              <div class="card text-white bg-info mt-3 mb-3"  style="max-width: 16rem;">
                <div v-for="responseCurrentHr in currentHR" id="btn2" class="card-body">
                  <h4 class="card-title text-center">{{responseCurrentHr}}</h4>
                </div>
              </div>
            </div>

            <span class="d-link-block col-lg-3 mx-auto" tabindex="0" data-toggle="tooltip" title="Wartość wzorcowa: HRmax = 208 - 0,7*(wiek pacjenta)">
              <div class="form-group">
                <legend>Maksymalna:</legend>
                <div class="card text-white bg-info mt-3 mb-3"  style="max-width: 16rem;">
                  <div v-for="responseMaximumHr in maximumHR" id="btn3" class="card-body">
                    <h4 class="card-title text-center">{{responseMaximumHr}}</h4>
                  </div>
                </div>
              </div>
            </span>

            <span class="d-link-block col-lg-3 mx-auto" tabindex="0" data-toggle="tooltip" title="Wartość wzorcowa: od ok. 40 do ok. 60 uderzeń/minutę">
              <div class="form-group">
                <legend>Minimalna:</legend>
                <div class="card text-white bg-info mt-3 mb-3" style="max-width: 16rem;">
                  <div v-for="responseMinimumHr in minimumHR" id="btn4" class="card-body">
                    <h4 class="card-title text-center">{{responseMinimumHr}}</h4>
                  </div>
                </div>
              </div>
            </span>

            <span class="d-link-block col-lg-3 mx-auto" tabindex="0" data-toggle="tooltip" title="Wartość wzorcowa: ok. 60 uderzeń/minutę">
              <div class="form-group">
                <legend>Uśredniona:</legend>
                <div class="card text-white bg-info mt-3 mb-3" style="max-width: 16rem;">
                  <div v-for="responseAverageHr in averageHR" id="btn5" class="card-body">
                    <h4 class="card-title text-center">{{responseAverageHr}}</h4>
                  </div>
                </div>
              </div>
            </span>
          </div>
        </form>
      </div>

      <div class="row mt-5 mb-3">
        <span class="d-link-block col-lg-5 mx-auto" tabindex="0" data-toggle="tooltip" title="Parametr wyznaczony dla serii wartości rytmu serca">
          <div class="form-group">
            <legend>Parametr zmienności:</legend>
            <div class="card text-white bg-info mt-3 mb-3" style="max-width: 24rem;">
              <div class="card-body" id="btn6">
                <h4 class="card-title text-center">
                  60
                </h4>
              </div>
            </div>
          </div>
        </span>
        <span class="d-link-block col-lg-5 mx-auto" tabindex="0" data-toggle="tooltip" title="Podane wartości są przybliżone i mogą różnić się w zależności od diety, aktywności fizycznej i wielu innych czynników">
          <div class="form-group">
            <legend>Wartości referencyjne:</legend>
            <div class="card text-white bg-info mt-3 mb-3" style="max-width: 24rem;">
              <div class="card-body" id="btn7">
                <h6>
                  Dzieci – ok. 100 uderzeń na minutę <br>
                  Młodzież – ok. 85 uderzeń na minutę <br>
                  Dorośli – ok. 70 uderzeń na minutę <br>
                  Seniorzy  – ok. 60 uderzeń na minutę <br>
                </h6>
              </div>
            </div>
          </div>
        </span>
      </div>

      <div class="form-group col-lg-8 mt-5 mx-auto" id="myChart" style="background-color: #5FA37E">
        <ChartsHR/>
      </div>

      <div class="row">
        <div class="col-lg-11 mt-5 mx-auto">
          <form>
            <fieldset>
              <legend>Wyślij zalecenia do pacjenta</legend>
              <div class="form-group mt-3">
                <label for="exampleInputEmail1" class="form-label mt-3">Adres email pacjenta</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                <label for="exampleTextarea" class="form-label mt-3">Treść</label>
                <textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
                <label for="formFile" class="form-label mt-3">Prześlij pliki</label>
                <input class="form-control" type="file" id="formFile">
                <button type="submit" class="btn btn-primary mt-3 mb-2" id="btn8">Wyślij</button>
              </div>
            </fieldset>
          </form>
        </div>
      </div>


      <div class="row mt-5 mb-3">
        <div class="col-lg-11 mx-auto">
          <button type="button" class="btn btn-dark btn-lg" id="tryb1" v-on:click="toggleContrastMode">
            {{ isContrastModeEnabled ? 'Tryb kontrastowy' : 'Tryb kontrastowy' }}
          </button>
        </div>
        <div class="col-lg-11 mx-auto">
          <br>
          <button type="button" class="btn btn-dark btn-lg" id="tryb2" v-on:click="toggleDarkMode">
            {{ isDarkModeEnabled ? 'Tryb ciemny' : 'Tryb ciemny' }}
          </button>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
import ChartsHR from "./ChartsHR";
import axios from "axios";

export default {
  name: "App",
  components: {ChartsHR},
  data() {
    return {
      minimumHR: ['-'],
      maximumHR: ['-'],
      currentHR: ['-'],
      averageHR: ['-'],
      isContrastModeEnabled: false,
      isDarkModeEnabled: false,
      patients: {},
      matType: null,
      patientId: null,
      analysisDate: null,
      fromDay: null,
      fromHour: null,
      toDay: null,
      toHour: null,
      chartsHR: ChartsHR,
    };
  },
  mounted() {
    let elPatients = document.querySelector("div[data-patients]");
    this.patients = JSON.parse(elPatients.dataset.patients);
  },
  methods: {
    //TRYB KONTRASTOWY
    toggleContrastMode() {
      this.isContrastModeEnabled = !this.isContrastModeEnabled;

      if (this.isContrastModeEnabled) {

        document.body.style.color = 'Gold';
        document.getElementById("ella").style.color = 'Gold';
        document.getElementById("exampleSelect1").style.backgroundColor = '#202020';
        document.getElementById("exampleSelect1").style.color = 'Gold';
        document.getElementById("optionsRadios1").style.backgroundColor = '#202020';
        document.getElementById("optionsRadios1").style.color = 'Gold';
        document.getElementById("optionsRadios2").style.backgroundColor = '#202020';
        document.getElementById("optionsRadios2").style.color = 'Gold';
        document.getElementById("inputDefault1").style.backgroundColor = '#202020';
        document.getElementById("inputDefault1").style.color = 'Gold';
        document.getElementById("inputDefault2").style.backgroundColor = '#202020';
        document.getElementById("inputDefault2").style.color = 'Gold';
        document.getElementById("inputDefault3").style.backgroundColor = '#202020';
        document.getElementById("inputDefault3").style.color = 'Gold';
        document.getElementById("inputDefault4").style.backgroundColor = '#202020';
        document.getElementById("inputDefault4").style.color = 'Gold';
        document.getElementById("exampleInputEmail1").style.backgroundColor = '#202020';
        document.getElementById("exampleInputEmail1").style.color = 'Gold';
        document.getElementById("exampleTextarea").style.backgroundColor = '#202020';
        document.getElementById("exampleTextarea").style.color = 'Gold';
        document.getElementById("formFile").style.backgroundColor = '#202020';
        document.getElementById("formFile").style.color = 'Gold';
        document.getElementById("myChart").style.backgroundColor = '#153122';
        document.getElementById("myChart").style.color = 'Gold'; ///?????
        document.getElementById("btn1").style.backgroundColor = '#202020';
        document.getElementById("btn1").style.color = 'Gold';
        document.getElementById("btn2").style.backgroundColor = '#202020';
        document.getElementById("btn2").style.color = 'Gold';
        document.getElementById("btn3").style.backgroundColor = '#202020';
        document.getElementById("btn3").style.color = 'Gold';
        document.getElementById("btn4").style.backgroundColor = '#202020';
        document.getElementById("btn4").style.color = 'Gold';
        document.getElementById("btn5").style.backgroundColor = '#202020';
        document.getElementById("btn5").style.color = 'Gold';
        document.getElementById("btn6").style.backgroundColor = '#202020';
        document.getElementById("btn6").style.color = 'Gold';
        document.getElementById("btn7").style.backgroundColor = '#202020';
        document.getElementById("btn7").style.color = 'Gold';
        document.getElementById("btn8").style.backgroundColor = '#202020';
        document.getElementById("btn8").style.color = 'Gold';
        document.getElementById("tryb1").style.color = 'Gold';
        document.getElementById("tryb2").style.color = 'Gold';
        document.body.style.backgroundColor = 'Black';

      } else {

        document.body.style.color = 'Black';
        document.body.style.backgroundColor = 'White';
        document.getElementById("ella").style.color = 'white';
        document.getElementById("exampleSelect1").style.backgroundColor = 'white';
        document.getElementById("exampleSelect1").style.color = 'black';
        document.getElementById("optionsRadios1").style.backgroundColor = 'white';
        document.getElementById("optionsRadios1").style.color = 'black';
        document.getElementById("optionsRadios2").style.backgroundColor = 'white';
        document.getElementById("optionsRadios2").style.color = 'black';
        document.getElementById("inputDefault1").style.backgroundColor = 'white';
        document.getElementById("inputDefault1").style.color = 'black';
        document.getElementById("inputDefault2").style.backgroundColor = 'white';
        document.getElementById("inputDefault2").style.color = 'black';
        document.getElementById("inputDefault3").style.backgroundColor = 'white';
        document.getElementById("inputDefault3").style.color = 'black';
        document.getElementById("inputDefault4").style.backgroundColor = 'white';
        document.getElementById("inputDefault4").style.color = 'black';
        document.getElementById("exampleInputEmail1").style.backgroundColor = 'white';
        document.getElementById("exampleInputEmail1").style.color = 'black';
        document.getElementById("exampleTextarea").style.backgroundColor = 'white';
        document.getElementById("exampleTextarea").style.color = 'black';
        document.getElementById("formFile").style.backgroundColor = 'white';
        document.getElementById("formFile").style.color = 'black';
        document.getElementById("myChart").style.backgroundColor = '#5FA37E';
        document.getElementById("myChart").style.color = 'Black'; ///?????
        document.getElementById("btn1").style.backgroundColor = '#6FC3AF';
        document.getElementById("btn1").style.color = 'white';
        document.getElementById("btn2").style.backgroundColor = '#71C6D2';
        document.getElementById("btn2").style.color = 'white';
        document.getElementById("btn3").style.backgroundColor = '#71C6D2';
        document.getElementById("btn3").style.color = 'white';
        document.getElementById("btn4").style.backgroundColor = '#71C6D2';
        document.getElementById("btn4").style.color = 'white';
        document.getElementById("btn5").style.backgroundColor = '#71C6D2';
        document.getElementById("btn5").style.color = 'white';
        document.getElementById("btn6").style.backgroundColor = '#71C6D2';
        document.getElementById("btn6").style.color = 'white';
        document.getElementById("btn7").style.backgroundColor = '#71C6D2';
        document.getElementById("btn7").style.color = 'white';
        document.getElementById("btn8").style.backgroundColor = '#6FC3AF';
        document.getElementById("btn8").style.color = 'white';
        document.getElementById("tryb1").style.color = 'white';
        document.getElementById("tryb2").style.color = 'white';
      }
    },
    //TRYB CIEMNY
    toggleDarkMode() {
      this.isDarkModeEnabled = !this.isDarkModeEnabled;

      if (this.isDarkModeEnabled) {

        document.body.style.color = 'White';
        document.getElementById("exampleSelect1").style.backgroundColor = '#303030';
        document.getElementById("optionsRadios1").style.backgroundColor = '#303030';
        document.getElementById("optionsRadios2").style.backgroundColor = '#303030';
        document.getElementById("inputDefault1").style.backgroundColor = '#303030';
        document.getElementById("inputDefault2").style.backgroundColor = '#303030';
        document.getElementById("inputDefault3").style.backgroundColor = '#303030';
        document.getElementById("inputDefault4").style.backgroundColor = '#303030';
        document.getElementById("exampleInputEmail1").style.backgroundColor = '#303030';
        document.getElementById("exampleTextarea").style.backgroundColor = '#303030';
        document.getElementById("formFile").style.backgroundColor = '#303030';
        document.getElementById("myChart").style.backgroundColor = '#316F5F';
        document.getElementById("btn1").style.backgroundColor = '#303030';
        document.getElementById("btn2").style.backgroundColor = '#303030';
        document.getElementById("btn3").style.backgroundColor = '#303030';
        document.getElementById("btn4").style.backgroundColor = '#303030';
        document.getElementById("btn5").style.backgroundColor = '#303030';
        document.getElementById("btn6").style.backgroundColor = '#303030';
        document.getElementById("btn7").style.backgroundColor = '#303030';
        document.getElementById("btn8").style.backgroundColor = '#303030';
        document.body.style.backgroundColor = 'DarkSlateGray';

      } else {

        document.body.style.color = 'DarkSlateGray';
        document.body.style.backgroundColor = 'White';
        document.getElementById("exampleSelect1").style.backgroundColor = 'white';
        document.getElementById("optionsRadios1").style.backgroundColor = 'white';
        document.getElementById("optionsRadios2").style.backgroundColor = 'white';
        document.getElementById("inputDefault1").style.backgroundColor = 'white';
        document.getElementById("inputDefault2").style.backgroundColor = 'white';
        document.getElementById("inputDefault3").style.backgroundColor = 'white';
        document.getElementById("inputDefault4").style.backgroundColor = 'white';
        document.getElementById("exampleInputEmail1").style.backgroundColor = 'white';
        document.getElementById("exampleTextarea").style.backgroundColor = 'white';
        document.getElementById("formFile").style.backgroundColor = 'white';
        document.getElementById("myChart").style.backgroundColor = '#5FA37E';
        document.getElementById("btn1").style.backgroundColor = '#6FC3AF';
        document.getElementById("btn2").style.backgroundColor = '#71C6D2';
        document.getElementById("btn3").style.backgroundColor = '#71C6D2';
        document.getElementById("btn4").style.backgroundColor = '#71C6D2';
        document.getElementById("btn5").style.backgroundColor = '#71C6D2';
        document.getElementById("btn6").style.backgroundColor = '#71C6D2';
        document.getElementById("btn7").style.backgroundColor = '#71C6D2';
        document.getElementById("btn8").style.backgroundColor = '#6FC3AF';

      }
    },
    async analyse() {
      console.log(this.matType);
      console.log(this.patientId);
      console.log(this.fromDay);
      console.log(this.fromHour);
      console.log(this.toDay);
      console.log(this.toHour);
      try {
        //CURRENT
        const responseCurrentHr = await axios.get(
            'http://localhost:8000/hr/current/' + this.matType,
            { params: {
                patientId: this.patientId,
              }}
        );
        this.currentHR = responseCurrentHr.data;

        //MAXIMUM
        const responseMaximumHr = await axios.get(
            'http://localhost:8000/hr/maximum/' + this.matType,
            { params: {
                patientId: this.patientId,
                from: this.fromDay + " " + this.fromHour,
                to: this.toDay + " " + this.toHour,
              }}
        );
        this.maximumHR = responseMaximumHr.data;

        //MINIMUM
        const responseMinimumHr = await axios.get(
            'http://localhost:8000/hr/minimum/' + this.matType,
            { params: {
                patientId: this.patientId,
                from: this.fromDay + " " + this.fromHour,
                to: this.toDay + " " + this.toHour,
              }}
        );
        this.minimumHR = responseMinimumHr.data;

        //AVERAGE
        const responseAverageHr = await axios.get(
            'http://localhost:8000/hr/average/' + this.matType,
            { params: {
                patientId: this.patientId,
                from: this.fromDay + " " + this.fromHour,
                to: this.toDay + " " + this.toHour,
              }}
        );
        this.averageHR = responseAverageHr.data;

      } catch (error) {
        console.log(error);
      }
    },
    handleMatInput(event) {
      this.matType = event.target.value
      this.chartsHR.methods.handleMatInput(event.target.value)
    },
    handlePatientIdInput(event) {
      this.patientId = event.target.value
      this.chartsHR.methods.handlePatientIdInput(event.target.value)
    },
    handleFromDayInput(event) {
      this.fromDay = event.target.value
      this.chartsHR.methods.handleFromDayInput(event.target.value)
    },
    handleFromHourInput(event) {
      this.fromHour = event.target.value
      this.chartsHR.methods.handleFromHourInput(event.target.value)
    },
    handleToDayInput(event) {
      this.toDay = event.target.value
      this.chartsHR.methods.handleToDayInput(event.target.value)
    },
    handleToHourInput(event) {
      this.toHour = event.target.value
      this.chartsHR.methods.handleToHourInput(event.target.value)
    },
  },
}

</script>