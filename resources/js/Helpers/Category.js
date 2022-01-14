/**
 * Create Category Class
 * @class Category
 */
class Category {
    /**
     * Get all categories
     * @returns {Object} categories
     * @memberof Category
     * return server response
     */
    async getAllCategories() {
        return await axios.get("/api/category").then(
            response => response.data
        );
    }


    async getCategoryBySlug(slug) {
        return await axios.get(`/api/category/${slug}`).then(
            response => response.data
        );
    }


    /**
     * Fetch question from a category
     * @param {String} slug - category slug
     * @returns {Object} questions
     */
    async getQuestionsByCategory(slug) {
        return await axios.get(`/api/category/${slug}`).then(
            response => response.data
        );
    }

    /**
     * Create a new category
     * @param {Object} category - category object
     * @returns {Object} response
     */
    async createCategory(name) {
        return await axios.post("/api/category", {
            name
        }).then(
            response => response.data
        );
    }
}

export default Category = new Category();