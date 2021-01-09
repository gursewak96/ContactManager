<template>
  <div v-if="isLoading" class="flex h-full justify-center items-center">
        <img v-if="isLoading" :src="spinner" class="max-w-sm block"/>
    </div>
    <div v-else class="h-full">
        <div v-if="contacts.length === 0" class="h-full flex flex-col justify-center items-center" >
            <h1 class="text-gray-400 text-4xl">Nothin Found! 😴</h1>
        </div>

        <div v-for="(contact, index) in contacts" :key="index">
            <router-link :to="'/contacts/'+contact.data.contact_id" class="flex items-center border-b border-gray-400 p-4 hover:bg-gray-100">
                <user-circle :name="contact.data.name"/>
                <div class="pl-4">
                    <p class="text-blue-400 font-bold">{{contact.data.name}}</p>
                    <p class="text-gray-600">{{contact.data.company}}</p>
                </div>
            </router-link>
        </div>
    </div>
</template>

<script>
import UserCircle from "../components/UserCircle";
export default {
     components:{
        UserCircle
    },
    props:[
        'endpoint',
    ],

    data(){
        return {
            isLoading: true,
            contacts: null,
            spinner : "http://localhost:8000/images/spinner.gif",
        }
    },
     mounted(){
        axios.get(this.endpoint)
            .then(reponse=>{
                this.contacts = reponse.data.data;
                this.isLoading = false;
            }).catch(err=>{
                this.isLoading = false;
                alert('Unable to find the contacts');
            })
    }

}
</script>

<style>

</style>