<template xmlns="http://www.w3.org/1999/html">
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid col-lg-12 mx-auto position">
        <a class="navbar-brand" id="ella1" href="#">Ella4Life</a>
      <button type="button" class="btn btn-primary btn-lg">
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
          <button type="button" v-on:click="analyse()" id="btn1" class="btn btn-primary btn-lg">Przeprowadź analizę danych</button>
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
<!--              <h4 class="card-title text-center">test</h4>-->
              <div v-for="responseHRV in HRV" id="hrv" class="card-body">
                    <h4 class="card-title text-center">{{responseHRV}}</h4>
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

      <div class="form-group col-lg-8 mt-5 mb-5 mx-auto" id="myChart" style="background-color: #5FA37E">
        <ChartsHR
          :matType="matType"
          :patientId="patientId"
          :fromDay="fromDay"
          :fromHour="fromHour"
          :toDay="toDay"
          :toHour="toHour"
          ref="chartsHRref"
        />
      </div>
    </div>
  </div>

</template>

<script>
import ChartsHR from "./ChartsHR";
import axios from "axios";

export default {
  name: "App",
  components: {
    ChartsHR
  },
  data() {
    return {
      minimumHR: ['-'],
      maximumHR: ['-'],
      currentHR: ['-'],
      averageHR: ['-'],
      HRV: ['-'],
      patients: {},
      matType: null,
      patientId: null,
      analysisDate: null,
      fromDay: null,
      fromHour: null,
      toDay: null,
      toHour: null,
    };
  },
  methods: {
    async analyse() {
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

        //HRV
        const responseHRV = await axios.get(
            'http://localhost:8000/hr/hrv/' + this.matType,
            { params: {
                patientId: this.patientId,
                from: this.fromDay + " " + this.fromHour,
                to: this.toDay + " " + this.toHour,
              }}
        );
        this.HRV = responseHRV.data;

        //CHART
        await this.$refs.chartsHRref.showChart()

      } catch (error) {
        console.log(error);
      }
    },
    handleMatInput(event) {
      this.matType = event.target.value
    },
    handlePatientIdInput(event) {
      this.patientId = event.target.value
    },
    handleFromDayInput(event) {
      this.fromDay = event.target.value
    },
    handleFromHourInput(event) {
      this.fromHour = event.target.value
    },
    handleToDayInput(event) {
      this.toDay = event.target.value
    },
    handleToHourInput(event) {
      this.toHour = event.target.value
    },
  },
}

</script>