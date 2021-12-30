<template>
  <div>
    <div class="hero-section">
      <v-container>
        <div class="hero-section__wrapper">
          <div class="hero-grid">
            <div class="hero-item">
              <div class="hero-inner_wrapper">
                <h1>Dive into the world where your opinions are valid</h1>
                <p>
                  DogeDiscuss is a platform for thousands of communities to
                  share opinions regarding trending crypto coin. Our goal is to
                  empower teams, communities with new insight into the web3
                  world as we approach the post-pandemic era.
                </p>
                <base-button link mode="outline"> Get Started </base-button>
              </div>
            </div>
            <div class="hero-item">
              <div class="hero-inner_wrapper">
                <img :src="heroImg" alt="" />
              </div>
            </div>
          </div>
        </div>
      </v-container>
    </div>

    <!-- feature section -->
    <v-container>
      <section class="feature-section">
        <div class="feature-inner-wrapper">
          <div class="feature-grids">
            <div class="feature-item">
              <div class="feature-inner_wrapper">
                <div class="feature-icon">
                  <img
                    :src="user"
                    alt=""
                  />
                </div>
                <div class="feature-content">
                  <h3>Create your account</h3>
                  <p>Create your account and start sharing your opinions.</p>
                </div>
              </div>
            </div>
            <div class="feature-item">
              <div class="feature-inner_wrapper">
                <div class="feature-icon">
                  <img
                    :src="chat"
                    alt=""
                  />
                </div>
                <div class="feature-content">
                  <h3>Share your opinion</h3>
                  <p>Share your opinion and get feedback from other users.</p>
                </div>
              </div>
            </div>
            <div class="feature-item">
              <div class="feature-inner_wrapper">
                <div class="feature-icon">
                  <img
                    :src="feedback"
                    alt=""
                  />
                </div>
                <div class="feature-content">
                  <h3>Get feedback</h3>
                  <p>
                    Get feedback from other users and help them to improve
                    their opinions.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </v-container>

    <!-- Crypto SHowcase -->
    <v-container>
      <div class="showcase-wrapper">
        <div class="justify-container">
          <div class="horizontal-line"></div>
        </div>
        <div class="showcase-grid">
          <div class="showcase-item">
            <div class="showcase-inner_wrapper">
              <img :src="discuss" alt="">
            </div>
          </div>
          <div class="showcase-item">
            <div class="showcase-inner_wrapper __text">
              <div class="showcase-contain">
                <div class="asset-title">
                  <img :src="doge" alt="">
                  <h2>{{ assetName }}</h2>
                </div>
                <h1> {{rate}} </h1>
              </div>
            </div>
          </div>
        </div>
      </div>
    </v-container>
  </div>
</template>

<script>
import heroImg from "../../../public/img/hero-img.png";
import User from "../../../public/img/create.svg"
import Chat from "../../../public/img/chat.svg"
import Feedback from "../../../public/img/feedback.svg"
import Discuss from "../../../public/img/discuss.png"
import Doge from "../../../public/img/doge.svg"

export default {
  data() {
    return {
      heroImg: heroImg,
      user: User,
      chat: Chat,
      feedback: Feedback,
      discuss: Discuss,
      doge: Doge,
      data: [],
      asset: []
    };
  },
  mounted() {
    // use axios to call https://pro-api.coinmarketcap.com/v1/cryptocurrency/map
    // and get the data
    // setting headers of api key and accept
    // then get the data
    // and set the data to the state
    axios
      .get("https://rest.coinapi.io/v1/exchangerate/DOGE/USD?apikey=DB057B64-B8D7-4448-810E-90D61FD3C819", {
        headers: {
          Accept: "application/json",
        },
      })
      .then((response) => {
        this.data = response.data;
      })
      .catch((error) => {
        console.log(error);
      });
  },
  computed: {
    assetName() {
      return this.data.asset_id_base;
    },
    rate() {
      // return rate at round 2
      return '$' + " " + this.data.rate + " " + this.data.asset_id_quote;
    }
  },
  // toFixed function


};
</script>

<style lang="css" scoped>
.hero-section__wrapper {
  position: relative;
}

.hero-grid {
  display: grid;
  grid-template-columns: 50% 50%;
  grid-gap: 1rem;
  padding: 1rem;
  align-items: center;
}

.hero-inner_wrapper img {
  width: 100%;
}

.hero-inner_wrapper h1 {
  font-size: 3rem;
  font-weight: 700;
  color: #000;
  margin-bottom: 1rem;
  line-height: 1;
}

.hero-inner_wrapper p {
  font-size: 0.8rem;
  color: #000;
  opacity: 0.6;
}

section.feature-section{
  background-color: rgb(15 76 92);
  background-image: linear-gradient(180deg, rgba(15, 76, 92, 0.95), rgba(15, 76, 92, 0.95)), url(/images/wave.png?f3764c8…);
  background-position: 0px 0px, 50% 50%;
  border-radius: 25px;
  margin: 5rem 0;
}

.feature-inner_wrapper{
  padding: 2em;
}

.feature-grids{
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  grid-gap: 1rem;
  padding: 1rem;
  align-items: center;
  color: #fff;
}


/* Feature Item Component */
.feature-content h3{
  font-size: 1.5rem;
  font-weight: 700;
  margin-bottom: 1rem;
  line-height: 1;
}

.feature-content p{
  font-size: 0.9rem;
  color: #fff;
  opacity: 0.8;
}

.feature-icon img{
  width: 50px;
  margin-bottom: 1rem;
}


/* End */
.justify-container{
  display: flex;
  justify-content: center;
}

.horizontal-line{
  height: 5rem;
  border-left: 5px solid #0f4c5c;
  opacity: 50%;
  padding: 0;
  display: flex;
}

.showcase-grid{
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  grid-gap: 1rem;
  padding: 1rem;
  align-items: center;
}

.showcase-inner_wrapper.__text{
  background: rgb(59, 59, 59);
  color: #fff;
  border: #000 solid 4px;
  border-radius: 30px;
  box-shadow: 0px 8px 30px rgb(64 64 64 / 37%)
}

.showcase-contain{
  padding: 2rem;
}

.showcase-contain h1{
  font-size: 3em;
}

.asset-title{
  display: flex;
  border: 3px solid rgb(255, 114, 58);
  border-radius: 100%;
  padding: 5px 20px;
  display: inline-block;
  margin-left: 10px;
}

.asset-title h2{
  font-size: 1.5rem;
  font-weight: 700;
  line-height: 1;
  margin-left: 1rem;
}

.showcase-grid{
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  
}

.showcase-inner_wrapper img{
  width: 100%;
}



/* Screen less than 767px */
@media screen and (max-width: 767px) {
  .hero-grid {
    grid-template-columns: 100%;
  }
  .feature-grids, .showcase-grid{
    grid-template-columns: 1fr;

  }

}
</style>