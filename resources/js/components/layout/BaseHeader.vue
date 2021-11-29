<template>
  <div class="header">
    <v-container>
      <nav>
        <div class="nav-row">
          <div class="nav-item no-mobile">
            <a href="">Forum</a>
            <a href="">Category</a>
          </div>
          <div class="nav-item">
            <div class="logo">
              <img :src="logo" alt="" />
            </div>
          </div>
          <div class="nav-item no-mobile">
            <a href="">Ask Question</a>
            <a href="" class="filled">Login</a>
          </div>
          <div class="nav-item no-desktop">
            <a href="" class="a-flex"><img :src="user" alt="" /> Login</a>
            <button><img @click="openSidebar" :src="hamburger" alt="" /></button>
          </div>
          <div class="sidebar" ref="sidebar">
            <div class="grid-sidebar">
              <div class="cancel-icon">
                <img @click="closeSidebar" :src="cancel" alt="" />
              </div>
              <div class="navigation">
                <a href="" class="links">Forum</a>
                <a href="" class="links">Category</a>
                <a href="" class="links">Ask Question</a>
                <a href="" class="links">Login</a>
              </div>
            </div>
          </div>
        </div>
      </nav>
    </v-container>
  </div>
</template>

<script>
import Logo from "../../../../public/img/logo-green.svg";
import Hamburger from "../../../../public/img/vuesax/bold/hamburger.svg";
import User from "../../../../public/img/vuesax/bold/user.svg";
import Cancel from "../../../../public/img/vuesax/bold/cancel.svg";
export default {
  data() {
    return {
      logo: Logo,
      hamburger: Hamburger,
      user: User,
      cancel: Cancel,
    };
  },
  methods: {
    openSidebar() {
      this.$refs.sidebar.classList.add("sidebar--open");
    },
    closeSidebar() {
      this.$refs.sidebar.classList.remove("sidebar--open");
    }
  }
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
  position: relative;
}

.logo img {
  width: 240px;
}

.nav-item {
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

.nav-item a {
  color: #0f4c5c;
  font-size: 14px;
  font-weight: 700;
  padding: 0 20px;
  text-decoration: none;
  text-transform: uppercase;
}

.nav-item a.filled {
  color: #fff;
  background: #0f4c5c;
  border-radius: 4px;
  padding: 10px 20px;
}

.no-desktop {
  display: none;
}

.sidebar--open{
  display: block !important;
}

.sidebar {
  display: none;
}

/* Screen less than 767px */
@media (max-width: 767px) {
  .no-mobile {
    display: none;
  }
  .no-desktop {
    display: flex;
    position: relative;
  }
  .nav-item button {
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .nav-item button img {
    width: 30px;
  }
  .a-flex {
    display: flex;
    align-items: center;
  }

  /* Sidebar design */
  .sidebar {
    position: fixed;
    left: 0;
    top: 0;
    right: 0;
    width: 100%;
    z-index: 999;
    height: 100vh;
    border-left: 2px solid #0f4c5c;
  }
  .grid-sidebar {
    padding: 4em 2em;
    display: grid;
    grid-template-columns: 10% 80%;
  }
  .navigation {
    display: grid;
    grid-template-columns: 1fr;
    grid-gap: 1em;
    justify-content: center;
    justify-items: center;
    margin-top: 6em;
  }
  .navigation a {
    color: #0f4c5c;
    text-decoration: none;
    font-size: 20px;
    font-weight: 700;
    text-transform: uppercase;
  }
}

/* Screen less than 480px */
@media (max-width: 480px) {
  .logo img {
    width: 160px;
    display: flex;
  }
}
</style>