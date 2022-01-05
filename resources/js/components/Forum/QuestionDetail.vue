<template>
  <v-container>
    <div class="question-detail-wrapper">
      <main>
        <loading-spinner v-if="isLoading"></loading-spinner>
        <div class="question-wrapper" v-else>
          <div class="question-main-grid">
            <div class="votes">
              <button>
                <svg
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M18.6806 13.9783L15.4706 10.7683L13.5106 8.79828C12.6806 7.96828 11.3306 7.96828 10.5006 8.79828L5.32056 13.9783C4.64056 14.6583 5.13056 15.8183 6.08056 15.8183H11.6906H17.9206C18.8806 15.8183 19.3606 14.6583 18.6806 13.9783Z"
                    :fill="
                      this.question.user_vote === 'up' ? '#00C853' : '#9E9E9E'
                    "
                  />
                </svg>
              </button>
              <span> {{ upVoteCount }} </span>
              <button>
                <svg
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M17.9188 8.17969H11.6888H6.07877C5.11877 8.17969 4.63877 9.33969 5.31877 10.0197L10.4988 15.1997C11.3288 16.0297 12.6788 16.0297 13.5088 15.1997L15.4788 13.2297L18.6888 10.0197C19.3588 9.33969 18.8788 8.17969 17.9188 8.17969Z"
                    :fill="
                      this.question.user_vote === 'down' ? '#D50000' : '#9E9E9E'
                    "
                  />
                </svg>
              </button>
            </div>
            <div class="question-content">
              <div class="question-title">
                <h1>{{ question.title }}</h1>
              </div>
              <div class="question-description">
                <p>{{ question.body }}</p>
              </div>
              <div class="question-meta">
                <span class="reply-count">
                  <router-link to="/"> {{ replyCount }} comments </router-link>
                </span>
                <span class="category-type">
                  <router-link to="/"> /c/{{ question.category }} </router-link>
                </span>
                <span class="asked-by"> by {{ question.user }} </span>
                <span class="asked-on">
                  <span>{{ question.created_at }}</span>
                </span>
              </div>
            </div>
          </div>
        </div>
      </main>
      <base-aside></base-aside>
    </div>
  </v-container>
</template>

<script>
import BaseAside from "../../layout/BaseAside.vue";
import LoadingSpinner from "../Layout/LoadingSpinner.vue";
export default {
  components: {
    BaseAside,
    LoadingSpinner,
  },
  data() {
    return {
      question: {},
      upVoteCount: 0,
      upVoteColor: "#9E9E9E",
      downVoteColor: "#9E9E9E",
      replyCount: 0,
      isLoading: true,
    };
  },
  props: {
    slug: {
      type: String,
      required: true,
    },
  },
  computed: {},
  created() {
    // get slug from props
    const slug = this.slug;
    // use Forum class to get forum
    const forum = Question.getQuestionBySlug(slug);
    forum
      .then((response) => {
        this.question = response.data;
        this.upVoteCount = this.question.properties.up_votes;
        // count length of replies array
        this.replyCount = this.question.replies.length;
        console.log(response);
      })
      .catch((error) => {
        console.log(error);
      }).finally(() => {
        this.isLoading = false;
      });
  },
};
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

.question-main-grid {
  display: flex;
  height: auto;
  background-color: rgb(255, 255, 255);
}

.question-main-grid .votes {
  display: flex;
  flex-direction: column;
  -webkit-box-align: center;
  align-items: center;
  justify-content: flex-start;
  width: 30px;
  padding: 4px;
  font-size: 12px;
  line-height: 25px;
  font-weight: 500;
  text-align: center;
  color: rgb(36, 43, 40);
}

.question-content .question-title h1 {
  font-size: 1.2em;
  font-weight: 500;
  margin: 0;
  padding: 0;
  color: rgb(36, 43, 40);
  text-decoration: none;
}

.question-content .question-description p {
  font-size: 1em;
  margin: 0;
  padding: 0;
  color: rgb(36, 43, 40);
  opacity: 0.8;
}

.question-meta span {
  font-size: 1em;
}

.question-meta span:first-child {
  margin-right: 0.1em;
}

.question-meta span:nth-child(3) {
  font-weight: 500;
  margin-right: 0.1em;
  margin-left: 0.1em;
}

/* second child on question content */
.question-content div:nth-child(2) {
  border-top: 1px solid rgb(235, 237, 240);
  border-bottom: 1px solid rgb(235, 237, 240);
  background-color: rgb(252, 252, 252);
}

.question-content div:nth-child(3) {
  border-top: 1px solid rgb(235, 237, 240);
  background-color: rgb(252, 252, 252);
}


</style>