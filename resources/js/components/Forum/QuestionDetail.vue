<template>
  <h1>Single Forum</h1>
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