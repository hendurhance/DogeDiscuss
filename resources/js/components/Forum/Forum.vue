<template>
  <v-container>
    <div class="inner-wrapper">
      <!-- Main and Aside -->
      <main>
        <div class="inner-main">
          <div class="questions-wrapper">
            <ul>
              <li v-for="(question) in questions" :key="question.slug">
                <div class="question-item">
                  <div class="votes">
                    <button class="upvote" @click="upvote">
                      <img :src="upIcon" alt="">
                    </button>
                    <span class="vote-count">{{question.properties.vote_count}}</span>
                    <button class="downvote" @click="downvote">
                      <img :src="downIcon" alt="">
                    </button>
                  </div>
                  <div class="question-content">
                    <h4>
                      <router-link to="/question/1">
                        {{question.title}}
                      </router-link>
                    </h4>
                    <p>
                      {{question.body}}
                    </p>
                    <div class="question-meta">
                      <span class="reply-count">
                        <router-link to="/">
                          {{question.properties.reply_count}}
                        </router-link>
                      </span>
                      <span class="category-type">
                        <router-link to="/">
                          /c/{{question.category}}
                        </router-link>
                      </span>
                      <span class="asked-by">
                        by {{question.author}}
                      </span>
                      <span class="asked-on">
                        <span>{{ question.created_at }}</span>
                      </span>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </main>
      <aside>
        <div class="inner-aside">
          <div class="aside-header-wrapper">
            <h3>TOP HEADLINES</h3>
          </div>
          <!-- v-for loop of news using ul -->
          <ul>
            <li v-for="(news) in news" :key="news.id">
              <a :href="news.url" target="_blank">
                <img :src="news.urlToImage" alt="" />
                <h4>{{ news.title }}</h4>
                <p>{{ news.description }}</p>
              </a>
            </li>
          </ul>
        </div>
      </aside>
    </div>
  </v-container>
</template>

<script>
// import icons
import upIcon from "../../../../public/img/vuesax/bold/upvote.svg";
import downIcon from "../../../../public/img/vuesax/bold/downvote.svg";
export default {
  data() {
    return {
      upIcon: upIcon,
      downIcon: downIcon,
      news: [],
      questions: [],
      isNotLoggedIn: true,
    };
  },
  methods: {
    upvote() {
      console.log("upvote");
    },
    downvote() {
      console.log("downvote");
    },
  },
  mounted() {
    // use Crypto class to get doge news
    const news = CryptoReq.getNews();
    news.then(response => {
      // slice the first 5 news and cut the description to 100 characters
      this.news = response.articles.slice(0, 5).map(news => {
        news.description = news.description.slice(0, 100) + "...Read More";
        return news;
      });
      this.news = response.articles.slice(0, 5);
    }).catch(error => {
      console.log(error);
    });

    // use Question class to get questions
    const questions = Question.getAllQuestions();
    questions.then(response => {
      this.questions = response.data
      console.log(response);
    }).catch(error => {
      console.log(error);
    });
  },
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
  position: sticky;
  top: 0;
  z-index: 1;
  height: 600px;
  overflow: auto;
  scroll-behavior: smooth;
  scrollbar-width: none;
  -ms-overflow-style: none;
  -webkit-overflow-scrolling: touch;

}
::-webkit-scrollbar {
    display: none;
}
.inner-aside {
  background: #faf5ef;
}

.aside-header-wrapper{
  display: flex;
  justify-content: center;
  align-items: center;
  margin-bottom: 1em;
  background: #0f4c5c;
  color: #fff;
  padding: 0.5em;
  position: sticky;
  top: 0;
  z-index: 1;

}

.inner-aside ul {
  list-style: none;
  padding: 1em;
  margin: 0;
}

.inner-aside ul li a{
  text-decoration: none;
}

.inner-aside ul li a h4{
  color: #000;
}

.inner-aside ul li a p{
  color: #000;
  font-size: 0.8em;
  opacity: 0.8;
}

.inner-aside ul li a img{
  width: 100%;
  height: auto;
}

main{
  padding: 1em;
}

.questions-wrapper ul{
  list-style: none;
  padding: 0;
  margin: 0;
}

li .question-item{
  display: flex;
  height: auto;
  background-color: rgb(255, 255, 255);
}

.question-item .votes{
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

.question-content{
  display: flex;
  flex: 1 1 0%;
  flex-direction: column;
  border-left: 1px solid rgb(235, 237, 240);
  padding: 8px;
  min-width: 0px;
}

.question-content h4 a{
  font-size: 1.2em;
  font-weight: 500;
  margin: 0;
  padding: 0;
  color: rgb(36, 43, 40);
  text-decoration: none;
}

.question-content p{
  font-size: 1em;
  margin: 0;
  padding: 0;
  color: rgb(36, 43, 40);
  opacity: 0.8;
}
.question-meta span{
  font-size: 1em;
}

.question-meta span:first-child{
  margin-right: .1em;
}

.question-meta span:nth-child(3){
  font-weight: 500;
  margin-right: .1em;
  margin-left: .1em;
}

.question-meta span a{
  color: rgb(36, 43, 40);
  text-decoration: none;
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