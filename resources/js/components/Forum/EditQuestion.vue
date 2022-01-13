<template>
  <v-container>
    <div class="create-wrapper">
      <div class="error-message" v-if="!ownQuestion">
        <p>You don't have permission to edit this question</p>
      </div>
      <section v-else>
        <div class="create-header">
          <h1>Edit Question</h1>
        </div>
        <div class="form-wrapper">
          <form @submit.prevent="editQuestionAction">
            <div class="category-wrapper">
              <label>Choose a Category</label>
              <!-- select input -->
              <select name="category" v-model="form.category">
                <option
                  v-for="category in categories"
                  :key="category.slug"
                  :value="category.id"
                  :selected="category.id == 3"
                >
                  {{ category.name }}
                </option>
              </select>
            </div>
            <p v-if="errors.category" class="error">
              {{ errors.category }}
            </p>
            <div class="main-form">
              <div class="form-input">
                <label>Title</label>
                <input type="text" name="title" v-model="form.title" />
                <p v-if="errors.title" class="error">
                  {{ errors.title }}
                </p>
              </div>
              <div class="form-input">
                <label>Description</label>
                <textarea
                  name="description"
                  v-model="form.description"
                ></textarea>
                <p v-if="errors.description" class="error">
                  {{ errors.description }}
                </p>
              </div>
              <div class="form-submit">
                <input 
                  type="submit" 
                  :value="buttonValue" 
                  ref="editButton" 
                  :disabled="!valueChanged"
                />
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
  props: {
    slug: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      question: {},
      categories: {},
      ownQuestion: false,
      buttonValue: "Edit Question",
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
      valueChanged: false,
    };
  },
  methods: {
    getQuestion() {
      const slugReq = Question.getQuestionBySlug(this.slug);
      slugReq.then((response) => {
        this.question = response.data;
        this.form.title = this.question.title;
        this.form.description = this.question.body;
        // this.form.category will get the category id from question.category using slug from category object
        this.form.category = () => {
          return this.getCategoryID()
        };

        console.log(this.question);
        this.userOwnsQuestion();
      });
    },
    userOwnsQuestion() {
      let question_user = this.question.user;
      let auth_user = User.getUsersName();
      if (question_user == auth_user) {
        this.ownQuestion = true;
      } else {
        this.ownQuestion = false;
      }
    },
    editQuestionAction() {
      console.log(this.ownQuestion, this.valueChanged)
      if (this.ownQuestion) {
        if (this.valueChanged) {
          this.buttonValue = "Editing...";
          this.valueChanged = false;
          const slug = this.slug;
          const payload = {
            title: this.form.title,
            body: this.form.description,
            category: this.form.category,
          };
          const editReq = Question.editQuestion(slug, payload);
          editReq.then((response) => {
            this.buttonValue = "Edit Question";
            this.valueChanged = true;
            const questionRes = response.data;
            this.$router.push({ name: "question", params: { slug: questionRes.slug } });
          }).catch((error) => {
            alert(error.response.data.message);
          });
        }
      }
    }
  },
  computed: {
    getCategoryId(cat) {
      // find the category id from the slug in category object and return id
      return this.categories.find((category) => {
        return category.slug == cat;
      }).id;
    }
  },
  mounted() {
    const catagories = Category.getAllCategories();
    catagories.then((response) => {
      this.categories = response.data;
    });

    this.getQuestion();
  },
  created() {
    if (!User.checkIfLoggedIn()) {
      this.$router.push({ name: "login" });
    }
  },
  watch: {
    // when any form field with question data changes set valueChanged to true
    form: {
      handler() {
        // if question data is changed
        if (
          this.form.title != this.question.title ||
          this.form.description != this.question.body ||
          this.form.category != this.question.category
        ) {
          this.valueChanged = true;
          this.buttonValue = "Save Changes";
        } else {
          this.valueChanged = false;
          this.buttonValue = "Edit Question";
        }
      },
      deep: true,
    },
  },
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
  border: 1px solid #0f4c5c;
  border-radius: 3px;
  padding: 0 20px;
  color: #0f4c5c;
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
  border: 1px solid #0f4c5c;
  border-radius: 3px;
  padding: 10px 20px;
  color: #0f4c5c;
  font-size: 12px;
}

.form-input textarea {
  height: 100px;
  resize: none;
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

label {
  color: #0f4c5c;
}

.form-input input:focus,
.form-input textarea:focus,
.category-wrapper select:focus {
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

/* disabled sub,it input */
input[type="submit"]:disabled{
  opacity: .7;
}

</style>