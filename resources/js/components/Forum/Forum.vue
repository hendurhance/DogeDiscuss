<template>
  <v-container>
    <div class="inner-wrapper">
      <!-- Main and Aside -->
      <main>
        <div class="inner-main">
          <div class="questions-wrapper">
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
      <base-aside></base-aside>
    </div>
  </v-container>
</template>

<script>
import QuestionItem from "../../../../resources/js/components/Forum/QuestionItem.vue";
import LoadingSpinner from "../Layout/LoadingSpinner.vue";
import BaseAside from "../../layout/BaseAside.vue";
export default {
  components: {
    "question-item": QuestionItem,
    LoadingSpinner,
    BaseAside
  },
  data() {
    return {
      news: [],
      questions: [],
      isNotLoggedIn: true,
      isLoading: true,
    };
  },
  methods: {
  },
  mounted() {
    // use Question class to get questions
    const questions = Question.getAllQuestions();
    questions
      .then((response) => {
        this.questions = response.data;
      })
      .catch((error) => {
        console.log(error);
      })
      .finally(() => {
        this.isLoading = false;
      });
  }
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

.questions-wrapper ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

/* less than 768px aside does not show */
@media (max-width: 768px) {
  aside {
    display: none;
  }
}

/* on mobile no padding on main */
@media (max-width: 576px) {
  main {
    padding: 0;
  }
}
</style>