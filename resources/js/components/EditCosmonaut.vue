<template>
    <div>
        <form @submit.prevent="editCosmonaut()">
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
            <input type="submit" class="btn btn-info" value="Uložit změny">
            <span>{{message}}</span>
        </form>
    </div>    
</template>

<script>
export default{
    data(){
        return {
            message: ''
        }
    },
    props: {
        cosmonaut: Object
    },
    methods: {
        editCosmonaut(){
            axios.put('api/cosmonaut', {
                cosmonaut_id: this.cosmonaut.id,
                name: this.cosmonaut.name,
                surname: this.cosmonaut.surname,
                superpower: this.cosmonaut.superpower,
                birth: this.cosmonaut.date_of_birth,
            })
            .then(response => {
                this.message = 'Změny byly provedeny.';
            })
            .catch(response => {
                this.message = 'Změna nemohla být provedena. Zkontroluj všechny údaje.';
            })
        }
    }        
}
</script>

<style scoped>
    .col > input {
        margin-bottom: 10px;
    }

    .red {
        color: red;
    }
</style>