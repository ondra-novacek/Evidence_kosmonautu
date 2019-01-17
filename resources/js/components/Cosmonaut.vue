<template>
    <div>
        <h2>Kosmonauti</h2>
        <!-- messages for users -->
        <div v-if="message" class="alert alert-info" role="alert">{{message}}</div>
        <div v-if="error" class="alert alert-danger" role="alert">{{error}}</div>
        <!-- add new cosmonaut -->
        <add-cosmonaut @success="successMessage()" @clear="clearMessage()" @failed="failMessage()"></add-cosmonaut>
        <!-- pagination -->
        <nav aria-label="Page navigation example" v-if="pagination.last_page != 1">
            <ul class="pagination">
              <li class="page-item" :class="{disabled: !pagination.prev_page}"><a class="page-link" href="#" @click="fetchCosmonauts(pagination.prev_page)">Předchozí</a></li>
              <li class="page-item disabled text-dark"><a class="page-link" href="#">{{pagination.current_page}} z {{pagination.last_page}}</a></li>
              <li class="page-item" :class="{disabled: !pagination.next_page}"><a class="page-link" href="#" @click="fetchCosmonauts(pagination.next_page)">Další</a></li>
            </ul>
        </nav>
        <!-- cosmonauts -->
        <table class="table highlighted-row">
            <tr id="table-header">
                <th>#</th>
                <th>Příjmení, jméno <button class="btn btn-sm btn-outline-dark" @click="sortAbc()"><i class="fas fa-sort"></i></button></th> <!-- This sort is only sorting items on the current page, not the whole data-->
                <th>Superschopnost</th>
                <th>Datum narození</th>                
                <th>Události</th>
            </tr>
            <tbody>
                <template v-for="(cosmonaut, index) in sortedCosmonauts">
                        <tr class="data" v-bind:class="{selected: rowClickState[index]}">
                            <td>{{index+1}}</td>
                            <td>{{cosmonaut.surname}}, {{cosmonaut.name}}</td>
                            <td>{{cosmonaut.superpower}}</td>
                            <td>{{cosmonaut.date_of_birth}}</td>
                            <td>
                                <button @click="toggleEditForm(index)"><i class="fa fa-edit"></i></button> 
                                <button @click="deleteCosmonaut(cosmonaut.id)"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr v-if="rowClickState[index]" class="edit-row"> 
                            <td colspan="5">
                                <edit-cosmonaut :cosmonaut="cosmonaut" @success="successMessage()" @failed="failMessage()"></edit-cosmonaut>
                            </td>
                        </tr>
                </template>
            </tbody>
        </table>
        
    </div>
</template>

<script>
    import AddCosmonaut from "./AddCosmonaut.vue";
    import EditCosmonaut from "./EditCosmonaut.vue";
    export default {
        data() {
            return {
                cosmonauts: [],
                pagination: {},
                sortNameInOrder: true ,
                message: '',
                error: '',
                rowClickState: []
            }
        },
        components: {
            'add-cosmonaut': AddCosmonaut,
            'edit-cosmonaut': EditCosmonaut
        },
        created() {
            this.fetchCosmonauts();
            this.clearMessage();
            // this.fillRowState();
        },
        methods: {
            fetchCosmonauts(page_url){
                // if not page_url is passed, fetch from normal api url, else fetch from the url given in parametr (the parameter is being passed for pagination)
                page_url = page_url || 'api/cosmonauts';
                axios.get(page_url)
                .then(response => {
                    // fill array cosmonauts with actual cosmonauts
                    this.cosmonauts = response.data.data;
                    this.makePagination(response.data.meta, response.data.links)
                    console.log(response.data);
                    // fill the row state, only if it isnt filled already
                    // condition is true if the array is empty
                    if (typeof this.rowClickState == "undefined" || this.rowClickState == null || this.rowClickState.length == null || this.rowClickState.length == 0) {
                        this.fillRowState();
                    }
                })
                .catch(err => console.log(err));
            },
            makePagination(meta, links){
                this.pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page: links.next,
                    prev_page: links.prev
                }
            },
            sortAbc(){
                // if it was sorted asc (1) => it will now be sorted desc (0) and vice versa
                this.sortNameInOrder ? this.sortNameInOrder = false : this.sortNameInOrder = true;  
            },
            clearMessage(){
                this.message = '';
                this.error = '';
            },
            successMessage(){
                this.clearMessage();
                this.message = "Kosmonaut úspěšně přidán.";
                this.fetchCosmonauts();
            },
            failMessage(){
                this.clearMessage();
                this.error = "Kosmonaut nemohl být přidán. Zkontroluj všechny údaje.";
            },
            deleteCosmonaut(id){
                this.clearMessage();
                if(confirm('Are you sure you want to delete this cosmonaut?')){
                    axios.delete('api/cosmonaut/' + id)
                    .then(response => {
                        console.log(response.data);
                        this.message = "Kosmonaut byl úspěšně smazán.";
                        this.fetchCosmonauts(); 
                        this.fillRowState();
                    })
                    .catch(error => {console.log(error)});
                }
                
            },
            fillRowState(){
                this.rowClickState = Array(this.cosmonauts.length).fill(false);
            },
            toggleEditForm(index){
                // set(array, key, value), sets always opposite value (true -> false, false -> true)
                this.$set(this.rowClickState, index, !this.rowClickState[index]);
            }
        },
        computed: {
            sortedCosmonauts: function () {
                // check if it should be ordered acs => true or desc => false
                if (this.sortNameInOrder){
                    // sorting algorithm for strings in objects in an array
                    return this.cosmonauts.sort((a,b) => {
                    let x = a.surname.toLowerCase();
                    let y = b.surname.toLowerCase();
                    
                    if (x < y) {return -1;}
                    if (x > y) {return 1;} 
                    return 0;
                    })
                }else{
                    return this.cosmonauts.sort((a,b) => {
                    let x = a.surname.toLowerCase();
                    let y = b.surname.toLowerCase();
                    
                    if (x < y) {return 1;}
                    if (x > y) {return -1;}
                    return 0;
                    })
                }
                
            }
        }
    }
</script>

<style scoped>
    .data:hover {
        background-color: rgba(137, 150, 179, 0.486);
    }

    #table-header {
        background-color: rgba(103, 128, 161, 0.774);
    }

    h2 {
        margin-top: 30px;
        margin-bottom: 30px;
    }

    .edit-row {
        background-color: rgb(231, 231, 231);
    }

    .selected {
        background-color: rgba(137, 150, 179, 0.486);
    }
</style>