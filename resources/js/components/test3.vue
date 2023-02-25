<template>
    <div class="col-5 m-auto">
        <select class="form-control m-2" v-model="method">
            <option disabled value="">Method</option>
            <option value="get">get</option>
            <option value="post">post</option>
        </select>
        <select class="form-control m-2" v-model="id">
            <option disabled value="">ID</option>
            <option v-for="d in dataQuery" :key="d" :value="d.id">{{ d.id }}</option>
        </select>
        <textarea type="text" class="form-control m-2" v-model.trim="token" placeholder="Token"></textarea>
        <div class="text-center text-danger">{{ error }}</div>
        <input class="form-control m-2" v-model.trim="data" placeholder="Data">
        <button class="btn btn-secondary m-2" @click="send()">send</button>
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
            id: '',
            error: '',
            data: '',
            dataQuery: {},
        }
    },

    methods: {
        send() {
            let token = ("Bearer " + this.token);
            this.error = '';

            axios.defaults.headers.common['Authorization'] = token;
            if (this.method === 'get') {
                axios.get(`api/exercise3get/${this.id}/${this.data}`).then(resolve => {
                    if (resolve.data.token !== '') {
                        this.token = resolve.data;
                    }
                }).catch((error) => {
                    this.error = 'Token is not valid';
                })
            }
            if (this.method === 'post') {
                axios.post(`api/exercise3post`, {
                    data: this.data,
                    id: this.id
                }).then(resolve => {
                    if (resolve.data.token !== '') {
                        this.token = resolve.data;
                    }
                }).catch((error) => {
                    this.error = 'Token is not valid';
                })
            }
        },

        query() {
            axios.get(`api/exercise`).then(resolve => {
                this.dataQuery = resolve.data;
            })
        }
    },

    mounted() {
        this.query();
    }
}
</script>

<style scoped>

</style>
