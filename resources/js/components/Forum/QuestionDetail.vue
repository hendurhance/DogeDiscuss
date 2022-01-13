<template>
  <v-container>
    <div class="question-detail-wrapper">
      <main>
        <loading-spinner v-if="isLoading"></loading-spinner>
        <section v-else>
          <div class="question-wrapper">
            <div class="question-main-grid">
              <div class="votes">
                <button @click="vote(question.slug, 'up')">
                  <svg
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M18.6806 13.9783L15.4706 10.7683L13.5106 8.79828C12.6806 7.96828 11.3306 7.96828 10.5006 8.79828L5.32056 13.9783C4.64056 14.6583 5.13056 15.8183 6.08056 15.8183H11.6906H17.9206C18.8806 15.8183 19.3606 14.6583 18.6806 13.9783Z"
                      :fill="upVoteColor"
                    />
                  </svg>
                </button>
                <span> {{ upVoteCount }} </span>
                <button @click="vote(question.slug, 'down')">
                  <svg
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M17.9188 8.17969H11.6888H6.07877C5.11877 8.17969 4.63877 9.33969 5.31877 10.0197L10.4988 15.1997C11.3288 16.0297 12.6788 16.0297 13.5088 15.1997L15.4788 13.2297L18.6888 10.0197C19.3588 9.33969 18.8788 8.17969 17.9188 8.17969Z"
                      :fill="downVoteColor"
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
                    <router-link to="/">
                      {{ replyCount }} comments
                    </router-link>
                  </span>
                  <span class="category-type">
                    <router-link to="/">
                      /c/{{ question.category }}
                    </router-link>
                  </span>
                  <span class="asked-by"> by {{ question.user }} </span>
                  <span class="asked-on">
                    <span>{{ question.created_at }}</span>
                  </span>
                </div>
              </div>
            </div>
            <div class="question-stats">
              <span> {{ viewsCount }} views </span>
              <span> {{ upVotedPercent }}% upvoted </span>
              <span v-if="!ownsQuestion"> <router-link :to="{name: 'edit', params: {slug: question.slug}}">edit</router-link> </span>
              <span v-if="!ownsQuestion" @click="deleteQuestion(question.slug)"> delete </span>
            </div>
          </div>
          <div class="reply-wrapper">
            <div class="new-reply">
              <form>
                <textarea rows="2" placeholder="Enter your reply..."></textarea>
                <input type="submit" value="Add Reply" />
              </form>
            </div>
            <div class="question-replies">
              <!-- use v-for to loop replies -->
              <div class="reply" v-for="reply in replies" :key="reply.body">
                <div class="reply-header">
                  <span>{{ reply.user }}</span>
                  <span>{{ reply.created_at }}</span>
                </div>
                <div class="reply-body">
                  <p>{{ reply.reply }}</p>
                </div>
              </div>
            </div>
          </div>
        </section>
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
      viewsCount: 0,
      userVoteType: null,
      upVotedPercent: 0.0,
      isLoading: true,
      replies: [],
      isAuthenticated: false,
      ownsQuestion: false,
    };
  },
  props: {
    slug: {
      type: String,
      required: true,
    },
  },
  methods: {
    vote(slug, vote_type) {
      console.log(slug, vote_type, this.userVoteType);
      // if user is not authenticated, alert them to login
      if (!this.isAuthenticated) {
        alert("You must be logged in to vote");
      }else{
        if (this.userVoteType === vote_type) {
          const reset = Question.resetVoteQuestion(slug);
          reset.then((response) => {
            console.log(response);
            const data = response.properties
            this.upVoteCount = data.up_votes
            this.userVoteType = null
            this.upVoteColor = "#9E9E9E"
            this.downVoteColor = "#9E9E9E"
            const percent = (data.up_votes / data.votes_count) * 100
            // if percent is NaN, set it to 0
            if (isNaN(percent)) {
              this.upVotedPercent = 0
            } else {
              this.upVotedPercent = Math.round(percent * 100) / 100
            }
          });
        } else {
          const vote = Question.voteQuestion(slug, vote_type);
          vote.then((response) => {
            console.log(response);
            const data = response.properties
            this.upVoteCount = data.up_votes
            this.userVoteType = vote_type
            const percent = (data.up_votes / data.vote_count) * 100
            // if percent is NaN, set it to 0
            if (isNaN(percent)) {
              this.upVotedPercent = 0
            } else {
              this.upVotedPercent = Math.round(percent * 100) / 100
            }
            if (vote_type === 'up') {
              this.upVoteColor = "#00C853"
              this.downVoteColor = "#9E9E9E"
            } else {
              this.upVoteColor = "#9E9E9E"
              this.downVoteColor = "#D50000"
            }
          });
        }
      }
    },
    userOwnsQuestion() {
      let question_user = this.question.user;
      let auth_user = User.getUsersName();
      if (question_user == auth_user) {
        this.ownQuestion = true;
      } else {
        this.ownQuestion = false;
      }
    },
    deleteQuestion(slug) {
      if (confirm("Are you sure you want to delete this question?")) {
        console.log(slug);
        // const deleteQuestion = Question.deleteQuestion(slug);
        // deleteQuestion.then((response) => {
        //   console.log(response);
        //  this.$router.push("/");
        // });
      }
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
        // user vote type
        this.userVoteType = this.question.user_vote;
        this.upVoteCount = this.question.properties.up_votes;
        // set vote color
        if (this.userVoteType === "up") {
          this.upVoteColor = "#00C853";
          this.downVoteColor = "#9E9E9E";
        } else if (this.userVoteType === "down") {
          this.upVoteColor = "#9E9E9E";
          this.downVoteColor = "#D50000";
        }else{
          this.upVoteColor = "#9E9E9E";
          this.downVoteColor = "#9E9E9E";
        }

        // count length of replies array
        this.viewsCount = this.question.properties.views;
        this.replyCount = this.question.replies.length;
        this.replies = this.question.replies;
        // calc upvote percent and round to 2 decimal places
        const percent =
          (this.question.properties.up_votes /
            (this.question.properties.up_votes +
              this.question.properties.down_votes)) *
          100;
        // if percent is NaN, set to 0
        if (isNaN(percent)) {
          this.upVotedPercent = 0;
        } else {
          this.upVotedPercent = Math.round(percent * 100) / 100;
        }
        console.log(response);
      })
      .catch((error) => {
        console.log(error);
      })
      .finally(() => {
        this.isLoading = false;
      });

    this.userOwnsQuestion();

    // check if user is authenticated
    // if user is authenticated
    if (User.checkIfLoggedIn()) {
      this.isAuthenticated = true;
    }
  },
};
</script>

