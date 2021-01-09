<template>
    <div class="rounded-full border border-gray-400 text-white bg-blue-400 w-10 h-10 flex items-center justify-center">
        {{userCircle}}
    </div>
</template>

<script>
export default {
    props:[
        'name'
    ],

    computed:{
        userCircle(){
            // Example: James Doe ==> JD ==> '
            return this.name.match(/[A-Z]/g).slice(0,2).join(""); 
        }
    }
}
</script>

<style>

</style>