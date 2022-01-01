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
        <div class="inner-showcase-wrapper">
          <div class="justify-container">
            <div class="middle-line"></div>
          </div>
          <!-- Content -->
          <div class="header-grid-showcase">
            <img :src="doge" alt="">
            <h1>Doge Market Overview</h1>
          </div>
          <div class="asset-metadata">
            <div class="asset-grid">
              <div class="asset-item">
                <h6>Asset Name</h6>
                <p> {{ getAssetName }} </p>
              </div>
              <div class="asset-item">
                <h6>Symbol</h6>
                <p> {{  getSym }} </p>
              </div>
              <div class="asset-item">
                <h6>Asset Price</h6>
                <p> {{ getPrice }} </p>
              </div>
              <div class="asset-item">
                <h6>Percent Change in 1h</h6>
                <!-- get percentage change for using param of 1h -->
                <p :class="getPercentChange1hColor"> {{ getPercentChange1h }} </p>
              </div>
              <div class="asset-item">
                <h6>Percent Change in 24h</h6>
                <!-- get percentage change for using param of 24h -->
                <p :class="getPercentChange24hColor"> {{ getPercentChange24h }} </p>
              </div>
              <div class="asset-item">
                <h6>Percent Change in 7d</h6>
                <!-- get percentage change for using param of 7d -->
                <p :class="getPercentChange7dColor"> {{ getPercentChange7d }} </p>
              </div>
               <div class="asset-item">
                <h6>Rank</h6>
                <p> {{ getRank }} </p>
              </div>
              <div class="asset-item">
                <h6>Price in BTC</h6>
                <p> {{ getBTCEquivalent }} </p>
              </div>
              <div class="asset-item">
                <h6>Circulating Supply</h6>
                <p> {{ getCirculatingSupply }} </p>
              </div>
              <div class="asset-item">
                <h6>Market Cap</h6>
                <p> {{ getMarketCap }} </p>
              </div>
              <div class="asset-item">
                <h6>24h Volume</h6>
                <p> {{ getVolume24h }} </p>
              </div>
              <div class="asset-item">
                <h6>Total Supply</h6>
                <p> {{ getTotalSupply }} </p>
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
import Doge from "../../../public/img/dogeicon.svg"

export default {
  data() {
    return {
      heroImg: heroImg,
      user: User,
      chat: Chat,
      feedback: Feedback,
      discuss: Discuss,
      doge: Doge,
      data: null,
      asset: null,
    };
  },
  mounted() {
    // use axios to call https://api.coinlore.net/api/ticker/?id=2
    // and set the data to the state
    axios
      .get("/api/ticker/doge", {
        headers: {
          Accept: "application/json",
        },
      })
      .then((response) => {
        this.data = response.data;
        this.asset = this.data[0];
      })
      .catch((error) => {
        console.log(error);
      });
  },
  computed: {
    getAssetName() {
      if (this.asset) {
        return this.asset.name;
      }
    },
    getMarketCap() {
      if (this.asset) {
        // return and put , after every 3 digits
        return '$' + this.asset.market_cap_usd.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
      }
    },
    getPrice() {
      if (this.asset) {
        return '$' + this.asset.price_usd
      }
    },
    getVolume24h() {
      if (this.asset) {
        return '$' + this.asset.volume24.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
      }
    },
    getTotalSupply() {
      if (this.asset) {
        return this.asset.tsupply.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
      }
    },
    getBTCEquivalent() {
      if (this.asset) {
        return this.asset.price_btc + 'BTC';
      }
    },
    // use one function to get increase and decrease in change in 1h, 24h, 7d
    getPercentChange1h() {
      if (this.asset) {
        return this.asset.percent_change_1h + '%'
      }
    },
    getPercentChange24h() {
      if (this.asset) {
        return this.asset.percent_change_24h + '%'
      }
    },
    getPercentChange7d() {
      if (this.asset) {
        return this.asset.percent_change_7d + '%'
      }
    },
    getRank() {
      if (this.asset) {
        return this.asset.rank;
      }
    },
    getSym() {
      if (this.asset) {
        return this.asset.symbol;
      }
    },
    getCirculatingSupply() {
      if (this.asset) {
        return '$' + this.asset.csupply.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
      }
    },
    // get increase and decrease in change in 1h, 24h, 7d and set the color
    getPercentChange1hColor() {
      if (this.asset) {
        if (this.asset.percent_change_1h > 0) {
          return 'green-color';
        } else {
          return 'red-color';
        }
      }
    },
    getPercentChange24hColor() {
      if (this.asset) {
        if (this.asset.percent_change_24h > 0) {
          return 'green-color';
        } else {
          return 'red-color';
        }
      }
    },
    getPercentChange7dColor() {
      if (this.asset) {
        if (this.asset.percent_change_7d > 0) {
          return 'green-color';
        } else {
          return 'red-color';
        }
      }
    },
  },
  
  


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
.showcase-wrapper{
  background-color: #faf5ef;
  padding: 2em;
  border-radius: 25px;
  margin: 5rem 0;
}

.justify-container{
  display: flex;
  justify-content: center;
}

.middle-line{
  height: 5rem;
  border-left: 5px solid #ffa02e;
  padding: 0;
  display: flex;
  margin-top: -5em;
}

.header-grid-showcase{
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 1em;
}

.header-grid-showcase img{
  width: 50px;
  padding-right: 1em;
}

.asset-metadata{
  margin-top: 1em;
}

.asset-grid{
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  grid-gap: 1rem;
  padding: 1rem;
  align-items: center;
  color: #000;
}

.red-color{
  color: #ff2e2e;
  font-weight: 600;
}

.green-color{
  color: #00b300;
  font-weight: 600;
}





/* Screen less than 767px */
@media screen and (max-width: 767px) {
  .hero-grid {
    grid-template-columns: 100%;
  }
  .feature-grids{
    grid-template-columns: 1fr;

  }
  .asset-grid{
    grid-template-columns: 1fr 1fr;
  }

}

/* screen less than 480px */
@media screen and (max-width: 480px) {
  .header-grid-showcase img{
    width: 40px;
  }

  .header-grid-showcase h1{
    font-size: 1.2rem;
  }

}
</style>