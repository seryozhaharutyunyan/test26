<template>
    <div class="col-5 m-auto">
        <select class="form-control m-2" v-model="method">
            <option disabled value="">Method</option>
            <option value="get">get</option>
            <option value="post">post</option>
        </select>
        <textarea type="text" class="form-control m-2" v-model.trim="token" placeholder="Token"></textarea>
        <div class="text-center text-danger">{{error}}</div>
        <textarea class="form-control m-2" v-model.trim="data" placeholder="Data"></textarea>
        <div v-show="id && time" class="text-center fs-1">id:{{ id }}, time:{{ time }}</div>
        <button class="btn btn-secondary m-2" @click="query()">send</button>
    </div>
</template>

<script>

import axios from "axios";

export default {
    name: "test2",

    data() {
        return {
            method: '',
            token: '',
            time: '',
            id: '',
            error:'',
            data: JSON.stringify({

                "firstName": "Иван",
                "lastName": "Иванов",
                "address": {
                    "streetAddress": "Московское ш., 101, кв.101",
                    "city": "Ленинград",
                    "postalCode": 101101
                },
                "phoneNumbers": [
                    "812 123-1234",
                    "916 123-4567"
                ]
            })
        }
    },

    methods: {
        query() {
            let token = ("Bearer " + this.token);
            this.error='';
            axios.defaults.headers.common['Authorization'] = token;
            if (this.method === 'get') {
                axios.get(`api/exercise2get/${this.data}`).then(resolve => {
                    if (resolve.data.token !== '') {
                        this.token = resolve.data;
                    }

                    this.time = resolve.data.time;
                    this.id = resolve.data.id;


                    console.log(resolve);
                }).catch(() => {
                    this.error = 'Token is not valid';
                })
            }
            if (this.method === 'post') {
                axios.post(`api/exercise2post`, {
                    data: this.data
                }).then(resolve => {
                    if (resolve.data.token !== '') {
                        this.token = resolve.data;
                    }
                    this.time = resolve.data.time;
                    this.id = resolve.data.id;
                }).catch((error) => {
                    this.error = 'Token is not valid';
                })
            }
        },
    }
}
</script>

<style scoped>

</style>
