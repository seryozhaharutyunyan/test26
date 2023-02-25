<template>
    <div class="col-11 m-auto">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Data</th>
                <th scope="col">Delete</th>
                <th scope="col">Read</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(d,k) in data" :key="k">
                <th scope="row">{{ k + 1 }}</th>
                <td>{{ d.data }}</td>
                <td>
                    <a class="text-danger btn" @click.prevent="deleted(d.id)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-trash-fill" viewBox="0 0 16 16">
                            <path
                                d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                        </svg>
                    </a>
                </td>
                <td>
                    <a class="btn text-info" @click.prevent="createStart(d.data)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-eye-fill" viewBox="0 0 16 16">
                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                            <path
                                d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                        </svg>
                    </a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div ref="li" class="col-5 m-auto">

    </div>
</template>

<script>

import axios from "axios";

export default {
    name: "test2",

    data() {
        return {
            id: '',
            data: {},
        }
    },

    methods: {
        deleted(id) {
            axios.delete(`/api/destroy/${id}`)
                .then(() => {
                    this.query();
                })
        },

        create(data) {
            let fragment = document.createDocumentFragment();
            let ol = document.createElement('ol');
            for (let i in data) {
                if (typeof data[i] === 'object') {
                    let k = this.create(data[i]);
                    console.log(k);
                    let span = document.createElement('span')
                    span.innerText = `${i} ${typeof data[i]}`;
                    k.prepend(span);
                    k.classList.add('drop-content');
                    let li = document.createElement('li');
                    li.append(k);
                    fragment.append(li);
                    continue;
                }

                let li = document.createElement('li');
                li.innerHTML = `${i} ${typeof data[i]}: ${data[i]}`;
                li.classList.add('drop-content');
                fragment.append(li);
            }

            ol.append(fragment);

            return ol;
        },

        createStart(data) {
            data = JSON.parse(data);
            this.$refs.li.innerHTML = '';
            let fragment = document.createDocumentFragment();
            let ol = document.createElement('ol');
            for (let i in data) {
                if (typeof data[i] === 'object') {
                    let li = document.createElement('li');
                    let span = document.createElement('span')
                    span.innerText = `${i} ${typeof data[i]}`;
                    span.classList.add('drop')
                    li.prepend(span);
                    let k = this.create(data[i]);
                    k.classList.add('drop-content');
                    li.append(k);
                    li.classList.add('drop')
                    fragment.append(li);
                    continue;
                }

                let li = document.createElement('li');
                li.innerHTML = `${i} ${typeof data[i]}: ${data[i]}`;
                fragment.append(li);
            }
            ol.append(fragment);
            this.$refs.li.append(ol);
        },

        query() {
            axios.get(`api/exercise`).then(resolve => {
                this.data = resolve.data;
            })
        }
    },

    mounted() {
        this.query();
    }
}
</script>

<style>
ol {
    list-style-type: none;
    padding-left: 5px;
}

li {
    padding-left: 10px;
}

.drop {

    cursor: pointer;
}

.drop-content {
    display: none;
}

.drop:hover .drop-content {
    display: block;
}
</style>
