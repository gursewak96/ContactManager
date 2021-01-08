<template>
  <div class="relative pb-4">
        <label :for="name" class="absolute pt-2 text-blue-500 uppercase text-xs font-bold">{{label}}</label>
        <input type="text" v-model="value" :id="name" :class="errorClassObject(name)" class="pt-8 w-full border-b pb-2 text-gray-900 focus:outline-none focus:border-blue-400" @input="updateField(name)" :placeholder="placeholder">
        <p class="text-red-600 text-sm" v-text="errorMessage(name)">Error here</p>
    </div>
</template>

<script>

export default {
    props:[
        'name',
        'label',
        'placeholder',
        'errors'
    ],

    data: function(){
        return {
            value: ""
        }
    },

    computed:{
        hasError: function(){
            return this.errors && this.errors[this.name] && this.errors[this.name].length > 0;
        }
    },

    methods:{
        updateField : function(field){
            this.clearErrors(field);
            this.$emit('update:field',this.value)
        },

        errorMessage : function(field){
            if( this.hasError)
                return this.errors[field][0];
        },

        clearErrors: function (field) {
            if( this.hasError)
                this.errors[field] = null;
        },

        errorClassObject: function(field){
            return {
                'error-field': this.hasError
            }
        }
    }
}
</script>

<style scoped>
.error-field{
    @apply border-red-500 border-b-2
}
</style>
