<template>
  <div class="hero-section">
    <v-container>
      <div class="hero-section__wrapper">
        <div class="hero-grid">
          <div class="hero-item">
            <div class="hero-inner_wrapper">
              <h1>Dive into the world where your opinions are valid</h1>
              <p>
                DogeDiscuss is a platform for thousands of communities to share
                opinions regarding trending crypto coin. Our goal is to empower
                teams, communities with new insight into the web3 world as we
                approach the post-pandemic era.
              </p>
              <base-button link mode="outline">
                Get Started
              </base-button>
            </div>
          </div>
          <div class="hero-item">
            <div class="hero-inner_wrapper">
              <img :src="heroImg" alt="">
            </div>
          </div>
        </div>
      </div>
    </v-container>
  </div>
</template>

<script>
import heroImg from '../../../public/img/hero-img.png'
export default {
  data() {
    return {
      heroImg: heroImg,
    }
  }
};
</script>

<style lang="css" scoped>
.hero-section__wrapper{
  position: relative;
  background: #faf9b6;
}

.hero-grid{
  display: grid;
  grid-template-columns: 50% 50%;
  grid-gap: 1rem;
  padding: 1rem;
  align-items: center;
}

.hero-inner_wrapper img{
  width: 100%;
}

.hero-inner_wrapper h1{
  font-size: 3rem;
  font-weight: 700;
  color: #000;
  margin-bottom: 1rem;
  line-height: 1;
}

.hero-inner_wrapper p{
  font-size: .8rem;
  color: #000;
  opacity: .6;
}

/* Screen less than 767px */
@media screen and (max-width: 767px) {
  .hero-grid{
    grid-template-columns: 100%;
  }
}

</style>