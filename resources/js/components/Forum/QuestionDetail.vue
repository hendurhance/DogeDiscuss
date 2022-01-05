<template>
  <v-container>
    <div class="question-detail-wrapper">
      <main>
        Test
      </main>
      <base-aside></base-aside>
    </div>
  </v-container>
</template>

<script>
import BaseAside from "../../layout/BaseAside.vue";
export default {
  components: {
    BaseAside,
  },
  data(){
    return {
      question: {},
    }
  },
  props: {
    slug: {
      type: String,
      required: true
    }
  },
  created() {
    // get slug from props
    const slug = this.slug;
    // use Forum class to get forum
    const forum = Question.getQuestionBySlug(slug);
    forum
      .then((response) => {
        this.forum = response.data;
        console.log(response);
      })
      .catch((error) => {
        console.log(error);
      });
  },

}
</script>

<style lang="css">
.question-detail-wrapper {
  display: flex;
  align-items: flex-start;
}

main {
  flex: 1 1 0%;
  padding: 1em;
}


</style>