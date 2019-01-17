<template>
    <div>
        <button class="btn btn-outline-success add-btn" @click="toggleShowForm"><span v-if="!showAddForm">Přidat kosmonauta</span><span v-else>Schovat formulář</span></button>
        <form @submit.prevent="addCosmonaut()" v-if="showAddForm">
            <!-- first row in a form -->
            <div class="row">
              <div class="col">
                <span title="nutné vyplnit">Jméno kosmonauta<i class="red">*</i></span>
                <input type="text" class="form-control" placeholder="" v-model="cosmonaut.name" required>
              </div>
              <div class="col">
                <span title="nutné vyplnit">Příjmení kosmonauta<i class="red">*</i></span>
                <input type="text" class="form-control" placeholder="" v-model="cosmonaut.surname" required>
              </div>
            </div>
            <!-- second row in a form -->
            <div class="row">
                <div class="col">
                  <span title="nutné vyplnit">Superschopnost<i class="red">*</i></span>  
                  <input type="text" class="form-control" placeholder="" v-model="cosmonaut.superpower" required>
                </div>
                <div class="col">
                    <span>Datum narození</span>
                  <input type="date" class="form-control" placeholder="" v-model="cosmonaut.date_of_birth">
                </div>
            </div>
            <!-- submit button -->
            <input type="submit" class="btn btn-success" value="Přidat kosmonauta">
        </form>
    </div>
</template>

<script>
    export default{
        data(){
            return {
                showAddForm: false,
                cosmonaut: {
                    name: '',
                    surname: '',
                    date_of_birth: '',
                    superpower: ''
                }
            }
        },
        methods: {
            toggleShowForm() {
                if (this.showAddForm) {
                    // hide the form
                    this.showAddForm = false;
                } else {
                    // show the form
                    this.showAddForm = true;
                }
                this.$emit('clear');
            },
            addCosmonaut(){
                axios.post('api/cosmonaut', {
                    name: this.cosmonaut.name,
                    surname: this.cosmonaut.surname,
                    superpower: this.cosmonaut.superpower,
                    birth: this.cosmonaut.date_of_birth
                })
                .then(response => {
                    this.$emit('success');
                    this.clearInputs();
                })
                .catch(error => {this.$emit('failed')});
            },
            clearInputs(){
                this.cosmonaut.name = '';
                this.cosmonaut.surname = '';
                this.cosmonaut.superpower = '';
                this.cosmonaut.date = '';
            }
        }
    }
</script>

<style scoped>
    form {
        border: 1px rgba(103, 128, 161, 0.774) solid;
        padding: 20px;
        margin-bottom: 20px;
    }

    .col > input {
        margin-bottom: 10px;
    }

    .add-btn {
        margin-bottom: 10px;
    }

    .red {
        color: red;
    }
</style>