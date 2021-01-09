<template>
  <div>
      <form @submit.prevent="submitForm">
          <InputField name="name" label="Contact Name" placeholder="Contact Name" :errors="errors" @update:field="form.name = $event" :data="form.name" />
          <InputField name="email" label="Contact Email" placeholder="your@email.com" :errors="errors" @update:field="form.email = $event" :data="form.email" />
          <InputField name="company" label="Company Name" placeholder="Company" :errors="errors" @update:field="form.company = $event" :data="form.company" />
          <InputField name="birthday" label="Birthday" placeholder="MM/DD/YYYY" :errors="errors" @update:field="form.birthday = $event" :data="form.birthday" />
          
          <div class="flex justify-end">
              <button class="bg-blue-500 py-2 px-4 rounded text-white mr-5 hover:bg-blue-400">Update Contact</button>
              <button class="py-2 px-4 rounded text-red-700 border hover:border-red-700">Cancel</button>
          </div>
      </form>
  </div>
</template>

<script>
import InputField from "../components/InputField"
export default {
    components: {
        InputField
    },
    data:function(){
        return {
            form: {
                name: "",
                email: "",
                company: "",
                birthday: ""
            },
            errors:null
        }
    },

    mounted(){
        axios.get('/api/contacts/' + this.$route.params.id)
            .then(response=>{
                this.form = response.data.data;
                // this.isLoading = false
            }).catch(err=>{
                // this.isLoading = false;
                if(err.response.status==404)
                    this.$router.push('/contacts');
                
            })
    },

    methods:{
        submitForm(){
            axios.patch("/api/contacts/"+this.$route.params.id, this.form)
                .then(response => {
                    this.$router.push(response.data.links.self);
                }).catch(err=>{
                    console.log(err.response.data.errors);
                    this.errors = err.response.data.errors;
                })
        }
    }
}
</script>

<style>

</style>