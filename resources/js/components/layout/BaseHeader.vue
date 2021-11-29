<template>
  <div class="header">
    <v-container>
      <nav>
        <div class="nav-row">
          <div class="nav-item">
            <a href="">Forum</a>
            <a href="">Category</a>
          </div>
          <div class="nav-item centered">
            <div class="logo">
              <img :src="logo" alt="" />
            </div>
          </div>
          <div class="nav-item">
            <a href="">Ask Question</a>
            <a href="">Login</a>
          </div>
        </div>
      </nav>
    </v-container>
  </div>
</template>

<script>
import Logo from "../../../../public/img/logo-green.svg";
export default {
  data() {
    return {
      logo: Logo,
    };
  },
};
</script>

<style lang="css" scoped>
nav {
  position: relative;
}

.nav-row {
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

.logo img {
  width: 240px;
}

.nav-item {
  display: flex;
  display: -ms-flexbox;
  display: -webkit-flex;
}

.nav-item a {
  color: rgb(15, 15, 15);
  font-size: 14px;
  font-weight: 700;
  padding: 0 20px;
  text-decoration: none;
  text-transform: uppercase;
}

</style>