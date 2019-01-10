<template>
    <div>
        <h2>Imenik</h2>

        <input type="text" v-model="search" placeholder="Iskanje po imeniku: Vnesite naziv, telefonsko ali regijo" class="form-control mb-3" />

        <div class="card card-body mb-2" v-for="phonebook in filteredPhonebooks" v-bind:key="phonebook.id">
            <h3><b>Naziv:</b> {{ phonebook.name }}</h3>
            <p><b>Telefonska:</b> {{ phonebook.phonenumber }}</p>
            <p><b>Naslov:</b> {{ phonebook.address }}</p>
            <p><b>Regija:</b> {{ phonebook.region }}</p>
            
            <hr>
        </div>
        
    </div>
</template>

<script>
    export default {
        data(){
            return  {
                phonebooks: [],
                phonebook:{
                    id: '',
                    name: '',
                    phonenumber: '',
                    region: '',
                    address: ''
                },
                phonebook_id: '',
                pagination: {},
                edit: false,
                search: ''
            }
        },

        created(){
            this.fetchPhonebooks();
        },

        methods: {
            fetchPhonebooks(page_url){
                let vm = this;
                page_url = page_url || '/api/phonebook'
                fetch(page_url)
                    .then(res => res.json())
                    .then(res =>{
                        this.phonebooks = res.data;
                        
                        
                    })
                    .catch(err => console.log(err));
            }
        },
        computed: {
            filteredPhonebooks: function(){
                return this.phonebooks.filter((phonebook) =>{
                    return phonebook.name.match(this.search) || phonebook.region.match(this.search) || phonebook.phonenumber.match(this.search);
                });
            }
        }
    }
</script>
