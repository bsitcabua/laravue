<template>
    <div>
        <h1 ref="myRef">Hooks</h1>
        <h2>My name is {{ name }}</h2>
    </div>
</template>

<script>
export default {
    data(){
        return {
            name: 'EM'
        }
    },

    beforeCreate() {
        console.log(this.name);
    },

    created(){
        console.log("My name is ", this.name );
    },

    mounted(){
        console.log(this.$refs.myRef)
    }
}
</script>