<template>
    <div>
        <h2>Imenik</h2>

        <form @submit.prevent="addArticle" class="mb-3">
            <div class="form-group">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Name" v-model="phonebook.name">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Phone number" v-model="phonebook.phonenumber">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Region" v-model="phonebook.region">
                </div>
                <div class="form-group">
                    <textarea class="form-control" placeholder="Address" v-model="phonebook.address"></textarea>
                </div>
                <button type="submit" class="btn btn-light btn-block">Save</button>
            </div>
        </form>

        <div class="card card-body mb-2" v-for="phonebook in phonebooks" v-bind:key="phonebook.id">
            <h3><b>Naziv:</b> {{ phonebook.name }}</h3>
            <p><b>Telefonska:</b> {{ phonebook.phonenumber }}</p>
            <p><b>Naslov:</b> {{ phonebook.address }}</p>
            <p><b>Regija:</b> {{ phonebook.region }}</p>
            
            <a href="#app">
            <button @click="editArticle(phonebook)" class="btn btn-warning mb-2">Edit</button>
            </a>
            <button @click="deleteArticle(phonebook.id)" class="btn btn-danger">Delete</button>
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
                edit: false
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
            },
            
            deleteArticle(id){
                if(confirm('Are you sure?')){
                    fetch(`api/phonebook/${id}`,{
                        method: 'delete'
                    })
                    .then(res => res.json())
                    .then(data => {
                        console.log('Article removed');
                        this.fetchPhonebooks();
                    })
                    .catch(err => console.log(err));
                }
            },
            addArticle(){
                if(this.edit){
                    //update
                    console.log(this.phonebook);
                     fetch('/api/phonebook', {
                        method: 'put',
                        body: JSON.stringify(this.phonebook),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json)
                    .then(data => {
                        this.phonebook.name = '';
                        this.phonebook.phonenumber = '';
                        this.phonebook.region = '';
                        this.phonebook.address = '';
                        console.log('Article updated');
                        this.fetchPhonebooks();
                    })
                    .catch(err => console.log(err))
                }else{
                    //add
                    fetch('/api/phonebook', {
                        method: 'post',
                        body: JSON.stringify(this.article),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json)
                    .then(data => {
                        this.phonebook.name = '';
                        this.phonebook.phonenumber = '';
                        this.phonebook.region = '';
                        this.phonebook.address = '';
                        console.log('Article added');
                        this.fetchPhonebooks();
                    })
                    .catch(err => console.log(err))
                }
            },
            editArticle(phonebook){
                console.log(phonebook);
                this.edit = true;
                this.phonebook.id = phonebook.id;
                this.phonebook.phonebook_id = phonebook.id;
                this.phonebook.name = phonebook.name;
                this.phonebook.phonenumber = phonebook.phonenumber;
                this.phonebook.region = phonebook.region;
                this.phonebook.address = phonebook.address;
            }
        }
    }
</script>
