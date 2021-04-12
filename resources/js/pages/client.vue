<template>
    <div class="main-layout">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Cliente Atualizado com sucesso
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form @submit.prevent="saveData">
            <div class="form-row">
                <div class="form-group col-md-6">
                <label for="inputEmail4">Email</label>
                <input type="email" class="form-control" id="inputEmail4" placeholder="Email" v-model="email">
                </div>
                <div class="form-group col-md-6">
                <label for="inputName">Nome</label>
                <input type="text" class="form-control" id="inputName" placeholder="Nome" v-model="name">
                </div>
            </div>
            <div class="form-group">
                <label for="inputCredit">Cartão de Crédito</label>
                <input type="text" class="form-control" id="inputCredit" placeholder="5505 4980 ..." v-model="credit_card">
            </div>
            <div class="form-group">
                <label for="inputCVV">CVV</label>
                <input type="text" class="form-control" id="inputCVV" placeholder="Três números atrás do cartão" maxlength="3" v-model="cvv">
                <label for="inputValidationDate">Data de Validade</label>
                <input type="text" class="form-control" id="inputValidationDate" placeholder="01/2025" maxlength="6" v-model="validation_date">
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                <label for="inputCEP">CEP</label>
                <input type="text" class="form-control" id="inputCep" maxlength="8" v-model="cep">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>

        <div class="col-md-6 historico">
            <p class="h1">Clientes</p>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Email</th>
                        <th scope="col">Validade Cartão de Crédito</th>
                        <th scope="col">CEP</th>
                        <th scope="col">Data/Hora</th>
                        <th scope="col">Editar</th>
                        <th scope="col">Deletar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="readado in readados" :key="readado.id">
                        <td>{{ readado.id }}</td>
                        <td>{{ readado.name }}</td>
                        <td>{{ readado.email }}</td>
                        <td>{{ readado.valid_date }}</td>
                        <td>{{ readado.cep }}</td>
                        <td>{{ readado.hourtime }}</td>
                        <td><button type="button" class="btn btn-info" data-toggle="modal" @click="editClient(readado)">Editar</button></td>
                        <td><button type="button" class="btn btn-danger" @click="deleteClient(readado.id)">Deletar</button></td>
                    </tr>
                </tbody>
        </table>

        </div>
        
        <!-- Modal Edit -->

        <div class="modal fade" id="editClient" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form @submit.prevent="updateClient" id="updateModal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Editar Cliente</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Nome:</label>
                                <input type="text" class="form-control" id="name" value="" name="name">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Email:</label>
                                <input type="text" class="form-control" id="email" value="" name="email">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Cartão de Crédito</label>
                                <input type="text" class="form-control" id="credit_card" value="" name="credit_card">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">CVV</label>
                                <input type="text" class="form-control" id="cvv" value="" name="cvv">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Data de Validade:</label>
                                <input type="text" class="form-control" id="validation_date" value="" name="validation_date">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">CEP:</label>
                                <input type="text" class="form-control" id="cep" value="" name="cep">
                            </div>
                            <input type="hidden" id="id" value="" name="id">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Editar</button>
                        </div>
                    </div> <!--fecha aqui -->
                </form>
            </div> 
        </div>

    </div>
    
    
</template>

<script>
import axios from 'axios';
import $ from 'jquery';
import index from './settings/index.vue';

export default {
  components: { index },
    
    data(){
        return{
            email: '',
            name: '',
            credit_card: '',
            cvv: '',
            validation_date: '',
            cep: '',
            readados: null,

        }
    },
    mounted(){
        
        const valorCep = document.querySelector("#inputCep");
        let cep = "";
        valorCep.addEventListener("keyup", () => {
            cep = valorCep.value;
            if(cep)
            if(cep.length === 8) {
                valorCep.value = `${cep.substr(0,5)}-${cep.substr(5,9)}`;
                //console.log(cep); 
            }
        });

        const valorData = document.querySelector("#inputValidationDate");
        let dataVal = "";
        valorData.addEventListener("keyup", () => {
            dataVal = valorData.value;
            //console.log(dataVal);
            if(dataVal.length === 6){
                valorData.value = `${dataVal.substr(0,2)}/${dataVal.substr(2,6)}`;
            }
        });
        this.readData()
        
    },

    methods:{
        editClient(dados){
            $("#editClient").modal("show");
            
            $("#name").val(dados.name)
            $("#email").val(dados.email)
            $("#credit_card").val(dados.credit_card)
            $("#cvv").val(dados.cvv)
            $("#validation_date").val(dados.validation_date)
            $("#cep").val(dados.cep)
            $("#id").val(dados.id)

        },
        deleteClient(id){
            let dado = new FormData()
            dado.append('_method', 'DELETE')
            axios.post('/api/client/'+id, dado)
        },
        updateClient(){
            const id = document.getElementById("id").value;
            const name = document.getElementById("name").value;
            const email = document.getElementById("email").value;
            const credit_card = document.getElementById("credit_card").value;
            const cvv = document.getElementById("cvv").value;
            const validation_date = document.getElementById("validation_date").value;
            const cep = document.getElementById("cep").value;
            let dado = new FormData();
            dado.append('_method', 'PATCH');
            dado.append('name', name);
            dado.append('email', email);
            dado.append('credit_card', credit_card);
            dado.append('cvv', cvv);
            dado.append('validation_date', validation_date);
            dado.append('cep', cep);
            axios.post('/api/client/'+id, dado).then(
                (response) => {
                    var statusUpdate = response;
                }
            );
            $("#editClient").modal("hide");
        },
        saveData(){
            let dado = new FormData()
            let maskdata = this.validation_date.substring(2,6) + '-' + this.validation_date.substring(0,2) + '-1' 
            dado.append('email', this.email)
            dado.append('name', this.name)
            dado.append('credit_card', this.credit_card)
            dado.append('cvv', this.cvv)
            dado.append('validation_date', maskdata)
            dado.append('cep', this.cep)
            axios.post('/api/client', dado);
            //console.log(dado)
        },
        readData(){
            axios.get('/api/client')
                .then((response) => {
                    this.readados = response.data
                })
                .catch((error) => {console.log(error)})
    },
    }
}


</script>