<style lang="css">
section {
  display: grid;
  grid-template-rows: 1fr;
  row-gap: 1rem;
}

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
  background-color: rgb(243 243 243);
  border: 1px solid rgb(235, 237, 240);
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
}

.question-content div:nth-child(3) {
  border-top: 1px solid rgb(235, 237, 240);
}

.question-stats {
  background-color: rgb(243 243 243);
  padding: 5px 10px;
  display: flex;
  justify-content: space-between;
}
/* Reply */

.reply-wrapper {
  background-color: rgb(243 243 243);
  padding: 1em;
}

.new-reply form {
  margin: 0.5em 0;
  border-bottom: 1px solid rgb(235, 237, 240);
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

.new-reply form textarea {
  width: 100%;
  background: #fff;
  border: 1px solid #0f4c5c;
  padding: 10px;
  resize: none;
  outline: none;
  font-size: 15px;
  appearance: none;
}

.new-reply form input[type="submit"] {
  background: #0f4c5c;
  color: #fff;
  font-size: 12px;
  padding: 4px 12px;
  text-transform: uppercase;
  margin: 0.5em 0;
  align-self: flex-end;
}

.question-replies {
  margin-top: 0.5em;
}

.question-replies .reply {
  padding: 1em 0;
  border-bottom: 1px solid rgb(235, 237, 240);
}

.reply-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid rgb(235, 237, 240);
}

.reply-header span {
  font-size: 14px;
}

.reply-header span:first-child {
  font-weight: 600;
}

.reply-body p {
  font-size: 1em;
  opacity: 0.8;
  color: rgb(36, 43, 40);
}

@media (max-width: 576px) {
  main {
    padding: 0;
  }
}
</style>