<template>
  <v-container>
    <footer>
      <div class="main-wrapper">
        <div class="main-row">
          <div class="left-footer">
            <p>
              built w/ <span><img :src="heart" alt="Heart" /></span> by
              @hendurhance
            </p>
          </div>
          <div class="right-footer">
            <a href="" class="links">Report a Bug</a>
            <a href="" class="links">Privacy Policy</a>
            <a href="" class="links">Github</a>
          </div>
        </div>
      </div>
    </footer>
  </v-container>
</template>

<script>
import Heart from "../../../public/img/vuesax/bold/heart.svg";
export default {
  data() {
    return {
      heart: Heart,
    };
  },
};
</script>

<style lang="css" scoped>
.main-row {
  display: flex;
  display: -ms-flexbox;
  display: -webkit-flex;
  flex-direction: row;
  -ms-flex-direction: row;
  -webkit-flex-direction: row;
  -ms-flex-align: center;
  -webkit-align-items: center;
  align-items: center;
  -ms-flex-pack: justify;
  -webkit-justify-content: space-between;
  justify-content: space-between;
}

.left-footer p {
  font-size: 14px;
  color: #828282;
  margin-bottom: 0;
}

.left-footer p span img {
  width: 20px;
  margin-bottom: -0.2em;
}

.right-footer {
  display: grid;
  display: -ms-grid;
  display: -webkit-grid;
  grid-template-columns: repeat(3, 1fr);
  -ms-grid-columns: repeat(3, 1fr);
  -webkit-grid-template-columns: repeat(3, 1fr);
  -ms-grid-column-gap: 10px;
  -webkit-grid-column-gap: 10px;
  grid-column-gap: 10px;
}

.right-footer a {
  color: #828282;
  text-decoration: none;
}

/* Screen less than 767px */
@media (max-width: 767px) {
  .main-row {
    flex-direction: column;
    -ms-flex-direction: column;
    -webkit-flex-direction: column;
    align-items: flex-start;
  }

  .left-footer {
    margin-bottom: 20px;
  }

  .right-footer a.links {
    font-size: 14px;
  }
}
</style>