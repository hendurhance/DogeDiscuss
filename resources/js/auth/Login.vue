<template>
  <div class="auth-wrapper">
    <div class="auth-grid">
      <div class="auth-image">
        <img :src="authImg" alt="" />
      </div>
      <div class="auth-form">
        <div class="inner-auth">
          <div class="auth-logo">
            <img @click="reRouteHome" :src="logo" alt="" />
          </div>
          <h1>Login</h1>
          <p>Hello there, Log in to your account</p>
          <div class="auth-form-wrapper">
            <form @submit.prevent="login">
              <div class="form-item">
                <label for="email">Email</label>
                <input
                  type="email"
                  placeholder="hello@example.com"
                  autocomplete="off"
                  v-model="form.email"
                  required
                />
                <p v-if="errors.email" class="error">
                  {{ errors.email }}
                </p>
              </div>
              <div class="form-item">
                <label for="password">Password</label>
                <input
                  type="password"
                  placeholder=""
                  autocomplete="off"
                  v-model="form.password"
                  required
                />
                <p v-if="errors.password" class="error">
                  {{ errors.password }}
                </p>
              </div>
              <div class="form-item">
                <input type="submit" :value="buttonValue" />
              </div>
            </form>
            <div class="extra-link">
              <p>
                Don't have an account?
                <router-link to="/register" class="a-op">Register</router-link>
              </p>
              <router-link to="/forgot-password">Forgot Password</router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>



<script>
import authImg from "../../../public/img/authimg.jpg";
import Logo from "../../../public/img/logo-green.svg";
export default {
  data() {
    return {
      authImg: authImg,
      logo: Logo,
      buttonValue: "Login",
      form: {
        email: null,
        password: null,
        isValidated: false
      },
      errors: {
        email: null,
        password: null
      }
    };
  },
  methods: {
    // validate function
    validate() {
      if (this.form.email === null) {
        this.errors.email = "Email is required";
      } else if (!this.form.email.includes("@")) {
        this.errors.email = "Email is invalid";
      } else if(this.form.password === null) {
        this.errors.password = "Password is required";
      } else {
        this.errors.email = null;
        this.errors.password = null;
        this.form.isValidated = true;
      }
    },
    // login function
    login() {
      this.validate();
      if (this.form.isValidated) {
        this.buttonValue = "Logging in...";

        const payload = {
          email: this.form.email,
          password: this.form.password
        };
        
        User.login(payload).then(response => {
          this.buttonValue = "Login";
          // this.$router.push("/");
        }).catch(error => {
          this.buttonValue = "Login";
          this.errors.email = "Email or password is invalid";
        });
        
      }
    },
    // re route to home
    reRouteHome() {
      this.$router.push("/");
    }
  }
};
</script>

<style lang="css" scoped>
.auth-wrapper {
  width: 100%;
  height: 100vh;
}

.auth-grid {
  width: 100%;
  height: 100%;
  display: grid;
  grid-template-columns: 1fr 1fr;
  grid-template-areas: "auth-image auth-image" "auth-form auth-form";
}

.auth-image img {
  width: 100%;
  height: 100vh;
  object-fit: cover;
  object-position: center;
}

.auth-form {
  background: #faf5ef;
  height: 100vh;
}

.inner-auth {
  padding: 4em 3em 0 3em;
}

.inner-auth h1 {
  font-size: 2.5em;
  font-weight: 700;
  color: #0f4c5c;
}

.inner-auth p {
  font-size: 1.2em;
  color: #0f4c5c;
  font-weight: 400;
  margin-bottom: 1em;
  opacity: 0.8;
}

.auth-logo img {
  width: 40%;
  height: auto;
  margin-bottom: 1em;
}

form {
  margin-top: 2em;
}

form .form-item {
  margin-bottom: 1em;
}

.form-item label {
  font-size: 1.2em;
  font-weight: 500;
  margin-bottom: 0.5em;
  color: #535353;
}

.form-item input {
  width: 100%;
  height: 3em;
  border: 1px solid #0f4c5c;
  border-radius: 0.5em;
  padding: 0.5em;
  font-size: 1em;
  background: #ffffff;
  font-weight: 400;
}

.form-item input:focus {
  outline: none;
  color: #0f4c5c;
}

.form-item input[type="submit"] {
  width: 100%;
  height: 3em;
  background: #0f4c5c;
  border-radius: 0.5em;
  padding: 0.5em;
  color: #fff;
  cursor: pointer;
  transition: all 0.3s ease;
}

.extra-link {
  text-align: center;
}

.extra-link p,
a {
  font-size: 1em;
  font-weight: 400;
  color: #0f4c5c !important;
  margin-bottom: 1em;
  opacity: 0.8;
}

.extra-link p .a-op,
.extra-link a {
  color: #0f4c5c !important;
  opacity: 1 !important;
}

.form-item p.error{
  color: #ff0000;
  font-size: 0.8em;
  font-weight: 400;
  margin-bottom: 0.5em;
  opacity: 0.8;
  background: none !important;
  border: none !important;
}

/* screen less than 767px */
@media (max-width: 767px) {
  .auth-image {
    display: none;
  }
  .auth-grid {
    grid-template-columns: 1fr;
    grid-template-areas: "auth-image" "auth-form";
  }
}

/* screen less than 576px */
@media (max-width: 576px) {
  .inner-auth {
    padding: 4em 1em 0 1em;
  }
}
</style>