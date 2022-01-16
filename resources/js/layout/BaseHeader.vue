<template>
  <div class="header">
    <v-container>
      <nav>
        <div class="nav-row">
          <div class="nav-item no-mobile">
            <router-link to="/forum">Forum</router-link>
            <router-link to="/categories">Categories</router-link>
          </div>
          <div class="nav-item">
            <div class="logo">
              <img :src="logo" alt="" @click="reRouteHome" />
            </div>
          </div>
          <div class="nav-item no-mobile">
            <router-link to="/ask-question">Ask Question</router-link>
            <router-link to="/login" class="filled" v-if="notLoggedIn">Login</router-link>
            <app-notification v-else></app-notification>
            <button @click="logout" class="filled" v-if="!notLoggedIn"> Logout</button>
          </div>  
          <div class="nav-item no-desktop">
            <router-link to="/login" class="a-flex" v-if="notLoggedIn"><img :src="user" alt="" /> Login</router-link>
            <app-notification></app-notification>
            <button @click="logout" class="a-flex" v-if="!notLoggedIn"><img class="logout" :src="logoutIcon" alt=""> Logout</button>
            <button><img @click="openSidebar" :src="hamburger" alt="" /></button>
          </div>
          <div class="sidebar" ref="sidebar">
            <div class="grid-sidebar">
              <div class="cancel-icon">
                <img @click="closeSidebar" :src="cancel" alt="" />
              </div>
              <div class="navigation">
                <router-link to="/forum" class="links">Forum</router-link>
                <router-link to="/categories" class="links">Categories</router-link>
                <router-link to="/ask-question" class="links">Ask Question</router-link>
                <router-link to="/register" class="links" v-if="notLoggedIn">Register</router-link>
              </div>
            </div>
          </div>
        </div>
      </nav>
    </v-container>
  </div>
</template>

<script>
import Logo from "../../../public/img/logo-green.svg";
import Hamburger from "../../../public/img/vuesax/bold/hamburger.svg";
import userIcon from "../../../public/img/vuesax/bold/user.svg";
import Cancel from "../../../public/img/vuesax/bold/cancel.svg";
import logoutIcon from "../../../public/img/vuesax/bold/logout.svg";
import AppNotification from "./AppNotification.vue"
export default {
  components: {
    AppNotification
  },
  data() {
    return {
      logo: Logo,
      hamburger: Hamburger,
      user: userIcon,
      logoutIcon: logoutIcon,
      cancel: Cancel,
      notLoggedIn: true,
    };
  },
  methods: {
    openSidebar() {
      this.$refs.sidebar.classList.add("sidebar--open");
    },
    closeSidebar() {
      this.$refs.sidebar.classList.remove("sidebar--open");
    },
    reRouteHome() {
      this.$router.push("/");
    },
    logout() {
      User.logout();
      this.$router.push("/");
      this.notLoggedIn = true;
    }
  },
  watch: {
    $route() {
      this.closeSidebar();
    },
  },
  mounted() {
    if (User.checkIfLoggedIn()) {
      this.notLoggedIn = false;
    }
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
  position: relative;
}

.logo img {
  width: 240px;
  cursor: pointer;
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

.nav-item a, .nav-item .a-flex {
  color: #0f4c5c;
  font-size: 14px;
  font-weight: 700;
  padding: 0 20px;
  text-decoration: none;
  text-transform: uppercase;
}

.nav-item a.filled , .nav-item .filled{
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
  .nav-item button .logout {
    padding-right: 5px;
    /* width: ; */
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
    background: #0f4c5c;
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
    color: #fff;
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
  .nav-item a, .nav-item .a-flex{
    padding: 0 10px;
  }
}


/* screen less than 359 */
@media (max-width: 359px) {
  .logo img {
    width: 120px;
  }
  button img{
    width: 20px !important;
  }

  .nav-item a, .nav-item .a-flex{
    font-size: 12px;
  }
}


</style>