<template>
  <div>
      <form @submit.prevent="submitForm">
          <InputField name="name" label="Contact Name" placeholder="Contact Name" :errors="errors" @update:field="form.name = $event" />
          <InputField name="email" label="Contact Email" placeholder="your@email.com" :errors="errors" @update:field="form.email = $event" />
          <InputField name="company" label="Company Name" placeholder="Company" :errors="errors" @update:field="form.company = $event" />
          <InputField name="birthday" label="Birthday" placeholder="MM/DD/YYYY" :errors="errors" @update:field="form.birthday = $event" />
          
          <div class="flex justify-end">
              <button class="bg-blue-500 py-2 px-4 rounded text-white mr-5 hover:bg-blue-400">Add New Contact</button>
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
    methods:{
        submitForm(){
            axios.post("/api/contacts", this.form)
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