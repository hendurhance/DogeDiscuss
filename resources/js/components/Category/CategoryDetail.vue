<template>
  <v-container>
    <div class="inner-wrapper">
      <main>
        <div class="inner-main">
          <div class="question-wrapper">
            <ul>
              <!-- still loading -->
              <loading-spinner v-if="isLoading"></loading-spinner>
              <!-- else question item -->
              <question-item
                v-else
                v-for="question in questions"
                :key="question.slug"
                :question="question"
              ></question-item>
            </ul>
          </div>
        </div>
      </main>
      <aside>
        <h1>Aside</h1>
      </aside>
    </div>
  </v-container>
</template>

<script>
import LoadingSpinner from "../../components/Layout/LoadingSpinner.vue";
export default {
  components: {
    LoadingSpinner,
  },
  props: {
    slug: {
      type: String,
    },
  },
  data() {
    return {
      questions: {},
      isLoading: true,
    };
  },
  mounted() {
    this.getCategory();
  },
  methods: {
    getCategory() {
      const request = Category.getQuestionsByCategory(this.slug);
      request.then((response) => {
        this.questions = response.data.questions;
        console.log(this.questions);
      });
    },
  },
};
</script>

<style lang="css" scoped>
.inner-wrapper {
  display: flex;
  align-items: flex-start;
}

main {
  flex: 1 1 0%;
  padding: 1em;
}
</style>