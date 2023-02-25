<template>
    <div class="text-center mt-3 mb-3">
        <router-link :to="{name:'test2'}">Exercise 2 |</router-link>
        <router-link :to="{name:'test3'}"> Exercise 3 |</router-link>
        <router-link :to="{name:'test4'}"> Exercise 4</router-link>
    </div>
    <router-view></router-view>
</template>

<script>
export default {
    name: "App"
}
</script>
