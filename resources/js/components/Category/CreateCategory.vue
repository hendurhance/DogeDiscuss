<template>
  <v-container>
    <div class="create-wrapper">
      <div class="error-message" v-if="!isAuth">
        <p> You are not authenticated to create a category </p>
      </div>
      <section v-else>
        <div class="create-header">
          <h1>Create a Category</h1>
        </div>
        <div class="form-wrapper">
          <form @submit.prevent="createCategory">
            <div class="main-form">
              <div class="form-input">
                <label>Category Name</label>
                <input type="text" name="name" v-model="form.name" />
                <p v-if="error" class="error">
                  {{ error }}
                </p>
              </div>
              <div class="form-submit">
                <input type="submit" :value="buttonValue" ref="submitButton" />
              </div>
            </div>
          </form>
        </div>
      </section>
    </div>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      form: {
        name: "",
      },
      error: "",
      buttonValue: "Create Category",
      isValidated: false,
      isAuth: false,
    };
  },
  methods: {
    validate() {
      if (this.form.name.trim() === "") {
        this.error = "Category name is required";
      } else if (this.form.name.length < 3) {
        this.error = "Category name must be at least 3 characters";
      } else {
        this.isValidated = true;
      }
    },
    createCategory() {
      this.validate();
      if (this.isValidated) {
        const name = this.form.name
        const request = Category.createCategory(name);
        request
          .then((response) => {
            this.$router.push("/categories");
          })
          .catch((error) => {
              console.log(error.response.data)
            this.error = error.response.data.errors.name[0];
          });
      }
    },
  },
  created() {
      const userAuth = User.checkIfLoggedIn();
      if (userAuth) {
        this.isAuth = true;
      }
  }
};
</script>

<style lang="css" scoped>
.create-wrapper {
  margin: 0 auto;
  position: relative;
  background: rgb(243, 243, 243);
  max-width: 600px;
  padding: 1.5rem;
}
.create-header {
  text-align: center;
  margin: 1rem 0;
}

.create-header h1 {
  color: #0f4c5c;
}

.main-form {
  display: grid;
  display: -ms-grid;
  display: -webkit-grid;
  grid-template-rows: 1fr;
  -ms-grid-row-gap: 1rem;
  -webkit-grid-row-gap: 1rem;
  grid-row-gap: 1rem;
}

form {
  display: grid;
  display: -ms-grid;
  display: -webkit-grid;
  grid-template-rows: 1fr;
  -ms-grid-rows: 1fr;
  -webkit-grid-rows: 1fr;
  grid-row-gap: 1rem;
}

label {
  color: #0f4c5c;
}

.form-input input {
  width: 100%;
  border: 1px solid #0f4c5c;
  border-radius: 3px;
  padding: 10px 20px;
  color: #0f4c5c;
  font-size: 12px;
}

.form-submit input[type="submit"] {
  width: 100%;
  border: none;
  background: #0f4c5c;
  color: rgb(255, 255, 255);
  font-size: 14px;
  font-weight: 700;
  text-decoration: none;
  text-transform: uppercase;
  padding: 10px 20px;
  border-radius: 3px;
}


.form-input input:focus{
  outline: none;
  border: 1px solid #082931;
}

.error-message {
  text-align: center;
  margin: 0.5rem 0;
  padding: 10px 0;
  background: rgb(255, 69, 69);
}

.error-message p {
  color: #fff;
  margin: 0;
  font-size: 12px;
}

.v-application .error {
  background: none !important;
}

.error {
  color: #ff0000;
  font-size: 0.8em;
  font-weight: 400;
  margin-bottom: 0.5em;
  opacity: 0.8;
  background: none !important;
  border: none !important;
}
</style>