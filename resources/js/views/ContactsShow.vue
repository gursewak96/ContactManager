<template>
    <div>
        <div class="flex justify-between">
            <div class="text-blue-400">
                &lt; Back
            </div>
            <div>
                <router-link :to="'/contacts/' + this.contact.id + '/edit'" class="px-4 py-2 rounded text-sm font-bold border border-green-500 text-green-500 mr-2">Edit</router-link>
                <a href="#" class="px-4 py-2 rounded text-sm font-bold border border-red-500 text-red-500">Delete</a>
            </div>
        </div>
        <div class="flex items-center pt-6">
            <div>VG</div>
            <p class="pl-5">{{contact.name}}</p>
        </div>

        <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Company</p>
        <p class="pt-2 text-blue-400">{{contact.company}}</p>

        <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Contact</p>
        <p class="pt-2 text-blue-400">{{contact.email}}</p>

        <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Birthday</p>
        <p class="pt-2 text-blue-400">{{contact.birthday}}</p>

    </div>
  
</template>

<script>
export default {

    data(){
        return {
            contact: null,
        }
    },

    mounted(){
        axios.get('/api/contacts/' + this.$route.params.id)
            .then(response=>{
                this.contact = response.data.data;
            }).catch(err=>{

            })
    }
}
</script>

<style>

</style>