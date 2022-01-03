<template>
  <li>
    <div class="question-item">
      <div class="votes">
        <button class="upvote" @click="upvote">
          <img :src="upIcon" alt="" />
        </button>
        <span class="vote-count">{{ question.properties.vote_count }}</span>
        <button class="downvote" @click="downvote">
          <img :src="downIcon" alt="" />
        </button>
      </div>
      <div class="question-content">
        <h4>
          <router-link :to="{ name: 'question', params: { slug: question.slug } }">
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
            required: true
        }
    },
    data(){
        return {
            upIcon: upIcon,
            downIcon: downIcon
        }
    },
    methods: {
        upvote(){
            console.log('upvote')
        },
        downvote(){
            console.log('downvote');
        }
    }
};
</script>

<style lang="css">
li .question-item{
  display: flex;
  height: auto;
  background-color: rgb(255, 255, 255);
}

li:not(:first-child) .question-item{
    border-top: 1px solid rgb(235, 237, 240);
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
</style>