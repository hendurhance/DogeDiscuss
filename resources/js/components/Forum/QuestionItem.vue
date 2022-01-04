<template>
  <li>
    <div class="question-item">
      <div class="votes" :vote-type="question.user_vote">
        <button class="upvote" @click="vote(question.slug, 'up')">
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
        <span class="vote-count">{{ upVoteCount }}</span>
        <button class="downvote" @click="vote(question.slug, 'down')">
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
        <h4>
          <router-link
            :to="{ name: 'question', params: { slug: question.slug } }"
          >
            {{ question.title }}
          </router-link>
        </h4>
        <p>
          {{ question.body }}
        </p>
        <div class="question-meta">
          <span class="reply-count">
            <router-link to="/">
              {{ question.properties.reply_count }} comments
            </router-link>
          </span>
          <span class="category-type">
            <router-link to="/"> /c/{{ question.category }} </router-link>
          </span>
          <span class="asked-by"> by {{ question.author }} </span>
          <span class="asked-on">
            <span>{{ question.created_at }}</span>
          </span>
        </div>
      </div>
    </div>
  </li>
</template>

<script>
import upIcon from "../../../../public/img/vuesax/bold/upvote.svg";
import downIcon from "../../../../public/img/vuesax/bold/downvote.svg";
export default {
  props: {
    question: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      upIcon: upIcon,
      downIcon: downIcon,
      isAuthenticated: false,
      userVoteType: this.question.user_vote,
      upVoteColor: this.question.user_vote === "up" ? "#00C853" : "#9E9E9E",
      downVoteColor: this.question.user_vote === "down" ? "#D50000" : "#9E9E9E",
    };
  },
  methods: {
    vote(slug, vote_type) {
      console.log(slug, vote_type, this.userVoteType);
      // if user is not authenticated
      if (!this.isAuthenticated) {
        // show login modal
        alert("You must be logged in to vote");
      } else {
        // if user userVoteType is to vote_type
        if (this.userVoteType === vote_type) {
          // remove vote
          const reset = Question.resetVoteQuestion(slug);
          reset
            .then((response) => {
              console.log(response);
              const data = response.properties;
              this.question.properties.up_votes = data.up_votes;
              this.question.properties.down_votes = data.down_votes;
              this.question.user_vote = null;
              this.userVoteType = null;
              // change color of upvote and downvote
              this.upVoteColor = "#9E9E9E";
              this.downVoteColor = "#9E9E9E";
            })
            .catch((error) => {
              console.log(error);
            });
        } else {
          // vote
          const vote = Question.voteQuestion(slug, vote_type);
          vote
            .then((response) => {
              const data = response.properties;
              this.question.properties.up_votes = data.up_votes;
              this.userVoteType = data.user_vote;
              console.log(response);
              // change color of upvote/downvote button
              if(this.userVoteType === "up") {
                this.upVoteColor = "#00C853";
                this.downVoteColor = "#9E9E9E";
              } else if(this.userVoteType === "down") {
                this.upVoteColor = "#9E9E9E";
                this.downVoteColor = "#D50000";
              }

            })
            .catch((error) => {
              console.log(error);
            });
        }
      }
    },
  },
  computed: {
    upVoteCount() {
      return this.question.properties.up_votes;
    },
  },
  mounted() {
    // if user is authenticated
    if (User.checkIfLoggedIn()) {
      this.isAuthenticated = true;
    }
  },
};
</script>

<style lang="css">
li .question-item {
  display: flex;
  height: auto;
  background-color: rgb(255, 255, 255);
}

li:not(:first-child) .question-item {
  border-top: 1px solid rgb(235, 237, 240);
}

.question-item .votes {
  display: flex;
  flex-direction: column;
  -webkit-box-align: center;
  align-items: center;
  justify-content: center;
  width: 30px;
  padding: 4px;
  font-size: 12px;
  line-height: 25px;
  font-weight: 500;
  text-align: center;
  color: rgb(36, 43, 40);
}

.question-content {
  display: flex;
  flex: 1 1 0%;
  flex-direction: column;
  border-left: 1px solid rgb(235, 237, 240);
  padding: 8px;
  min-width: 0px;
}

.question-content h4 a {
  font-size: 1.2em;
  font-weight: 500;
  margin: 0;
  padding: 0;
  color: rgb(36, 43, 40);
  text-decoration: none;
}

.question-content p {
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

.question-meta span a {
  color: rgb(36, 43, 40);
  text-decoration: none;
}
</style>