<script>
export default {
  setup() {
    let helloWorld = "Hello World";


    return{
      helloWorld
    }
  },

}
</script>

<template>
    <h1 class="text-3xl font-bold underline">
      {{ helloWorld }}
    </h1>
</template>