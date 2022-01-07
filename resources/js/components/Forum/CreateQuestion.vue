<template>
  <v-container>
    <div class="create-wrapper">
      <div class="error-message"  v-if="!isAuth">
        <p> You have to be logged in to create a question </p>
      </div>
      <section>
        <div class="create-header">
          <h1>Ask a Question</h1>
        </div>
        <div class="form-wrapper">
          <form @submit.prevent="">
            <div class="category-wrapper">
              <label>Choose a Category</label>
              <!-- select input -->
              <select name="category">
                <option value="none" selected disabled hidden>
                  Select a category
                </option>
                <option
                  v-for="category in categories"
                  :key="category.slug"
                  :value="category.id"
                >
                  {{ category.name }}
                </option>
              </select>
            </div>
            <div class="main-form">
              <div class="form-input">
                <label>Title</label>
                <input type="text" name="title" />
              </div>
              <div class="form-input">
                <label>Description</label>
                <textarea name="description"></textarea>
              </div>
              <div class="form-submit">
                <input type="submit" value="Post Question" ref="submitButton" />
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
      categories: {},
      isAuth: false,
      isValidated: false,
      form: {
        title: null,
        description: null,
        category: null,
      },
      errors: {
        title: null,
        description: null,
        category: null,
      },
    };
  },
  methods: {
    validate(){
      if(this.form.title === null){
        this.errors.title = "Title is required";
      }else if(this.form.title.length < 5){
        this.errors.title = "Title must be at least 5 characters";
      }else if(this.form.description === null){
        this.errors.description = "Description is required";
      }else if(this.form.description.length < 50){
        this.errors.description = "Description must be at least 5 characters";
      }else if(this.form.category === null){
        this.errors.category = "Category is required";
      }else{
        this.isValidated = true;
        this.errors.title = null;
        this.errors.description = null;
        this.errors.category = null;
      }
    }
  },
  mounted() {
    const catagories = Category.getAllCategories();
    catagories.then((response) => {
      console.log(response);
      this.categories = response.data;
    });

    // if user is not logged in and is not validated
    if (User.checkIfLoggedIn()) {
      this.isAuth = true;
    }

    // get refs "submitButton"
    const submitButton = this.$refs.submitButton;
    if (this.isAuth) {
      submitButton.disabled = false;
    } else {
      submitButton.disabled = true;
      submitButton.style.opacity = 0.5;
    }
  },
};
</script>

<style lang="css" scoped>
.create-wrapper {
  margin: 0 auto;
  position: relative;
  background: rgb(247, 247, 247);
  max-width: 600px;
  padding: 1.5rem;
}
.create-header {
  text-align: center;
  margin: 1rem 0;
}

.create-header h1 {
  color: rgb(27, 27, 27);
}

form .category-wrapper {
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

form {
  display: grid;
  display: -ms-grid;
  display: -webkit-grid;
  grid-template-rows: 1fr;
  -ms-grid-rows: 1fr;
  -webkit-grid-rows: 1fr;
  grid-row-gap: 1rem;
}

form .category-wrapper select {
  width: 50%;
  height: 40px;
  border: 1px solid rgb(204, 204, 204);
  border-radius: 3px;
  padding: 0 20px;
  color: rgb(27, 27, 27);
  font-size: 12px;
  text-decoration: none;
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

.form-input input,
.form-input textarea {
  width: 100%;
  border: 1px solid rgb(204, 204, 204);
  border-radius: 3px;
  padding: 10px 20px;
  color: rgb(27, 27, 27);
  font-size: 12px;
}

.form-input textarea {
  height: 100px;
  resize: none;
}

.form-submit input[type="submit"] {
  width: 100%;
  border: none;
  background: rgb(27, 27, 27);
  color: rgb(255, 255, 255);
  font-size: 14px;
  font-weight: 700;
  text-decoration: none;
  text-transform: uppercase;
  padding: 10px 20px;
  border-radius: 3px;
}

.form-input input:focus,
.form-input textarea:focus,
.category-wrapper select:focus {
  outline: none;
  border: 1px solid rgb(27, 27, 27);
}

.error-message {
  text-align: center;
  margin: .5rem 0;
  padding: 10px 0;
  background: rgb(255, 69, 69);
}

.error-message p{
  color: #fff;
  margin: 0;
  font-size: 12px;
}


</style>