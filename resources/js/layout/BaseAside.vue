<template>
  <aside>
    <div class="inner-aside">
      <div class="aside-header-wrapper">
        <h3>TOP HEADLINES</h3>
      </div>
      <!-- v-for loop of news using ul -->
      <ul>
        <li v-for="news in news" :key="news.id">
          <a :href="news.url" target="_blank">
            <img :src="news.urlToImage" alt="" />
            <h4>{{ news.title }}</h4>
            <p>{{ news.description }}</p>
          </a>
        </li>
      </ul>
    </div>
  </aside>
</template>

<script>
export default {
  data() {
    return {
      news: [],
    };
  },
  methods: {},
  mounted() {
    // use Crypto class to get doge news
    const news = CryptoReq.getNews();
    news
      .then((response) => {
        // slice the first 5 news and cut the description to 100 characters
        this.news = response.articles.slice(0, 5).map((news) => {
          news.description = news.description.slice(0, 100) + "...Read More";
          return news;
        });
        this.news = response.articles.slice(0, 5);
      })
      .catch((error) => {
        console.log(error);
      });
  },
};
</script>

<style lang="css">
aside {
  display: flex;
  flex-direction: column;
  flex: 0 0 25%;
  position: sticky;
  top: 2em;
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

.aside-header-wrapper {
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

.inner-aside ul li a {
  text-decoration: none;
}

.inner-aside ul li a h4 {
  color: #000;
}

.inner-aside ul li a p {
  color: #000;
  font-size: 0.8em;
  opacity: 0.8;
}

.inner-aside ul li a img {
  width: 100%;
  height: auto;
}

/* less than 768px aside does not show */
@media (max-width: 768px) {
  aside {
    display: none;
  }
}

</style>