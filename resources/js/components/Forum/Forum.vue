<template>
  <v-container>
    <div class="inner-wrapper">
      <!-- Main and Aside -->
      <main>Main</main>
      <aside>Aside</aside>
    </div>
  </v-container>
</template>

<script>
export default {

}
</script>

<style lang="css" scoped>
.inner-wrapper {
  display: flex;
  align-items: flex-start;
}

main {
  flex: 1 1 0%;
}

aside {
  display: flex;
  flex-direction: column;
  flex: 0 0 25%;

}

</style>