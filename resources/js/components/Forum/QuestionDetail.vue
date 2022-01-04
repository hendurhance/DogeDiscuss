<template>
  <v-container>
    <div class="question-detail-wrapper">
      <main>
        Hrello
      </main>
      <aside>
        Aside
      </aside>
    </div>
  </v-container>
</template>

<script>
export default {
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

<style>

</style>