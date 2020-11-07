<template>
  <div class="main-layout">
    <form @submit.prevent="saveData">
      <div class="row">
        <div class="form-group">
          <div class="col-md-6">
            <label>Valor Conversor</label>
            <input v-model="valor_conversor" class="form-control">
              <select v-model="moeda_conversora" class="custom-select">
                <option disabled value="">Escolha uma moeda</option>
                <option>BRL</option>
                <option>CAD</option>
                <option>USD</option>
              </select>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-6">
            <label for="convertido">Valor Convertido</label>
            <input v-model="valor_convertido" class="form-control" disabled>
            <select v-model="moeda_convertida" class="custom-select">
              <option dis abled value="">Escolha uma moeda</option>
              <option>BRL</option>
              <option>CAD</option>
              <option>USD</option>
            </select>
          </div>
        </div>

      </div>
      <div class="form-group">
        <div class="row">
          <div class="col-md-4">
            <button class="btn btn-primary" type="submit">Salvar</button>
            <a href="#" class="btn btn-primary" role="button" aria-pressed="true" @click="mult()">Calcular</a>
          </div>
        </div>
      </div>
    </form>
    <div class="col-md-6 historico">
        <p class="h1">Histórico</p>
        <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Moeda</th>
          <th scope="col">Moeda Conv.</th>
          <th scope="col">Valor</th>
          <th scope="col">Valor Conv.</th>
          <th scope="col">Data/Hora</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="readado in readados" :key="readado.id">
          <th scope="row">{{ readado.id }}</th>
          <td>{{ readado.moeda_conversora }}</td>
          <td>{{ readado.moeda_convertida }}</td>
          <td>{{ readado.valor_conversor }}</td>
          <td>{{ readado.valor_convertido }}</td>
          <td>{{ readado.created_at }}</td>
        </tr>
      </tbody>
    </table>

    </div>
  </div>

</template>

<script>

import axios from 'axios';
import Form from 'vform';

export default {
  middleware: 'auth',
  data(){
    return{
      moeda_conversora: '',
      moeda_convertida: '',
      valor_conversor: '',
      valor_convertido: '',
      readados: null,
      dadosUSD: null,
      dadosBRL: null,
      dadosCAD: null,
      dadouser: null,
      form: new Form({
        moeda_conversora: '',
        moeda_convertida: '',
        valor_conversor: '',
        valor_convertido: '',
      })
    }
  },


  mounted() {
    //API da exchange
    axios.get('https://api.exchangeratesapi.io/latest?symbols=BRL,CAD&base=USD').then(response => this.dadosUSD = response.data).catch(error => this.dadosUSD = console.log(error))
    axios.get('https://api.exchangeratesapi.io/latest?symbols=USD,CAD&base=BRL').then(response => this.dadosBRL = response.data)
    axios.get('https://api.exchangeratesapi.io/latest?symbols=BRL,USD&base=CAD').then(response => this.dadosCAD = response.data)
    this.readData()
  },


  methods: {
    mult(){
      if(this.moeda_conversora == 'USD' && this.moeda_convertida == 'CAD'){
        return this.valor_convertido = this.dadosUSD.rates['CAD'] * this.valor_conversor
      }
      else if(this.moeda_conversora == 'USD' && this.moeda_convertida == 'BRL'){
        return this.valor_convertido = this.dadosUSD.rates['BRL'] * this.valor_conversor
      }
      else if(this.moeda_conversora == 'CAD' && this.moeda_convertida == 'USD'){
        return this.valor_convertido = this.dadosCAD.rates['USD'] * this.valor_conversor
      }
      else if(this.moeda_conversora == 'CAD' && this.moeda_convertida == 'BRL'){
        return this.valor_convertido = this.dadosCAD.rates['BRL'] * this.valor_conversor
      }
      else if(this.moeda_conversora == 'BRL' && this.moeda_convertida == 'CAD'){
        return this.valor_convertido = this.dadosBRL.rates['CAD'] * this.valor_conversor
      }
      else if(this.moeda_conversora == 'BRL' && this.moeda_convertida == 'USD'){
        return this.valor_convertido = this.dadosBRL.rates['USD'] * this.valor_conversor
      }

    },
    saveData(){
      let dado = new FormData()
      dado.append('moeda_conversora', this.moeda_conversora)
      dado.append('moeda_convertida', this.moeda_convertida)
      dado.append('valor_conversor', this.valor_conversor)
      dado.append('valor_convertido', this.valor_convertido)
      axios.post('/api/currency', dado)
    },
    readData(){
      axios.get('/api/currency')
        .then((response) => {
            this.readados = response.data
        })
        .catch((error) => {console.log(error)})
    }
  }
}
</script>

<style scoped>
  .form-control {
    width: auto;
  }
  .custom-select{
    margin-top: 10%;
    width: auto;
  }
  .btn-primary{
    background-color: rgb(95, 158, 160);
  }
  navbar .navbar-expand-lg .navbar-light{
    background-color: rgb(95, 158, 160) !important;
  }
  .col-md-6.historico{
    margin-top: 30px;
    padding-left: 0;
  }
  .h1{
    font-weight: 200;
  }
</style>
